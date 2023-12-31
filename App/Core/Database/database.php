<?php

namespace App\Database;
use PDO, PDOException;

class Database
{
    private $connection;

    public function __construct($config)
    {
        try
        {
            // Établir une connexion à la base de données avec les informations de configuration
            $this->connection = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['database'], $config['db']['user'], $config['db']['password']);
        } catch (PDOException $e) {
            // Gérer les erreurs de connexion
            $message = 'Erreur de connexion à la base de données : ' . $e->getMessage() .  '</hr>';
        }
    }

    public function fetchData()
    {
        // Liste des mois
        $months = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];

        // Requête pour récupérer les données depuis les tables liées
        $sql = "SELECT chantiers.id AS chantier_id, Entreprise.nom_de_chantier, Prestations.prestation, mois.mois AS month, chantiers.heurre
                FROM chantiers
                LEFT JOIN Entreprise ON chantiers.nom_de_chantier = Entreprise.id
                LEFT JOIN Prestations ON chantiers.prestations_id = Prestations.id
                LEFT JOIN mois ON chantiers.mois_id = mois.id";

        // Exécution de la requête PDO
        $result = $this->connection->query($sql);

        $data = [];

        if ($result) {
            // Parcours des résultats pour construire les données sous forme d'array
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                foreach ($months as $month) {
                    $hour = 0;
                    if ($row['month'] === $month) {
                        $hour = $row['heurre'];
                    }
                    $data[] = [
                        'chantier_id' => $row['chantier_id'],
                        'nom_de_chantier' => $row['nom_de_chantier'],
                        'prestation' => $row['prestation'],
                        'month' => $month,
                        'hour' => $hour
                    ];
                }
            }
        }

        return $data;
    }

    public function createData($entreprise, $prestation, $heures, $requestMethod)
    {
        try {
            // $_SERVER['REQUEST_METHOD'] yerine $requestMethod değişkeni kullanılacak
            if ($requestMethod === 'POST') {
                // Préparation de la requête pour l'insertion de données
                $sql = "INSERT INTO chantiers (nom_de_chantier, mois_id, prestations_id, heurre) VALUES (:entreprise, :mois, :prestation, :heure)";
                $stmt = $this->connection->prepare($sql);
                
                // Insertion des données pour chaque mois
                foreach ($heures as $key => $heure) {
                    // Mois sayısını 1'den başlatmak yerine doğrudan $key'i kullanın
                    $stmt->execute([
                        ':entreprise' => $entreprise,
                        ':mois' => $key + 1,
                        ':prestation' => $prestation,
                        ':heure' => $heure
                    ]);
                }
                return "Veri başarıyla eklendi.";
            } else {
                return "Geçersiz istek methodu.";
            }
        } catch (PDOException $e) {
            return "Veri eklenirken hata oluştu: " . $e->getMessage();
        }
    }
    


    public function UpdateData()
    {

    }

    public function deleteData($id)
    {
        try {
            // Requête SQL pour supprimer des données en fonction de l'identifiant
            $sql = "DELETE FROM chantiers WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            
            // Liaison de l'identifiant et exécution de la requête
            $stmt->execute([':id' => $id]);
            
            return "Veri başarıyla silindi.";
        } catch (PDOException $e) {
            return "Veri silinirken hata oluştu: " . $e->getMessage();
        }
    }

}
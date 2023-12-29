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
            $this->connection = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['database'], $config['db']['user'], $config['db']['password']);
        }catch (PDOException $e){
            $message = 'Erreur de connection basse de données' . $e->getMessage() .  '</hr>';
        }
    }

    public function fetchData()
    {
        $months = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];

        $sql = "SELECT chantiers.id AS chantier_id, Entreprise.nom_de_chantier, Prestations.prestation, mois.mois AS month, chantiers.heurre
                FROM chantiers
                LEFT JOIN Entreprise ON chantiers.nom_de_chantier = Entreprise.id
                LEFT JOIN Prestations ON chantiers.prestations_id = Prestations.id
                LEFT JOIN mois ON chantiers.mois_id = mois.id";

        // PDO sorgusunu hazırlama ve çalıştırma
        $result = $this->connection->query($sql);

        $data = [];

        if ($result) {
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

    public function CreateData()
    {

    }

    public function UpdateData()
    {

    }

    public function DeleteData()
    {
        
    }

}
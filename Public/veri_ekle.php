<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clicdroit";

try {
    // PDO bağlantısını oluşturma
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Hata modunu ayarlama
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Formdan gelen verileri al
    $entreprise = $_POST['entreprise'];
    $prestation = $_POST['prestation'];

    // 12 aya ait saat bilgilerini al
    $heures = [];
    for ($i = 1; $i <= 12; $i++) {
        $heures[] = $_POST['heure_mois_' . $i];
    }

    // Veritabanına ekleme işlemi
    $sql = "INSERT INTO chantiers (nom_de_chantier, mois_id, prestations_id, heurre) VALUES (:entreprise, :mois, :prestation, :heure)";
    $stmt = $conn->prepare($sql);

    foreach ($heures as $key => $heure) {
        $stmt->execute([
            ':entreprise' => $entreprise,
            ':mois' => ($key + 1),
            ':prestation' => $prestation,
            ':heure' => $heure
        ]);
    }

    echo "Veri başarıyla eklendi.";
} catch(PDOException $e) {
    echo "Veri eklenirken hata oluştu: " . $e->getMessage();
}

$conn = null;
?>

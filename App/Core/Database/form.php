<?php
require '../Config/app.php';
require_once 'database.php';
$database = new App\Database\Database($config);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entreprise = $_POST['entreprise'];
    $prestation = $_POST['prestation'];
    $heures = [];

    // Saat bilgilerini alma işlemi
    for ($i = 1; $i <= 12; $i++) {
        $heure = $_POST['heure_mois_' . $i];
        $heures[] = $heure;
    }

    // Veritabanına ekleme işlemi
    $result = $database->createData($entreprise, $prestation, $heures, $_SERVER['REQUEST_METHOD']);

}
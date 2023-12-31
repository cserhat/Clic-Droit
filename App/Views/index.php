<?php

 require '../App//Core/Config/app.php';
 require '../App//Core/Database/database.php';

use App\Database\Database;

// Veritabanı bağlantısını yapılandırma parametresiyle oluştur
$database = new Database($config);

// fetchData metodunu çağırarak verileri al
$data = $database->fetchData();

// Verileri chantier ID'lerine göre gruplandırma
$groupedData = [];
foreach ($data as $row) {
    $chantierID = $row['chantier_id'];
    if (!isset($groupedData[$chantierID])) {
        $groupedData[$chantierID] = [
            'chantier_id' => $chantierID,
            'nom_de_chantier' => $row['nom_de_chantier'],
            'prestations' => [],
        ];
    }
    $groupedData[$chantierID]['prestations'][] = [
        'prestation' => $row['prestation'],
        'month' => $row['month'],
        'hour' => $row['hour'],
    ];
}

// Verileri göstermek için örnek bir döngü
foreach ($groupedData as $chantier) {
    echo "Chantier ID: " . $chantier['chantier_id'] . ", Chantier: " . $chantier['nom_de_chantier'] . "<br>";
    foreach ($chantier['prestations'] as $prestation) {
        echo "Prestation: " . $prestation['prestation'] . ", Month: " . $prestation['month'] . ", Hour: " . $prestation['hour'] . "<br>";
    }
    echo "<br>";
}


?>

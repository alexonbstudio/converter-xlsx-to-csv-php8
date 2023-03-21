<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
// Inclure la bibliothèque PhpSpreadsheet
require 'vendor/autoload.php';

// Chemin du dossier d'entrée
$inputFolder = 'DD/fix/part13'; //glob('DD/*/*')

// Chemin du dossier de sortie
$outputFolder = 'EE';

// Récupérer tous les fichiers XLSX dans le dossier d'entrée
$inputFiles = glob($inputFolder . '/*.xlsx');

// Parcourir chaque fichier XLSX
foreach ($inputFiles as $inputFile) {

    // Chemin du fichier de sortie CSV
    $outputFile = $outputFolder . '/' . basename($inputFile, '.xlsx') . '.csv';

    // Charger le fichier d'entrée
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFile);

    // Récupérer la feuille active
    $worksheet = $spreadsheet->getActiveSheet();

    // Ouvrir le fichier de sortie pour l'écriture
    $file = fopen($outputFile, 'w');

    // Parcourir chaque ligne dans la feuille
    foreach ($worksheet->getRowIterator() as $row) {

        // Parcourir chaque cellule dans la ligne
        $rowData = array();
        foreach ($row->getCellIterator() as $cell) {
            $rowData[] = $cell->getValue();
        }

        // Écrire les données de la ligne dans le fichier de sortie au format CSV
        fputcsv($file, $rowData);
    }

    // Fermer le fichier de sortie
    fclose($file);

    echo "Conversion du fichier $inputFile terminée. Le fichier CSV de sortie est $outputFile\n";
}

echo "Conversion terminée pour tous les fichiers XLSX dans le dossier $inputFolder.";
?>

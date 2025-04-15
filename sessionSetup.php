<?php
session_start();
$bestand = "champions.txt";
$regels = file($bestand, FILE_IGNORE_NEW_LINES);
$aantalRegels = count($regels);

// Set session champ if not yet set
if (!isset($_SESSION['randomRegel']) || $_SESSION['randomRegel'] == "") {
    if (file_exists($bestand) && $aantalRegels > 0) {
        $randomIndex = rand(0, $aantalRegels - 1);
        $_SESSION['randomRegel'] = strtolower(trim($regels[$randomIndex]));
    }
}
?>

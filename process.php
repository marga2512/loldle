<?php
session_start();

$bestand = "champions.txt";
$regels = file($bestand, FILE_IGNORE_NEW_LINES);
$aantalRegels = count($regels);

// Initialize the session value for 'randomRegel' if it's not set
if (!isset($_SESSION['randomRegel']) || $_SESSION['randomRegel'] == "") {
    if (file_exists($bestand) && $aantalRegels > 0) {
        $randomIndex = rand(0, $aantalRegels - 1);
        $_SESSION['randomRegel'] = strtolower(trim($regels[$randomIndex]));
    }
}

// Handle the form submission via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gebruikerInvoer = htmlspecialchars($_POST['tekstInput']);
    $gebruikerInvoer = mb_convert_encoding($gebruikerInvoer, 'UTF-8', 'auto');
    $gebruikerInvoer = strtolower(trim($gebruikerInvoer));
    $gebruikerInvoer = str_replace(' ', '', $gebruikerInvoer);
    $gebruikerInvoer = html_entity_decode($gebruikerInvoer, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']);
    $_SESSION['randomRegel'] = html_entity_decode($_SESSION['randomRegel'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

    if ($gebruikerInvoer === $_SESSION['randomRegel']) {
        $randomIndex = rand(0, $aantalRegels - 1);
        $_SESSION['randomRegel'] = strtolower(trim($regels[$randomIndex]));
        $_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']);
        echo "correct";
    } else {
        echo "nah";
    }
    exit;
}
?>

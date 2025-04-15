<?php
include 'sessionSetup.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gebruikerInvoer = htmlspecialchars($_POST['tekstInput']);
    $gebruikerInvoer = mb_convert_encoding($gebruikerInvoer, 'UTF-8', 'auto');
    $gebruikerInvoer = strtolower(trim($gebruikerInvoer));
    $gebruikerInvoer = str_replace(' ', '', $gebruikerInvoer);
    $gebruikerInvoer = html_entity_decode($gebruikerInvoer, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']);
    $_SESSION['randomRegel'] = html_entity_decode($_SESSION['randomRegel'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

    if ($gebruikerInvoer === $_SESSION['randomRegel']) {
        // Pick new random champ
        $randomIndex = rand(0, count($regels) - 1);
        $_SESSION['randomRegel'] = strtolower(trim($regels[$randomIndex]));
        $_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']);
        echo "correct";
    } else {
        echo "nah";
    }
    exit;
}

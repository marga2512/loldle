<?php
session_start();
$bestand = "champions.txt";
$regels = file($bestand, FILE_IGNORE_NEW_LINES);
$aantalRegels = count($regels);
// Initialize the session value for 'randomRegel' if it's not set
if (!isset($_SESSION['randomRegel']) || $_SESSION['randomRegel'] == "") {
    if (file_exists($bestand)) {
        if ($aantalRegels > 0) {
            $randomIndex = rand(0, $aantalRegels - 1);
            $_SESSION['randomRegel'] = strtolower(trim($regels[$randomIndex])); // Random line from file
            //$_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']); // Remove internal spaces
        }
        
    }
}
//var_dump($_SESSION['randomRegel']);
// Handle the form submission via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and clean user input
    $gebruikerInvoer = htmlspecialchars($_POST['tekstInput']);
    $gebruikerInvoer = mb_convert_encoding($gebruikerInvoer, 'UTF-8', 'auto');  // Convert to UTF-8
    $gebruikerInvoer = strtolower(trim($gebruikerInvoer));  // Trim and lowercase
    $gebruikerInvoer = str_replace(' ', '', $gebruikerInvoer);  // Remove internal spaces
    $_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']);  // Remove internal spaces
    $gebruikerInvoer = html_entity_decode($gebruikerInvoer, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $_SESSION['randomRegel'] = html_entity_decode($_SESSION['randomRegel'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // Compare the user input with the session value
    if ($gebruikerInvoer === $_SESSION['randomRegel']) {
        $randomIndex = rand(0, $aantalRegels - 1);
            $_SESSION['randomRegel'] = strtolower(trim($regels[$randomIndex])); // Random line from file
            $_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']); // Remove internal spaces
        echo "correct";  // If the input matches the session value
    } else {
        echo "nah";  // If the input doesn't match
    }
    exit;  // Prevent further processing
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>AJAX Input Box Voorbeeld</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f9f9f9;
        }
        .form-container {
            background-color: white;
            border: 1px solid #ccc;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"] {
            padding: 0.5rem;
            margin-top: 10px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            padding: 0.5rem 1rem;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        #response {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9f7fd;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Voer tekst in (zonder herladen):</h2>
        <p>Hint: Het antwoord is een championaam zonder spaties. <?php echo $_SESSION['randomRegel'] ?></p>
        <form id="textForm">
            <input type="text" id="tekstInput" name="tekstInput" placeholder="Type hier..." required>
            <input type="submit" value="Verzenden">
        </form>

        <div id="response"></div>
    </div>

    <script src="script.js" defer></script>
</body>
</html>

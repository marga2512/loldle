<?php
session_start();
$bestand = "champions.txt";
$regels = file($bestand, FILE_IGNORE_NEW_LINES);

// If randomRegel is not yet set, choose a random one (to display hint)
if (!isset($_SESSION['randomRegel']) || $_SESSION['randomRegel'] == "") {
    $aantalRegels = count($regels);
    if (file_exists($bestand) && $aantalRegels > 0) {
        $randomIndex = rand(0, $aantalRegels - 1);
        $_SESSION['randomRegel'] = strtolower(trim($regels[$randomIndex]));
    }
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

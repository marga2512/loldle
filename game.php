<?php
session_start();
// Bestandspad
$bestand = "champions.txt";

// Controleren of het bestand bestaat
if (file_exists($bestand)) {
    // Bestandsinhoud ophalen
    $inhoud = file_get_contents($bestand);
    $regels = file($bestand, FILE_IGNORE_NEW_LINES);
    $aantalRegels = count($regels);


    if (!isset($_SESSION['randomRegel'])) {
        if ($aantalRegels > 0) {
            $randomIndex = rand(0, $aantalRegels - 1);
            $_SESSION['randomRegel'] = $regels[$randomIndex]; // Only set the value if it's not already set            
        }
    }
    // When the form is submitted (POST request)
    /*if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // You can modify the session variable after form submission
         // Only set the value if it's not already set
                echo !isset($_SESSION['randomRegel']);
            
        
    }*/
    
    // Access session variable
    //echo $_SESSION['randomRegel']; // This should echo the value stored in the session

} else {
    $inhoud = "Het bestand bestaat niet.";
}

// This handles the POST request when the form is submitted via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and clean user input
    $gebruikerInvoer = htmlspecialchars($_POST['tekstInput']);
    $gebruikerInvoer = mb_convert_encoding($gebruikerInvoer, 'UTF-8', 'auto');  // Convert to UTF-8
    
    // Remove unwanted spaces (internal or leading/trailing) from user input and session value
    $gebruikerInvoer = strtolower(trim($gebruikerInvoer));  // Trim and lowercase the user input
    $_SESSION['randomRegel'] = strtolower(trim($_SESSION['randomRegel']));  // Trim and lowercase session value
    
    // Debugging output to check the cleaned values
    echo "Gehuister Input (trimmed, lowercased): " . bin2hex($gebruikerInvoer) . "<br>";  // Hex representation of the input
    echo "Session Input (trimmed, lowercased): " . bin2hex($_SESSION['randomRegel']) . "<br>"; // Hex representation of the session value

    // Remove internal extra spaces if there are any (spaces between words)
    $gebruikerInvoer = str_replace(' ', '', $gebruikerInvoer);  // Remove internal spaces
    $_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']);  // Remove internal spaces

    // Debugging after internal space removal
    echo "Gehuister Input (no internal spaces): " . bin2hex($gebruikerInvoer) . "<br>";
    echo "Session Input (no internal spaces): " . bin2hex($_SESSION['randomRegel']) . "<br>";

    // Compare the user input with the session value
    if ($gebruikerInvoer == $_SESSION['randomRegel']) {
        echo "correct";
        
        // Update the session with a new random line if necessary
        if ($aantalRegels > 0) {
            $randomIndex = rand(0, $aantalRegels - 1);
            $_SESSION['randomRegel'] = $regels[$randomIndex]; // Only set the value if it's not already set
        }
    } else {
        echo "nah";
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
        <?php echo ($_SESSION['randomRegel'])?>
        <form id="textForm">
            <input type="text" id="tekstInput" name="tekstInput" placeholder="Type hier..." required>
            <input type="submit" value="Verzenden">
        </form>

        <div id="response"></div>
    </div>

    <script>
        // AJAX formulier verzenden
        document.getElementById("textForm").addEventListener("submit", function(e) {
            e.preventDefault(); // Voorkom dat het formulier op de traditionele manier verzonden wordt

            var formData = new FormData();
            formData.append("tekstInput", document.getElementById("tekstInput").value);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // Send to the same page
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update the page with the response from the server
                    document.getElementById("response").innerHTML = "Ingevoerde tekst: " + xhr.responseText;
                    document.getElementById("tekstInput").value = ""; // Clear the input after submission
                    console.log(xhr.responseText); // Log the response to check if it's exactly "correct"
if (xhr.responseText.trim() === "correct") {
    window.location.reload();
}
                }
            };
            xhr.send(formData); // Send the data via AJAX
        });
    </script>
</body>
</html>

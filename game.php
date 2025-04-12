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
            $_SESSION['randomRegel'] = str_replace(' ', '', $_SESSION['randomRegel']); // Remove internal spaces
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
    

    // Debugging: Log the user input and session value to ensure the comparison is correct
    error_log("User input: " . $gebruikerInvoer);
    error_log("Session value: " . $_SESSION['randomRegel']);

    // Compare the user input with the session value
    if ($gebruikerInvoer == $_SESSION['randomRegel']) {
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

    <script>
        // AJAX formulier verzenden
        document.getElementById("textForm").addEventListener("submit", function(e) {
            e.preventDefault(); // Voorkom dat het formulier op de traditionele manier verzonden wordt

            // Maak een nieuw XMLHttpRequest-object voor de AJAX-aanroep
            var xhr = new XMLHttpRequest();

            var formData = new FormData();
            formData.append("tekstInput", document.getElementById("tekstInput").value);

            // Open de POST-aanroep voor de huidige pagina
            xhr.open("POST", "", true); // Send to the same page

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update de pagina met het antwoord van de server
                    document.getElementById("response").innerHTML = "Ingevoerde tekst: " + xhr.responseText;
                    document.getElementById("tekstInput").value = ""; // Clear the input after submission
                    console.log(xhr.responseText); // Log the response

                    // Check the response if it is "correct"
                    if (xhr.responseText.trim() === "correct") {
                        window.location.reload(); // Reload the page if the answer is correct
                    } else {
                        console.log("Incorrect answer");
                    }
                }
            };

            // Verstuur het formulier via AJAX
            xhr.send(formData); // Send formData to the same page

        });
    </script>
</body>
</html>

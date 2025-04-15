<?php include 'sessionSetup.php'; ?>

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
        body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.wordle-container {
    text-align: center;
}

.input-row {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
}

.wordle-input {
    width: 40px;
    height: 40px;
    font-size: 24px;
    text-align: center;
    margin: 0 5px;
    border: 2px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
}

.wordle-input:focus {
    border-color: #007bff;
    outline: none;
}

button {
    padding: 10px 20px;
    font-size: 16px;
    margin-top: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
}

button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>        
    <div class="wordle-container">
    <form id="wordle-form">
        <div class="input-row">
        <?php 
            for ($i = 0; $i < $_SESSION['championNameLength']; $i++) {
                // Generate an input box for each character in the champion name
                echo '<input type="text" maxlength="1" class="wordle-input" id="input-' . $i . '">';
            }
        ?>
        </div>
        <button type="submit">Check</button>
    </form>
    <div id="response"></div>
</div>

<script>
    const correctWord = <?php echo json_encode($_SESSION['randomRegel']); ?>;
    const championNameLength = <?php echo json_encode($_SESSION['championNameLength']); ?>;
</script>
<script src="script.js"></script>
</body>
</html>

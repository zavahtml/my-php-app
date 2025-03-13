<?php
include 'connessione.php'; // Connessione al database Railway

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    if (!empty($id) && is_numeric($id)) {
        $id = $conn->real_escape_string($id);

        // Controlliamo se l'ID esiste
        $check_sql = "SELECT * FROM prodotti WHERE id = $id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Se l'ID esiste, eliminiamo il prodotto
            $sql = "DELETE FROM prodotti WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p style='color:green;'>Prodotto eliminato con successo!</p>";

                // Riorganizza gli ID: resetta e ricrea l'indice
                $conn->query("SET @count = 0;");
                $conn->query("UPDATE prodotti SET id = @count:= @count + 1;");
                $conn->query("ALTER TABLE prodotti AUTO_INCREMENT = 1;");
                
            } else {
                echo "<p style='color:red;'>Errore durante l'eliminazione: " . $conn->error . "</p>";
            }
        } else {
            echo "<p style='color:red;'>Errore: Nessun prodotto trovato con questo ID.</p>";
        }
    } else {
        echo "<p style='color:red;'>Errore: Inserisci un ID valido.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rimuovi Prodotto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        form {
            display: inline-block;
            background: #f8f8f8;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        input {
            padding: 8px;
            margin: 10px 0;
        }
        button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: darkred;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Rimuovi un Prodotto</h2>
<form method="POST">
    <label for="id">ID Prodotto:</label><br>
    <input type="number" name="id" required><br>
    <button type="submit">Elimina Prodotto</button>
</form>

<a href="prodotti.php">🔙 Torna alla lista prodotti</a>

</body>
</html>

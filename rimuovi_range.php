<?php
include 'connessione.php'; // Connessione al database Railway

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_inizio = $_POST['id_inizio'];
    $id_fine = $_POST['id_fine'];

    if (!empty($id_inizio) && !empty($id_fine) && is_numeric($id_inizio) && is_numeric($id_fine)) {
        $id_inizio = intval($conn->real_escape_string($id_inizio));
        $id_fine = intval($conn->real_escape_string($id_fine));

        if ($id_inizio <= $id_fine) {
            // Controlliamo se esistono prodotti in questo range
            $check_sql = "SELECT * FROM prodotti WHERE id BETWEEN $id_inizio AND $id_fine";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows > 0) {
                // 1️⃣ Eliminiamo tutti i prodotti nell'intervallo di ID specificato
                $sql = "DELETE FROM prodotti WHERE id BETWEEN $id_inizio AND $id_fine";
                if ($conn->query($sql) === TRUE) {
                    echo "<p style='color:green;'>Prodotti eliminati con successo (ID da $id_inizio a $id_fine)!</p>";

                    // 2️⃣ Riordinare gli ID rimanenti
                    $conn->query("SET @count = 0;");
                    $conn->query("UPDATE prodotti SET id = @count:= @count + 1;");
                    
                    // 3️⃣ Resettare AUTO_INCREMENT al valore corretto
                    $conn->query("ALTER TABLE prodotti AUTO_INCREMENT = 1;");

                } else {
                    echo "<p style='color:red;'>Errore durante l'eliminazione: " . $conn->error . "</p>";
                }
            } else {
                echo "<p style='color:red;'>Errore: Nessun prodotto trovato in questo intervallo di ID.</p>";
            }
        } else {
            echo "<p style='color:red;'>Errore: L'ID iniziale deve essere minore o uguale all'ID finale.</p>";
        }
    } else {
        echo "<p style='color:red;'>Errore: Inserisci ID validi.</p>";
    }
}
?>

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rimuovi Prodotti per Range</title>
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

<h2>Rimuovi Più Prodotti</h2>
<form method="POST">
    <label for="id_inizio">ID Iniziale:</label><br>
    <input type="number" name="id_inizio" required><br>
    <label for="id_fine">ID Finale:</label><br>
    <input type="number" name="id_fine" required><br>
    <button type="submit">Elimina Prodotti</button>
</form>

<a href="prodotti.php">🔙 Torna alla lista prodotti</a>

</body>
</html>

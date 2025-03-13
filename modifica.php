<?php
include 'connessione.php'; // Connessione al database Railway

$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $campo = $_POST['campo'];
    $valore = $_POST['valore'];

    if (!empty($id) && !empty($campo) && !empty($valore) && is_numeric($id)) {
        $id = $conn->real_escape_string($id);
        $campo = $conn->real_escape_string($campo);
        $valore = $conn->real_escape_string($valore);

        // Controlliamo se il prodotto esiste
        $check_sql = "SELECT * FROM prodotti WHERE id = $id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Modifica il campo scelto
            $sql = "UPDATE prodotti SET $campo = '$valore' WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                $messaggio = "<p style='color:green;'>Prodotto modificato con successo!</p>";
            } else {
                $messaggio = "<p style='color:red;'>Errore durante la modifica: " . $conn->error . "</p>";
            }
        } else {
            $messaggio = "<p style='color:red;'>Errore: Nessun prodotto trovato con questo ID.</p>";
        }
    } else {
        $messaggio = "<p style='color:red;'>Errore: Compila tutti i campi correttamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Prodotto</title>
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
        input, select {
            padding: 8px;
            margin: 10px 0;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
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

<h2>Modifica un Prodotto</h2>
<?php echo $messaggio; ?>
<form method="POST">
    <label for="id">ID Prodotto:</label><br>
    <input type="number" name="id" required><br>

    <label for="campo">Seleziona il campo da modificare:</label><br>
    <select name="campo" required>
        <option value="nome">Nome</option>
        <option value="prezzo">Prezzo</option>
        <option value="stato">Stato</option>
    </select><br>

    <label for="valore">Nuovo Valore:</label><br>
    <input type="text" name="valore" required><br>

    <button type="submit">Modifica Prodotto</button>
</form>

<a href="prodotti.php">🔙 Torna alla lista prodotti</a>

</body>
</html>

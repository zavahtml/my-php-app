<?php
include 'connessione.php'; // Connessione al database Railway

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $stato = $_POST['stato'];
    $quantita = $_POST['quantita']; // Numero di oggetti da aggiungere

    // Sicurezza: Prevenzione SQL Injection
    $nome = $conn->real_escape_string($nome);
    $prezzo = $conn->real_escape_string($prezzo);
    $stato = $conn->real_escape_string($stato);
    $quantita = intval($quantita); // Convertiamo la quantità in numero intero

    if ($quantita > 0) {
        for ($i = 0; $i < $quantita; $i++) {
            $sql = "INSERT INTO prodotti (nome, prezzo, stato) VALUES ('$nome', '$prezzo', '$stato')";
            $conn->query($sql);
        }
        echo "<p style='color:green;'>Aggiunti $quantita prodotti con nome '$nome'!</p>";
    } else {
        echo "<p style='color:red;'>Errore: La quantità deve essere almeno 1!</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci Prodotto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
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
<a href="prodotti.php">🔙 Torna alla lista prodotti</a>
</body>
</html>

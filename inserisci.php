<?php
include 'connessione.php'; // Connessione al database Railway

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $stato = $_POST['stato'];

    // Prevenzione SQL Injection
    $nome = $conn->real_escape_string($nome);
    $prezzo = $conn->real_escape_string($prezzo);
    $stato = $conn->real_escape_string($stato);

    $sql = "INSERT INTO prodotti (nome, prezzo, stato) VALUES ('$nome', '$prezzo', '$stato')";

    if ($conn->query($sql) === TRUE) {
        echo "Prodotto aggiunto con successo!";
    } else {
        echo "Errore nell'inserimento: " . $conn->error;
    }
}

$conn->close();
?>

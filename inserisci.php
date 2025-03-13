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

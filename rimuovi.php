<?php
include 'connessione.php'; // Connessione al database Railway

$messaggio = "";

// Se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    if (!empty($id) && is_numeric($id)) {
        $id = $conn->real_escape_string($id);

        // Controlliamo se l'ID esiste
        $check_sql = "SELECT * FROM prodotti WHERE id = $id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Eliminiamo il prodotto
            $sql = "DELETE FROM prodotti WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                $messaggio = "<p style='color:green;'>Prodotto eliminato con successo!</p>";
            } else {
                $messaggio = "<p style='color:red;'>Errore durante l'eliminazione: " . $conn->error . "</p>";
            }
        } else {
            $messaggio = "<p style='color:red;'>Errore: Nessun prodotto trovato con questo ID.</p>";
        }
    } else {
        $messaggio = "<p style='color:red;'>Errore: Inserisci un ID valido.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rimuovi Prodotto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Rimuovi un Prodotto</h2>
<?php echo $messaggio; ?>

<form method="POST">
    <label for="id">ID Prodotto:</label><br>
    <input type="number" name="id" required><br>
    <button type="submit">Elimina Prodotto</button>
</form>

<div class="link-container">
    <a href="index.html">🏠 Torna alla Home</a>
</div>

</body>
</html>

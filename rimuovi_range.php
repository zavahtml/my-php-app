<?php
include 'connessione.php'; // Connessione al database Railway

$messaggio = "";

// Se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_inizio = $_POST['id_inizio'];
    $id_fine = $_POST['id_fine'];

    if (!empty($id_inizio) && !empty($id_fine) && is_numeric($id_inizio) && is_numeric($id_fine)) {
        $id_inizio = $conn->real_escape_string($id_inizio);
        $id_fine = $conn->real_escape_string($id_fine);

        if ($id_inizio <= $id_fine) {
            // Controlliamo se esistono prodotti in questo range
            $check_sql = "SELECT * FROM prodotti WHERE id BETWEEN $id_inizio AND $id_fine";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows > 0) {
                // Eliminiamo tutti i prodotti nell'intervallo di ID specificato
                $sql = "DELETE FROM prodotti WHERE id BETWEEN $id_inizio AND $id_fine";
                if ($conn->query($sql) === TRUE) {
                    $messaggio = "<p style='color:green;'>Prodotti eliminati con successo (ID da $id_inizio a $id_fine)!</p>";
                } else {
                    $messaggio = "<p style='color:red;'>Errore durante l'eliminazione: " . $conn->error . "</p>";
                }
            } else {
                $messaggio = "<p style='color:red;'>Errore: Nessun prodotto trovato in questo intervallo di ID.</p>";
            }
        } else {
            $messaggio = "<p style='color:red;'>Errore: L'ID iniziale deve essere minore o uguale all'ID finale.</p>";
        }
    } else {
        $messaggio = "<p style='color:red;'>Errore: Inserisci ID validi.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rimuovi Più Prodotti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Rimuovi Prodotti in un Intervallo di ID</h2>
<?php echo $messaggio; ?>

<form method="POST">
    <label for="id_inizio">ID Iniziale:</label><br>
    <input type="number" name="id_inizio" required><br>
    <label for="id_fine">ID Finale:</label><br>
    <input type="number" name="id_fine" required><br>
    <button type="submit">Elimina Prodotti</button>
</form>

<div class="link-container">
    <a href="index.html">🏠 Torna alla Home</a>
</div>

</body>
</html>

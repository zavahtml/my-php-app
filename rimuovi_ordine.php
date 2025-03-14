<?php
include 'connessione.php'; // Connessione al database Railway

$messaggio = "";

// Recupera la lista degli ordini
$ordini = $conn->query("SELECT id FROM ordini ORDER BY id ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ordine_id = $_POST['ordine_id'];

    if (!empty($ordine_id) && is_numeric($ordine_id)) {
        $ordine_id = $conn->real_escape_string($ordine_id);

        // Controlliamo se l'ordine esiste
        $check_sql = "SELECT * FROM ordini WHERE id = $ordine_id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Eliminiamo l'ordine (MySQL cancellerà automaticamente i prodotti associati)
            $sql = "DELETE FROM ordini WHERE id = $ordine_id";
            if ($conn->query($sql) === TRUE) {
                // 1️⃣ Riordiniamo gli ID dopo l'eliminazione
                $conn->query("SET @count = 0;");
                $conn->query("UPDATE ordini SET id = @count:= @count + 1;");
                
                // 2️⃣ Resettiamo `AUTO_INCREMENT`
                $conn->query("ALTER TABLE ordini AUTO_INCREMENT = 1;");

                $messaggio = "<p style='color:green;'>Ordine #$ordine_id eliminato con tutti i suoi prodotti! ID riordinati.</p>";
            } else {
                $messaggio = "<p style='color:red;'>Errore durante l'eliminazione: " . $conn->error . "</p>";
            }
        } else {
            $messaggio = "<p style='color:red;'>Errore: Nessun ordine trovato con questo ID.</p>";
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
    <title>Rimuovi Ordine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Elimina un Ordine e i suoi Prodotti</h2>
<?php echo $messaggio; ?>

<form method="POST">
    <label for="ordine_id">Seleziona un Ordine:</label>
    <select name="ordine_id" required>
        <?php while ($ordine = $ordini->fetch_assoc()): ?>
            <option value="<?php echo $ordine['id']; ?>">Ordine #<?php echo $ordine['id']; ?></option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Elimina Ordine</button>
</form>

<div class="link-container">
    <a href="index.html">🏠 Torna alla Home</a>
</div>

</body>
</html>

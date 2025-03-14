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
            // 1️⃣ Disattiviamo temporaneamente i vincoli di chiave esterna
            $conn->query("SET FOREIGN_KEY_CHECKS = 0");

            // 2️⃣ Eliminiamo l'ordine (i prodotti associati verranno eliminati grazie a ON DELETE CASCADE)
            $sql = "DELETE FROM ordini WHERE id = $ordine_id";
            if ($conn->query($sql) === TRUE) {

                // 3️⃣ Riordiniamo gli ID degli ordini
                $conn->query("SET @count = 0;");
                $conn->query("UPDATE ordini SET id = @count:= @count + 1;");
                $conn->query("ALTER TABLE ordini AUTO_INCREMENT = 1;");

                // 4️⃣ Riordiniamo anche gli ID dei prodotti
                $conn->query("SET @count = 0;");
                $conn->query("UPDATE prodotti SET id = @count:= @count + 1;");
                $conn->query("ALTER TABLE prodotti AUTO_INCREMENT = 1;");

                // 5️⃣ Riattiviamo i vincoli di chiave esterna
                $conn->query("SET FOREIGN_KEY_CHECKS = 1");

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

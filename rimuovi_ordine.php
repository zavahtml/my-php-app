<?php
include 'connessione.php'; // Connessione al database Railway

$messaggio = "";

// Recupera la lista degli ordini per il menu a tendina
$ordini = $conn->query("SELECT id FROM ordini ORDER BY id DESC");

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
                $messaggio = "<p style='color:green;'>Ordine #$ordine_id eliminato con tutti i suoi prodotti!</p>";
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
        select, button {
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
    </style>
</head>
<body>

<h2>Elimina un Ordine e i suoi Prodotti</h2>
<?php echo $messaggio; ?>

<form method="POST">
    <label for="ordine_id">Seleziona un Ordine:</label>
    <select name="ordine_id" required>
        <option value="">Seleziona un Ordine</option>
        <?php while ($ordine = $ordini->fetch_assoc()): ?>
            <option value="<?php echo $ordine['id']; ?>">Ordine #<?php echo $ordine['id']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <button type="submit">Elimina Ordine</button>
</form>

<a href="prodotti.php">🔙 Torna alla lista prodotti</a>

</body>
</html>

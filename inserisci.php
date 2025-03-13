<?php
include 'connessione.php'; // Connessione al database Railway

// Ottenere gli ordini esistenti
$ordini = $conn->query("SELECT id FROM ordini ORDER BY id DESC");

// Messaggio di conferma/errore
$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $stato = $_POST['stato'];
    $quantita = $_POST['quantita'];
    $ordine_id = $_POST['ordine_id'];

    if (!empty($nome) && is_numeric($prezzo) && is_numeric($quantita) && $quantita > 0) {
        $nome = $conn->real_escape_string($nome);
        $prezzo = $conn->real_escape_string($prezzo);
        $stato = $conn->real_escape_string($stato);
        $quantita = intval($quantita);
        $ordine_id = intval($ordine_id);

        // Se è stato selezionato "Nuovo ordine", creiamo un ordine
        if ($ordine_id == 0) {
            $conn->query("INSERT INTO ordini (stato, totale) VALUES ('In lavorazione', 0)");
            $ordine_id = $conn->insert_id;
        }

        // Inserire i prodotti nel database
        for ($i = 0; $i < $quantita; $i++) {
            $conn->query("INSERT INTO prodotti (nome, prezzo, stato, ordine_id) 
                          VALUES ('$nome', '$prezzo', '$stato', '$ordine_id')");
        }

        $messaggio = "<p style='color:green;'>Aggiunti $quantita prodotti con nome '$nome' all'ordine #$ordine_id!</p>";
    } else {
        $messaggio = "<p style='color:red;'>Errore: Assicurati di compilare tutti i campi correttamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Prodotti</title>
</head>
<body>

<h2>Aggiungi un Nuovo Prodotto</h2>
<?php echo $messaggio; ?>

<form action="inserisci.php" method="POST">
    Nome: <input type="text" name="nome" required><br>
    Prezzo: <input type="number" name="prezzo" step="0.01" required><br>
    Stato: <input type="text" name="stato" required><br>
    Quantità: <input type="number" name="quantita" min="1" required><br>

    <label for="ordine_id">Seleziona Ordine:</label>
    <select name="ordine_id" required>
        <option value="0">🆕 Nuovo Ordine</option>
        <?php while ($ordine = $ordini->fetch_assoc()): ?>
            <option value="<?php echo $ordine['id']; ?>">Ordine #<?php echo $ordine['id']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <button type="submit">Aggiungi Prodotto</button>
</form>

</body>
</html>

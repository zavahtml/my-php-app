<?php
include 'connessione.php'; // Connessione al database Railway

// Ottenere tutti gli ordini
$ordini = $conn->query("SELECT * FROM ordini ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Prodotti per Ordine</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Lista Prodotti per Ordine</h2>

<?php
if ($ordini->num_rows > 0) {
    while ($ordine = $ordini->fetch_assoc()) {
        echo "<h3>Ordine #" . $ordine['id'] . " - Stato: " . $ordine['stato'] . "</h3>";

        // Recuperiamo i prodotti dell'ordine
        $prodotti = $conn->query("SELECT * FROM prodotti WHERE ordine_id = " . $ordine['id']);

        if ($prodotti->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Prezzo (€)</th>
                        <th>Stato</th>
                    </tr>";

            while ($row = $prodotti->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['prezzo']}€</td>
                        <td>{$row['stato']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nessun prodotto in questo ordine.</p>";
        }
    }
} else {
    echo "<p>Nessun ordine disponibile.</p>";
}

$conn->close();
?>

<div class="link-container">
    <a href="index.html">🏠 Torna alla Home</a>
</div>

</body>
</html>

<?php
include 'connessione.php'; // Connessione al database Railway

$sql = "SELECT * FROM prodotti";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Lista Prodotti</h2>";
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Prezzo</th>
    <th>Stato</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nome']}</td>
            <td>{$row['prezzo']}</td>
            <td>{$row['stato']}</td>
        </tr>";
    }

    echo "</table>";
} else {
    echo "Nessun prodotto trovato.";
}

$conn->close();
?>

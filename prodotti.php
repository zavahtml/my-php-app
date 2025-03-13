<?php
include 'connessione.php'; // Connessione al database Railway

$sql = "SELECT * FROM prodotti";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Prodotti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<h2>Lista Prodotti</h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Prezzo (€)</th>
                <th>Stato</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome']}</td>
                <td>{$row['prezzo']}€</td>
                <td>{$row['stato']}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>Nessun prodotto disponibile.</p>";
}

$conn->close();
?>

</body>
</html>

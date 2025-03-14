<?php
include 'connessione.php'; // Connessione al database Railway

// Recupera la lista degli ordini
$result = $conn->query("SELECT id FROM ordini ORDER BY id DESC");

$ordini = [];
while ($row = $result->fetch_assoc()) {
    $ordini[] = $row;
}

// Restituisce la lista degli ordini in formato JSON
header('Content-Type: application/json');
echo json_encode($ordini);

$conn->close();
?>

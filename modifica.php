<?php
include 'connessione.php';

$messaggio = "";
$prodotto = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerca"])) {
    $id = $_POST["id"];
    if (!empty($id) && is_numeric($id)) {
        $sql = "SELECT * FROM prodotti WHERE id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $prodotto = $result->fetch_assoc();
        } else {
            $messaggio = "<p style='color:red;'>Nessun prodotto trovato con questo ID.</p>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifica"])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $stato = $_POST['stato'];

    if (!empty($id) && is_numeric($id)) {
        $sql = "UPDATE prodotti SET nome = '$nome', prezzo = '$prezzo', stato = '$stato' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $messaggio = "<p style='color:green;'>Prodotto modificato!</p>";
        } else {
            $messaggio = "<p style='color:red;'>Errore: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Prodotto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Modifica un Prodotto</h2>
<?php echo $messaggio; ?>

<form method="POST">
    <input type="number" name="id" placeholder="ID Prodotto" required>
    <button type="submit" name="cerca">Cerca</button>
</form>

<?php if ($prodotto): ?>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $prodotto["id"]; ?>">
    <input type="text" name="nome" value="<?php echo $prodotto["nome"]; ?>">
    <input type="number" name="prezzo" step="0.01" value="<?php echo $prodotto["prezzo"]; ?>">
    <input type="text" name="stato" value="<?php echo $prodotto["stato"]; ?>">
    <button type="submit" name="modifica">Salva</button>
</form>
<?php endif; ?>

<div class="link-container">
    <a href="index.html">🏠 Torna alla Home</a>
</div>

</body>
</html>

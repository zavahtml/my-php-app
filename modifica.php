<?php
include 'connessione.php'; // Connessione al database Railway

$messaggio = "";
$prodotto = null;

// Se viene inviato l'ID, carichiamo i dettagli del prodotto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerca"])) {
    $id = $_POST["id"];
    if (!empty($id) && is_numeric($id)) {
        $id = $conn->real_escape_string($id);
        $sql = "SELECT * FROM prodotti WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $prodotto = $result->fetch_assoc();
        } else {
            $messaggio = "<p style='color:red;'>Errore: Nessun prodotto trovato con questo ID.</p>";
        }
    }
}

// Se viene inviata una modifica
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifica"])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $stato = $_POST['stato'];

    if (!empty($id) && is_numeric($id)) {
        $id = $conn->real_escape_string($id);
        $nome = $conn->real_escape_string($nome);
        $prezzo = $conn->real_escape_string($prezzo);
        $stato = $conn->real_escape_string($stato);

        $sql = "UPDATE prodotti SET nome = '$nome', prezzo = '$prezzo', stato = '$stato' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $messaggio = "<p style='color:green;'>Prodotto modificato con successo!</p>";
        } else {
            $messaggio = "<p style='color:red;'>Errore durante la modifica: " . $conn->error . "</p>";
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
    <title>Modifica Prodotto</title>
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
        input {
            padding: 8px;
            margin: 10px 0;
            width: 100%;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Modifica un Prodotto</h2>
<?php echo $messaggio; ?>

<!-- Form per cercare il prodotto -->
<form method="POST">
    <label for="id">Inserisci ID del prodotto da modificare:</label><br>
    <input type="number" name="id" required><br>
    <button type="submit" name="cerca">Cerca Prodotto</button>
</form>

<?php if ($prodotto): ?>
    <!-- Form per modificare il prodotto -->
    <h3>Modifica Prodotto ID: <?php echo $prodotto["id"]; ?></h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $prodotto["id"]; ?>">
        
        <label for="nome">Nome:</label><br>
        <input type="text" name="nome" value="<?php echo $prodotto["nome"]; ?>" required><br>

        <label for="prezzo">Prezzo:</label><br>
        <input type="number" name="prezzo" step="0.01" value="<?php echo $prodotto["prezzo"]; ?>" required><br>

        <label for="stato">Stato:</label><br>
        <input type="text" name="stato" value="<?php echo $prodotto["stato"]; ?>" required><br>

        <button type="submit" name="modifica">Salva Modifica</button>
    </form>
<?php endif; ?>

<a href="prodotti.php">🔙 Torna alla lista prodotti</a>

</body>
</html>

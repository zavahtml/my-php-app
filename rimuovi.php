if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    if (!empty($id) && is_numeric($id)) {
        $id = $conn->real_escape_string($id);

        // Controlliamo se l'ID esiste
        $check_sql = "SELECT * FROM prodotti WHERE id = $id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Se l'ID esiste, eliminiamo il prodotto
            $sql = "DELETE FROM prodotti WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "<p style='color:green;'>Prodotto eliminato con successo!</p>";

                // Riorganizza gli ID: resetta e ricrea l'indice
                $conn->query("SET @count = 0;");
                $conn->query("UPDATE prodotti SET id = @count:= @count + 1;");
                $conn->query("ALTER TABLE prodotti AUTO_INCREMENT = 1;");
                
            } else {
                echo "<p style='color:red;'>Errore durante l'eliminazione: " . $conn->error . "</p>";
            }
        } else {
            echo "<p style='color:red;'>Errore: Nessun prodotto trovato con questo ID.</p>";
        }
    } else {
        echo "<p style='color:red;'>Errore: Inserisci un ID valido.</p>";
    }
}

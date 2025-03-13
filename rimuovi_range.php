<?php
include 'connessione.php'; // Connessione al database Railway

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_inizio = $_POST['id_inizio'];
    $id_fine = $_POST['id_fine'];

    if (!empty($id_inizio) && !empty($id_fine) && is_numeric($id_inizio) && is_numeric($id_fine)) {
        $id_inizio = intval($conn->real_escape_string($id_inizio));
        $id_fine = intval($conn->real_escape_string($id_fine));

        if ($id_inizio <= $id_fine) {
            // Controlliamo se esistono prodotti in questo range
            $check_sql = "SELECT * FROM prodotti WHERE id BETWEEN $id_inizio AND $id_fine";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows > 0) {
                // 1️⃣ Eliminiamo tutti i prodotti nell'intervallo di ID specificato
                $sql = "DELETE FROM prodotti WHERE id BETWEEN $id_inizio AND $id_fine";
                if ($conn->query($sql) === TRUE) {
                    echo "<p style='color:green;'>Prodotti eliminati con successo (ID da $id_inizio a $id_fine)!</p>";

                    // 2️⃣ Riordinare gli ID rimanenti
                    $conn->query("SET @count = 0;");
                    $conn->query("UPDATE prodotti SET id = @count:= @count + 1;");
                    
                    // 3️⃣ Resettare AUTO_INCREMENT al valore corretto
                    $conn->query("ALTER TABLE prodotti AUTO_INCREMENT = 1;");

                } else {
                    echo "<p style='color:red;'>Errore durante l'eliminazione: " . $conn->error . "</p>";
                }
            } else {
                echo "<p style='color:red;'>Errore: Nessun prodotto trovato in questo intervallo di ID.</p>";
            }
        } else {
            echo "<p style='color:red;'>Errore: L'ID iniziale deve essere minore o uguale all'ID finale.</p>";
        }
    } else {
        echo "<p style='color:red;'>Errore: Inserisci ID validi.</p>";
    }
}
?>

<?php
include 'includes/config.php';

if(isset($_POST['id']) && isset($_POST['ruolo']) && isset($_POST['nome']) && isset($_POST['squadra']) && isset($_POST['prezzo']) && isset($_POST['lista']) && isset($_POST['utente']) && isset($_POST['team'])) {
    $id = $_POST['id'];
    $ruolo = $_POST['ruolo'];
    $nome = $_POST['nome'];
    $squadra = $_POST['squadra'];
    $prezzo = $_POST['prezzo'];
    $lista = $_POST['lista'];
    $utente = $_POST['utente'];
    $team = $_POST['team'];

    try {
        $stmt = $pdo->prepare("INSERT INTO calciatori_liste (id, ruolo, nome, squadra, prezzo, lista, utente, team) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id, $ruolo, $nome, $squadra, $prezzo, $lista, $utente, $team]);
        echo "Calciatore inserito con successo";
    } catch(PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }
}
?>
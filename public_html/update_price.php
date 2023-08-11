<?php
include 'includes/config.php';

$response = [
    'status' => 'error',
    'message' => 'Errore sconosciuto'
];

if(isset($_POST['id']) && isset($_POST['prezzo'])) {
    $id = $_POST['id'];
    $prezzo = $_POST['prezzo'];
    $team = isset($_POST['team']) ? $_POST['team'] : null;

    try {
        $stmt = $pdo->prepare("UPDATE calciatori_liste SET prezzo = ? WHERE id = ?");
        $stmt->execute([$prezzo, $id]);
        
        if ($stmt->rowCount() > 0) { 
            $stmt = $pdo->prepare("SELECT * FROM calciatori_liste WHERE id = ?");
            $stmt->execute([$id]);
            $player = $stmt->fetch(PDO::FETCH_ASSOC);

            // Controlla se la colonna 'team' esiste nel risultato e assegnale un valore di default se non esiste.
            if(!isset($player['team'])) {
                $player['team'] = "Unknown Team";
            }
            
            $response['status'] = 'success';
            $response['message'] = 'Prezzo aggiornato con successo';
            $response['player'] = $player;
        } else {
            $response['message'] = "Nessuna riga aggiornata.";
        }

    } catch(PDOException $e) {
        $response['message'] = "Errore nell'aggiornamento del prezzo: " . $e->getMessage();
    }
} else {
    $response['message'] = "Dati POST incompleti o mancanti.";
}

echo json_encode($response);
?>
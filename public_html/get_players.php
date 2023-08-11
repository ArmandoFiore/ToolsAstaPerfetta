<?php
include 'includes/config.php';

$response = [
    'status' => 'error',
    'data' => []
];

try {
    $stmt = $pdo->prepare("SELECT * FROM calciatori_liste");
    $stmt->execute();
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($players) {
        $response['status'] = 'success';
        $response['data'] = $players;
    }

} catch(PDOException $e) {
    $response['message'] = "Errore nel recupero dei calciatori: " . $e->getMessage();
}

echo json_encode($response);
?>
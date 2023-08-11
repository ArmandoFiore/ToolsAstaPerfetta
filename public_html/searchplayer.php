<?php
include 'includes/config.php';

$response = [];

if (isset($_POST['query'])) {
    $query = $_POST['query'];

    $stmt = $pdo->prepare("SELECT * FROM calciatori WHERE nome LIKE :query LIMIT 10");
    $stmt->execute(['query' => "%" . $query . "%"]);

    if ($stmt->rowCount()) {
        while ($row = $stmt->fetch()) {
            $response[] = [
                'id' => $row['id'],
                'ruolo' => $row['ruolo'],
                'nome' => $row['nome'],
                'squadra' => $row['squadra'],
                'prezzo' => $row['prezzo'],
            ];
        }
    }
}

echo json_encode($response);
?>
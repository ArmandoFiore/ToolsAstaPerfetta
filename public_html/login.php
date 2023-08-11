<?php
include 'includes/config.php';
session_start();

if (isset($_SESSION['username'])) {
    // Se l'utente è già connesso, reindirizzalo alla pagina principale
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Utente esistente: Imposta la sessione e reindirizza
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        // Nuovo utente: Genera e salva i nuovi dati
        $stmt = $pdo->prepare("INSERT INTO users (username) VALUES (?)");
        $stmt->execute([$username]);

        // Imposta la sessione e reindirizza
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card rounded">
                
                <!-- Card Image -->
                <img src="assets/login-img.gif" class="card-img-top" alt="Login" style="width: 40%; margin: 10px auto;">

                <!-- Card Body & Form -->
                <div class="card-body">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- JS Dependencies for Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
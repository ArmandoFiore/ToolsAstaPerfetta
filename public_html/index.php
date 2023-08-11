<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Se l'utente non è connesso, reindirizzalo alla pagina di login
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calciatori Manager</title>
    <script src="https://kit.fontawesome.com/e2bc1db4cc.js" crossorigin="anonymous"></script>
    <!-- Bootstrap 4.5.2 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-4">
    <!-- Sezione di Ricerca e Inserimento -->
    <div class="search-section mb-4">
        <h2>Ricerca Calciatori</h2>
        <div class="input-group mb-3" style="display: block;">
            <input type="text" id="searchBox" class="form-control" placeholder="Cerca un calciatore..." style="width: 100%;">
            <ul id="searchResults" style="width: 100%;"></ul>
        </div>
        <div class="player-details">
            <input type="hidden" id="playerId">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" id="nomeInput" class="form-control">
            </div>
            <div class="mb-3">
                <input type="hidden" id="ruoloInput" class="form-control">
            </div>
            <div class="mb-3">
                <input type="hidden" id="squadraInput" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Prezzo</label>
                <input type="number" id="prezzoInput" class="form-control" step="0.01">
            </div>
            <button id="addToList" class="btn btn-primary">Aggiungi ai Preferiti</button>
        </div>
    </div>

    <!-- Sezione delle Liste -->
    <div class="lists-section row">
        <div class="list col-md-4" id="favoritesList">
            <h3>Preferiti</h3>
            <!-- Qui verranno inseriti i calciatori aggiunti ai preferiti -->
        </div>
        
        <div class="list col-md-4" id="purchasedList">
            <h3>Acquistati</h3>
            <!-- Qui verranno inseriti i calciatori acquistati -->
        </div>

        <div class="list col-md-4" id="notPurchasedList">
            <h3>Non Acquistati</h3>
            <div id="notPurchasedList">
            <!-- Gli elenchi dei teams saranno inseriti qui -->
            </div>
        </div>
    </div>
</div>

<!-- Modal per modificare il prezzo -->
<div class="modal" id="priceModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifica Prezzo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="number" id="editPriceInput" class="form-control" step="0.01" placeholder="Inserisci il nuovo prezzo">
                <select id="teamSelect" class="form-control" style="margin-top: 10px;">
                <option value="AC Santa Rita">AC Santa Rita</option>
                <option value="AJAJAX Brazorf">AJAJAX Brazorf</option>
                <option value="FC Barbara D Urso">FC Barbara D'Urso</option>
                <option value="FC Internazionale">FC Internazionale</option>
                <option value="Milan e Shiro">Milan e Shiro</option>
                <option value="Paris Saint Gennar">Paris Saint Gennar</option>
                <option value="Real Lupacchiotta">Real Lupacchiotta</option>
                <option value="Scarsenal">Scarsenal</option>
                <option value="SSC HorizonCraft">SSC HorizonCraft</option>
</select>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary savePriceBtn">Salva</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap 4.5.2 JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="scripts.js"></script>
</body>
</html>

$(document).ready(function() {
    
    // Ricerca giocatori
    $("#searchBox").on('keyup', function() {
        let query = $(this).val();

        $.ajax({
            url: 'searchplayer.php',
            method: 'POST',
            data: { query: query },
            success: function(response) {
                const results = JSON.parse(response);
                $("#searchResults").empty();

                results.forEach(player => {
                    const playerInfo = `${player.ruolo} - ${player.nome} - ${player.squadra} - Prezzo: ${player.prezzo}`;
                    $("#searchResults").append(
                        `<a href="#" class="list-group-item list-group-item-action" 
                              data-id="${player.id}" 
                              data-nome="${player.nome}" 
                              data-ruolo="${player.ruolo}"
                              data-squadra="${player.squadra}"
                              data-prezzo="${player.prezzo}">
                            ${playerInfo}
                        </a>`
                    );
                });
            }
        });
    });
    
    // Click sul calciatore dalla lista
    $("#searchResults").on('click', '.list-group-item', function(event) {
        event.preventDefault();

        const id = $(this).data('id');
        const ruolo = $(this).data('ruolo');
        const nome = $(this).data('nome');
        const squadra = $(this).data('squadra');
        const prezzo = $(this).data('prezzo');

        $("#playerId").val(id);
        $("#ruoloInput").val(ruolo);
        $("#nomeInput").val(nome);
        $("#squadraInput").val(squadra);
        $("#prezzoInput").val(prezzo);

        $("#searchResults").empty();
    });
    
    $("#addToList").on('click', function(event) {
        event.preventDefault();

        let playerData = {
            id: $("#playerId").val(),
            ruolo: $("#ruoloInput").val(),
            nome: $("#nomeInput").val(),
            squadra: $("#squadraInput").val(),
            prezzo: $("#prezzoInput").val(),
            lista: 'preferiti',
            utente: 'nome_utente',
            team: 'nome_team'
        };

        $.ajax({
            url: 'add_favorite.php',
            method: 'POST',
            data: playerData,
            success: function(response) {
                alert(response);
                
                if (response.includes("successo")) {
                    const playerInfo = `<span style="color: white;background-color: lightcoral;padding: 5px;border-radius: 3px;">${playerData.ruolo}</span> - ${playerData.nome} - <span style="color: white;background-color: darkgoldenrod;padding: 5px;border-radius: 3px;">${playerData.squadra}</span> - ${playerData.prezzo} <img src="assets/icon-currency.gif"/ width="25px;">`;
                    $("#favoritesList").append(
                        `<div class="list-group-item" data-playerId="${playerData.id}">
                            <span>${playerInfo}</span>
                            <span class="float-right">
                                <button class="btn btn-success buyBtn"><i class="fa-solid fa-check"></i></button>
                                <button class="btn btn-warning notBuyBtn"><i class="fa-solid fa-x"></i></button>
                            </span>
                        </div>`
                    );
                }
                // Pulisci i campi di input
                $("#playerId").val('');
                $("#ruoloInput").val('');
                $("#nomeInput").val('');
                $("#squadraInput").val('');
                $("#prezzoInput").val('');
            }
        });
    });

$("#favoritesList").on('click', '.buyBtn, .notBuyBtn', function() {
    const playerId = $(this).closest('.list-group-item').data('playerid');
    const playerPrice = $(this).closest('.list-group-item').find('.playerPrice').text();

    $("#editPriceInput").val(playerPrice);
    const action = $(this).hasClass('buyBtn') ? 'buy' : 'notBuy';
    $("#priceModal").data('playerId', playerId).data('action', action).modal('show');

    if (action === 'notBuy') {
        $("#teamSelect").show();
    } else {
        $("#teamSelect").hide();
    }
});

$(".savePriceBtn").on('click', function() {
    const prezzo = $("#editPriceInput").val();
    const playerId = $("#priceModal").data('playerId');
    const action = $("#priceModal").data('action');
    const team = $("#teamSelect").val();

    $.ajax({
        url: 'update_price.php',
        method: 'POST',
        data: {
            id: playerId,
            prezzo: prezzo,
            team: team
        },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === 'success') {
                const playerInfo = `${data.player.ruolo} - ${data.player.nome} - ${data.player.squadra} - Prezzo: ${data.player.prezzo}`;
                
                // Qui rimuovi l'elemento dalla lista dei preferiti
                $(`.list-group-item[data-playerId=${playerId}]`).remove();

                // E lo aggiungi alla lista degli acquistati o non acquistati
                if (action === 'buy') {
                    $("#purchasedList").append(`<div class="list-group-item">${playerInfo}</div>`);
                } else {
                    updateNotPurchasedList(data.player.squadra, parseFloat(data.player.prezzo));
                }
            } else {
                alert(data.message);
            }
            $("#priceModal").modal('hide');
        },
        error: function() {
            alert("Errore nella chiamata AJAX.");
        }
    });

// Funzione per aggiornare la lista dei non acquistati
function updateNotPurchasedList(teamName, playerPrice) {
    let teamElem = $(`#notPurchasedList .team[data-teamName="${teamName}"]`);

    if (teamElem.length === 0) {
        teamElem = $(`<div class="team" data-teamName="${teamName}" data-playerCount="0" data-totalPrice="0.00">
                        ${teamName} - <span class="playerCount">0</span> players - <span class="totalPrice">€0.00</span>
                      </div>`);
        $("#notPurchasedList").append(teamElem);
    }

    const currentCount = parseInt(teamElem.attr('data-playerCount')) || 0;
    const currentTotalPrice = parseFloat(teamElem.attr('data-totalPrice')) || 0.00;

    const newPlayerCount = currentCount + 1;
    const newTotalPrice = currentTotalPrice + playerPrice;

    teamElem.attr('data-playerCount', newPlayerCount);
    teamElem.attr('data-totalPrice', newTotalPrice.toFixed(2));

    teamElem.find('.playerCount').text(newPlayerCount);
    teamElem.find('.totalPrice').text(`€${newTotalPrice.toFixed(2)}`);
}


    $.ajax({
        url: 'get_players.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                for (let player of response.data) {
                    const playerInfo = `${player.ruolo} - ${player.nome} - ${player.squadra} - Prezzo: ${player.prezzo}`;

                    if (/* condizione per determinare se il calciatore è stato acquistato */) {
                        $("#purchasedList").append(`<div class="list-group-item">${playerInfo}</div>`);
                    } else {
                        // Usare la funzione updateNotPurchasedList() se hai già creato una logica per "non acquistati"
                        updateNotPurchasedList(player.squadra, parseFloat(player.prezzo));
                    }
                }
            }
        },
        error: function() {
            alert("Errore nel caricamento dei calciatori.");
        }
    });
    
});

});
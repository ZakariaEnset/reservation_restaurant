<?php $title = "Réservation Restaurant - réservation";  ?>

<?php ob_start(); ?>

<div class="container">
    <?php if (!isset($_SESSION['reservation_success'])) { ?>
        <a href="./" class="btn btn-lg m-2"><i class="bi bi-house"></i> Accueil</a>
        <div class="card mt-3   ">
            <h3 class="card-header">Nouvelle Réservation</h3>

            <div class="card-body">
                <form class="row  g-3 align-items-center" action="?action=sauvegarder_reservation" method="POST">
                    <div class="col-md-4">
                        <label for="date_reservation">Data réservation <span class="text-danger">(*)</span></label>
                        <input class="form-control" lang="fr" type="date" name="dateReservation" id="date_reservation">
                    </div>

                    <div class="col-md-3">
                        <label for="date_reservation">Nombre des personnes <span class="text-danger">(*)</span></label>
                        <select class="form-select" name="nbrPersonnes" id="nbr_personnes">
                            <?php for ($i = 2; $i <= 10; $i += 2) :  ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor ?>
                        </select>
                    </div>

                    <input type="hidden" name="idCreneau" id="idCreneau">
                    <input type="hidden" name="idTableRestaurant" id="idTableRestaurant">
                    <div class="col-md-10" id="tableRestaurantBloc"></div>
                    <div class="col-md-10" id="creneauxBloc"></div>

                    <div class="col-md-10" id="blocFinal">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Informations de client</div>
                            </div>
                            <div class="card-body row  g-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="">Nom complete: <span class="text-danger">(*)</span></label>
                                    <input class="form-control" type="text" name="nomClient" id="nom_client">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Email: <span class="text-danger">(*)</span></label>
                                    <input class="form-control" type="email" name="email" id="email">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Télephone:</label>
                                    <input class="form-control" type="text" name="tel" id="tel">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Commentaire</label>
                                    <textarea class="form-control" name="commentaires" id="commentaires"></textarea>
                                </div>
                            </div>
                        </div>
                        <button id="btnSave" disabled class="btn btn-lg btn-success mt-3" type="submit">Sauvegarder</button>
                    </div>
            </div>
        </div>
</div>

<?php } else {
        unset($_SESSION['reservation_success']);  ?>

        <div class="row text-center align-items-center mt-5">
            <div class="alert alert-dismissible alert-success ">
                <h4 class="alert-heading">Bon réservation!</h4>
                <i style="font-size:50px;" class="bi bi-check-circle"></i>
                <p class="my-3"> <a href="?action=add_reservation" class="alert-link"><strong>Nouvelle réservation <i class="bi bi-arrow-up-right"></i></strong></a></p>
            </div>
        </div>

<?php } ?>
</div>

<script>
    const emailRx = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var date_reservation;
    $(function() {
        let minDateReservation = new Date();
        minDateReservation.setDate(new Date().getDate() + 1);
        $('#date_reservation').val(minDateReservation.toISOString().split('T')[0]);
        $('#date_reservation').attr('min', minDateReservation.toISOString().split('T')[0]);
        $('#date_reservation').on('change', function(event) {
            date_reservation = $(event.target).val();
            let creneaux = $.get('?action=api_get_creneaux', {
                date: date_reservation
            });
            creneaux.done(function(data) {
                data = JSON.parse(data);
                $('#creneauxBloc').html('');
                $('#tableRestaurantBloc').html('');
                $('#idTableRestaurant').val('');
                data.forEach(creneau => {
                    let btnCreneau = document.createElement('button');
                    $(btnCreneau).addClass(`col-md-2 btn btn-lg btn-primary m-2 creneauBtn`);
                    $(btnCreneau).attr('type', 'button');
                    $(btnCreneau).attr('id', `creneau${creneau.id}`);
                    $(btnCreneau).data('id-creneau', creneau.id);
                    $(btnCreneau).text(creneau.heure);
                    $('#creneauxBloc').append(btnCreneau);
                });

                $('.creneauBtn').on('click',async function(event) {
                    $('#idCreneau').val($(event.currentTarget).data('id-creneau'));
                    $('.creneauBtn').removeClass('bg-info');
                    $(event.currentTarget).addClass('bg-info');

                    await getTableRestaurant(date_reservation, $('#idCreneau').val(), $('#nbr_personnes').val());
                    validateForm();
                });
            });
        });
        $('#date_reservation').trigger('change');

        $('#nbr_personnes').on('change', async function(event) {
            await getTableRestaurant(date_reservation, $('#idCreneau').val(), $('#nbr_personnes').val());
            validateForm();
        });

        $('#date_reservation, #nom_client, #email, #tel').on('change', function() {
            validateForm();
        });
    });

    function validateForm(){
        if (date_reservation != null 
            && $('#idCreneau').val() != ''
            && $('#nbr_personnes').val() != '' 
            && $('#idTableRestaurant').val() != ''
            && $('#nom_client').val().length > 3
            && emailRx.test($('#email').val())) {

            $('#btnSave').removeAttr('disabled');
        } else {
            $('#btnSave').attr('disabled', 'disabled');
        }
    }

    function getTableRestaurant(date, creneau, nbr_personnes) {
        let tableRestaurant = $.get('?action=api_get_available_table', {
            date: date,
            creneau: creneau,
            nbr_personnes: nbr_personnes
        });
        tableRestaurant.done(function(data) {
            data = JSON.parse(data);
            if (data && data.id != 0) {
                $('#tableRestaurantBloc').html('');
                $('#tableRestaurantBloc').append(`<div class='alert alert-light'>La table <strong>N° ${data.numero}</strong> zone: <strong>${data.zone}</strong> </div>`);
                $('#idTableRestaurant').val(data.id)
            } else {
                if($('#idCreneau').val() != ''){
                   $('#tableRestaurantBloc').html(`<div class='alert alert-warning'> Aucune table disponible à ces choix ! </div>`);
                }
                $('#idTableRestaurant').val('');
            }
            validateForm();
        });
    }
</script>
<?php $content = ob_get_clean(); ?>
<?php require('layouts/layout.php'); ?>
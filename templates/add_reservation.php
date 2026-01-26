<?php $title = "Réservation Restaurant";  ?>

<?php ob_start(); ?>
<h1>Nouvelle réservation</h1>


<div class="container">

    <?php if (!isset($_SESSION['reservation_success'])) { ?>

        <form class="row  g-3 align-items-center" action="?action=sauvegarder_reservation" method="POST">
            <div class="col-md-4">
                <label for="date_reservation">Data réservation</label>
                <input class="form-control" lang="fr" type="date" name="dateReservation" id="date_reservation">
            </div>

            <div class="col-md-3">
                <label for="date_reservation">Nombre des personnes</label>
                <select class="form-select" name="nbrPersonnes" id="nbr_personnes">
                    <?php for ($i = 2; $i <= 10; $i += 2) :  ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor ?>
                </select>
            </div>

            <input type="hidden" name="idCreneau" id="idCreneau">
            <input type="hidden" name="idTableRestaurant" id="idTableRestaurant">
            <div class="col-md-10" id="tableRestaurantBloc"></div>

            <div class="col-md-10" id="creneauxBloc">

            </div>

            <div class="col-md-10" id="blocFinal">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Informations de client</div>
                    </div>
                    <div class="card-body row  g-3 align-items-center">
                        <div class="col-md-3">
                            <label for="">Nom complete: </label>
                            <input class="form-control" type="text" name="nomClient" id="nom_client">
                        </div>
                        <div class="col-md-3">
                            <label for="">Email:</label>
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

        <?php } else {  unset($_SESSION['reservation_success']);  ?>

            <div class="alert alert-dismissible alert-success">
                <h4 class="alert-heading">Bon réservation!</h4>
                <p class="mb-0"> <a href="?action=add_reservation" class="alert-link">Nouvelle réservation</a>.</p>
            </div>

        <?php } ?>
</div>

<script>
    $(function() {
        var date_reservation;
        const emailRx = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z-0-9]+\.)+[a-zA-Z]{2,}))$/;

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
                    let not_avaiable_cls = '';
                    if (!creneau.is_available) {
                        not_avaiable_cls = 'disabled bg-light';
                        // when we have after changes of date_reservation and nbr_persones
                        // available creneu used before is the same this one, now  we should clear the value of input
                        if ($('#idCreneau').val() == creneau.id) {
                            $('#idCreneau').val('');
                            $('#idTableRestaurant').val('');
                        }
                    }
                    // `<button type='button' class='col-md-2 btn btn-lg btn-primary  ${not_avaiable_cls} m-2 creneauBtn ' id="creneau${creneau.id}" data-id-creneau=${creneau.id}>${creneau.heure}</button>
                    let btnCreneau = document.createElement('button');
                    $(btnCreneau).addClass(`col-md-2 btn btn-lg btn-primary  ${not_avaiable_cls} m-2 creneauBtn`);
                    $(btnCreneau).attr('type', 'button');
                    $(btnCreneau).attr('id', `creneau${creneau.id}`);
                    $(btnCreneau).data('id-creneau', creneau.id);

                    $(btnCreneau).text(creneau.heure);
                    $('#creneauxBloc').append(btnCreneau);
                });

                $('.creneauBtn').on('click', function(event) {
                    $('#idCreneau').val($(event.currentTarget).data('id-creneau'));
                    $('.creneauBtn').removeClass('bg-info');
                    $(event.currentTarget).addClass('bg-info');

                    getTableRestaurant(date_reservation, $('#idCreneau').val(), $('#nbr_personnes').val());
                });
            });
        });
        $('#date_reservation').trigger('change');

        $('#nbr_personnes').on('change', function(event) {
            getTableRestaurant(date_reservation, $('#idCreneau').val(), $('#nbr_personnes').val(), $('#idCreneau').val());
        });

        $('#date_reservation, #nbr_personnes, #nom_client, #email, #tel, #idCreneau').on('change blur', function() {
            if (date_reservation != null && $('#idCreneau').val() != null && $('#nbr_personnes').val() != null && $('#idCreneau').val() &&
                $('#idTableRestaurant').val() != null && $('#nom_client').val().length > 3 && emailRx.test($('#email').val())) {
                $('#btnSave').removeAttr('disabled');
            } else {
                $('#btnSave').attr('disabled', 'disabled');
            }
        });

    });



    function getTableRestaurant(date, creneau, nbr_personnes) {
        let tableRestaurant = $.get('?action=api_get_available_table', {
            date: date,
            creneau: creneau,
            nbr_personnes: nbr_personnes
        });

        tableRestaurant.done(function(data) {
            data = JSON.parse(data);
            if (data !== null) {
                $('#tableRestaurantBloc').html('');
                $('#tableRestaurantBloc').append(`<div class='alert alert-light'>La table <strong>N° ${data.numero}</strong> zone: <strong>${data.zone}</strong> </div>`);
                $('#idTableRestaurant').val(data.id)
            } else {
                $('#tableRestaurantBloc').html(`<div class='alert alert-warning'> Aucune table disponible à ces conditions ! </div>`);
                $('#idTableRestaurant').val('');
            }

        });
    }
</script>

<?php $content = ob_get_clean(); ?>
<?php require('layouts/layout.php'); ?>
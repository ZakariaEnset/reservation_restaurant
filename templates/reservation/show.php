<?php $title = "Réservation Restaurant - Gestion reservations";  ?>

<?php ob_start(); ?>

<h1>Gestion des reservations (<?= count($reservations) ?>)</h1>
<div class="card my-2">
    <div class="card-header bg-light">
        <h4>Filtres</h4>
    </div>
    <div class="card-body">
        <form action="" method="get">
            <input type="hidden" name="action" value="reservations">
            <div class="form-group">
                <label for="">Statut:</label>
                <select class="form-select" name="statut" id="statutFilter" onchange="submit()">
                    <option value="">Tous</option>
                    <option <?php echo $_GET['statut'] == 'en_attente' ? 'selected' : '' ?> value="en_attente">en_attente</option>
                    <option <?php echo $_GET['statut'] == 'confirmee' ? 'selected' : '' ?> value="confirmee">confirmee</option>
                    <option <?php echo $_GET['statut'] == 'annulee' ? 'selected' : '' ?> value="annulee">annulee</option>
                </select>
            </div>
        </form>
    </div>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Date réservation</th>
            <th>Heure</th>
            <th>Table</th>
            <th>Client</th>
            <th>Email</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $reservation) { ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($reservation['date_reservation'])) ?></td>
                <td><?= $reservation['heure_creneau']  ?></td>
                <td><?php echo 'Table N° ' . $reservation['numero_table'] . ' (' . $reservation['zone_table']  . ')'; ?></td>
                <td><?= $reservation['nom_client']  ?></td>
                <td><?= $reservation['email']  ?></td>
                <td>
                    <?php $clsBadge = '';
                    switch ($reservation['statut']) {
                        case 'confirmee':
                            $clsBadge = 'success';
                            break;
                        case 'annulee':
                            $clsBadge = 'danger';
                            break;
                        default:
                            $clsBadge = 'light';
                    }

                    ?>
                    <span class="badge text-bg-<?= $clsBadge ?>"><?= $reservation['statut'] ?></span>
                </td>
                <td class="d-flex">
                    <a type="button" title="modifier statut" class="edit-btn btn btn-sm bg-warning mx-1" data-id="<?= $reservation['id'] ?>" data-statut=<?= $reservation['statut'] ?>>
                        <i class="bi bi-pencil-square"></i> Statut
                    </a>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="reservationStatutModal" tabindex="-1" aria-labelledby="reservationStatutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="reservationStatutModalLabel">Changer staut</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reservationStatutForm" action="?action=change_statut_reservation" method="POST">

                    <div class="form-group">
                        <label for="">Statut</label>
                        <select class="form-select" name="statut" id="statut">
                            <option value="en_attente">en_attente</option>
                            <option value="confirmee">confirmee</option>
                            <option value="annulee">annulee</option>
                        </select>
                    </div>

                    <input type="hidden" name="id" id="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button form="reservationStatutForm" type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.edit-btn').click(function(e) {
            id = $(e.currentTarget).data('id');
            statut = $(e.currentTarget).data('statut');
            $('#id').val(id);
            $('#statut').val(statut).change();

            $('#reservationStatutModal').modal('show');
        });


        $("#reservationStatutModal").on("hidden.bs.modal", function() {
            $('#reservationStatutForm').get(0).reset();
        });
    });
</script>

<?php $content = ob_get_clean(); ?>


<?php require('templates/layouts/admin_layout.php'); ?>
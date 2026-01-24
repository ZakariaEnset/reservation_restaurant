<?php $title = "Réservation Restaurant - Gestion tables";  ?>

<?php ob_start(); ?>

<h1>Gestion des tables restaurant (<?= count($tables) ?>)
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tableReservationModal">
    <i class="bi bi-plus-square"></i>
  </button>
</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>N°</th>
            <th>Capacite</th>
            <th>Zone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
       <?php foreach($tables as $table) { ?>
        <tr>
            <td><?= $table->numero ?></td>
            <td><?= $table->capacite ?></td>
            <td><?= htmlspecialchars($table->zone) ?></td>
            <td class="d-flex">
                <button title="modifier" class="edit-btn btn btn-sm bg-warning mx-1" data-id="<?= $table->id ?>">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <form action="?action=delete_table_restaurant" method="POST">
                  <input type="hidden" name="id" value="<?= $table->id ?>">
                  <button title="supprimer" type="submit" class="btn btn-sm bg-danger text-light">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>

            </td>
        </tr>
     <?php } ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="tableReservationModal" tabindex="-1" aria-labelledby="tableReservationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tableReservationModalLabel">Ajouter table restaurant</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="tableReservationForm" action="?action=add_table_restaurant" method="POST">
            <div class="form-group">
                <label for="">Numero</label>
                <input class="form-control" type="number" name="numero" id="numero">
            </div>

            <div class="form-group">
                <label for="">capacité</label>
                <input class="form-control" type="number" name="capacite" id="capacite">
            </div>

            <div class="form-group">
                <label for="">zone</label>
                <input class="form-control" type="text" name="zone" id="zone">
            </div>

            <input type="hidden" name="id" id="id">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button form="tableReservationForm" type="submit" class="btn btn-primary">Sauvegarder</button>
      </div>
    </div>
  </div>
</div>
<script>


$(function() {
  let formAddAction = '?action=add_table_restaurant';
  let formEditAction = '?action=update_table_restaurant';

   $('.edit-btn').click(function(e) {
      id = $(e.currentTarget).data('id');
      let table = $.get('?action=api_get_table_restaurant', { id: id } );
      table.done(function( data ) {
          data = JSON.parse(data);
          $("#tableReservationModalLabel").text('Modifier table restaurant');
          $('#tableReservationForm').attr('action', formEditAction);
          $('#id').val(data.id);
          $('#numero').val(data.numero);
          $('#capacite').val(data.capacite);
          $('#zone').val(data.zone);
          $('#tableReservationModal').modal('show');
      });
    
    }); 
    
    $("#tableReservationModal").on("hidden.bs.modal", function () {
        $("#tableReservationModalLabel").text('Ajouter table restaurant');
        $('#tableReservationForm').attr('action', formAddAction);
        $('#tableReservationForm').get(0).reset();
    });
});

</script>

<?php $content = ob_get_clean(); ?>


<?php require('templates/admin_layout.php'); ?>
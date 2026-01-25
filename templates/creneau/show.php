<?php $title = "Réservation Restaurant - Gestion tables";  ?>

<?php ob_start(); ?>

<h1>Gestion des creneaux (<?= count($creneaux) ?>)
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#creneauModal">
    <i class="bi bi-plus-square"></i>
  </button>
</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Heure</th>
            <th>Service</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
       <?php foreach($creneaux as $creneau) { ?>
        <tr>
            <td><?= htmlspecialchars($creneau->heure) ?></td>
            <td><?= $creneau->service->name ?></td>
            <td class="d-flex">
                <button title="modifier" class="edit-btn btn btn-sm bg-warning mx-1" data-id="<?= $creneau->id ?>">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <form action="?action=delete_creneau" method="POST">
                  <input type="hidden" name="id" value="<?= $creneau->id ?>">
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
<div class="modal fade" id="creneauModal" tabindex="-1" aria-labelledby="creneauModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="creneauModalLabel">Ajouter creneau</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="creneauForm" action="?action=add_creneau" method="POST">
            <div class="form-group">
                <label for="">Heure</label>
                <input class="form-control" type="text" pattern="(?:[01]|2(?![4-9])){1}\d{1}:[0-5]{1}\d{1}" name="heure" id="heure" placeholder="HH:mm">
            </div>

            <div class="form-group">
                <label for="">service</label>
                <select class="form-select" name="service" id="service">
                    <option value="midi">Midi</option>
                    <option value="soir">Soir</option>
                </select>
            </div>
            <input type="hidden" name="id" id="id">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button form="creneauForm" type="submit" class="btn btn-primary">Sauvegarder</button>
      </div>
    </div>
  </div>
</div>
<script>


$(function() {
  let formAddAction = '?action=add_creneau';
  let formEditAction = '?action=update_creneau';

   $('.edit-btn').click(function(e) {
      id = $(e.currentTarget).data('id');
      let table = $.get('?action=api_get_creneau', { id: id } );
      table.done(function( data ) {
          data = JSON.parse(data);
          $("#creneauModalLabel").text('Modifier creneau');
          $('#creneauForm').attr('action', formEditAction);
          $('#id').val(data.id);
          $('#heure').val(data.heure);
          $('#service').val(data.service).change();
          $('#creneauModal').modal('show');
      });
    
    }); 
    
    $("#creneauModal").on("hidden.bs.modal", function () {
        $("#creneauModalLabel").text('Ajouter table restaurant');
        $('#creneauForm').attr('action', formAddAction);
        $('#creneauForm').get(0).reset();
    });
});

</script>

<?php $content = ob_get_clean(); ?>


<?php require('templates/admin_layout.php'); ?>
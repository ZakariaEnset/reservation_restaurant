<?php $title = "Réservation Restaurant - Error";  ?>

<?php ob_start(); ?>

<div class="alert alert-danger mt-5">
    <h3>Une erreur est survenue : <?= $errorMessage ?>  <a href="./">Revenir à l'accueil</a></h3>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layouts/layout.php') ?>
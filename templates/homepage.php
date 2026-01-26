<?php $title = "Réservation Restaurant";  ?>

<?php ob_start(); ?>
<h1>Bienvenu cheez nous !</h1>


<div class="container mx-auto">
    <a href="?action=add_reservation" class="btn btn-lg btn-primary"><h1>Nouvelle Réservation</h1></a>
    <a class="btn btn-lg btn-primary"><h1>Espace Admin</h1></a>

</div>

<?php $content = ob_get_clean(); ?>
<?php require('layouts/layout.php'); ?>
<?php $title = "Réservation Restaurant";  ?>

<?php ob_start(); ?>
<h1>Bienvenu cheez nous !</h1>


<? $content = ob_get_clean(); ?>
<?php require('layout.php'); ?>
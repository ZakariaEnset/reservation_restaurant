<?php $title = "Réservation Restaurant";  ?>

<?php ob_start(); ?>

<style>
.btn-light,
.btn-light:hover,
.btn-light:focus {
  color: #333;
  text-shadow: none; 
}

body {
  text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
  box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
}

.cover-container {
  max-width: 42em;
}
.nav-masthead .nav-link {
  color: rgba(255, 255, 255, .5);
  border-bottom: .25rem solid transparent;
}
.nav-masthead .nav-link:hover,
.nav-masthead .nav-link:focus {
  border-bottom-color: rgba(255, 255, 255, .25);
}
.nav-masthead .nav-link + .nav-link {
  margin-left: 1rem;
}
.nav-masthead .active {
  color: #fff;
  border-bottom-color: #fff;
}
</style>

<div class="d-flex text-center text-bg-dark">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div>
                <h3 class="float-md-start mb-0">Restaurant</h3>
                <nav class="nav nav-masthead justify-content-center float-md-end"> <a
                        class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="#">A Propos</a> 
            </div>
        </header>
        <main class="px-3 mt-5" style="height: 85vh";>
            <h1>Bienvenu chez nous !.</h1>
            <p class="lead">Système de Réservation Restaurant</p>

               <div class="d-flex">
                 <a href="?action=add_reservation" class="btn btn-lg btn-primary w-100">
                    <h1>
                        Nouvelle Réservation
                    </h1>
                </a>
                <a href="?action=dashboard" class="btn btn-lg btn-primary w-100">
                    <h1>Espace Admin</h1>
                </a>
               </div>
        </main>

    </div>
</div>




<?php $content = ob_get_clean(); ?>
<?php require('layouts/layout.php'); ?>
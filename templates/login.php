<?php $title = "Réservation Restaurant - Login";  ?>

<?php ob_start(); ?>

<style>
    html,
    body {
        height: 100%;
    }

    .form-signin {
        max-width: 330px;
        padding: 1rem;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

<main class="form-signin w-100 m-auto">
    <form action="?action=login" method="POST">
        <h1 class="h3 mb-3 fw-normal">Réservation Restaurant - Admin</h1>
        <div class="form-floating">
            <input type="text" class="form-control" name="username" id="username" placeholder="" require>
            <label for="username">Nom utilisateur</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Password" require> 
            <label for="mdp">Mot de passe</label>
        </div>

        </label> </div> <button class="btn btn-primary w-100 py-2" type="submit">Connecter</button>
    </form>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('layouts/layout.php'); ?>
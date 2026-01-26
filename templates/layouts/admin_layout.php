<?php 
   parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $queryParams);
   $currentAction = $queryParams['action'];
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= $title ?></title>
      <link rel="stylesheet" href="public/css/bootstrap.min.css">
      <link rel="stylesheet" href="public/css/bootstrap-icons.min.css">
      <link rel="stylesheet" href="public/css/dashboard.css">
      <script src="public/js/bootstrap.bundle.min.js"></script>
      <script src="public/js/jquery.min.js"></script>
   </head>
   <body>
      
      <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
         <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="./">Système de Réservation</a>
         <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
               <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                  <svg class="bi" aria-hidden="true">
                     <use xlink:href="#list"></use>
                  </svg>
               </button>
            </li>
         </ul>
         <div id="navbarSearch" class="navbar-search w-100 collapse"> <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search"> </div>
      </header>
      <div class="container-fluid">
         <div class="row" style="height: 90vh;">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
               <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                  <div class="offcanvas-header">
                     <h5 class="offcanvas-title" id="sidebarMenuLabel">Système de Réservation</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                     <ul class="nav flex-column">
                        <li class="nav-item">
                           <a class="nav-link d-flex align-items-center gap-2 <?php echo str_contains($currentAction, 'dashboard') ? 'active' :  '' ?>" aria-current="page" href="?action=dashboard">
                              <i class="bi bi-house-fill"></i>
                              Dashboard
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link d-flex align-items-center gap-2   <?php echo str_contains($currentAction, 'table_restaurant') ? 'active' :  '' ?>" href="?action=table_restaurant" >
                             <i class="bi bi-tablet-fill"></i>
                              Tables restaurant
                           </a>
                        </li>
                         <li class="nav-item">
                           <a class="nav-link d-flex align-items-center gap-2   <?php echo str_contains($currentAction, 'creneaux') ? 'active' :  '' ?>" href="?action=creneaux" >
                             <i class="bi bi-tablet-fill"></i>
                              Creneaux
                           </a>
                        </li>
                     </ul>
                     <!-- <hr class="my-3">  -->
                     <ul class="nav flex-column mb-auto">
                        <!-- <li class="nav-item">
                           <a class="nav-link d-flex align-items-center gap-2" href="#">
                              <svg class="bi" aria-hidden="true">
                                 <use xlink:href="#gear-wide-connected"></use>
                              </svg>
                              Settings
                           </a>
                        </li> -->
                        <li class="nav-item">
                           <a class="nav-link d-flex align-items-center bg-danger text-white border gap-2 text-danger" href="?action=logout">
                              <strong><i class="bi bi-box-arrow-left"></i> Déconnexion</strong>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
               <div class="row mt-1">
                  <?php require_once('templates/include/alert_messages.php'); ?>
               </div>
               <?= $content  ?>
            </main>
         </div>
      </div>
   </body>
</html>
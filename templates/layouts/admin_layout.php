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
   <link rel="stylesheet" href="public/css/timetable.css">

   <script src="public/js/bootstrap.bundle.min.js"></script>
   <script src="public/js/jquery.min.js"></script>
   <script src="public/js/timetable.min.js"></script>

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
                        <a class="nav-link d-flex align-items-center gap-2   <?php echo str_contains($currentAction, 'reservations') ? 'active' :  '' ?>" href="?action=reservations">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fork-knife" viewBox="0 0 16 16">
                              <path d="M13 .5c0-.276-.226-.506-.498-.465-1.703.257-2.94 2.012-3 8.462a.5.5 0 0 0 .498.5c.56.01 1 .13 1 1.003v5.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5zM4.25 0a.25.25 0 0 1 .25.25v5.122a.128.128 0 0 0 .256.006l.233-5.14A.25.25 0 0 1 5.24 0h.522a.25.25 0 0 1 .25.238l.233 5.14a.128.128 0 0 0 .256-.006V.25A.25.25 0 0 1 6.75 0h.29a.5.5 0 0 1 .498.458l.423 5.07a1.69 1.69 0 0 1-1.059 1.711l-.053.022a.92.92 0 0 0-.58.884L6.47 15a.971.971 0 1 1-1.942 0l.202-6.855a.92.92 0 0 0-.58-.884l-.053-.022a1.69 1.69 0 0 1-1.059-1.712L3.462.458A.5.5 0 0 1 3.96 0z" />
                           </svg>
                           Réservations
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2   <?php echo str_contains($currentAction, 'calendrier') ? 'active' :  '' ?>" href="?action=calendrier">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                           </svg>
                           Calendrier
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2   <?php echo str_contains($currentAction, 'table_restaurant') ? 'active' :  '' ?>" href="?action=table_restaurant">
                           <i class="bi bi-tablet-fill"></i>
                           Tables restaurant
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2   <?php echo str_contains($currentAction, 'creneaux') ? 'active' :  '' ?>" href="?action=creneaux">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                           </svg>
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
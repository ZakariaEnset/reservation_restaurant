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

<body class=" h-100 ">
    <div class="row mt-1">
        <?php require_once('templates/include/alert_messages.php'); ?>
    </div>
    <?= $content  ?>
</body>

</html>
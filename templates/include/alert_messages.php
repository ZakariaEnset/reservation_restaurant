<div class="row mt-1">
<?php

// TODO: need imporvement

if (isset($_SESSION['success'])) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['success']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION['success']);
}


if (isset($_SESSION['error'])) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['error']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION['error']);
}


if (isset($_SESSION['warning'])) {
?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['warning']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION['warning']);
}

?>
</div>


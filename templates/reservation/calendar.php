<?php $title = "Réservation Restaurant - Calendrier";  ?>

<?php ob_start(); ?>

<h1>Calendrier</h1>

<style>
    .timetable section header li:not(:last-of-type) {
        width: 20em;
    }


    .timetable ul.room-timeline li:after {
        background-size: 20em auto;

    }

    .timetable .time-entry {
        background: rgb(104 211 145) !important;
        border-color: rgb(60, 124, 84) !important;
        color: black;
    }
</style>
<div class="row">
    <form class="form">
        <input type="hidden" name="action" value="calendrier">
        <div class="col-md-3">
            <div class="form-group">
                <label for="">Date: </label>
                <input class="form-control" type="date" name="date" id="date" onchange="submit()">
            </div>
        </div>
    </form>
    <div class="timetable my-3"></div>
</div>


<script>
    let tables = JSON.parse('<?= $tables ?>');
    let reservations = JSON.parse('<?= $reservations ?>');

    var timetable = new Timetable();
    var locations = tables.map(t => "Table " + t.numero);
    timetable.setScope(12, 23);
    timetable.addLocations(locations);

    function scheduleEvents(referenceDate) {
        reservations.forEach(event => {
            const startDate = new Date(referenceDate);

            startDate.setHours(event.heure_creneau.split(':')[0], 0, 0, 0);

            const endDate = new Date(referenceDate);
            endDate.setHours(event.heure_creneau.split(':')[0], 0, 0, 0);
            endDate.setMinutes(startDate.getMinutes() + 30);

            startDate.setDate(startDate.getDate());
            endDate.setDate(endDate.getDate());

            timetable.addTimeslot(
                event.id,
                'Client: ' + event.nom_client,
                'Table ' + event.numero_table,
                startDate,
                endDate,
                'Statut: ' + event.statut,
                event.commentaires,
                '',
                []
            );
        });
    }

    scheduleEvents(new Date());

    var renderer = new Timetable.Renderer(timetable);
    renderer.draw('.timetable');


    $(function() {
        let dateInput = "<?= isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d')  ?>";
        $('#date').val(dateInput);
    });

</script>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layouts/admin_layout.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EasyBusiness</title>
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    
    <link href='public/js/fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='public/js/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />

    <script src='public/js/fullcalendar/packages/core/main.js'></script>
    <script src='public/js/fullcalendar/packages/daygrid/main.js'></script>

    <script>

function post(path, params, method='post') {

// The rest of this code assumes you are not using a library.
// It can be made less wordy if you use one.
const form = document.createElement('form');
form.method = method;
form.action = path;

for (const key in params) {
  if (params.hasOwnProperty(key)) {
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = key;
    hiddenField.value = params[key];

    form.appendChild(hiddenField);
  }
}

document.body.appendChild(form);
form.submit();
}


        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'dayGrid' ],
            height: 'parent',
            header: {
              center: 'addEventBtn'
            },
            customButtons: {
              addEventBtn: {
                text: 'Ajouter une facture...',
                click: function() {
                  var dateStr = prompt('Entrer une date (YYYY-MM-DD)');
                  //var dateParsed = new Date(dateStr + 'T00:00:00'); // will be in local time
                  
                  var montant = prompt('Prix');

                  var notesUser = prompt('Notes');

                  var id = prompt('ID du Client')

                  post('controllers/backend.php', {typeForm: 'addFacture', notes: notesUser, prix: montant, idClient: id, date: dateStr});

                }
              }
            }
        });
        
        <?php
          require('models/backend.php');

          $factures = getFacturesFromId(getId($_SESSION['mail']));

          foreach ($factures as $row) {
              ?>
                var date = new Date('<?php echo $row['date']; ?>' + 'T00:00:00');

                calendar.addEvent({
                    title: '<?php echo $row['notes']; ?>',
                    start: date,
                    allDay: true
                });
              <?php
          }
        ?>

        calendar.render();
      });

    </script>
</head>
<body>

<?php require('template/top.php'); ?>
<?php require('template/navbar.php'); ?>

<!-- TOUT ICI -->

<div class="containerCenter" id="app">

<div id="calendar" style="width: 80%; position: absolute; left: 0%;"></div>

<?php 

foreach ($factures as $row) {
 echo $row['date'];
}

?>

</div>

<!-- FIN TOUT ICI -->

<?php require('template/bottom.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="public/js/vue.js"></script>
<script>
const app = new Vue({
    el: '#app',
    data: {}
})
</script>
</body>
</html>
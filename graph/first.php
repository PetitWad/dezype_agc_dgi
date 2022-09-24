<?php
 require '../controller/data/connect.php';


    $reqSQL = "SELECT COUNT(*) as nbr FROM impot";
    $state = $bd->prepare($reqSQL);
    $state->execute();
    $rslt = $state->fetchAll();

        foreach($rslt as $rowSelect):
            $nbrSave = $rowSelect['nbr'];
        endforeach;
?>


<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([

          ['Type of Impot', 'Save count'],   
          <?php
    echo  "
            ['Patent', $nbrSaveDouane],
            ['Taxe sur le chiffre d\'affaire', $nbrSaveChifAffaire], 
            ['Impot sur les societes', $nbrSaveSociete],
            ['Taxe sur la massa salariale', $nbrSaveTMS],
          "
         ?>
    ]);

        var options = {
          title: 'Statistique de Tous type d\'Impot Enregistrer',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart_3d" style="width:450px;"></div>
  </body>
</html>
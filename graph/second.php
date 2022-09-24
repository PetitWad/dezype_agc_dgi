<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Ouest', 'Nord', 'Nord\'Ouest', 'Nord\'Est', 'Artibonite', 'Centre', 'Sud', 'Sud\'Est', 'Grand\'Anse', 'Nippes'],
          ['2017',    165,     938,      522,         998,          450,         614,    340,    234,       348,          509],
          ['2018',    135,     1120,     599,         1268,         288,         682,    340,    234,       348,          509],
          ['2019',    157,     1167,     587,         807,          397,         623,    340,    234,       348,          509],
          ['2020',    139,     1110,     615,         968,          215,         609,    340,    234,       348,          509],
          ['2021',    136,     691,      629,         1026,         366,         569,    340,    234,       348,          509]
        ]);

        var options = {
          title : 'Statistique Recette Total des Impots par Departement',
          vAxis: {title: 'Montant total assujeti'},
          hAxis: {title: 'Mois'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div"></div>
  </body>
</html>

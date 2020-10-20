<html>
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel='stylesheet' type='text/css' href='../css/webpage.css'/>
  <script src="../js/jquery-3.5.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>


    <?php // sqltest.php
    $hn = 'localhost'; //hostname
    $db = 'afiz_project'; //database
    $un = 'afiz_project'; //username
    $pw = 'password123'; //password
    
    require_once 'merchant_stats.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    

  $query  = "SELECT purchase.isbn, book.isbn, book.category, book.price FROM purchase, book WHERE purchase.isbn = book.isbn ORDER BY book.isbn";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  //Catagory variable
  $adventure=0;
  $fantasy=0;
  $classics=0;
  $horror=0;
  $romance=0;
  $sciFi=0;
  $thrillers=0;
  $other=0;
  $priceArray = array();

  
  for ($j = 0 ; $j < $rows ; ++$j){
      
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    if ($row[2] == 'Adventure'){
        $adventure +=1;
    }
    elseif($row[2] == 'Fantasy'){
        $fantasy +=1;
    }
    elseif($row[2] == 'Classics'){
        $classics +=1;
    }
    elseif($row[2] == 'Horror'){
        $horror +=1;
    }
    elseif($row[2] == 'Romance'){
        $romance +=1;
    }
    elseif($row[2] == 'SciFi'){
        $sciFi +=1;
    }
    elseif($row[2] == 'Thrillers'){
        $thrillers +=1;
    }
    else{
        $other +=1;
    }
    $priceArray[$j] = $row[3];
}
  $result->close();
  $conn->close();
?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var adventure = "<?php echo $adventure; ?>";
        var fantacy = "<?php echo $fantasy; ?>";
        var classics = "<?php echo $classics; ?>";
        var horror = "<?php echo $horror; ?>";
        var romance = "<?php echo $romance; ?>";
        var sciFi = "<?php echo $sciFi; ?>";
        var thrillers = "<?php echo $thrillers; ?>";
        var other = "<?php echo $other; ?>";
        var priceArray = "<?php echo $priceArray; ?>";


        var data = google.visualization.arrayToDataTable([
          ['Catagory', 'Share'],
          ['adventure',    parseInt(adventure)],
          ['fantacy', parseInt(fantacy)],
          ['classics',    parseInt(classics)],
          ['horror', parseInt(horror)],
          ['romance',    parseInt(romance)],
          ['sciFi', parseInt(sciFi)],
          ['thrillers',    parseInt(thrillers)],
          ['other', parseInt(other)]
        ]);

        var options = {
          title: 'Catagory: Market Share'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
<body>
<div  class="container">
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </div>
  </body>
</html>
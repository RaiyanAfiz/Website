<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel='stylesheet' type='text/css' href='../css/webpage.css'/>
  <script src="../js/jquery-3.5.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>

</head>
<body class="background">
<div  class="col-xs-1 text-center">
<?php // sqltest.php
    $hn = 'localhost'; //hostname
    $db = 'afiz_project'; //database
    $un = 'afiz_project'; //username
    $pw = 'password123'; //password
    
    require_once 'merchant_balance.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    

  $query  = "SELECT purchase.isbn, book.isbn, book.author_id, book.price FROM purchase, book WHERE purchase.isbn = book.isbn ORDER BY book.author_id";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  //
  $balance=0;
  
  for ($j = 0 ; $j < $rows ; ++$j){
      
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
    $balance += $row[3];
    }
  $result->close();
  $conn->close();
  
  echo "<h1>Your current balance: $balance</h1>";
?>
</div>
            
</body>
</html>
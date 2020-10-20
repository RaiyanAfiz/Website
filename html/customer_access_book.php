<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Books</title>
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
    
    require_once 'customer_access_book.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    

  $query  = "SELECT book.title, book.category, purchase.isbn, book.isbn, purchase.customer_id, book.text_path FROM purchase, book WHERE purchase.isbn = book.isbn ORDER BY purchase.customer_id";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
     echo <<<_END
<table class="table"> 
  <td id = "title" colspan="5">
      <caption>Access Books</caption>
  </td>


  <thead> <!--This is the coloum title-->
      <tr>
          <th scope="col">Title</th>     
          <th scope="col">Catagory</th>     
          <th scope="col">ISBN</th>
          <th scope="col">Access</th>
          
      </tr>
  </thead>


<tbody>
_END;
  
  for ($j = 0 ; $j < $rows ; ++$j){
      
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
    echo <<<_END
    <tr>     
        <td scope="row">$row[0]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>
        <form action="displaying.php" method="post">
        <input type="hidden" name="display" value="$row[5]">
        <input type="submit" value="Access">
        </form>
        </td>
    </tr> 
_END;
    }
    
echo <<<_END
</tbody>
</table> 
_END;
  $result->close();
  $conn->close();
  
?>

</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
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
    
    require_once 'customer_review.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    

  $query  = "SELECT book.title, book.category, book.isbn, review.isbn, review.actual, customer.customer_name, customer.customer_id, review.customer_id FROM review, book, customer WHERE book.isbn = review.isbn AND customer.customer_id = review.customer_id ORDER BY book.isbn";
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
          <th>Title</th>     
          <th>Catagory</th>     
          <th>ISBN</th>
          <th>Review</th>
          <th>Customer</th>
          
      </tr>
  </thead>


<tbody>
_END;
  
  for ($j = 0 ; $j < $rows ; ++$j){
      
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
    echo <<<_END
    <tr>     
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row[4]</td>
        <td>$row[5]</td>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy</title>
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
    
    require_once 'customer_buy.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    

    //Add
  if (isset($_POST['isbn']) &&
        isset($_POST['customer_id'])
    
    
    ) 
  {
    $isbn   = get_post($conn, 'isbn');
    $id    = get_post($conn, 'customer_id');
    
    $query    = "INSERT INTO purchase (isbn, customer_id) VALUES ('$isbn', '$id')";
    $result   = $conn->query($query);

  	if (!$result) echo "INSERT failed: $query<br>" .
      $conn->error . "<br><br>";
  }


  $query  = "SELECT book.title, book.price, book.category, book.isbn, book.author_id, author.author_id, author.author_name FROM book, author WHERE book.author_id = author.author_id ORDER BY book.isbn";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
   echo <<<_END

<table class="table"> 
  <td id = "title" colspan="5">
      <caption>Books to buy</caption>
  </td>


  <thead> <!--This is the coloum title-->
      <tr>      
          <th>Title</th>     
          <th>Price</th>     
          <th>Catagory</th>     
          <th>ISBN</th>     
          <th>Author</th>
         <th>Buy</th>
      </tr>
  </thead>


<tbody>
_END;

  for ($j = 0 ; $j < $rows ; ++$j){
      
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
   
    echo <<<_END
    <tr>  
    <form action="customer_buy.php" method="post">
        <td>$row[0]</td>
        <td>$row[1]</td>
        <td>$row[2]</td>
        <td>$row[3]</td>
        <td>$row[6]</td>
        <input type="hidden" name="isbn" value="$row[3]">
        <input type="hidden" name="customer_id" value="1">
        <input type="submit" value="Buy">
        </form>

    </tr> 
_END;
}
  
echo <<<_END
</tbody>
</table> 
_END;
  
  $result->close();
  $conn->close();
  
  function get_post($conn, $var){
    return $conn->real_escape_string($_POST[$var]);
  }
  
?>

</div>
            



</body>
</html>
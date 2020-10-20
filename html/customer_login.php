<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel='stylesheet' type='text/css' href='../css/webpage.css'/>
  <script src="../js/jquery-3.5.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>

</head>
<body class="background">
<div  class="col-xs-1 text-center">
<?php
    
    $hn = 'localhost'; //hostname
    $db = 'afiz_project'; //database
    $un = 'afiz_project'; //username
    $pw = 'password123'; //password
    
    require_once 'customer_login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    
    
    
        //Add
    if (isset($_POST['username'])   &&
        isset($_POST['password'])
        )
        {
            $username      = get_post($conn, 'username');
            $pass       = get_post($conn, 'password');
            
            $query    = "SELECT customer_username, customer_password FROM customer";
            $result   = $conn->query($query);
            $rows = $result->num_rows;
            for ($j = 0 ; $j < $rows ; ++$j){
                $result->data_seek($j);
                $row = $result->fetch_array(MYSQLI_NUM);
                if($row[0] == $username && $row[1]==$pass){
                    header("Location: customer_main.html");
                }

                }
            if (!$result) echo "failed: $query<br>" .
            $conn->error . "<br><br>";
        }



    $query  = "SELECT customer_username, customer_password FROM customer";
    $result = $conn->query($query);
    if (!$result) die ("Database access failed: " . $conn->error);

  echo <<<_END
  <form action= "customer_login.php" method="post">
  <label for="username">User Name:</label> <br>
  <input type="text" id="username" name="username" placeholder="exampleUserName123" autocomplete="off" required="true">
  <br><br>    

  <label for="password">Password:</label> <br>
  <input type="password" id="password" name="password" required="true">
  <br><br>

  <input type="submit" value="Login">
</form> 
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
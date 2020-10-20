<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
    
    require_once 'sign_up.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    
    
    
        //Add
    if (isset($_POST['username'])   &&
        isset($_POST['password'])    &&
        isset($_POST['useLevel']) &&
        isset($_POST['name']) &&
        isset($_POST['email'])
        )
        {
            $username      = get_post($conn, 'username');
            $password       = get_post($conn, 'password');
            $userlevel       = get_post($conn, 'useLevel');
            $email       = get_post($conn, 'email');
            $name       = get_post($conn, 'name');

            if($userlevel == 2){
                $query    = "INSERT INTO author (author_name, author_username, author_password, author_email) VALUES ('$name', '$username', '$password', '$email')";
                $result   = $conn->query($query);
            }
            else {
                $query    = "INSERT INTO customer (customer_name, customer_username, customer_password, customer_email) VALUES ('$name', '$username', '$password', '$email')";
                $result   = $conn->query($query); 
            }

            if ($result) echo "Added Successfully.";
            
            if (!$result) echo "INSERT failed: $query<br>" .
            $conn->error . "<br><br>";
        }

    //Add Form
  echo <<<_END
  <form action="sign_up.php" method="post">
  <label for="name">Name:</label> <br>
  <input type="text" id="name" name="name" placeholder="John John" autocomplete="off" required="true">
  <br><br>

  <label for="username">User Name:</label> <br>
  <input type="text" id="username" name="username" placeholder="exampleUserName123" autocomplete="off" required="true">
  <br><br>

  <label for="password">Password:</label> <br>
  <input type="password" id="password" name="password" required="true">
  <br><br>

  <label for="useLevel">Choose Account Type:</label> <br>
  <select name="useLevel" id="userLevel">
      <option value="1">Customer</option>
      <option value="2">Merchant</option>
  </select>
  <br><br>

  <label for="email">Email:</label> <br>
  <input type="text" id="email" name="email" placeholder="example@email.ca" autocomplete="off" required="true">
  <br><br>

  <input type="submit" value="Sign Up">
</form> 
_END;

    $query  = "SELECT * FROM customer, author";
    $result = $conn->query($query);
    if (!$result) die ("Database access failed: " . $conn->error);

    $result->close();
    $conn->close();
    
     function get_post($conn, $var){
    return $conn->real_escape_string($_POST[$var]);
  }
    
    ?>
</div>
            
</body>
</html>
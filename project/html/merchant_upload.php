<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
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
    
    require_once 'merchant_upload.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    
    
    
        //Add
    if (isset($_POST['title'])   &&
        isset($_POST['price'])    &&
        isset($_POST['catagory']) &&
        isset($_POST['isbn']) &&
        $_FILES
        )
        {
            $title      = get_post($conn, 'title');
            $price       = get_post($conn, 'price');
            $catagory       = get_post($conn, 'catagory');
            $isbn       = get_post($conn, 'isbn');
            $filename       = get_post($conn, 'filename');

            //File upload
            if ($_FILES){
              $name = $_FILES['filename']['name'];
              
              switch($_FILES['filename']['type']){
                case 'text/plain': $ext = 'txt'; break;
                default:           $ext = '';    break;
              }
            
              if ($ext){
              
              $n = "$name";
              move_uploaded_file($_FILES['filename']['tmp_name'], $n);
              echo "'$name' has been accepted. Upload another?";
              echo "'$name'";
              }
              else echo "'$name' is not an accepted text file";
              
            }
            else echo "No file has been uploaded";


            $query    = "INSERT INTO book (author_id, title, price, category, isbn, text_path) VALUES ('2', '$title', '$price' ,'$catagory' ,'$isbn' , '$name')";
            $result   = $conn->query($query);
            
            
            

            if ($result) echo "Added Successfully.";
            
            if (!$result) echo "INSERT failed: $query<br>" .
            $conn->error . "<br><br>";
        }

    //Add Form
  echo <<<_END
 
<form method='post' action='merchant_upload.php' enctype='multipart/form-data' methord="post">
<label for="title">Title:</label> <br>
  <input type="text" id="title" name="title" placeholder="Book Title" autocomplete="off" required="true">
<br><br> 

<label for="price">Price:</label> <br>
  <input type="text" id="price" name="price" placeholder="12.99" autocomplete="off" required="true">
<br><br>

<label for="catagory">Catagory:</label> <br>
<select name="catagory" id="catagory">
  <option value="Adventure">Adventure</option>
  <option value="Fantacy">Fantacy</option>
  <option value="Classics">Classics</option>
  <option value="Horror">Horror</option>
  <option value="Romance">Romance</option>
  <option value="Sci-Fi">Sci-Fi</option>
  <option value="Thrillers">Thrillers</option>
  <option value="Other">Other</option>
</select>
<br><br>

<label for="isbn">ISBN:</label> <br>
  <input type="text" id="isbn" name="isbn" placeholder="9999999999999" autocomplete="off" required="true">
<br><br> 

<label for='filename'>Select a .txt file:</label> <br>
<input type='file' name='filename' size='10' require="true"> 
<br><br>

<input type='submit' value='Upload'>
</form>

_END;

    $query  = "SELECT * FROM book";
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
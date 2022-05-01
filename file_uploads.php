<?php session_start(); ?>
<?php require_once 'functions/functions.php'; ?>
<?php
  if(isset($_POST['upload'])){
    $errors = "";
    $file_name = $_FILES['myFile']['name'];
    $file_tmp_name = $_FILES['myFile']['tmp_name'];
    // Find the extension of the file
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $allowed_type = array('csv');
    if(!has_presence($file_name)){
      $errors = "You must upload your CSV File!";
    }elseif(!in_array($file_extension, $allowed_type)){
      $errors = "Invalid File Extension - Please upload your CSV File";
    }
    if(!empty($error)){
      //upload your csv file
      $handle = fopen($file_tmp_name, 'r');
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>File Upload</title>
</head>
<body>  
<div class="container">
  <hr>
  <p class="msgInfo">
  Please upload your CSV File
  </p>
    <form class="form-group" action="file_uploads.php" enctype="multipart/form-data"  method="post">
    <input type="file" name="myFile" class="form-control" >    
    <button type="submit" class="btn btn-info bttn" name="upload">Upload File</button>
  </form>
  <hr>
      <?php
        if(!empty($errors)){
          echo "<div class='alert alert-danger text-center'>";
          echo $errors;
          echo "</div>";
        }
      ?>
</div>
</body>
</html>
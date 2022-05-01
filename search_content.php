<?php require_once 'sessions/sessions.php'; ?>
<?php require_once 'functions/functions.php'; ?>
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
    <link rel="stylesheet" type="text/css" href="style/search-style.css">
    <title>Search for device</title>
</head>
<body>  
<div class="container-fluid">
  
  <hr>
  <p class="msgInfo">
  Search for specific devices or <a href="index.php" class="btn btn-light"><?php if(logged_in()){ echo "Go back to Manage Content"; }else{ echo "Go back to Device Content"; } ?></a>
  </p>
  <hr>            
  <div class="container">
      <?php  
            if(isset($_SESSION['errorsMsg'])){
                if($_SESSION["alertType"] === "alert-danger"){
                echo "<div class='alert alert-danger text-center'>";
                echo $_SESSION['errorsMsg'];
                echo '</div>';
                $_SESSION["alertType"] = null;
                $_SESSION['errorsMsg'] = null;
            }
            if($_SESSION["alertType"] === "alert-warning"){
                echo '<div class="alert alert-warning" text-center>';
                echo $_SESSION['errorsMsg'];
                echo '</div>';
                $_SESSION["alertType"] = null;
                $_SESSION['errorsMsg'] = null;
            }
        }
      ?>
  <form action="search_process.php" class="form-group" method="post">
  <input type="text" class="form-control" name="search" placeholder="Search for specific device Info" required>
  <button type="submit" class="btn btn-light btn-block bttn " name="submit">Search</button>
   </form>
    </div>
    </div>
    </body>
  </html>
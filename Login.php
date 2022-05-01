<?php require_once 'sessions/sessions.php'; ?>
<?php require_once 'functions/functions.php'; ?>
<?php require_once 'database/db-handler.php'; ?>
<?php
  
     if(isset($_POST['submit'])){   
        $errors = "";        
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];
        if(!has_presence($username)){
            $errors = "Username can't be blank. It's required.";
         }elseif(!has_presence($password)){
            $errors = "Password can't be blank. It's required.";
         }    
        if(empty($errors)){
            // * attempt to Login
            $admin = find_admin_by_username($username, $conn);
            if($admin !== null){
                // found admin now check password
                $check = password_check($password, $admin['hashed_password']);
                if($check){
                    // username and password are match
                    // Sucess
                    // Mark Admin as Logged In
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['username'] = $admin['username'];
                    header("location: index.php");
                }else{
                    // password doesn't match
                    $errors = "Wrong password for the Admin <strong>[{$username}]</strong>";
                }
            }else{
               // Admin not found
               $errors = "The Admin you've provided is not found";
            }
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
    <link rel="stylesheet" type="text/css" href="style/login-style.css">
    <title>SHIFA Admin Login</title>
</head>
<body>  
<div class="container-fluid">
  
  <hr>
  <p class="msgInfo">
  <strong>Login as Admin to Manage Device Content</strong>
  </p>
  <hr>
               
  <div class="container">
      <?php  
            if(!empty($errors)){
                echo '<div class="alert alert-danger text-center">';
                echo $errors;
                echo '</div>';
            }       
      ?>
  </div>
  <div class="container">
  <form action="Login.php" class="form-group" method="post">
  <input type="text" class="form-control" name="username" placeholder="Please enter your username" value="<?php if(isset($_POST['username']) && !empty($errors)){echo $_POST['username'];} ?>" title="Username can't be blank" required>
  <input type="password" class="form-control" name="password" placeholder="Please enter your password" title="Password can't be blank" required>
  <hr>
  <button type="submit" class="btn btn-primary btn-block bttn " name="submit">Log In as Admin</button>
   </form>
   </body>
  </html>
  <?php mysqli_close($conn); ?>
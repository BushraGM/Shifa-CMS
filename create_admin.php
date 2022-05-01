<?php require_once 'sessions/sessions.php'; ?>
<?php require_once 'functions/functions.php'; ?>
<?php require_once 'database/db-handler.php'; ?>
<?php confirm_logged_in(); ?>
<?php
  
     if(isset($_POST['submit'])){   
        $errors = "";   
        $message = "";     
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        if(!has_presence($username)){
            $errors = "Username can't be blank. It's required.";
         }elseif(!has_max_length($username, 20)){
            $errors = "Sorry, username is too long.";
          }elseif(!has_presence($password)){
            $errors = "Password can't be blank. It's required.";
         }elseif(!has_max_length($password, 20)){
            $errors = "Sorry, password is too long.";
          }elseif(!has_presence($confirm_password)){
            $errors = "Confirmation can't be blank. It's required.";
         }elseif($password !== $confirm_password){
            $errors = "Sorry, <strong>passwords</strong> do not match!"; 
         }    
        if(empty($errors)){
            // * Create new admin
            // * Check username first 
            $admin = find_admin_by_username($username, $conn);
            if($admin !== null){
                // found admin 
                $errors = "<strong>Username</strong> is taken. Pick up different one.";
            }else{
               // Username not found so create new admin
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $result = create_new_admin($username, $hashed_password, $conn);
                if($result){
                // Success
                $message = "Admin has been created successfully";
                //$_SESSION['message'] = "Admin has been created successfully";
                //header("location: manage_admins.php"); 
                }else{
                // Failure
                $message = "Admin creation failed";
                //$_SESSION['message'] = "Admin creation failed";
                //header("location: manage_admins.php");
            }
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
    <title>New Admin</title>
</head>
<body>  
<div class="container-fluid">
  
  <hr>
  <p class="msgInfo">
  <strong>Create New Admin for Managing Content</strong>
  </p>
  <hr>
               
  <div class="container">
      <?php  
            if(!empty($errors)){
                echo '<div class="alert alert-danger text-center">';
                echo $errors;
                echo '</div>';
            }   
            if(!empty($message)){
                if($message === "Admin has been created successfully"){
                    echo '<div class="alert alert-success text-center">';
                    echo $message;
                    echo '</div>';
                }
                if($message === "Admin creation failed"){
                    echo '<div class="alert alert-danger text-center">';
                    echo $message;
                    echo '</div>';
                }
            }    
      ?>
  </div>
  <div class="container">
  <form action="create_admin.php" class="form-group" method="post">
  <input type="text" class="form-control" name="username" placeholder="Please enter your username" value="<?php if(isset($_POST['username']) && !empty($errors)){echo $_POST['username'];} ?>" title="The username must be letters only, and shouldn't be less than 5 latters and not more than 20 letters." pattern="[a-zA-Z]{5,20}"required>
  <input type="password" class="form-control" name="password" title="Password can be letters or numbers or [@#&-_$] and it mustn't be less than 6 letters or numbers" pattern="[a-zA-Z0-9@#&-_$]{6,20}" placeholder="Please enter your password" required>
  <input type="password" class="form-control" name="confirm_password" title="Confirm your password" placeholder="Please confirm your password" required>
  <hr>
  <button type="submit" class="btn btn-success btn-block bttn " name="submit">Create New Admin</button>
  <a href="index.php" class="btn btn-light btn-block bttn">Cancel</a>
   </form>
   </body>
  </html>
  <?php mysqli_close($conn); ?>
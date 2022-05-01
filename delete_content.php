<?php require_once 'sessions/sessions.php'; ?>
<?php require_once 'functions/functions.php'; ?>
<?php require_once 'database/db-handler.php'; ?>
<?php if(!logged_in()){ header("location: Login.php"); exit();} ?>
<?php // * Retrieving all data by id ?>
<?php
$current_row = "";
$id = "";
if(isset($_GET['device'])){
    $id = $_GET['device'];
    $current_row  = find_info_by_id($id, $conn);
    if($current_row === null){
      header("location: index.php");
      exit();
      }
    }else{
    header("location: index.php");
    exit();
   }
?>

<?php
      // * delete the record from the database based on the id
        $query = "DELETE FROM equipment WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if($result && mysqli_affected_rows($conn) === 1){
          // Success
          $_SESSION['message2'] = "Device Info has been deleted successfully";
          header("location: index.php");
        }else{
          // Failure
          $_SESSION['message2'] = "Deletion failed, please try again!";
          header("location: index.php?device={$id}");
        }
  
?>
<?php mysqli_close($conn); ?>

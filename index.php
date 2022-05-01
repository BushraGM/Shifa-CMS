<?php require_once 'sessions/sessions.php'; ?>
<?php require_once 'functions/functions.php'; ?>
<?php require_once 'database/db-handler.php'; ?>
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
    <link rel="stylesheet" type="text/css" href="style/manage-style.css">
    <title><?php if(logged_in()){echo "Manage Device Content";} else{echo "Device Content";} ?></title>
</head>
<body>  
<div class="container-fluid">
  <p class="msgInfo">
  <strong><?php if(logged_in()){ echo "Manage Device Content"; }else{ echo "Device Content"; } ?></strong>
  </p>
  <hr>
  <p class="msgInfo">
  <?php if(logged_in()){ ?>    
  Welcome to the admin area, <strong><?php echo htmlentities($_SESSION['username']); ?></strong><a href="logout.php" class="btn btn-link">[Logout]</a> | <a href="create_admin.php" class="btn btn-light">Create New Admin</a>
  <?php }else{?>
  Welcome, you can read the content of the devices and make search.
  <?php }?>
  </p>
  <hr>
  <?php if(logged_in()){ ?><a href="add_device.php" class="btn btn-success" >+ Add Device Info</a><?php } ?>
  <a href="search_content.php" class="btn btn-info <?php if(logged_in()){ echo 'float-right'; } ?>" >Search for Devices</a>
  <hr>
  <div class="container">
      <?php  
            if(logged_in()){
            if(isset($_SESSION['message'])){
            if($_SESSION['message'] === "Device Info has been edited successfully"){
                echo '<div class="alert alert-success text-center">';
                echo $_SESSION['message'];
                echo '</div>';
                $_SESSION['message'] = null;
            }
            if($_SESSION['message'] === "Edit failed, please try again!"){
                echo '<div class="alert alert-warning text-center">';
                echo $_SESSION['message'];
                echo '</div>';
                $_SESSION['message'] = null;
              }
            }
            if(isset($_SESSION['message2'])){
            if($_SESSION['message2'] === "Device Info has been deleted successfully"){
                echo '<div class="alert alert-success text-center">';
                echo $_SESSION['message2'];
                echo '</div>';
                $_SESSION['message2'] = null;
            }
            if($_SESSION['message2'] === "Deletion failed, please try again!"){
                echo '<div class="alert alert-warning text-center">';
                echo $_SESSION['message2'];
                echo '</div>';
                $_SESSION['message2'] = null;
              }
            }
            if(isset($_SESSION['message1'])){
            if($_SESSION['message1'] === "Device Info has been saved successfully"){
                echo '<div class="alert alert-success text-center">';
                echo $_SESSION['message1'];
                echo '</div>';
                $_SESSION['message1'] = null;
            }
            if($_SESSION['message1'] === "Addition failed, please try again!"){
                echo '<div class="alert alert-warning text-center">'; 
                echo $_SESSION['message1'];
                echo '</div>';
                $_SESSION['message1'] = null; 
              }
            }
        }
      ?>
  </div>
    <?php
        $query = "SELECT * FROM equipment";
        $result = mysqli_query($conn, $query); 
        if($result):?>
                <div class="table-responsive">
                <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th style="text-align:center; white-space:nowrap">Serial</th>
                        <th style="text-align:center; white-space:nowrap">Building</th>
                        <th style="text-align:center; white-space:nowrap">Floor</th>
                        <th style="text-align:center; white-space:nowrap">Department</th>
                        <th style="text-align:center; white-space:nowrap">Employee</th>
                        <th style="text-align:center; white-space:nowrap">Device Name</th>
                        <th style="text-align:center; white-space:nowrap">Field Type</th>
                        <th style="text-align:center; white-space:nowrap">Casper</th>
                        <?php if(logged_in()){ ?>
                        <th style="text-align:center; white-space:nowrap">IP Address</th>
                        <th style="text-align:center; white-space:nowrap">MAC Address</th>
                        <?php } ?>
                        <th style="text-align:center; white-space:nowrap">Device Type</th>
                        <th style="text-align:center; white-space:nowrap">Status</th>
                        <th style="text-align:center; white-space:nowrap">Other</th>
                        <th style="text-align:center; white-space:nowrap">Notes</th>
                        <?php if(logged_in()){ ?> <th colspan="2" style="text-align:center">Action</th><?php } ?>
                    </tr>
                </thead>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['serial']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['building']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['floor']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['dept']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['employee']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['device_name']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['field_type']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['casper']); ?></td>
                    <?php if(logged_in()){ ?>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['ip_address']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['mac_address']); ?></td>
                    <?php } ?>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['device_type']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['status']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['other']); ?></td>
                    <td style="text-align:center; white-space:nowrap"><?php echo stripslashes($row['notes']); ?></td>
                    <?php if(logged_in()){ ?>
                    <td style="text-align:center; white-space:nowrap"><a href="edit_content.php?device=<?php echo urlencode($row['id']); ?>" class="btn btn-warning" >Edit</a></td>
                    <td style="text-align:center; white-space:nowrap"><a href="delete_content.php?device=<?php echo urlencode($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure, you want to delete it?');">Delete</a></td>
                    <?php } ?>
                </tr>       
                <?php endwhile; ?>
            </table>
            <?php mysqli_free_result($result); ?>
          <?php endif ?>
        </div>
        </div>
  </body>
  </html>
  <?php mysqli_close($conn); ?>
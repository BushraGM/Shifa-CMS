<?php require_once 'sessions/sessions.php'; ?>
<?php require_once 'functions/functions.php'; ?>
<?php require_once 'database/db-handler.php'; ?>
<?php
if(isset($_POST['submit'])){         
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        if(!has_presence($search)){
           $_SESSION['alertType'] = "alert-danger";
           $_SESSION['errorsMsg'] = "Search can't be blank. It's required field.";
           header("location: search_content.php");
           exit();
        }    
        $query = "";
        if(logged_in()){
        $query = "SELECT * FROM equipment WHERE serial = '$search' OR building = '$search' OR floor = '$search' OR dept = '$search' OR employee = '$search' OR device_name = '$search' OR field_type = '$search' OR casper = '$search' OR ip_address = '$search' OR mac_address = '$search' OR device_type = '$search' OR status = '$search' OR other = '$search' OR notes = '$search'";
        }else{
        $query = "SELECT * FROM equipment WHERE serial = '$search' OR building = '$search' OR floor = '$search' OR dept = '$search' OR employee = '$search' OR device_name = '$search' OR field_type = '$search' OR casper = '$search' OR device_type = '$search' OR status = '$search' OR other = '$search' OR notes = '$search'";
        }
        $result = mysqli_query($conn, $query); 
        if($result && mysqli_num_rows($result) > 0){?>
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
                <title>Search Result</title>
            </head>
            <body>  
            <div class="container-fluid">
            <hr>
            <p class="msgInfo">
            <a href="search_content.php" class="btn btn-light">Back to Search</a>
            </p>
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
             <?php if(logged_in()){?><th colspan="2" style="text-align:center">Action</th><?php } ?>
                    </tr>
                </thead>

            <?php while($row = mysqli_fetch_assoc($result)){?>
                <div class="table-responsive">       
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
            </div>
  <?php 
            
            }?>
            </table>
            </div>  
        </div>
        </body>
  </html>
  <?php 
        mysqli_free_result($result);
        }else{
            $search = stripslashes($search);
            $_SESSION['alertType'] = "alert-warning";
            $_SESSION['errorsMsg'] = "Your search - <strong>{$search}</strong> - did not match any data.";
            header("location: search_content.php");
        }
    }else{
        header("location: search_content.php"); 
    }
  ?>
<?php mysqli_close($conn); ?>




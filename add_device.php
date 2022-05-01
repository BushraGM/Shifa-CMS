<?php require_once 'sessions/sessions.php'; ?>
<?php require_once 'functions/functions.php'; ?>
<?php require_once 'database/db-handler.php'; ?>
<?php confirm_logged_in(); ?>

<?php
  // * if the form submitted
  if(isset($_POST['save'])){
    $errors = "";
    $floor = "";
    $serial = mysqli_real_escape_string($conn, $_POST['serial']);
    $building = mysqli_real_escape_string($conn, $_POST['building']);
    $check = isset($_POST['floor']) ? $_POST['floor'] : false;
    if ($check) {
        $floor = mysqli_real_escape_string($conn, $_POST['floor']);
    }
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);
    $employee = mysqli_real_escape_string($conn, $_POST['employee']);
    $device_name = mysqli_real_escape_string($conn, $_POST['device_name']);
    $field_type = mysqli_real_escape_string($conn, $_POST['field_type']);
    $casper = mysqli_real_escape_string($conn, $_POST['casper']);
    $ip_address = mysqli_real_escape_string($conn, $_POST['ip_address']);
    $mac_address = mysqli_real_escape_string($conn, $_POST['mac_address']);
    $device_type = mysqli_real_escape_string($conn, $_POST['device_type']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $other = mysqli_real_escape_string($conn, $_POST['other']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
   if(!has_presence($serial)){
     $errors = "Serial number can't be blank. It's required field.";
   }elseif(!has_max_length($serial, 50)){
    $errors = "The serial number is too long.";
  }elseif(!preg_match("/^[a-zA-Z0-9-]*$/", $serial)){
    $errors = "Serial number consist of letters or numbers or hyphen only.";
  }elseif(!has_presence($building)){
     $errors = "Building can't be blank. It's required field.";
   }elseif(!has_max_length($building, 20)){
    $errors = "The building field is too long.";
  }elseif(!$check){
    $errors = "Select which floor? It's required field.";
  }elseif(!has_presence($dept)){
    $errors = "Department can't be blank. It's required field.";
  }elseif(!has_max_length($dept, 20)){
    $errors = "The department field is too long.";
  }elseif(!has_presence($employee)){
    $errors = "Employee/Signator can't be blank. It's required field.";
  }elseif(!has_max_length($employee, 20)){
    $errors = "Employee/Signator name is too long.";
  }elseif(!has_presence($device_name)){
    $errors = "Device name can't be blank. It's required field.";
  }elseif(!has_max_length($device_name, 20)){
    $errors = "The device name is too long.";
  }elseif(!has_presence($field_type)){
    $errors = "Field type can't be blank. It's required field.";
  }elseif(!has_max_length($field_type, 20)){
    $errors = "The field type is too long.";
  }elseif(!has_presence($casper)){
    $errors = "Casper can't be blank. It's required field.";
  }elseif(!has_max_length($casper, 20)){
    $errors = "The Casper field is too long.";
  }elseif(!has_presence($ip_address)){
    $errors = "IP Address can't be blank. It's required field.";
  }elseif(!has_max_length($ip_address, 15)){
    $errors = "IP Address is too long.";
  }elseif(!preg_match("/[0-9]{1,3}[.]{1}[0-9]{1,3}[.]{1}[0-9]{1,3}[.]{1}[0-9]{1,3}/", $ip_address)){
    $errors = "IP Address is consisting of four decimal numbers, each ranging from 0 to 255, separated by dots, e.g., 172.16.254.1";
  }elseif(!has_presence($mac_address)){
    $errors = "MAC Address can't be blank. It's required field.";
  }elseif(!has_max_length($mac_address, 17)){
    $errors = "MAC Address is too long.";
  }elseif(!preg_match("/[0-9a-f]{2}[-:]{1}[0-9a-f]{2}[-:]{1}[0-9a-f]{2}[-:]{1}[0-9a-f]{2}[-:]{1}[0-9a-f]{2}[-:]{1}[0-9a-f]{2}/", $mac_address)){
    $errors = "MAC address is two hex digits separated by - or :";
  }elseif(!has_presence($device_type)){
    $errors = "Device type can't be blank. It's required field.";
  }elseif(!has_max_length($device_type, 20)){
    $errors = "Device type is too long.";
  }elseif(!has_presence($status)){
    $errors = "Status can't be blank. It's required field.";
  }elseif(!has_max_length($status, 20)){
    $errors = "Status field is too long.";
  }elseif(!has_presence($other)){
    $errors = "Other can't be blank. It's required field.";
  }elseif(!has_max_length($other, 20)){
    $errors = "Other field is too long.";
  }elseif(!has_presence($notes)){
    $errors = "Notes can't be blank. It's required field.";
  }elseif(!has_max_length($notes, 250)){
    $errors = "The max characters for notes are 250 characters only.";
  }
      // * if there's no error insert the data in database
      if(empty($errors)){
        $message = "";
        $query = "INSERT INTO equipment (serial, building, floor, dept, employee, device_name, field_type, casper, ip_address, mac_address, device_type, status, other, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssssssss", $serial, $building, $floor, $dept, $employee, $device_name, $field_type, $casper, $ip_address, $mac_address, $device_type, $status, $other, $notes);
        if(mysqli_stmt_execute($stmt)){
          // Success
          $_SESSION['message1'] = "Device Info has been saved successfully";
          header("location: index.php");
        }else{
          // Failure
          $_SESSION['message1'] = "Addition failed, please try again!";
          header("location: index.php");
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
    <link rel="stylesheet" type="text/css" href="style/add-style.css">
    <title>Add Device Info</title>
</head>
<body>  
<div class="container">
  <hr>
  <p class="msgInfo">
  Add Device Info - * fields are required
  </p>
  <hr>
      <?php
        if(!empty($errors)){
          echo "<div class='alert alert-danger text-center'>";
          echo $errors;
          echo "</div>";
          // You can use the below function phpAlert!
          /*
          phpAlert($errors);
          */
        }
      ?>
    <form class="form-group" action="add_device.php" id="equipForm" method="post">
    <input type="text" class="form-control" name="serial" placeholder="Please enter serial number *" value="<?php if(isset($_POST['serial']) && !empty($errors)){echo $_POST["serial"];} ?>" pattern="([a-zA-Z0-9-]*).{8,50}$" title="Serial number consist of letters or numbers or hyphen only. And the length mustn't be less than 8 and more than 50 letters long." required>
    <input type="text" class="form-control" name="building" placeholder="Please enter the building *" value="<?php if(isset($_POST['building']) && !empty($errors)){echo $_POST['building'];} ?>"  required>
    <select class="form-control" name="floor" required="">
    <option value="" selected disabled>Select which floor: *</option>
        <option value="1" <?php $display = ""; if(isset($_POST['floor']) && empty(!$errors)){if($_POST['floor'] === "1"){$display = "selected";}else{$display = "";}}echo $display; ?>>floor 1</option>
        <option value="2" <?php $display = ""; if(isset($_POST['floor']) && empty(!$errors)){if($_POST['floor'] === "2"){$display = "selected";}else{$display = "";}}echo $display; ?>>floor 2</option>
        <option value="3" <?php $display = ""; if(isset($_POST['floor']) && empty(!$errors)){if($_POST['floor'] === "3"){$display = "selected";}else{$display = "";}}echo $display; ?>>floor 3</option>
        <option value="4" <?php $display = ""; if(isset($_POST['floor']) && empty(!$errors)){if($_POST['floor'] === "4"){$display = "selected";}else{$display = "";}}echo $display; ?>>floor 4</option>
        <option value="5" <?php $display = ""; if(isset($_POST['floor']) && empty(!$errors)){if($_POST['floor'] === "5"){$display = "selected";}else{$display = "";}}echo $display; ?>>floor 5</option>
        <option value="6" <?php $display = ""; if(isset($_POST['floor']) && empty(!$errors)){if($_POST['floor'] === "6"){$display = "selected";}else{$display = "";}}echo $display; ?>>floor 6</option>
        <option value="7" <?php $display = ""; if(isset($_POST['floor']) && empty(!$errors)){if($_POST['floor'] === "7"){$display = "selected";}else{$display = "";}}echo $display; ?>>floor 7</option>
    </select>
        <input type="text" class="form-control" name="dept" placeholder="Please enter the department *" value="<?php if(isset($_POST['dept']) && !empty($errors)){echo $_POST['dept'];} ?>"  required>
        <input type="text" class="form-control" name="employee" placeholder="Please enter employee/signatory *" value="<?php if(isset($_POST['employee']) && !empty($errors)){echo $_POST['employee'];} ?>"  required>
        <input type="text" class="form-control" name="device_name" placeholder="Please enter the device name *" value="<?php if(isset($_POST['device_name']) && !empty($errors)){echo $_POST['device_name'];} ?>" required>
        <input type="text" class="form-control" name="field_type" placeholder="Please enter the field type *" value="<?php if(isset($_POST['field_type']) && !empty($errors)){echo $_POST['field_type'];} ?>"  required>
        <input type="text" class="form-control" name="casper" placeholder="Please enter the Casper *" value="<?php if(isset($_POST['casper']) && !empty($errors)){echo $_POST['casper'];} ?>"  required>
        <input type="text" class="form-control" name="ip_address" placeholder="Please enter the IP Address *" value="<?php if(isset($_POST['ip_address']) && !empty($errors)){echo $_POST['ip_address'];} ?>" pattern="[0-9]{1,3}[.]{1}[0-9]{1,3}[.]{1}[0-9]{1,3}[.]{1}[0-9]{1,3}" title="IPv4 addresses are usually represented in dot-decimal notation, consisting of four decimal numbers, each ranging from 0 to 255, separated by dots, e.g., 172.16.254.1" required>
        <input type="text" class="form-control" name="mac_address" placeholder="Please enter the MAC Address *" value="<?php if(isset($_POST['mac_address']) && !empty($errors)){echo $_POST['mac_address'];} ?>" pattern="[0-9a-f]{2}[-:]{1}[0-9a-f]{2}[-:]{1}[0-9a-f]{2}[-:]{1}[0-9a-f]{2}[-:]{1}[0-9a-f]{2}[-:]{1}[0-9a-f]{2}" title="MAC addresses are recognizable as six groups of two hexadecimal digits, separated by hyphens, colons." required>
        <input type="text" class="form-control" name="device_type" placeholder="Please enter the device type *" value="<?php if(isset($_POST['device_type']) && !empty($errors)){echo $_POST['device_type'];} ?>"  required>
        <input type="text" class="form-control" name="status" placeholder="Please enter the status *" value="<?php if(isset($_POST['status']) && !empty($errors)){echo $_POST['status'];} ?>"  required>
        <input type="text" class="form-control" id="equipForm" name="other" placeholder="Other Info *" value="<?php if(isset($_POST['other']) && !empty($errors)){echo $_POST['other'];} ?>"  required>
        <textarea class="form-control"    name="notes" placeholder="Please enter any notes *" rows="5" value="<?php if(isset($_POST['notes']) && !empty($errors)){echo $_POST['notes'];} ?>"  required=""></textarea>
        <button type="submit" class="btn btn-info btn-block bttn" name="save">Save Information</button>
        <a href="index.php" class="btn btn-secondary btn-block bttn" >Cancel Saving</a>
    </form>     
  </div>
  </body>
  </html>
  <?php mysqli_close($conn); ?>
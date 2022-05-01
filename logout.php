<?php require_once 'sessions/sessions.php'; ?>
<?php require_once 'functions/functions.php'; ?>
<?php
    $_SESSION['admin_id'] = null;
    $_SESSION['username'] = null;
    header("location: Login.php");
?>
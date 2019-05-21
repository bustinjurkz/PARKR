<?php
//start session per usual and then check to see if user is loggedin (boolean = true), then redirect to login.php if they are not. 
session_start();
if (!isset($_SESSION['isLoggedIn'])) {
    header("Location: https://{$_SERVER['HTTP_HOST']}/login.php");
    exit();
}
?>
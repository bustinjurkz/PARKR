<?php
//destroy session and then redirect to loggedOut.php
session_start();
session_destroy();
header("location:loggedOut.php");
?>
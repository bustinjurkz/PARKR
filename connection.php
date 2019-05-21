<?php
//try to connect or display error message
try {
    $dbh = new PDO('mysql:host=localhost;dbname=comp4ww3', 'root', 'password');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    echo 'Connection failed: ' . $e->getMessage();
}
?>
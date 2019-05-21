<?php
//used for connection
require_once('connection.php');
if (isset($_POST['login'])) {
// validate and process posted username and password here
    if (empty($_POST['username']) || empty($_POST['password'])) {
        header("location:login.php?Empty=Please fill in form!");
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        //run query
        $stmt = $dbh->prepare("SELECT * FROM users WHERE username = \"$username\"");
        $stmt->execute();
        $row = $stmt->fetch();
        $salt = $row['salt'];
        //hash password and concatenate with salt, alg used is sha512
        $passhash = hash('sha512', $password . $salt);
        //first check if it returns 1 row, if successful, continue, else display error message at bottom
        $stmt2 = $dbh->prepare("SELECT COUNT(*) FROM users WHERE username = \"$username\" and passwordhash = \"$passhash\"");
        $stmt2->execute();
        $row2 = $stmt2->fetch();
        //print_r($row2[0]);
        /*
         * if only 1 result found from database,
         * store username and set isLoggedIn to True
         * in the $_SESSION array
         */
        if ($row2[0] == 1) {
            session_start();
            $_SESSION['User'] = $username;
            $_SESSION['isLoggedIn'] = true;
            header("location:home.php");
            exit();
        } else {
            header("location:login.php?Invalid=Your login credentials were incorrect! Try again");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="generator" content="CoffeeCup HTML Editor (www.coffeecup.com)">
    <meta name="dcterms.created" content="Mon, 08 Oct 2018 20:35:13 GMT">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="mystyle.css" rel="stylesheet" type="text/css">
    <title>Login
    </title>
    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="site-wrapper">
    <?php
    include 'header.inc';
    ?>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <h1>Login</h1>
    <div class="loginform">
        <form method="POST" action="login.php">
            Username <input type="text" id="username" name="username"><br>
            Password <input type="text" id="password" name="password"><br>
            <input type="submit" name="login" value="Login" onclick="login.php">
        </form>
    </div>


    <?php
    //form validation, if empty display message on login!
    if ($_GET['Empty'] == true) {
        ?>
        <div class="emptyAlert"><?php echo @$_GET['Empty'] ?></div>
        <?php
    }
    ?>

    <?php
    //form validation, if invalid display message on login!
    if ($_GET['Invalid'] == true) {
        ?>
        <div class="emptyAlert"><?php echo @$_GET['Invalid'] ?></div>
        <?php
    }
    ?>

</div>
<?php
include 'footer.inc';
?>
</body>
</html>



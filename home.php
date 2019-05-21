<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="generator" content="CoffeeCup HTML Editor (www.coffeecup.com)">
    <meta name="dcterms.created" content="Sat, 06 Oct 2018 18:31:21 GMT">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="mystyle.css" rel="stylesheet" type="text/css">
    <title>Parkr.io
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

    <!-- banner image -->
    <div class="banner">
        <!-- image class -->
        <img class="banner-image" src="images/banner2.jpg" alt="Banner">
    </div>
    <div class="hometext">
        <h1>
            <?php
            //start session, each page requires this if invoking $_SESSION, display Welcome _USERNAME_ if logged in
            session_start();
            if (isset($_SESSION['User'])) {
                echo "Welcome " . $_SESSION['User'];
            }


            ?>
            <br/>
        </h1>
        <h2>Finally,
            <br/> hassle-free parking
        </h2>
    </div>
    <!-- wrapper with 2 col classes -->
    <div class="wrapper">
        <div class="col col1">
            <a href="search.php">
                <p>Search Parking Spots
                </p>
            </a>
        </div>
        <div class="col col2">
            <a href="submission.php">
                <p>Submit Parking Spots
                </p>
            </a>
        </div>
    </div>
</div>

<?php
include 'footer.inc';
?>

</div>
</body>
</html>

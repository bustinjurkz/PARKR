<?php require 'loggedInCheck.inc.php'; ?>
<?php include('park_submit.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- load external script file -->
    <script type="text/javascript" src="JSscripts.js"></script>
    <meta charset="utf-8">
    <meta name="generator" content="CoffeeCup HTML Editor (www.coffeecup.com)">
    <meta name="dcterms.created" content="Sat, 06 Oct 2018 18:37:37 GMT">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="mystyle.css" rel="stylesheet" type="text/css">

    <title>Submit
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
    <div class="main">
        <!-- includes both HTML5 and JS validation
        I used (this) as an input parameter to the onsubmit because action was
        executing first without it!

        -->
        <form method="POST" action="submission.php" enctype="multipart/form-data" onsubmit="return validateSubmissionForm(this);
        ">
        <?php include('successSubmit.php'); ?>
        <h1>Submit your Spot
        </h1>
        <!-- errors go here -->
        <?php include('errors.php'); ?>
        <!-- added HTML5 form validation using type=text or type=number, as well as specifying "required" -->
        Name of Spot:
        <input type="text" id="name" name="name" required>
        Price per Hour in $CAD
        <input type="number" min="0" step="any" name="price" required>
        Description:
        <input type="text" id="desc" name="desc" required>

        Location:
        <br>
        <br>
        <!-- html5 form validation for lat/long to make sure its of type number with min and max:
        latitude range is -90 to +90, longitude is -180 to +180
        I also adjusted the step to be "any" because decimals weren't being accepted prior -->
        Lat:
        <input type="number" min=-90 max=90 step="any" id="Lat" name="lat" required>
        Long:
        <input type="number" min=-180 max=180 step="any" id="Long" name="lng" required>

        <!-- I've specified type=button so that
it overrides the form's submit type
and does not take me to the 
results page as the other button
search does -->
        <button onclick="getLocation()" type="button">Get Current Location</button>
        <br/><br/>
        <!-- html5 form validation making sure image jpeg  -->
        Upload Image (required):
        <input type="file"
               id="submitpic" name="parking_pic"
               accept="image/jpeg"/>
        <br>
        <br>
        <!-- submission button -->
        <button type="submit" name="parksubmit">Submit
        </button>
        </form>
    </div>
</div>
<?php
include 'footer.inc';
?>
</body>
</html>

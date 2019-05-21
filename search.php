<!DOCTYPE html>
<html lang="en">
<head>
    <!-- load script file -->
    <script type="text/javascript" src="JSscripts.js"></script>
    <meta charset="utf-8">
    <meta name="generator" content="CoffeeCup HTML Editor (www.coffeecup.com)">
    <meta name="dcterms.created" content="Sat, 06 Oct 2018 18:34:09 GMT">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="mystyle.css" rel="stylesheet" type="text/css">
    <title>Search
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
        <!-- HTML5 and JS form validation - NAME is most important for SQL/PHP reasons -->
        <form action="results.php" method="post" onsubmit="return validateSearchForm()">
            <h1>Find a Spot
            </h1>
            Name of Spot (optional):<br>
            <br>
            <input type="text" id="name" name="name">
            Max Price in $CAD (optional):<br>
            <br>
            <select name="price">
                <option value="10">Under $10/hr
                </option>
                <option value="5">Under $5/hr
                </option>
                <option value="3">Under $3/hr
                </option>
                <option selected value="100">any
                </option>
            </select>
            Min Rating (optional):
            <br>
            <br>
            <select name="rating">
                <option value="95">95% Positive
                </option>
                <option value="85">85% Positive
                </option>
                <option value="75">75% Positive
                </option>
                <option value="65">65% Positive
                </option>
                <option selected value="">any
                </option>
            </select>
            Your Location:
            <br/> <br/>
            <!-- html5 form validation for lat/long to make sure its of type number with min and max:
            latitude range is -90 to +90, longitude is -180 to +180
            I also adjusted the step to be "any" because decimals weren't being accepted prior -->
            Latitude:
            <input type="number" min=-90 max=90 step="any" id="Lat" name="lat" required>
            Longitude:
            <input type="number" min=-180 max=180 step="any" id="Long" name="lng" required>
            <br/>
            <!-- I've specified type=button so that
  it overrides the form's submit type
  and does not take me to the
  results page as the other button
  search does -->
            <button onclick="getLocation()" type="button">Get Current Location</button>
            <br/><br/>
            <!-- required distance specification: radio must all have same name
          in order to require 1 selection
          note: if browser cannot handle HTML5, then JS window will pop-up
          instead
            -->
            Distance:
            <br/><br/>
            <input type="radio" id="loc1" value="1" name="dist" required>less than 1 km
            <br>
            <input type="radio" id="loc2" value="3" name="dist">less than 3 km
            <br>
            <input type="radio" id="loc3" value="10" name="dist">less than 10 km
            <br>
            <input type="radio" id="loc4" value="50" name="dist">less than 50 km
            <br>
            <input checked type="radio" id="loc5" value="10000" name="dist">any
            <br>
            <br>
            <!-- submission button -->
            <button type="submit" name="submit">Search
            </button>
        </form>
    </div>
</div>

<?php
include 'footer.inc';
?>
</body>
</html>

<!-- html5 tag in DOCTYPE so Google Maps 
API can be enabled -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="JSscripts.js"></script>
    <meta name="description" content="PARKR to suit your parking needs">
    <meta name="keywords" content="">
    <link href="mystyle.css" rel="stylesheet" type="text/css">
    <title>Results
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
        <h1>
            We found what you need.
        </h1>
        <div class="tableinfo">
            Select a name for full details:
            <br/>
            <br/>
        </div>

        <div class="resulttable">
            <!-- creation of table
    tr = table row
    th = "headers"
    td = table data-->

            <!-- -> accesses objects in array, fetch() retrieves row from database in question-->
            <?php

            require_once('connection.php');
            $price = $_POST["price"];
            $name = $_POST["name"];
            $rating = $_POST["rating"];
            $lat = $_POST["lat"];
            $long = $_POST["lng"];
            $dist = $_POST["dist"];

            //lat/long to distance in km converter
            //found online, fairly simplistic calculator
            function distance($lat1, $lon1, $lat2, $lon2)
            {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                return ($miles * 1.609344);
            }

            /*
             * PROCEED to populate table with 4 cases:
             * case 1: from form, name not specified and rating not specified (any) (including null)
             * case 2: from form, name specified and rating specified (not null)
             * case 3: from form, name not specified and rating specified (not null)
             * case 4: from form, name specified and rating not specified (including null)
             * see fillArrayResults.php for the code on how it populates the global array in JCscripts.js
             */
            //case 1
            if ($name == '' && $rating == '') {
                $stmt = $dbh->query("SELECT * FROM parkings WHERE price<=$price");
                include 'fillArrayResults.php';
            } //case 3
            else if ($name == '') {
                $stmt = $dbh->query("SELECT parkings.id, parkings.name, parkings.price, parkings.lat, parkings.lng, ROUND(AVG(value),0)*10 AS 'avg'
FROM parkings 
    LEFT JOIN reviews 
        ON parkings.id=reviews.p_id 
GROUP BY parkings.id, parkings.name, parkings.price, parkings.lat, parkings.lng
HAVING avg>=$rating and parkings.price <=$price;");
                if (!$stmt) {
                    print_r($dbh->errorInfo());
                } else {
                    include 'fillArrayResults.php';
                }
            } //case 4
            else if ($rating == '') {
                $stmt = $dbh->query("SELECT * FROM parkings WHERE (price<=$price AND name='$name')");
                include 'fillArrayResults.php';
            } //case 2
            else {
                $stmt = $dbh->query("SELECT parkings.id, parkings.name, parkings.price, parkings.lat, parkings.lng, 
    ROUND(AVG(value),0)*10 AS 'avg'
FROM parkings 
    LEFT JOIN reviews 
        ON parkings.id=reviews.p_id 
GROUP BY parkings.id, parkings.name, parkings.price, parkings.lat, parkings.lng
HAVING avg>=$rating and parkings.price <=$price and parkings.name = '$name';");

                include 'fillArrayResults.php';
            }

            ?>
        </div>

        <br>
        <br>
        <!-- id MUST be "map" according to Google API rules  -->
        <div id="map"></div>

        <!-- callback parameter executes initMap function after API loads -->
        <script async defer
                <!-- key -->
        </script>
        <br>

        <?php
        include 'footer.inc';
        ?>
</body>
</html>

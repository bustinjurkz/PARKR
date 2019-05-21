<!-- AJAX review functions  -->
<script>
    function insertReviewResponse() {
        if (this.status == 200) {
            response = JSON.parse(this.response);
            if (response.status == false) {
                document.getElementById("errorplaceholder").innerHTML = "<div class=\"container\"><b>Error:</b> " + response.message + "</div>";
            } else {
                //display new NAME/RATING/COMMENT container from reviews
                document.getElementById("reviewform").innerHTML
                    = "<p>Name: " + response.name + "</p>"
                    + "<p>Rating: " + response.rating + "</p>"
                    + "<p>Review: " + response.review + "</p>";
                ;
            }
        }
    }
</script>

<script>
    function submitReviewForm() {
        request = new XMLHttpRequest();
        request.open("POST", "submit_review.php");
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onload = insertReviewResponse;
        request.send("id=" + encodeURIComponent(<?php echo $_GET['id'] ?>) + "&name=" + encodeURIComponent(document.getElementById("name").value) + "&rating=" + encodeURIComponent(document.getElementById("rating").value) + "&review=" + encodeURIComponent(document.getElementById("review").value));
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="JSscripts.js"></script>
    <link href="mystyle.css" rel="stylesheet" type="text/css">
    <title>Parking Spot
    </title>
    <!--[if IE]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="site-wrapper">

    <?php
    include 'header.inc';
    $dbh = new PDO('mysql:host=localhost;dbname=comp4ww3', 'root', 'password');
    $stmt = $dbh->query("SELECT * FROM parkings WHERE id = {$_GET['id']}");
    $stmt->execute();
    $row = $stmt->fetch();
    //get averaged rating from reviews table
    $avgratingquery = $dbh->query("SELECT ROUND(AVG(value),0) FROM reviews WHERE p_id={$_GET['id']}");
    $avgrating = $avgratingquery->fetchColumn();
    ?>
    <script>
        var tempLat = "<?php echo $row['lat']; ?>";
        var tempLong = "<?php echo $row['lng']; ?>";
        getUserLoc(tempLat, tempLong);
        var parkid = "<?php echo $row['id']; ?>";
        var parkname = "<?php echo $row['name']; ?>";
        var parkprice = "<?php echo $row['price']; ?>";
        var parkrating = "<?php echo $avgrating * 10; ?>";
        var parklat = "<?php echo $row['lat']; ?>";
        var parklong = "<?php echo $row['lng']; ?>";
        //pushing these data vars to a global array stored in JSscripts.js
        pushArray(parkid, parkname, parkprice, parkrating, parklat, parklong);
        //printArray();
    </script>

    <h1>
        <?php
        echo $row['name'];
        ?>

    </h1>
    <!-- id MUST be "map" according to Google API rules  -->
    <div id="map"></div>
    <!-- callback parameter executes initMap function after API loads -->
    <script async defer
            <!-- key -->
    </script>
    <br>
    <!-- id MUST be "map" according to Google API rules-->
    <div id="imagePark">
        <img src="<?php echo $row['imglink']; ?>">
    </div>
    <div class="resultstext">

        <h2>Owner Description
        </h2>
        <?php echo $row['description']; ?>
        <h2>Price
        </h2><?php echo $row['price']; ?>
        /hr
        <h2>Ratings
        </h2>
        <?php echo $avgrating * 10; ?>% positive
        <h2>Reviews
        </h2>
        <p>
            ** Score is out of ten
        </p>
    </div>


    <?php
    $stmt2 = $dbh->prepare("SELECT * FROM reviews WHERE p_id = {$_GET['id']}");
    $stmt2->execute(array("%$query%"));
    $data = $stmt2->fetchAll();
    ?>

    <div id="reviewform">
        name: <input type="text" id="name" name="name"><br>
        rating: <input type="number" id="rating" name="rating"><br>
        comments: <input type="text" id="review" name="review"><br>
        <button onclick="submitReviewForm()">Submit Review</button>

    </div>

    <!-- error messages go here! -->
    <div id="errorplaceholder"></div>
    <?php foreach ($data as $row): ?>

        <div class="container">

            <p><b>Name: </b><?= $row['customer'] ?>
            </p>
            <p><b>Score: </b> <?= $row['value'] ?>
            </p>
            <p><b>Comments: </b> <?= $row['description'] ?>
            </p>

        </div>
    <?php endforeach ?>




    <?php
    include 'footer.inc';
    ?>

</div>
</body>
</html>

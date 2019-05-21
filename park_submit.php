<?php
//initialize error array
$errors = array();
$successArray = array();
//connect to database
require_once('connection.php');

//server side error checking
//if submit button is clicked on submission.php
if (isset($_POST['parksubmit'])) {

    if (!isset($_FILES['parking_pic']['error']) || ($_FILES['parking_pic']['error'] != UPLOAD_ERR_OK)) {
        array_push($errors, "Image did not upload! Try again with a valid .jpg");
    }
    //valid jpg checker
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if ($finfo->file($_FILES['parking_pic']['tmp_name']) === "image/jpeg") {
        $fileextension = "jpg";
    } else {
        array_push($errors, "Image did not upload! Try again with a valid .jpg");
    }
    //get variables from form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $lat = $_POST['lat'];
    $long = $_POST['lng'];
    $desc = $_POST['desc'];
    if (empty($name)) {
        array_push($errors, "Parking spot name is required");
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
        array_push($errors, "Only alphanumeric characters and whitespace is allowed for name!");
    }

    if (empty($price)) {
        array_push($errors, "Price is required");
    }


    if (empty($lat)) {
        array_push($errors, "Latitude is required");
    }
    if (!preg_match("/^(\+|-)?(?:90(?:(?:\.0{1,15})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,15})?))$/", $lat)) {
        array_push($errors, "Please enter a valid latitude!");
    }


    if (empty($long)) {
        array_push($errors, "Longitude is required");
    }

    if (!preg_match("/^(\+|-)?(?:180(?:(?:\.0{1,15})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,15})?))$/", $long)) {
        array_push($errors, "Please enter a valid longitude!");
    }
    if (empty($desc)) {
        array_push($errors, "Description is required");
    }


    //after validating form stuff, do this if error count == 0
    if (count($errors) == 0) {
        //SHA1 alg to give unique filename
        $filehash = sha1_file($_FILES['parking_pic']['tmp_name']);
        $filename = $filehash . "." . $fileextension;
        //aws access from library
        $bucketName = "jurkaudj4ww3";
        require("S3.php");
        $s3 = new S3($awsAccessKey, $awsSecretKey);
        //upload file to AWS
        $ok = $s3->putObjectFile($_FILES['parking_pic']['tmp_name'], $bucketName, $filename, S3::ACL_PUBLIC_READ);
        if ($ok) {
            //concatenate proper url format
            $url = 'https://s3.amazonaws.com/' . $bucketName . '/' . $filename;
            //run query, insert values if OK == true
            //uses prepared statements
            $query2 = $dbh->prepare("INSERT INTO parkings (name, price, lat, lng, imglink, description) VALUES (:name,:price,:lat,:lng,:imglink,:desc)");
            error_log($query2, 0);
            $success = $query2->execute([':name' => $name, ':price' => $price, ':lat' => $lat, ':lng' => $long, ':imglink' => $url, ':desc' => $desc]);
            //if successful on sql end, display thank you page
            if ($success) {
                array_push($successArray, "<div class=\"submitsuccess\"><h1>Thank you!</h1>");

                array_push($successArray, "<p>Your parking submission was successful! <a href=$url>
                    Click here to preview your submitted image</a></p></div>");

            } else {
                echo '<h1>One of us messed up!</h1>';
                echo 'Error uploading to server';
            }
        }
    }


}

?>



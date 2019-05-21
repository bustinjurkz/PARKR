<?php
session_start();
//connect to database
require_once('connection.php');
/*
 * server-side AJAX validation
 * checks if both empty and proper rating format as well as
 * login status
 */

//check if rating empty
if (!isset($_POST["rating"]) || ($_POST["rating"] === "")) {
    echo json_encode(array("status" => false, "message" => "No rating provided"));
} //check if review empty
elseif (!isset($_POST["review"]) || ($_POST["review"] === "")) {
    echo json_encode(array("status" => false, "message" => "No review provided"));
} //check if rating between 0 and 10
elseif (!(0 <= $_POST["rating"] && (int)$_POST["rating"] <= 10)) {
    echo json_encode(array("status" => false, "message" => "rating must be 0-10"));
} //check if name empty
elseif (!isset($_POST["name"]) || ($_POST["name"] === "")) {
    echo json_encode(array("status" => false, "message" => "No name provided"));
} //log in check
elseif (!isset($_SESSION['isLoggedIn'])) {
    echo json_encode(array("status" => false, "message" => "<a href='login.php'>\"You must be logged in to submit a review! Click here to login\"</a>"));
} else {

    //run query
    $id = $_POST['id'];
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $stmt = $dbh->prepare("INSERT INTO reviews (p_id, value, customer, description) VALUES (:id,:rating,:name,:review)");
    $success = $stmt->execute([':id' => $id, ':rating' => $rating, ':name' => $name, ':review' => $review]);
    error_log($stmt, 0);
    if ($success) {
        echo json_encode(array("status" => true, "name" => htmlspecialchars($_POST["name"]),
            "rating" => htmlspecialchars($_POST["rating"]),
            "review" => htmlspecialchars($_POST["review"])));
    } else {
        echo '<h1>One of us messed up!</h1>';
        echo 'Error uploading to server';
    }

}
?>
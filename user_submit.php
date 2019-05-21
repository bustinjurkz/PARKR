<?php
//initialize error array
$errors = array();
//connect to database
require_once('connection.php');


//validation: if register button is clicked from register.php
if (isset($_POST['register'])) {
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $birth = $_POST['DateofBirth'];
    $userbio = $_POST['userbio'];
    $type = $_POST['signeeType'];
    $referral = $_POST['referral'];
    $username = $_POST['username'];

    /* these series of checks are for empty fields */
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    //pattern check for just letters/whitespace for name
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        array_push($errors, "Only letters and whitespace is allowed for name!");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid e-mail format!");
    }

    if (empty($birth)) {
        array_push($errors, "Birthday is required");
    }
    //birthday regex checker for proper form as in users table
    if (!preg_match("/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/", $birth)) {
        array_push($errors, "Invalid birthday format!");
    }
//anything can be inputted for bio
    if (empty($userbio)) {
        array_push($errors, "Brief bio is required");
    }
    if (empty($type)) {
        array_push($errors, "Please select Driver or Owner");
    }
    if (empty($referral)) {
        array_push($errors, "Referral is required");
    }
    if (empty($username)) {
        array_push($errors, "Username is required");
    }

    //username regex, only alphanumeric characters or an underscore, minimum of 4 characters
    if (!preg_match("/^[a-zA-Z0-9\_]{4,}$/", $username)) {
        array_push($errors, "Username must contain at least 4 alphanumeric characters.  Only underscore is allowed");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    //password regex, must contain upper case character and a number
    if (!preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/", $password)) {
        array_push($errors, "Your password must contain at least 8 characters: at least one of 1) uppercase 2) lowercase and 3) number");
    }


    //if no errors, insert user into database
    if (count($errors) == 0) {
        //add salt and then use sha512 alg to store hashed password with salt in database
        $salt = bin2hex(random_bytes(20));
        $passwordhash = hash('sha512', $password . $salt);

        //store in database, use SHA512 for encryption and prepared statements
        $query = $dbh->prepare("INSERT INTO users (name, email, dateofbirth, bio, type, referredBy, username, salt, passwordhash) VALUES (:name,:email,:birth,:bio,:type,:refer,:username,:salt,:passwordhash)");
        $success = $query->execute([':name' => $name, ':email' => $email, ':birth' => $birth, ':bio' => $userbio, ':type' => $type, ':refer' => $referral, ':username' => $username, ':salt' => $salt, ':passwordhash' => $passwordhash]);
        error_log($query, 0);
        //if successful on sql end, display thank you page
        if ($success) {
            header('Location: RegistrationThanks.php');
        } else {
            echo '<h1>One of us messed up!</h1>';
            echo 'Error during registration';
        }

    }
}


?>

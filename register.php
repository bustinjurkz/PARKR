<?php include('user_submit.php') ?>
<!DOCTYPE html>
<head>
    <script type="text/javascript" src="JSscripts.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register
    </title>
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>
<div class="site-wrapper">
    <?php
    include 'header.inc';
    ?>

    <!-- if function validateRegisterForm() returns true, then it'll go to thankyou.html via post -->
    <!-- also has HTML5 form validation with the HTML5 types and the "required" keyword -->
    <!-- (this) variable passed in because without it, action was executing first -->
    <!-- form posting back to ITSELF (register.php) for server side validation handling -->
    <form method="POST" action="register.php" enctype="multipart/form-data" onsubmit="return validateRegisterForm(this);">
        <br>
        <!-- display server side validation errors here -->
        <?php include('errors.php'); ?>
        <h1>Register
        </h1>
        <h2>Basic Info
        </h2>
        Full Name:
        <input type="text" id="name" name="name" required>
        <!-- HTML5 email validation -->
        Email:
        <input type="email" id="email" name="email" required>

        Username:
        <input type="text" id="username" name="username" required>
        <!-- HTML5 password validation -->
        Password <br>(a password must be at least eight characters including at least one uppercase letter and at least
        one number):
        <input type="password" id="password" name="password" required>
        <!-- HTML5 date validation -->
        Date of Birth:
        <input type="date" id="DateofBirth" value="1991-03-16" name="DateofBirth" required>
        <h2>Your profile
        </h2>
        Brief Bio
        <textarea id="userbio" name="userbio" required>
    </textarea>
        <!-- Select type for variability -->
        How did you find us? (optional):
        <select id="referral" name="referral">
            <option value="Word of Mouth">Word of Mouth
            </option>
            <option value="Google">Google
            </option>
            <option value="Bing">Bing
            </option>
            <option value="Online Ad">Online Ad
            </option>
            <option value="Social Media">Social Media
            </option>
            <option value="Referral">Referral
            </option>
        </select>
        Register As:
        <br>
        <br>
        <!-- same name to ensure only 1 of the 2 are selected and work with the HTML5 "required" keyword -->
        <!-- at least 1 of the radio types must have the required keyword for it to be enforced -->
        <input type="radio" name="signeeType" id="driver" value="Driver" required>Driver
        <input type="radio" name="signeeType" id="owner" value="Owner">Owner
        <br>
        <br>

        <!-- submission button -->
        <button type="submit" name="register">Sign Up</button>
    </form>

    <div class="footer">
        <p>Created by Dustin Jurkaulionis<br/>All Rights Reserved <br/>
        </p>
    </div>
</div>
</body>
</html>
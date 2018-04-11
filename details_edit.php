<?php

  session_start();//Start user session for global variables

  //If loggedIn flag doesn't exist (user isn't logged in)
  if (!isset($_SESSION['loggedIn'])){
    header('Location: sign_in.php');//Send user to the Sign In page
    exit();//Exit this file
  }

  //Check if the details change form has been submited
  if (isset($_POST['forename'])){
    //Successful validation flag
    $successVal = true;

    //Check if forename is valid
    $forename = $_POST['forename'];//Assign forename value submitted in the details change form to 'forename' variable
    $regex = "/^[a-zA-Z]{2,30}$/";//Set regular expression for 'forename' validation

    if (!preg_match($regex, $forename)){//If 'forename' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_forename'] = "Forename has to be between 2 and 30 characters and cosist of letters only!";//Set error message for 'forename' field
    }

    //Check if surname is valid
    $surname = $_POST['surname'];//Assign surname value submitted in the details change form to 'forename' variable
    $regex = "/^([a-zA-Z]+[\s]?[-\s]?[\s]?[a-zA-Z]{1,29})$/";//Set regular expression for 'surname' validation

    if (!preg_match($regex, $surname)){//If 'surname' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_surname'] = "Surname has to be between 2 and 30 characters! Use dash to separate double-barrelled surnames.";//Set error message for 'surname' field
    }

    //Check if email address is valid
    $email = $_POST['email-address'];//Store user email input in variable
    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);//Sanitize email

    //Validate sanitized email and compare it to the original user input
    if ((filter_var($emailS, FILTER_VALIDATE_EMAIL) == false) || ($emailS != $email)){
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_email'] = "Input correct email address!";//Email error message
    }

    //Check if the phone number is valid
    $phone_num = $_POST['phone-num'];//Assign phone_num value submitted in the details change form to 'phone_num' variable
    $regex = "/^[0-9]{11,14}$/";//Set regular expression for phone number validation

    if ((!preg_match($regex, $phone_num)) && $phone_num != ""){//If phone number validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_phonenum'] = "Phone number must contain numbers only and be 11-14 digits long!";//Set error message for 'phonenum' field
    }

    //Check if the address (line 1) is valid
    $address = $_POST['address-line1'];//Assign address line-1 value submitted in the details change form to 'address' variable
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";//Set regular expression for address validation

    if ((!preg_match($regex, $address)) && $address != ""){//If address validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_address1'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";//Set error message for 'address1' field
    }

    //Check if the address (line 2) is valid
    $address2 = $_POST['address-line2'];//Assign address line-2 value submitted in the details change form to 'address2' variable
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";//Set regular expression for address2 validation

    if ((!preg_match($regex, $address2)) && $address2 != ""){//If address2 validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_address2'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";//Set error message for 'address2' field
    }

    //Check if the city is valid
    $city = $_POST['city'];//Assign city value submitted in the details change form to 'city' variable
    $regex = "/^[a-zA-Z]{2,20}$/";//Set regular expression for city validation

    if ((!preg_match($regex, $city)) && $city != ""){//If city validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_city'] = "City can containe letters only and cannot be longer than 20 characters!";//Set error message for 'city' field
    }

    //Check if the postcode is valid
    $postcode = $_POST['postcode'];//Assign postcode value submitted in the details change form to 'postcode' variable

    $regex = "/^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/";
    //Set regular expression for postcode validation

    if ((!preg_match($regex, $postcode)) && $postcode != ""){//If postcode validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_postcode'] = "Enter a correct UK postcode";//Set error message for 'postcode' field
    }

    require_once "connect.php";//Include the 'connect.php' file
    mysqli_report(MYSQLI_REPORT_STRICT);//Instead of errors throw exceptions

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);//Esablish a new database connection

      if($connection->connect_errno!=0){//If there are database connection errors
        throw new Exception(mysqli_connect_errno());//Throw an exception containing error number
      }else{
        //Check if the email exists in the db
        $result = $connection->query("SELECT user_id FROM users WHERE email='$email'");//Assign user_id values from users table, where email is equal to user's email, to 'result' variable

        if (!$result){//If the SQL query wasn't successful
          throw new Exception($connection->error);//Throw an exception containing an error
        }

        $emailsNum = $result->num_rows;//Assign number of emails in the database to the 'emailsNum' variable

        $c_user_email = $_SESSION['email'];//Assign currently logged-in user email to the local variable
        $c_user_id = $_SESSION['user_id'];//Assign currently logged-in user id to the local variable

        if ($emailsNum > 0){//If the email address is already in the database
          $successVal = false;//Set successful validation flag to false
          $_SESSION['e_email'] = "Sorry, this email is assigned to another account";//Set error message for 'email' field
        }

        if($successVal == true){//If validation IS successful
          if($connection->query("UPDATE users SET first_name='$forename', last_name='$surname', email='$email', phone_num='$phone_num', address='$address', address2='$address2', city='$city', postcode='$postcode' WHERE user_id='$c_user_id'")){//Update user data in the database

            $db_result = $connection->query("SELECT * FROM users WHERE user_id='$c_user_id'");//Assign user_id values from users table, is is equl to user's id, to 'db_result' variable

            if (!$db_result){//In case of an SQL query error
              throw new Exception($connection->error);//Throw an exception
              session_unset();//Close the session (log out the user)
              exit();//Exit the file
            }

            $record = $db_result->fetch_assoc();//Create associative array and assign it to 'record' variable

            $_SESSION['user_id'] = $record['user_id'];//Set global 'user_id' variable to the value fetched from the database
            $_SESSION['first_name'] = $record['first_name'];//Set global 'first_name' variable to the value fetched from the database
            $_SESSION['last_name'] = $record['last_name'];//Set global 'last_name' variable to the value fetched from the database
            $_SESSION['email'] = $record['email'];//Set global 'email' variable to the value fetched from the database
            $_SESSION['phone_num'] = $record['phone_num'];//Set global 'phone_num' variable to the value fetched from the database
            $_SESSION['address'] = $record['address'];//Set global 'address' variable to the value fetched from the database
            $_SESSION['address2'] = $record['address2'];//Set global 'address2' variable to the value fetched from the database
            $_SESSION['city'] = $record['city'];//Set global 'city' variable to the value fetched from the database
            $_SESSION['postcode'] = $record['postcode'];//Set global 'postcode' variable to the value fetched from the database

            $_SESSION['details_change_success'] = true;//set global/session variable 'details_change_success' to true - indicates that user has changed their details
            header('Location: details_change_success.php');//Direct user to the 'details_change_success' page
          }else{
            throw new Exception($connection->error);//Throw an exception containing the error
          }
        }

        $connection->close();//Close the connection with the database
      }
    }
    catch(Exception $e){
      echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';//Show a server error message
      //echo '<br />Developer info: '.$e;//Display the detailed description of an error - DEVELOPER USE ONLY!!!
    }
  }

  require_once "booking_processing.php";//Link the booking form processing script
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Smith's Computer Service</title>
  <meta name="description" content="Computer service located in Brighton, UK">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONTS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Work+Sans:300,400,500,600|Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/style.css">

  <!-- JavaScript
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/details_change_val.js"></script>
  <script type="text/javascript" src="js/functions.js"></script>
  <script type="text/javascript" src="js/booking_form_val.js"></script>
  <script>
  $(document).ready(function(){//When the file loads (do the function)
    $("#booking-open").click(function(){//If booking-open button is clicked
        <?php
          if (isset($_SESSION['loggedIn'])){//If user is logged in
            echo 'var logged_in = '.$_SESSION['loggedIn'].';';//Set 'logged_in' variable to true
          }else{
            echo 'var logged_in = false;';//Otherwise, set 'logged_in' to false
          }
        ?>

        if (logged_in == false){//If user isn't logged in
          window.location.replace("sign_in.php");//Direct them to the Sign In page
        }
    });
  });
  </script>

  <!-- Page icon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <!-- Booking form (overlay) -->
  <div id="overlay">
  	<div id="booking-form-main">
      <?php
        require_once "booking_form.php";//Include the booking form
      ?>
    </div>
  </div>

  <div class="nav-bar">
    <div id="nav">
      <ul>
        <li><a href="index.php#landing-page" id="home-nav">Home</a></li>
        <li><a href="index.php#about" id="about-nav">About</a></li>
        <li><a href="index.php#services" id="services-nav">Services</a></li>
        <li><a href="index.php#services" id="prices-nav">Prices</a></li>
        <li><a href="index.php#contact" id="contact-nav">Contact</a></li>
        <li><a href="myaccount.php" style="color: #5B0606">My Account</a></li>
        <li><button id="booking-open" class="astext" onclick="on()">Booking</button></li>
        <li><a href="sign_in.php">Sign In</a></li>
      </ul>
    </div>
  </div>

  <div id="details-edit-main" class="container">
    <div class="heading">
      <h1>Your details</h1>
    </div>

    <div id="details-edit-form">
      <form id="d-edit-form" method="post" onsubmit="return !!(valForenameDet() & valSurnameDet() & valEmailDet() & valPhoneNumDet() & valAddressDet() & valAddress2Det() & valCityDet() & valPostcodeDet());">
        <label for="forename" class="d-form-label">Forename:</label> <input type="text" name="forename" id="details-forename"
        <?php
          if (isset($_SESSION['first_name'])){//If first_name variable is set
            echo 'value="'.$_SESSION['first_name'].'"';//Set it as "value" parameter for the input field
          }

        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_forename'])){//If forename error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_forename'].'</div>';//Display the error message
            unset($_SESSION['e_forename']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>

        <label for="surname" class="d-form-label">Surname:</label><input type="text" name="surname" id="details-surname"
        <?php
          if (isset($_SESSION['last_name'])){//If last_name variable is set
            echo 'value="'.$_SESSION['last_name'].'"';//Set it as "value" parameter for the input field
          }

        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_surname'])){//If surname error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_surname'].'</div>';//Display the error message
            unset($_SESSION['e_surname']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>

        <label for="email-address" class="d-form-label">E-mail address:</label><input type="email" name="email-address" id="details-email"
        <?php
          if (isset($_SESSION['email'])){//If email variable is set
            echo 'value="'.$_SESSION['email'].'"';//Set it as "value" parameter for the input field
          }

        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_email'])){//If email error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_email'].'</div>';//Display the error message
            unset($_SESSION['e_email']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>

        <label for="phone-num" class="d-form-label">Phone Number:</label><input type="text" name="phone-num" id="details-phone-num"
        <?php
          if (isset($_SESSION['phone_num'])){//If phone_num variable is set
            echo 'value="'.$_SESSION['phone_num'].'"';//Set it as "value" parameter for the input field
          }

        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_phonenum'])){//If phone number error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_phonenum'].'</div>';//Display the error message
            unset($_SESSION['e_phonenum']);//Unset the error variable so it doesn't show up until the next error

          }
        ?>

        <label for="address-line1" class="d-form-label">Address:</label><input type="text" name="address-line1" id="details-addressl1"
        <?php
          if (isset($_SESSION['address'])){//If address variable is set
            echo 'value="'.$_SESSION['address'].'"';//Set it as "value" parameter for the input field
          }

        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_address1'])){//If address line-1 error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_address1'].'</div>';//Display the error message
            unset($_SESSION['e_address1']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>

        <label for="address-line2" class="d-form-label">Address (line 2):</label><input type="text" id="details-addressl2" name="address-line2"
        <?php
          if (isset($_SESSION['address2'])){//If address2 variable is set
            echo 'value="'.$_SESSION['address2'].'"';//Set it as "value" parameter for the input field
          }

        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_address2'])){//If address line-2 error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_address2'].'</div>';//Display the error message
            unset($_SESSION['e_address2']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>

        <label for="city" class="d-form-label">City:</label><input type="text" name="city" id="details-city"
        <?php
          if (isset($_SESSION['city'])){//If city variable is set
            echo 'value="'.$_SESSION['city'].'"';//Set it as "value" parameter for the input field
          }

        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_city'])){//If city error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_city'].'</div>';//Display the error message
            unset($_SESSION['e_city']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>


        <label for="postcode" class="d-form-label">Postcode:</label><input type="text" name="postcode" id="details-postcode"
        <?php
          if (isset($_SESSION['postcode'])){//If postcode variable is set
            echo 'value="'.$_SESSION['postcode'].'"';//Set it as "value" parameter for the input field
          }

        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_postcode'])){//If postcode error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_postcode'].'</div>';//Display the error message
            unset($_SESSION['e_postcode']);//Unset the error variable so it doesn't show up until the next error
          }
        ?>

        <input type="submit" value="Save">
      </form>
    </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

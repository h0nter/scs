<?php

  session_start();//Start user session for global variables

  //If loggedIn flag doesn't exist (user isn't logged in)
  if (!isset($_SESSION['loggedIn'])){
    header('Location: sign_in.php');//Send user to the Sign In page
    exit();//Exit this file
  }

  //Check if the form has been submited
  if (isset($_POST['forename'])){
    //Successful validation flag
    $successVal = true;

    //Check if forename is valid
    $forename = $_POST['forename'];
    $regex = "/^[a-zA-Z]{2,30}$/";

    if (!preg_match($regex, $forename)){
      $successVal = false;
      $_SESSION['e_forename'] = "Forename has to be between 2 and 30 characters and cosist of letters only!";
    }

    //Check if surname is valid
    $surname = $_POST['surname'];
    $regex = "/^([a-zA-Z]+[\s]?[-\s]?[\s]?[a-zA-Z]{1,29})$/";

    if (!preg_match($regex, $surname)){
      $successVal = false;
      $_SESSION['e_surname'] = "Surname has to be between 2 and 30 characters! Use dash to separate double-barrelled surnames.";
    }

    //Check if email address is valid
    $email = $_POST['email-address'];//Store user email input in variable
    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);//Sanitize email

    //Validate sanitized email and compare it to the original user input
    if ((filter_var($emailS, FILTER_VALIDATE_EMAIL) == false) || ($emailS != $email)){
      $successVal = false;
      $_SESSION['e_email'] = "Input correct email address!";//Email error message
    }

    //Check if the phone number is valid
    $phone_num = $_POST['phone-num'];
    $regex = "/^[0-9]{11,14}$/";

    if ((!preg_match($regex, $phone_num)) && $phone_num != ""){
      $successVal = false;
      $_SESSION['e_phonenum'] = "Phone number must contain numbers only and be 11-14 digits long!";
    }

    //Check if the address (line 1) is valid
    $address = $_POST['address-line1'];
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";

    if ((!preg_match($regex, $address)) && $address != ""){
      $successVal = false;
      $_SESSION['e_address1'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";
    }

    //Check if the address (line 2) is valid
    $address2 = $_POST['address-line2'];
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";

    if ((!preg_match($regex, $address2)) && $address2 != ""){
      $successVal = false;
      $_SESSION['e_address2'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";
    }

    //Check if the city is valid
    $city = $_POST['city'];
    $regex = "/^[a-zA-Z]{2,20}$/";

    if ((!preg_match($regex, $city)) && $city != ""){
      $successVal = false;
      $_SESSION['e_city'] = "City can containe letters only and cannot be longer than 20 characters!";
    }

    //Check if the postcode is valid
    $postcode = $_POST['postcode'];
    $regex = "/^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/";

    if ((!preg_match($regex, $postcode)) && $postcode != ""){
      $successVal = false;
      $_SESSION['e_postcode'] = "Enter a correct UK postcode";
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);

      if($connection->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());
      }else{
        $result = $connection->query("SELECT user_id FROM users WHERE email='$email'");

        if (!$result){
          throw new Exception($connection->error);
        }

        $emailsNum = $result->num_rows;
        $c_user_email = $_SESSION['email'];
        $c_user_id = $_SESSION['user_id'];

        if (($emailsNum > 0) && ($email != $c_user_email)){
          $successVal = false;
          $_SESSION['e_email'] = "Sorry, this email is assigned to another account";
        }

        if($successVal == true){
          if($connection->query("UPDATE users SET first_name='$forename', last_name='$surname', email='$email', phone_num='$phone_num', address='$address', address2='$address2', city='$city', postcode='$postcode' WHERE user_id='$c_user_id'")){

            $_SESSION['details_change_success'] = true;

            $db_result = $connection->query("SELECT * FROM users WHERE user_id='$c_user_id'");

            if (!$db_result){
              throw new Exception($connection->error);
              session_unset();
              exit();
            }

            $record = $db_result->fetch_assoc();

            $_SESSION['user_id'] = $record['user_id'];
            $_SESSION['first_name'] = $record['first_name'];
            $_SESSION['last_name'] = $record['last_name'];
            $_SESSION['email'] = $record['email'];
            $_SESSION['phone_num'] = $record['phone_num'];
            $_SESSION['address'] = $record['address'];
            $_SESSION['address2'] = $record['address2'];
            $_SESSION['city'] = $record['city'];
            $_SESSION['postcode'] = $record['postcode'];

            header('Location: details_change_success.php');
          }else{
            throw new Exception($connection->error);
          }
        }

        $connection->close();
      }
    }
    catch(Exception $e){
      echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';
      //echo '<br />Developer info: '.$e;
    }
  }
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
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/functions.js"></script>
  <script src="js/details_change_val.js"></script>
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
  		<div id="booking-form">
  			<form id="b-form" action="" onsubmit="return !!(valYearOfProdbook() & valForenamebook() & valSurnamebook() & valEmailbook() & valPhoneNumbook() & valAddressbook() & valAddress2book() & valCitybook() & valPostcodebook() & valDescriptionbook());">
          <div class="heading">
            <h3>Booking form</h3>
          </div>

          <div id="computer-type-s">
            <label for="computer-type" class="d-form-label">Computer type:</label><br>
            <select name="computer-type" id="computer-type" required>
              <option></option>
              <option value="PC">Desktop PC/iMac</option>
              <option value="Laptop">Laptop/Notebook/Macbook</option>
              <!--<option value="Macbook">Macbook</option>
              <option value="iMac">iMac</option>-->
            </select>
          </div>

          <div id="computer-details">
            <label for="make" class="d-form-label">Computer make:</label>
            <select name="make" id="comp-make" required>
              <option></option>
              <option value="HP">HP</option>
              <option value="Lenovo">Lenovo</option>
              <option value="Dell">Dell</option>
              <option value="Asus">Asus</option>
              <option value="Acer">Acer</option>
              <option value="Apple">Apple</option>
              <option value="Alienware">Alienware</option>
              <option value="Other">Other</option>
            </select><br>

            <label for="model" class="d-form-label">Computer model:</label>
            <input type="text" name="model" id="comp-model"><br>

            <label for="year" class="d-form-label">Year of production:</label>
            <input type="text" name="year" id="year-prod">
          </div>

          <div id="service-details">
            <div class="label-item-rel">
              <label for="type-os" class="d-form-label">Type of service:</label>
              <select name="type-os" id="type-os" required>
                <option></option>
                <option value="OS install">OS install/re-install</option>
                <option value="cleaning">Device cleaning</option>
                <option value="hw-update">Hardware update</option>
                <option value="pc-build">Building a new PC</option>
                <option value="screen-replacment">Screen replacment</option>
                <option value="hard-drive-recovery">Hard-drive data recovery</option>
                <option value="Other">Other</option>
              </select><br>
            </div>

            <div class="label-item-rel">
              <label for="devices-num" class="d-form-label">Number of devices:</label>
              <select name="devices-num" id="devices-num" required>
                <option></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="more">More</option>
              </select><br>
            </div>
          </div>

          <div id="delivery-method">
            <h4>DELIVERY METHOD:</h4>
            <input type="radio" name="d-method" value="in-person"> In-person<br>

            <input type="radio" name="d-method" value="collect-delivery"> Collect & Delivery (extra cost)<br>
          </div>

          <div id="date-select">
            <h4>SELECT THE DATE:</h4>
            <input type="date" name="booking-date" id="booking-date">
          </div>

          <div id="personal-information">
            <div style="grid-column: 1/3; grid-row: 1;">
              <h4>PERSONAL INFORMATION:</h4>
            </div>
            <div id="col-1">
              <input type="text" name="forename" id="booking-forename" placeholder="Forename*"><br>

              <input type="text" name="surname" id="booking-surname" placeholder="Surname*"><br>

              <input type="email" name="email-address" id="booking-email" placeholder="E-mail address*"><br>

              <input type="text" name="phone-num" id="booking-phone-num" placeholder="Phone Number*"><br>
            </div>

            <div id="col-2">
              <input type="text" name="address-line1" id="booking-addl1" placeholder="Address"><br>

              <input type="text" name="address-line2" id="booking-addl2" placeholder="Address (line 2)"><br>

              <input type="text" name="city" id="booking-city" placeholder="City"><br>

              <input type="text" name="postcode" id="booking-postcode" placeholder="Postcode" style="max-width: 15rem;"><br>
            </div>
          </div>

          <div id="description">
            <h4>FAULT/PROBLEM/SERVICE DESCRIPTION:</h4>
            <textarea name="service-description" id="service-description" maxlength="1000" rows="5" placeholder="Max. 1000 characters"></textarea>
          </div>

          <div id="form-submit">
            <input type="submit" value="Submit">
          </div>
			  </form>
		  </div>
      <div id="close-x" onclick="off()">
        <img src="images/close-cross2.png" />
      </div>
    </div>
  </div>

  <div class="nav-bar">
    <div id="nav">
      <ul>
        <li><a href="index.php" id="home-nav">Home</a></li>
        <li><a href="index.php" id="about-nav">About</a></li>
        <li><a href="index.php" id="services-nav">Services</a></li>
        <li><a href="index.php" id="prices-nav">Prices</a></li>
        <li><a href="index.php" id="contact-nav">Contact</a></li>
        <li><a href="myaccount.php" style="color: #5B0606">My Account</a></li>
        <li><button class="astext" onclick="on()">Booking</button></li>
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
          if (isset($_SESSION['first_name'])){
            echo 'value="'.$_SESSION['first_name'].'"';
          }
        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_forename'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_forename'].'</div>';
            unset($_SESSION['e_forename']);
          }
        ?>

        <label for="surname" class="d-form-label">Surname:</label><input type="text" name="surname" id="details-surname"
        <?php
          if (isset($_SESSION['last_name'])){
            echo 'value="'.$_SESSION['last_name'].'"';
          }
        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_surname'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_surname'].'</div>';
            unset($_SESSION['e_surname']);
          }
        ?>

        <label for="email-address" class="d-form-label">E-mail address:</label><input type="email" name="email-address" id="details-email"
        <?php
          if (isset($_SESSION['email'])){
            echo 'value="'.$_SESSION['email'].'"';
          }
        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_email'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
          }
        ?>

        <label for="phone-num" class="d-form-label">Phone Number:</label><input type="text" name="phone-num" id="details-phone-num"
        <?php
          if (isset($_SESSION['phone_num'])){
            echo 'value="'.$_SESSION['phone_num'].'"';
          }
        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_phonenum'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_phonenum'].'</div>';
            unset($_SESSION['e_phonenum']);
          }
        ?>

        <label for="address-line1" class="d-form-label">Address:</label><input type="text" name="address-line1" id="details-addressl1"
        <?php
          if (isset($_SESSION['address'])){
            echo 'value="'.$_SESSION['address'].'"';
          }
        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_address1'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_address1'].'</div>';
            unset($_SESSION['e_address1']);
          }
        ?>

        <label for="address-line2" class="d-form-label">Address (line 2):</label><input type="text" id="details-addressl2" name="address-line2"
        <?php
          if (isset($_SESSION['address2'])){
            echo 'value="'.$_SESSION['address2'].'"';
          }
        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_address2'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_address2'].'</div>';
            unset($_SESSION['e_address2']);
          }
        ?>

        <label for="city" class="d-form-label">City:</label><input type="text" name="city" id="details-city"
        <?php
          if (isset($_SESSION['city'])){
            echo 'value="'.$_SESSION['city'].'"';
          }
        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_city'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_city'].'</div>';
            unset($_SESSION['e_city']);
          }
        ?>


        <label for="postcode" class="d-form-label">Postcode:</label><input type="text" name="postcode" id="details-postcode"
        <?php
          if (isset($_SESSION['postcode'])){
            echo 'value="'.$_SESSION['postcode'].'"';
          }
        ?>
        ><br>
        <?php
          if (isset($_SESSION['e_postcode'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_postcode'].'</div>';
            unset($_SESSION['e_postcode']);
          }
        ?>

        <input type="submit" value="Save">
      </form>
    </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

<?php
  session_start();//Start user session for global variables

  //If loggedIn flag doesn't exist (user isn't logged in)
  if (!isset($_SESSION['loggedIn'])){
    header('Location: sign_in.php');//Send user to the Sign In page
    exit();//Exit this file
  }

  //Check if the form has been submited
  if (isset($_POST['current-password'])){
    //Successful validation flag
    $successVal = true;

    //Check if the current password is valid
    $passC = $_POST['current-password'];
    $regex = "/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+=?^_-].{8,}$/";

    if(!preg_match($regex, $passC)){
      $successVal = false;
      $_SESSION['e_passwordC'] = "Incorrect password!";
    }

    //Check if the new passwords are valid
    $pass1 = $_POST['new-password'];
    $pass2 = $_POST['confirm-password'];
    $regex = "/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+=?^_-].{8,}$/";

    if (!preg_match($regex, $pass1)){
      $successVal = false;
      $_SESSION['e_password'] = "Password must have more than 8 characters, at least 1 capital letter and at least 1 number!";
    }

    if ($pass1 != $pass2){
      $successVal = false;
      $_SESSION['e_password'] = "Entered passwords aren't identical";
    }

    $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);

    require_once "connect.php";//Attach 'connect.php' file
    mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);//Establish a new database connection
      //Check if the connection with database was successful
      if($connection->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());//In case of connection error, throw an exception
      }else{
        $c_user_id = $_SESSION['user_id'];

        $c_user_pass = $connection->query("SELECT password FROM users WHERE user_id='$c_user_id'");//Variable to store result of the SQL query which selects the user password from the db

        if (!$c_user_pass){
          throw new Exception($connection->error);
        }

        if(!password_verify($passC, $c_user_pass)){
          $successVal = false;
          $_SESSION['e_passwordC'] = "Incorrect password!";
        }

        if(successVal == true){
          if($connection->query("UPDATE users SET password='$pass_hash' WHERE user_id='$c_user_id'")){
            $_SESSION['pass_change_success'] = true;
            header('Location: pass_change_success.php');
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
  <script src="js/passchange_val.js"></script>
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

  <div id="password-change-main">
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

    <div id="password-change-form" class="container">
      <div class="heading">
        <h1>Change Password</h1>
      </div>

      <form id="pass-change-form" method="post" onsubmit="return !!(valCurrentPswrd() & valNewPswrd());">
        <label for="current-password" class="p-form-label">Current Password:</label> <input type="password" name="current-password" id="pass-change-crntpass" required><br>
        <?php
          if (isset($_SESSION['e_passwordC'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_passwordC'].'</div>';
            unset($_SESSION['e_passwordC']);
          }
        ?>

        <label for="new-password" class="p-form-label">New Password:</label> <input type="password" name="new-password" id="pass-change-newpass" required><br>
        <?php
          if (isset($_SESSION['e_password'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_password'].'</div>';
            unset($_SESSION['e_password']);
          }
        ?>

        <label for="confirm-password" class="p-form-label">Confirm Password:</label> <input type="password" id="pass-change-confirmpass" name="confirm-password" required><br>

        <input type="submit" value="Confirm">
      </form>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

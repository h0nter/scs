<?php

  session_start();//Start user session for global variables

  //If successReg flag doesn't exist in the session (user hasn't registered a new account)
  if (!isset($_SESSION['successReg'])){
    header('Location: sign_in.php');//Send user to the Sign In page
    exit();//Exit this file
  }else{//If the successReg flag exists in the session
    unset($_SESSION['successReg']);
  }

  //Check if the booking form has been submited
  if (isset($_POST['booking-date'])){
    //Successful validation flag
    $successVal = true;

    //Check if computer type is valid
    $comp_type = $_POST['computer-type'];

    if ($comp_type == ""){
      $successVal = false;
      $_SESSION['e_comptype'] = "This field cannot be empty";
    }else if(($comp_type != "PC/iMac") && ($comp_type != "Laptop/Macbook")){
      $successVal = false;
      $_SESSION['e_comptype'] = "Incorrect value!";
    }

    //Check if computer make is valid
    $comp_make = $_POST['make'];

    if ($comp_make == ""){
      $successVal = false;
      $_SESSION['e_make'] = "This field cannot be empty";
    }else if(($comp_make != "HP") && ($comp_make != "Lenovo") && ($comp_make != "Dell") && ($comp_make != "Asus") && ($comp_make != "Acer") && ($comp_make != "Apple") && ($comp_make != "Alienware") && ($comp_make != "Other")){
      $successVal = false;
      $_SESSION['e_make'] = "Incorrect value!";
    }

    //Check if computer model is valid
    $comp_model = $_POST['model'];

    if ((strlen($comp_model) < 2) || (strlen($comp_model) > 30)){
      $successVal = false;
      $_SESSION['e_model'] = "Computer model must be between 2 and 30 characters!";
    }

    $comp_model = htmlentities($comp_model, ENT_QUOTES, "UTF-8");//Sanitize model string

    //Check if year of production is valid
    $year_of_prod = $_POST['year'];
    $regex = "/^((19||20)+([0-9]{2}))$/";

    if (!preg_match($regex, $year_of_prod)){
      $successVal = false;
      $_SESSION['e_year'] = "Enter a correct year in the range 1900-2099";
    }

    //Check if type of service is valid
    $type_os = $_POST['type-os'];

    if ($type_os == ""){
      $successVal = false;
      $_SESSION['e_service'] = "This field cannot be empty";
    }else if(($type_os != "os-install") && ($type_os != "cleaning") && ($type_os != "hw-update") && ($type_os != "pc-build") && ($type_os != "screen-replacement") && ($type_os != "hard-drive-recovery") && ($type_os != "other")){
      $successVal = false;
      $_SESSION['e_service'] = "Incorrect value!";
    }

    //Check if number of devices is valid
    $devices_num = $_POST['devices-num'];

    if ($devices_num == ""){
      $successVal = false;
      $_SESSION['e_dnum'] = "This field cannot be empty";
    }else if(($devices_num != "1") && ($devices_num != "2") && ($devices_num != "3") && ($devices_num != "4") && ($devices_num != "5") && ($devices_num != "more")){
      $successVal = false;
      $_SESSION['e_dnum'] = "Incorrect value!";
    }

    //Check if delivery method is selected
    $d_method = $_POST['d-method'];

    if (($d_method != "in-person") && ($d_method != "collect-delivery")){
      $successVal = false;
      $_SESSION['e_dmethod'] = "Please, select the delivery method!";
    }

    //Check if the booking date is vaild (yyyy-mm-dd)
    $booking_date = $_POST['booking-date'];
    $regex = "/^([0-9]{4}-[0-9]{2}-[0-9]{2})$/";

    if (!preg_match($regex, $booking_date)){
      $successVal = false;
      $_SESSION['e_date'] = "Date has to be in a correct format!";
    }

    //Check if forename is valid
    $forename = $_POST['b-forename'];
    $regex = "/^[a-zA-Z]{2,30}$/";

    if (!preg_match($regex, $forename)){
      $successVal = false;
      $_SESSION['e_bforename'] = "Forename has to be between 2 and 30 characters and cosist of letters only!";
    }

    //Check if surname is valid
    $surname = $_POST['b-surname'];
    $regex = "/^([a-zA-Z]+[\s]?[-\s]?[\s]?[a-zA-Z]{1,29})$/";

    if (!preg_match($regex, $surname)){
      $successVal = false;
      $_SESSION['e_bsurname'] = "Surname has to be between 2 and 30 characters! Use dash to separate double-barrelled surnames.";
    }

    //Check if email address is valid
    $email = $_POST['b-email-address'];//Store user email input in variable
    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);//Sanitize email

    //Validate sanitized email and compare it to the original user input
    if ((filter_var($emailS, FILTER_VALIDATE_EMAIL) == false) || ($emailS != $email)){
      $successVal = false;
      $_SESSION['e_bemail'] = "Input correct email address!";//Email error message
    }

    //Check if the phone number is valid
    $phone_num = $_POST['b-phone-num'];
    $regex = "/^[0-9]{11,14}$/";

    if (!preg_match($regex, $phone_num)){
      $successVal = false;
      $_SESSION['e_bphonenum'] = "Phone number must contain numbers only and be 11-14 digits long!";
    }

    //Check if the address (line 1) is valid
    $address = $_POST['b-address-line1'];
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";

    if ((!preg_match($regex, $address)) && $address != ""){
      $successVal = false;
      $_SESSION['e_baddress'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";
    }

    //Check if the address (line 2) is valid
    $address2 = $_POST['b-address-line2'];
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";

    if ((!preg_match($regex, $address2)) && $address2 != ""){
      $successVal = false;
      $_SESSION['e_baddress'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";
    }

    //Check if the city is valid
    $city = $_POST['b-city'];
    $regex = "/^[a-zA-Z]{2,20}$/";

    if ((!preg_match($regex, $city)) && $city != ""){
      $successVal = false;
      $_SESSION['e_bcity'] = "City can containe letters only and cannot be longer than 20 characters!";
    }

    //Check if the postcode is valid
    $postcode = $_POST['b-postcode'];
    $regex = "/^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/";

    if ((!preg_match($regex, $postcode)) && $postcode != ""){
      $successVal = false;
      $_SESSION['e_bpostcode'] = "Enter a correct UK postcode";
    }

    //Check if the service description is valid
    $service_note = $_POST['service-description'];

    if ($service_note == ""){
      $successVal = false;
      $_SESSION['e_serviceds'] = "This field cannot be empty";
    }

    $service_note = htmlentities($service_note, ENT_QUOTES, "UTF-8");//Sanitize model string

    require_once "connect.php";//Include 'connect.php' file
    mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);
      if ($connection->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());
      }else{
        //Check if the email exists in the db
        $result = $connection->query("SELECT user_id FROM users WHERE email='$email'");

        if (!$result){
          throw new Exception($connection->error);
        }

        $emailsNum = $result->num_rows;

        if($emailsNum = 0){
          $successVal = false;
          $_SESSION['e_bemail'] = "This email doesn't exist in the database!";
        }

        $comp_model = mysqli_real_escape_string($connection, $comp_model);

        $service_note = mysqli_real_escape_string($connection, $service_note);

        $user_id = $_SESSION['user_id'];

        if($successVal == true){
          //Validation IS successful, add user to the db
          if ($connection->query("INSERT INTO bookings VALUES (NULL,'$user_id','$booking_date','$comp_type','$comp_make','$comp_model','$year_of_prod','$type_os','$devices_num','$d_method','$service_note')")){
            $_SESSION['successBooking']=true;
            header('Location: success_booking.php');
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
  <script type="text/javascript" src="js/functions.js"></script>
  <script type="text/javascript" src="js/booking_form_val.js"></script>
  <script>
  $(document).ready(function(){
    $("#booking-open").click(function(){
        <?php
          if (isset($_SESSION['loggedIn'])){
            echo 'var logged_in = '.$_SESSION['loggedIn'].';';
          }else{
            echo 'var logged_in = false;';
          }
        ?>

        if (logged_in == false){
          window.location.replace("sign_in.php");
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
      if ($_SESSION['loggedIn'] == true){
echo <<<EOL
  <div id="booking-form">
  <form id="b-form" method="post" onsubmit="return !!(valYearOfProdbook() & valForenamebook() & valSurnamebook() & valEmailbook() & valPhoneNumbook() & valAddressbook() & valAddress2book() & valCitybook() & valPostcodebook() & valDescriptionbook());">
    <div class="heading">
      <h3>Booking form</h3>
    </div>

    <div id="computer-type-s">
      <label for="computer-type" class="d-form-label">Computer type:</label><br>
      <select name="computer-type" id="computer-type" required>
        <option></option>
        <option value="PC/iMac">Desktop PC/iMac</option>
        <option value="Laptop/Macbook">Laptop/Notebook/Macbook</option>
        <!--<option value="Macbook">Macbook</option>
        <option value="iMac">iMac</option>-->
      </select>
EOL;
        if (isset($_SESSION['e_comptype'])){
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_comptype'].'</div>';
          unset($_SESSION['e_comptype']);
        }
echo <<<EOL
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
EOL;
        if (isset($_SESSION['e_make'])){
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_make'].'</div>';
          unset($_SESSION['e_make']);
        }
echo <<<EOL
      <label for="model" class="d-form-label">Computer model:</label>
      <input type="text" name="model" id="comp-model"><br>
EOL;
        if (isset($_SESSION['e_model'])){
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_model'].'</div>';
          unset($_SESSION['e_model']);
        }
echo <<<EOL
      <label for="year" class="d-form-label">Year of production:</label>
      <input type="text" name="year" id="year-prod">
EOL;
        if (isset($_SESSION['e_year'])){
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_year'].'</div>';
          unset($_SESSION['e_year']);
        }
echo <<<EOL
    </div>

    <div id="service-details">
      <div class="label-item-rel">
        <label for="type-os" class="d-form-label">Type of service:</label>
        <select name="type-os" id="type-os" required>
          <option></option>
          <option value="os-install">OS install/re-install</option>
          <option value="cleaning">Device cleaning</option>
          <option value="hw-update">Hardware update</option>
          <option value="pc-build">Building a new PC</option>
          <option value="screen-replacement">Screen replacment</option>
          <option value="hard-drive-recovery">Hard-drive data recovery</option>
          <option value="other">Other</option>
        </select><br>
EOL;
          if (isset($_SESSION['e_service'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_service'].'</div>';
            unset($_SESSION['e_service']);
          }
echo <<<EOL
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
EOL;
          if (isset($_SESSION['e_dnum'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_dnum'].'</div>';
            unset($_SESSION['e_dnum']);
          }
echo <<<EOL
      </div>
    </div>

    <div id="delivery-method">
      <h4>DELIVERY METHOD:</h4>
      <input type="radio" name="d-method" value="in-person"> In-person<br>

      <input type="radio" name="d-method" value="collect-delivery"> Collect & Delivery (extra cost)<br>
EOL;
        if (isset($_SESSION['e_dmethod'])){
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_dmethod'].'</div>';
          unset($_SESSION['e_dmethod']);
        }
echo <<<EOL
    </div>

    <div id="date-select">
      <h4>SELECT THE DATE:</h4>
      <input type="date" name="booking-date" id="booking-date">
EOL;
        if (isset($_SESSION['e_date'])){
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_date'].'</div>';
          unset($_SESSION['e_date']);
        }
echo <<<EOL
    </div>

    <div id="personal-information">
      <div style="grid-column: 1/3; grid-row: 1;">
        <h4>PERSONAL INFORMATION:</h4>
      </div>
      <div id="col-1">
        <input type="text" name="b-forename" id="booking-forename" placeholder="Forename*"><br>
EOL;
          if (isset($_SESSION['e_bforename'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bforename'].'</div>';
            unset($_SESSION['e_bforename']);
          }
echo <<<EOL
        <input type="text" name="b-surname" id="booking-surname" placeholder="Surname*"><br>
EOL;
          if (isset($_SESSION['e_bsurname'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bsurname'].'</div>';
            unset($_SESSION['e_bsurname']);
          }
echo <<<EOL
        <input type="email" name="b-email-address" id="booking-email" placeholder="E-mail address*"><br>
EOL;
          if (isset($_SESSION['e_bemail'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bemail'].'</div>';
            unset($_SESSION['e_bemail']);
          }
echo <<<EOL
        <input type="text" name="b-phone-num" id="booking-phone-num" placeholder="Phone Number*"><br>
EOL;
          if (isset($_SESSION['e_bphonenum'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bphonenum'].'</div>';
            unset($_SESSION['e_bphonenum']);
          }
echo <<<EOL
      </div>

      <div id="col-2">
        <input type="text" name="b-address-line1" id="booking-addl1" placeholder="Address"><br>
EOL;
          if (isset($_SESSION['e_baddress'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_baddress'].'</div>';
            unset($_SESSION['e_baddress']);
          }
echo <<<EOL
        <input type="text" name="b-address-line2" id="booking-addl2" placeholder="Address (line 2)"><br>
EOL;
          if (isset($_SESSION['e_baddress'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_baddress'].'</div>';
            unset($_SESSION['e_baddress']);
          }
echo <<<EOL
        <input type="text" name="b-city" id="booking-city" placeholder="City"><br>
EOL;
          if (isset($_SESSION['e_bcity'])){
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bcity'].'</div>';
            unset($_SESSION['e_bcity']);
          }
echo <<<EOL
        <input type="text" name="b-postcode" id="booking-postcode" placeholder="Postcode" style="max-width: 15rem;"><br>
      </div>
EOL;
        if (isset($_SESSION['e_bpostcode'])){
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bpostcode'].'</div>';
          unset($_SESSION['e_bpostcode']);
        }
echo <<<EOL
    </div>

    <div id="description">
      <h4>FAULT/PROBLEM/SERVICE DESCRIPTION:</h4>
      <textarea name="service-description" id="service-description" maxlength="1000" rows="5" placeholder="Max. 1000 characters"></textarea>
EOL;
        if (isset($_SESSION['e_serviceds'])){
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_serviceds'].'</div>';
          unset($_SESSION['e_serviceds']);
        }
echo <<<EOL
    </div>

    <div id="form-submit">
      <input type="submit" value="Submit">
    </div>
  </form>
</div>
EOL;
        }
      ?>

      <div id="close-x" onclick="off()">
        <img src="images/close-cross2.png" />
      </div>
    </div>
  </div>

  <div id="sign-in-main">
    <div class="nav-bar">
      <div id="nav">
        <ul>
          <li><a href="index.php" id="home-nav">Home</a></li>
          <li><a href="index.php" id="about-nav">About</a></li>
          <li><a href="index.php" id="services-nav">Services</a></li>
          <li><a href="index.php" id="prices-nav">Prices</a></li>
          <li><a href="index.php" id="contact-nav">Contact</a></li>
          <li><a href="myaccount.php">My Account</a></li>
          <li><button id="booking-open" class="astext" onclick="on()">Booking</button></li>
          <li><a href="sign_in.php" style="color: #5B0606">Sign In</a></li>
        </ul>
      </div>
    </div>

    <div id="sign-in-form" class="container">
      <div class="heading">
        <h1>Welcome</h1>
        <h3>Thank you for creating your account with us!</h3>
        <a href="sign_in.php"><h3>You can now sign in into your account</h3></a>
      </div>

    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

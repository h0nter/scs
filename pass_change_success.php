<?php

  session_start();//Start user session for global variables

  //If successReg flag doesn't exist in the session (user hasn't registered a new account)
  if (!isset($_SESSION['pass_change_success'])){
    header('Location: pass_change.php');//Send user to the Details Change page
    exit();//Exit this file
  }else{//If the successReg flag exists in the session
    unset($_SESSION['pass_change_success']);//Unset the 'pass_change_success' variable, so the user can't access this page again (utnil password changed again)
  }

  //Check if the booking form has been submited
  if (isset($_POST['booking-date'])){
    //Successful validation flag
    $successVal = true;

    //Check if computer type is valid
    $comp_type = $_POST['computer-type'];//Assign value submitted in the booking form to 'comp_type' variable

    if ($comp_type == ""){//If 'comp_type' variable is empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_comptype'] = "This field cannot be empty";//Set error message for 'computer-type' field
    }else if(($comp_type != "PC/iMac") && ($comp_type != "Laptop/Macbook")){//If 'comp_type' variable isn't empty but doesn't have a valid value
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_comptype'] = "Incorrect value!";//Set error message for 'computer-type' field
    }

    //Check if computer make is valid
    $comp_make = $_POST['make'];//Assign value submitted in the booking form to 'comp_make' variable

    if ($comp_make == ""){//If 'comp_make' value is empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_make'] = "This field cannot be empty";//Set error message for 'comp_make' field
    }else if(($comp_make != "HP") && ($comp_make != "Lenovo") && ($comp_make != "Dell") && ($comp_make != "Asus") && ($comp_make != "Acer") && ($comp_make != "Apple") && ($comp_make != "Alienware") && ($comp_make != "Other")){//If 'comp_make' variable isn't empty but doesn't have a valid value
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_make'] = "Incorrect value!";//Set error message for 'make' field
    }

    //Check if computer model is valid
    $comp_model = $_POST['model'];//Assign value submitted in the booking form to 'comp_model' variable

    if ((strlen($comp_model) < 2) || (strlen($comp_model) > 30)){//If 'comp_model' value is less than 2 or more than 30 characters
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_model'] = "Computer model must be between 2 and 30 characters!";//Set error message for 'model' field
    }

    $comp_model = htmlentities($comp_model, ENT_QUOTES, "UTF-8");//Sanitize 'model' string

    //Check if year of production is valid
    $year_of_prod = $_POST['year'];//Assign value submitted in the booking form to 'year_of_prod' variable
    $regex = "/^((19||20)+([0-9]{2}))$/";//Set regular expression for 'year_of_prod' validation

    if (!preg_match($regex, $year_of_prod)){//If 'year_of_prod' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_year'] = "Enter a correct year in the range 1900-2099";//Set error message for 'year' field
    }

    //Check if type of service is valid
    $type_os = $_POST['type-os'];//Assign value submitted in the booking form to 'type_os' variable

    if ($type_os == ""){//If 'type_os' variable is empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_service'] = "This field cannot be empty";//Set error message for 'type-os' field
    }else if(($type_os != "os-install") && ($type_os != "cleaning") && ($type_os != "hw-update") && ($type_os != "pc-build") && ($type_os != "screen-replacement") && ($type_os != "hard-drive-recovery") && ($type_os != "other")){//If 'type_os' variable isn't empty but doesn't have a valid value
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_service'] = "Incorrect value!";//Set error message for 'type-os' field
    }

    //Check if number of devices is valid
    $devices_num = $_POST['devices-num'];//Assign value submitted in the booking form to 'devices_num' variable

    if ($devices_num == ""){//If 'devices_num' variable is empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_dnum'] = "This field cannot be empty";//Set error message for 'devices_num' field
    }else if(($devices_num != "1") && ($devices_num != "2") && ($devices_num != "3") && ($devices_num != "4") && ($devices_num != "5") && ($devices_num != "more")){//If 'devices_num' variable isn't empty but doesn't have a valid value
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_dnum'] = "Incorrect value!";//Set error message for 'devices-num' field
    }

    //Check if delivery method is selected
    $d_method = $_POST['d-method'];//Assign value submitted in the booking form to 'd_method' variable

    if (($d_method != "in-person") && ($d_method != "collect-delivery")){//If 'd_method' varible doesn't have a valid value
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_dmethod'] = "Please, select the delivery method!";//Set error message for 'd-method' field
    }

    //Check if the booking date is vaild (yyyy-mm-dd)
    $booking_date = $_POST['booking-date'];//Assign value submitted in the booking form to 'booking_date' variable
    $regex = "/^([0-9]{4}-[0-9]{2}-[0-9]{2})$/";//Set regular expression for 'booking_date' validation

    if (!preg_match($regex, $booking_date)){//If 'booking_date' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_date'] = "Date has to be in a correct format!";//Set error message for 'booking-date' field
    }

    //Check if forename is valid
    $forename = $_POST['b-forename'];//Assign value submitted in the booking form to 'forename' variable
    $regex = "/^[a-zA-Z]{2,30}$/";//Set regular expression for 'forename' validation

    if (!preg_match($regex, $forename)){//If 'forename' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_bforename'] = "Forename has to be between 2 and 30 characters and cosist of letters only!";//Set error message for 'b-forename' field
    }

    //Check if surname is valid
    $surname = $_POST['b-surname'];//Assign value submitted in the booking form to 'surname' variable
    $regex = "/^([a-zA-Z]+[\s]?[-\s]?[\s]?[a-zA-Z]{1,29})$/";//Set regular expression for 'surname' validation

    if (!preg_match($regex, $surname)){//If 'surname' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_bsurname'] = "Surname has to be between 2 and 30 characters! Use dash to separate double-barrelled surnames.";//Set error message for 'b-surname' field
    }

    //Check if email address is valid
    $email = $_POST['b-email-address'];//Store user email input in 'email' variable
    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);//Sanitize email

    //Validate sanitized email and compare it to the original user input
    if ((filter_var($emailS, FILTER_VALIDATE_EMAIL) == false) || ($emailS != $email)){//If email sanitization is unsuccessful or sanitized email doesn't equal user input
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_bemail'] = "Input correct email address!";//Email error message
    }

    //Check if the phone number is valid
    $phone_num = $_POST['b-phone-num'];//Assign value submitted in the booking form to 'phone_num' variable
    $regex = "/^[0-9]{11,14}$/";//Set regular expression for 'phone_num' validation

    if (!preg_match($regex, $phone_num)){//If 'phone_num' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_bphonenum'] = "Phone number must contain numbers only and be 11-14 digits long!";//Set error message for 'b-phone-num' field
    }

    //Check if the address (line 1) is valid
    $address = $_POST['b-address-line1'];//Assign value submitted in the booking form to 'address' variable
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";//Set regular expression for 'address' validation

    if ((!preg_match($regex, $address)) && $address != ""){//If 'address' validation is unsuccesful and variable isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_baddress'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";//Set error message for 'b-address-line1' field
    }

    //Check if the address (line 2) is valid
    $address2 = $_POST['b-address-line2'];//Assign value submitted in the booking form to 'address2' variable
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";//Set regular expression for 'address2' validation

    if ((!preg_match($regex, $address2)) && $address2 != ""){//If 'address2' validation is unsuccesful and variable isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_baddress'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";//Set error message for 'b-address-line2' field
    }

    //Check if the city is valid
    $city = $_POST['b-city'];//Assign value submitted in the booking form to 'city' variable
    $regex = "/^[a-zA-Z]{2,20}$/";//Set regular expression for 'city' validation

    if ((!preg_match($regex, $city)) && $city != ""){//If 'city' validation is unsuccesful and variable isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_bcity'] = "City can containe letters only and cannot be longer than 20 characters!";//Set error message for 'b-city' field
    }

    //Check if the postcode is valid
    $postcode = $_POST['b-postcode'];/Assign value submitted in the booking form to 'postcode' variable/*Assign value submitted in the booking form to 'postcode' variable*/
    $regex = "/^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/";
    //Set regular expression for 'postcode' validation

    if ((!preg_match($regex, $postcode)) && $postcode != ""){//If 'postcode' validation is unsuccesful and variable isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_bpostcode'] = "Enter a correct UK postcode";//Set error message for 'b-postcode' field
    }

    //Check if the service description is valid
    $service_note = $_POST['service-description'];//Assign value submitted in the booking form to 'service_note' variable

    if ($service_note == ""){//If 'service_note' validation is unsuccesful and variable isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_serviceds'] = "This field cannot be empty";//Set error message for 'service_description' field
    }

    $service_note = htmlentities($service_note, ENT_QUOTES, "UTF-8");//Sanitize 'service_note' variable value

    require_once "connect.php";//Include 'connect.php' file
    mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

    try{//Begin try-catch
      $connection = new mysqli($host, $db_user, $db_password, $db_name);//Establish a new database connection
      if ($connection->connect_errno!=0){//If there are database connection errors
        throw new Exception(mysqli_connect_errno());//Throw an exception containing error number
      }else{
        //Check if the email exists in the db
        $result = $connection->query("SELECT user_id FROM users WHERE email='$email'");//Assign user_id values from users table, where email is equal to user's email, to 'result' variable

        if (!$result){//If the SQL query wasn't successful
          throw new Exception($connection->error);//Throw an exception containing the error
        }

        $emailsNum = $result->num_rows;//Assign number of emails in the database to the 'emailsNum' variable

        if($emailsNum = 0){//If email address doesn't exist in the database
          $successVal = false;//Set successful validation flag to false
          $_SESSION['e_bemail'] = "This email doesn't exist in the database!";//Set error message for 'b-email-address' field
        }

        $comp_model = mysqli_real_escape_string($connection, $comp_model);//Sanitize 'comp_model' variable

        $service_note = mysqli_real_escape_string($connection, $service_note);//Sanitize 'service_note' variable

        $user_id = $_SESSION['user_id'];//Assign values of global/session variable 'user_id' to the local 'user_id' variable

        if($successVal == true){//If Validation IS successful
          //Add user booking to the 'users' table in the database
          if ($connection->query("INSERT INTO bookings VALUES (NULL,'$user_id','$booking_date','$comp_type','$comp_make','$comp_model','$year_of_prod','$type_os','$devices_num','$d_method','$service_note')")){//If INSERT SQL query is successful
            $_SESSION['successBooking']=true;//set global/session variable 'successBooking' to true - indicates that booking has been made successfully
            header('Location: success_booking.php');//Direct user to the 'success_booking.php' page
          }else{//If the SQL query isn't successful
            throw new Exception($connection->error);//Throw an exception including the error
          }
        }

        $connection->close();//Close the connection with the database
      }
    }
    catch(Exception $e){
      echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';//Show a server error message
      exit();//Exit the file - don't continue on translating/executing
      //echo '<br />Developer info: '.$e;//Display the detailed description of an error - DEVELOPER USE ONLY!!!
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
  $(document).ready(function(){//When the file loads (do the function)
    $("#booking-open").click(function(){//If booking-open button is clicked
        <?php//Begin PHP script (server side)
          if (isset($_SESSION['loggedIn'])){//If user is logged in
            echo 'var logged_in = '.$_SESSION['loggedIn'].';';//Set 'logged_in' variable to true
          }else{
            echo 'var logged_in = false;';//Otherwise, set 'logged_in' to false
          }
        ?>//End PHP script (server side)

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
      <?php//Begin PHP code (server side)
      if ($_SESSION['loggedIn'] == true){//If user is logged in
//Display the booking form
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
        if (isset($_SESSION['e_comptype'])){//If comp_type error exists (user has made an error)
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_comptype'].'</div>';//Display the error message
          unset($_SESSION['e_comptype']);//Unset the error variable so it doesn't show up until the next error
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
        if (isset($_SESSION['e_make'])){//If comp_make error exists (user has made an error)
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_make'].'</div>';//Display the error message
          unset($_SESSION['e_make']);//Unset the error variable so it doesn't show up until the next error
        }
echo <<<EOL
      <label for="model" class="d-form-label">Computer model:</label>
      <input type="text" name="model" id="comp-model"><br>
EOL;
        if (isset($_SESSION['e_model'])){//If comp_model error exists (user has made an error)
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_model'].'</div>';//Display the error message
          unset($_SESSION['e_model']);//Unset the error variable so it doesn't show up until the next error
        }
echo <<<EOL
      <label for="year" class="d-form-label">Year of production:</label>
      <input type="text" name="year" id="year-prod">
EOL;
        if (isset($_SESSION['e_year'])){//If year_of_prod error exists (user has made an error)
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_year'].'</div>';//Display the error message
          unset($_SESSION['e_year']);//Unset the error variable so it doesn't show up until the next error
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
          if (isset($_SESSION['e_service'])){//If service_type error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_service'].'</div>';//Display the error message
            unset($_SESSION['e_service']);//Unset the error variable so it doesn't show up until the next error
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
          if (isset($_SESSION['e_dnum'])){//If devices_number error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_dnum'].'</div>';//Display the error message
            unset($_SESSION['e_dnum']);//Unset the error variable so it doesn't show up until the next error
          }
echo <<<EOL
      </div>
    </div>

    <div id="delivery-method">
      <h4>DELIVERY METHOD:</h4>
      <input type="radio" name="d-method" value="in-person"> In-person<br>

      <input type="radio" name="d-method" value="collect-delivery"> Collect & Delivery (extra cost)<br>
EOL;
        if (isset($_SESSION['e_dmethod'])){//If delivery_method error exists (user has made an error)
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_dmethod'].'</div>';//Display the error message
          unset($_SESSION['e_dmethod']);//Unset the error variable so it doesn't show up until the next error
        }
echo <<<EOL
    </div>

    <div id="date-select">
      <h4>SELECT THE DATE:</h4>
      <input type="date" name="booking-date" id="booking-date">
EOL;
        if (isset($_SESSION['e_date'])){//If booking_date error exists (user has made an error)
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_date'].'</div>';//Display the error message
          unset($_SESSION['e_date']);//Unset the error variable so it doesn't show up until the next error
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
          if (isset($_SESSION['e_bforename'])){//If booking_forename error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bforename'].'</div>';//Display the error message
            unset($_SESSION['e_bforename']);//Unset the error variable so it doesn't show up until the next error
          }
echo <<<EOL
        <input type="text" name="b-surname" id="booking-surname" placeholder="Surname*"><br>
EOL;
          if (isset($_SESSION['e_bsurname'])){//If booking_surname error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bsurname'].'</div>';//Display the error message
            unset($_SESSION['e_bsurname']);//Unset the error variable so it doesn't show up until the next error
          }
echo <<<EOL
        <input type="email" name="b-email-address" id="booking-email" placeholder="E-mail address*"><br>
EOL;
          if (isset($_SESSION['e_bemail'])){//If booking_email error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bemail'].'</div>';//Display the error message
            unset($_SESSION['e_bemail']);//Unset the error variable so it doesn't show up until the next error
          }
echo <<<EOL
        <input type="text" name="b-phone-num" id="booking-phone-num" placeholder="Phone Number*"><br>
EOL;
          if (isset($_SESSION['e_bphonenum'])){//If booking_phone_number error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bphonenum'].'</div>';//Display the error message
            unset($_SESSION['e_bphonenum']);//Unset the error variable so it doesn't show up until the next error
          }
echo <<<EOL
      </div>

      <div id="col-2">
        <input type="text" name="b-address-line1" id="booking-addl1" placeholder="Address"><br>
EOL;
          if (isset($_SESSION['e_baddress'])){//If booking_address error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_baddress'].'</div>';//Display the error message
            unset($_SESSION['e_baddress']);//Unset the error variable so it doesn't show up until the next error
          }
echo <<<EOL
        <input type="text" name="b-address-line2" id="booking-addl2" placeholder="Address (line 2)"><br>
EOL;
          if (isset($_SESSION['e_baddress'])){//If booking_address error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_baddress'].'</div>';//Display the error message
            unset($_SESSION['e_baddress']);//Unset the error variable so it doesn't show up until the next error
          }
echo <<<EOL
        <input type="text" name="b-city" id="booking-city" placeholder="City"><br>
EOL;
          if (isset($_SESSION['e_bcity'])){//If booking_city error exists (user has made an error)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bcity'].'</div>';//Display the error message
            unset($_SESSION['e_bcity']);//Unset the error variable so it doesn't show up until the next error
          }
echo <<<EOL
        <input type="text" name="b-postcode" id="booking-postcode" placeholder="Postcode" style="max-width: 15rem;"><br>
      </div>
EOL;
        if (isset($_SESSION['e_bpostcode'])){//If booking_postcode error exists (user has made an error)
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bpostcode'].'</div>';//Display the error message
          unset($_SESSION['e_bpostcode']);//Unset the error variable so it doesn't show up until the next error
        }
echo <<<EOL
    </div>

    <div id="description">
      <h4>FAULT/PROBLEM/SERVICE DESCRIPTION:</h4>
      <textarea name="service-description" id="service-description" maxlength="1000" rows="5" placeholder="Max. 1000 characters"></textarea>
EOL;
        if (isset($_SESSION['e_serviceds'])){//If booking_service_description error exists (user has made an error)
          echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_serviceds'].'</div>';//Display the error message
          unset($_SESSION['e_serviceds']);//Unset the error variable so it doesn't show up until the next error
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
      //End PHP code
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
        <h1>Thank you!</h1>
        <h3>Your password has been updated successfully</h3>
        <a href="myaccount.php"><h3>You can now change it on 'My Account' page</h3></a>
      </div>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

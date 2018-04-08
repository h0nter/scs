<?php

  session_start();//Start session for use of global variables

  if(!isset($_SESSION['loggedIn'])){//If user isn't logged in
    header('Location: sign_in.php');//Direct user to the Sign In page
    exit();//Exit the file
  }

  require_once "connect.php";//Attach 'connect.php' file
  mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

  try{
    $connection = new mysqli($host, $db_user, $db_password, $db_name);//Establish a new database connection
    //Check if the connection with database was successful
    if($connection->connect_errno!=0){
      throw new Exception(mysqli_connect_errno());//In case of connection error, throw an exception
    }else{
      $user_id = $_SESSION['user_id'];//Set 'user_id' variable to the value of global 'user_id' variable

      $db_result = $connection->query("SELECT * FROM bookings WHERE user_id='$user_id'");//Store results of the bookings SELECT query in the 'db_result' variable

      if (!db_result){//If there was an error with the SQL query
        throw new Exception($connection->error);//Throw an exception containing the error
      }

      $_SESSION['bookings_num'] = $db_result->num_rows;//Store number of bookings in the global 'bookings_num' variable

      //Get all the user bookings from the database and store them in an array
      if ($_SESSION['bookings_num'] > 0){//If user has made at least one booking

        if(!$connection->query("CREATE TEMPORARY TABLE userbookings LIKE bookings")){//SQL query to create a temporary table with columns pattern of the 'bookings' table
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if(!$connection->query("TRUNCATE TABLE userbookings")){//SQL query to empty the contents of the temporary 'userbookings' table - in case any data was input on CREATE
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if (!$connection->query("INSERT INTO userbookings SELECT * FROM bookings WHERE user_id='$user_id'")){//SQL query to copy all user bookings from 'bookings' table to 'userbookings' table
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if (!$connection->query("ALTER TABLE userbookings MODIFY booking_id INT NOT NULL")){//SQL query to remove auto increment from 'booking_id' column
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if (!$connection->query("ALTER TABLE userbookings DROP PRIMARY KEY")){//SQL query to remove primary key from the 'booking_id' column
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if (!$connection->query("ALTER TABLE userbookings ADD id INT NOT NULL AUTO_INCREMENT UNIQUE FIRST")){//SQL to add new primary key to the 'userbookings' table
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        //Output all user bookings into a variable
        for ($i = 1; $i <= $_SESSION['bookings_num']; $i++){//Loop to get all of the user's bookings
          $userbookings = $connection->query("SELECT * FROM userbookings WHERE id='$i'");//Get a single user booking

          $booking_records[$i] = $userbookings->fetch_assoc();//Add associative array of a single booking record into a single element of an array
        }

        $_SESSION['user_bookings'] = $booking_records;//Assign the array created by looping to a global array
      }else{
        $_SESSION['no_bookings'] = "You haven't made any bookings yet";//In case of no bookings being made, display an appropriate message
      }

      $connection->close();//Close the connection with the database
    }
  }
  catch(Exception $e){
    echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';//Show a server error message
    //echo '<br />Developer info: '.$e;//Display the detailed description of an error - DEVELOPER USE ONLY!!!
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
    //If 'comp_make' variable isn't empty but doesn't have a valid value
    }else if(($comp_make != "HP") && ($comp_make != "Lenovo") && ($comp_make != "Dell") && ($comp_make != "Asus") && ($comp_make != "Acer") && ($comp_make != "Apple") && ($comp_make != "Alienware") && ($comp_make != "Other")){
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
    $postcode = $_POST['b-postcode'];/*Assign value submitted in the booking form to 'postcode' variable*/
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
      $(".mb").click(function(){//When object of '.mb' class is pressed
        window.but_id = $(this).attr('mbbutton');//Assign id of the selected booking to the but_id variable
        $("#booking-details").load("bd_col.php", {butID: window.but_id});//Load booking data using AJAX through 'bd_col.php', passing the booking id as parameter
      });

      $("#b-cancel").click(function(){//When booking cancel button is pressed
        if (window.but_id !== 'undefined'){//Check if a booking is selected
          $.post("booking_cancel.php", {butID: window.but_id}, function(data, status){//Cancel booking using AJAX through 'booking_cancel.php' file, passing the booking id as parameter,
            alert(status);//Show message box informing about booking being cancelled successfully
            location.reload();//Reload the page, so the booking list is updated
          });
        }
      });

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

      ?>

      <div id="close-x" onclick="off()">
        <img src="images/close-cross2.png" />
      </div>
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

  <div id="booking-main" class="container">
    <div class="heading">
      <h1>My Bookings</h1>
    </div>

    <div id="booking-dat-section">
      <!--<div id="calendar-view">
        <h3>Calendar view</h3>
      </div>-->

      <div id="list-view">
        <ul>
          <?php

            $user_bookings = $_SESSION['user_bookings'];//Assign value of global 'user_bookings' variable to local 'user_bookings' variable
            $bookings_num = $_SESSION['bookings_num'];//Assign value of global 'bookings_num' variable to local 'bookings_num' variable
            for ($i = 1; $i <= $bookings_num; $i++){//Loop to display all the bookings
              if ($i % 2 == 0){//Check if the booking number is odd or even
                $bg_color = '#C4C5C7';//If booking number is even, set background color to light grey
              }else{
                $bg_color = '#E1E3E5';//If booking number is odd, set background color to dark grey
              }

              //Display a booking in the list
              echo '<button id="mb-'.$i.'" class="no-style mb" mbbutton="'.$i.'"><li style="background-color: '.$bg_color.'">'.$user_bookings[$i]['comp_make'].' | '.$user_bookings[$i]['comp_model'].', '.$user_bookings[$i]['yop'].' | '.$user_bookings[$i]['type_os'].' | '.$user_bookings[$i]['devices_num'].' unit(s) | '.$user_bookings[$i]['date'].'</li></button>';
            }

          ?>
        </ul>
      </div>

      <div id="booking-details">
        <div id="b-details-heading">
          <h3>Booking details</h3>
        </div>

        <div id="bd-col1">
          <h4>Device:</h4>
          <h5 id="d-type">Type:</h5>
          <h5 id="d-make">Make:</h5>
          <h5 id="d-model">Model:</h5>
          <h5 id="d-yop">YOP:</h5>
          <h5 id="d-num">Quantity:</h5>
        </div>

        <div id="bd-col2">
          <h4>Service:</h4>
          <h5>Type:</h5>
          <h5>Delivery:</h5>
          <h5>Date:</h5>
          <h5>Description:</h5>
        </div>
      </div>

      <div id="cancel-booking-button">
        <button id="b-cancel">Cancel booking</button>
      </div>
    </div>
  </div>
</body>
</html>

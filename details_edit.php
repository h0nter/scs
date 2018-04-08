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

        $c_user_email = $_SESSION['email'];//Assign currenty logged-in user email to the local variable
        $c_user_id = $_SESSION['user_id'];//Assign currenty logged-in user id to the local variable

        if (($emailsNum > 0) && ($email != $c_user_email)){//If the email address is already in the database
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

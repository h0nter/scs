<?php

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

  if (($comp_model != "") && ((strlen($comp_model) < 2) || (strlen($comp_model) > 30))){//If 'comp_model' value isn't "" and is less than 2 or more than 30 characters long
    $successVal = false;//Set successful validation flag to false
    $_SESSION['e_model'] = "Computer model must be between 2 and 30 characters!";//Set error message for 'model' field
  }

  $comp_model = htmlentities($comp_model, ENT_QUOTES, "UTF-8");//Sanitize 'model' string

  //Check if year of production is valid
  $year_of_prod = $_POST['year'];//Assign value submitted in the booking form to 'year_of_prod' variable
  $regex = "/^((19||20)+([0-9]{2}))$/";//Set regular expression for 'year_of_prod' validation

  if ((!preg_match($regex, $year_of_prod)) && ($year_of_prod != "")){//If 'year_of_prod' validation is unsuccesful
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
  }else{

    $current_date = date("Y-m-d");//Get the current day as a string

    $dateB = new DateTime($booking_date);//Convert the booking date string into date form variable
    $dateC = new DateTime($current_date);//Convert the current date string into date form variable
    $dateC->modify('+1 day');//Increase current date by 1 day - bookings have to be made at least 1 day in advance

    if ($dateB <= $dateC){//Check if booking is being made for at least the following day
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_date'] = "Date has to be in a correct format and in the future!";//Set error message for 'booking-date' field
    }
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

  if (($service_note == "") || (strlen($service_note) > 1000)){//If 'service_note' validation is unsuccesful and variable isn't empty
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
      $result = $connection->query(sprintf("SELECT user_id FROM users WHERE email='%s'", mysqli_real_escape_string($connection,$email)));//Assign user_id values from users table, where email is equal to user's email, to 'result' variable

      if (!$result){//If the SQL query wasn't successful
        throw new Exception($connection->error);//Throw an exception containing the error
      }

      $emailsNum = $result->num_rows;//Assign number of emails in the database to the 'emailsNum' variable

      if($emailsNum == 0){//If email address doesn't exist in the database
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

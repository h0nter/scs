<?php

  session_start();//Start user session for global variables

  //Check if the register form has been submited
  if (isset($_POST['forename'])){
    //Successful validation flag
    $successVal = true;

    //Check if forename is valid
    $forename = $_POST['forename'];//Assign forename value submitted in the create account form to 'forename' variable
    $regex = "/^[a-zA-Z]{2,30}$/";//Set regular expression for 'forename' validation

    if (!preg_match($regex, $forename)){//If 'forename' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_forename'] = "Forename has to be between 2 and 30 characters and cosist of letters only!";//Set error message for 'forename' field
    }

    //Check if surname is valid
    $surname = $_POST['surname'];//Assign surname value submitted in the create account form to 'surname' variable
    $regex = "/^([a-zA-Z]+[\s]?[-\s]?[\s]?[a-zA-Z]{1,29})$/";//Set regular expression for 'surname' validation

    if (!preg_match($regex, $surname)){//If 'surname' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_surname'] = "Surname has to be between 2 and 30 characters! Use dash to separate double-barrelled surnames.";//Set error message for 'surname' field
    }

    //Check if email address is valid
    $email = $_POST['email-address'];//Store user email input in variable
    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);//Sanitize email

    //Validate sanitized email and compare it to the original user input
    if ((filter_var($emailS, FILTER_VALIDATE_EMAIL) == false) || ($emailS != $email)){//If email sanitization is unsuccessful or sanitized email doesn't equal user input
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_email'] = "Input correct email address!";//Email error message
    }

    //Check if the passwords are valid
    $pass1 = $_POST['u-password'];//Assign password value submitted in the create account form to 'pass1' variable
    $pass2 = $_POST['pass-confirm'];//Assign confirm password value submitted in the create account form to 'pass2' variable
    $regex = "/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+=?^_-].{8,}$/";//Set regular expression for password validation

    if (!preg_match($regex, $pass1)){//If 'pass1' validation is unsuccesful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_password'] = "Password must have more than 8 characters, at least 1 capital letter and at least 1 number!";//Set error message for 'password' field
    }

    if ($pass1 != $pass2){//If 'pass1' doesn't equal 'pass2'
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_password'] = "Entered passwords aren't identical";//Set error message for 'password' field
    }

    $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);//Hash the password

    //Check if the phone number is valid
    $phone_num = $_POST['phone-num'];//Assign phone number value submitted in the create account form to 'phone_num' variable
    $regex = "/^[0-9]{11,14}$/";//Set regular expression for phone number validation

    if ((!preg_match($regex, $phone_num)) && $phone_num != ""){//If phone number validation is unsuccesful and phone number field isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_phonenum'] = "Phone number must contain numbers only and be 11-14 digits long!";//Set error message for 'phonenum' field
    }

    //Check if the address (line 1) is valid
    $address = $_POST['address-line1'];//Assign address1 value submitted in the create account form to 'address' variable
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";//Set regular expression for address validation

    if ((!preg_match($regex, $address)) && $address != ""){//If address validation is unsuccesful and 'address1' field isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_address1'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";//Set error message for 'address1' field
    }

    //Check if the address (line 2) is valid
    $address2 = $_POST['address-line2'];//Assign address2 value submitted in the create account form to 'address2' variable
    $regex = "/^[a-zA-Z0-9\s]{2,50}$/";//Set regular expression for address validation

    if ((!preg_match($regex, $address2)) && $address2 != ""){//If address validation is unsuccesful and 'address2' field isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_address2'] = "Address can contain letters, numbers and spaces only and cannot be longer than 50 characters!";//Set error message for 'address2' field
    }

    //Check if the city is valid
    $city = $_POST['city'];//Assign city value submitted in the create account form to 'city' variable
    $regex = "/^[a-zA-Z]{2,20}$/";//Set regular expression for city validation

    if ((!preg_match($regex, $city)) && $city != ""){//If city validation is unsuccesful and 'city' field isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_city'] = "City can containe letters only and cannot be longer than 20 characters!";//Set error message for 'city' field
    }

    //Check if the postcode is valid
    $postcode = $_POST['postcode'];//Assign postcode value submitted in the create account form to 'postcode' variable

    $regex = "/^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/";
    //Set regular expression for postcode validation

    if ((!preg_match($regex, $postcode)) && $postcode != ""){//If postcode validation is unsuccesful and 'postcode' field isn't empty
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_postcode'] = "Enter a correct UK postcode";//Set error message for 'postcode' field
    }

    //Check if checkbox was clicked
    if (!isset($_POST['terms-cond'])){//If checkbox wasn't ticked
      $successVal == false;//Set successful validation flag to false
      $_SESSION['e_checkbox'] = "You have to agree to terms and conditions!";//Set error message for 'postcode' field
    }

    //Bot or not - reCAPTCHA
    $secret = "6Ldi7UsUAAAAAMUwFp4_jf02tbZWUSDpVANkZy_t";//Set 'secret' variable value to the key provided by Google reCAPTCHA service

    $check_CAPTCHA = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);//send user reCAPTCHA input to Google for processing

    $answer_CAPTCHA = json_decode($check_CAPTCHA);//Decode the response from Google reCAPTCHA

    if ($answer_CAPTCHA->success == false){//If reCAPTCHA validation was unsuccessful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_bot'] = "Confirm that you're a human!";//Set error message for 'bot' field
    }

    require_once "connect.php";//Include the 'connect.php' file
    mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

    //Check if the email has been used previously to register an account and if not, add new account to the 'users' table in the database
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

        if($emailsNum>0){//If the email address is already in the database
          $successVal = false;//Set successful validation flag to false
          $_SESSION['e_email'] = "Email you're trying to use is already assigned to another account!";//Set error message for 'email' field
        }

        if($successVal == true){//If validation IS successful
          if ($connection->query("INSERT INTO users VALUES (NULL, '$forename','$surname','$email','$pass_hash','$phone_num','$address','$address2','$city','$postcode')")){//Add user to the database - If INSERT SQL query is successful
            $_SESSION['successReg']=true;//set global/session variable 'successReg' to true - indicates that user registered a new account
            header('Location: welcome.php');//Direct user to the 'welcome.php' page
          }else{
            throw new Exception($connection->error);//In case if the SQL query is unsuccessful, throw an exception containing the error
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
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/functions.js"></script>
  <script src="js/create_account_val.js"></script>
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

  <!-- reCAPTCHA
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script src='https://www.google.com/recaptcha/api.js'></script>

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
        <li><a href="myaccount.php">My Account</a></li>
        <li><button id="booking-open" class="astext" onclick="on()">Booking</button></li>
        <li><a href="sign_in.php">Sign In</a></li>
      </ul>
    </div>
  </div>

  <div id="account-create-main" class="container">
    <div class="heading">
      <h1>Create Account</h1>
    </div>

    <div id="account-create-form">
      <form id="account-create-f" method="post" onsubmit="return !!(valForenameAcc() & valSurnameAcc() & valEmailAcc() & valPasswords() & valPhoneNumAcc() & valAddressAcc() & valAddress2Acc() & valCityAcc() & valPostcodeAcc());">
        <div id="required-data">
          <label for="forename" class="d-form-label">Forename<span style="color: red;">*</span>:</label> <input type="text" name="forename" id="new-account-forename" required><br>

          <?php
            if (isset($_SESSION['e_forename'])){//If forename error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_forename'].'</div>';//Display the error message
              unset($_SESSION['e_forename']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label for="surname" class="d-form-label">Surname<span style="color: red;">*</span>:</label><input type="text" name="surname" id="new-account-surname" required><br>

          <?php
            if (isset($_SESSION['e_surname'])){//If surname error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_surname'].'</div>';//Display the error message
              unset($_SESSION['e_surname']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label for="email-address" class="d-form-label">E-mail address<span style="color: red;">*</span>:</label><input type="email" name="email-address" id="new-account-email" required><br>

          <?php
            if (isset($_SESSION['e_email'])){//If email error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_email'].'</div>';//Display the error message
              unset($_SESSION['e_email']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label for="u-password" class="d-form-label">Password<span style="color: red;">*</span>:</label><input type="password" name="u-password" id="new-account-password" required><br>

          <?php
            if (isset($_SESSION['e_password'])){//If password error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_password'].'</div>';//Display the error message
              unset($_SESSION['e_password']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label for="pass-confirm" class="d-form-label">Confirm password<span style="color: red;">*</span>:</label><input type="password" name="pass-confirm" id="new-account-passconf" required><br>
        </div>

        <h3>Additional Information</h3>

        <div id="additional-data">
          <label for="phone-num" class="d-form-label">Phone Number:</label><input type="text" name="phone-num" id="new-account-phonenum"><br>

          <?php
            if (isset($_SESSION['e_phonenum'])){//If phone number error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_phonenum'].'</div>';//Display the error message
              unset($_SESSION['e_phonenum']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label for="address-line1" class="d-form-label">Address:</label><input type="text" name="address-line1" id="new-account-addl1"><br>

          <?php
            if (isset($_SESSION['e_address1'])){//If address1 error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_address1'].'</div>';//Display the error message
              unset($_SESSION['e_address1']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label for="address-line2" class="d-form-label">Address (line 2):</label><input type="text" name="address-line2" id="new-account-addl2"><br>

          <?php
            if (isset($_SESSION['e_address2'])){//If address2 error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_address2'].'</div>';//Display the error message
              unset($_SESSION['e_address2']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label for="city" class="d-form-label">City:</label><input type="text" name="city" id="new-account-city"><br>

          <?php
            if (isset($_SESSION['e_city'])){//If city error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_city'].'</div>';//Display the error message
              unset($_SESSION['e_city']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label for="postcode" class="d-form-label">Postcode:</label><input type="text" name="postcode" id="new-account-postcode" style="max-width: 15rem;"><br>

          <?php
            if (isset($_SESSION['e_postoce'])){//If postcode error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_postcode'].'</div>';//Display the error message
              unset($_SESSION['e_postcode']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <label>
          <input type="checkbox" name="terms-cond" required/>I agree to terms and conditions</label>

          <?php
            if (isset($_SESSION['e_checkbox'])){//If checkbox error exists (user hasn't ticked it)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_checkbox'].'</div>';//Display the error message
              unset($_SESSION['e_checkbox']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <div class="g-recaptcha" data-sitekey="6Ldi7UsUAAAAAIMr-M7_X5dvI6b4w0CIcVYP0Tin"></div>

          <?php
            if (isset($_SESSION['e_bot'])){//If reCAPTCHA error exists (user has made an error)
              echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bot'].'</div>';//Display the error message
              unset($_SESSION['e_bot']);//Unset the error variable so it doesn't show up until the next error
            }

          ?>

          <input type="submit" value="Create your account">
        </div>

      </form>
    </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

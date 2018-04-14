<?php

  session_start();//Start session for use of gloabal variables

  //Function for generating a random password
  function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";//Characters set for the random password
    $pass = array(); //Declare 'pass' variable as an empty array
    $alphaLength = strlen($alphabet) - 1; //Put the length of the charset - 1 in the 'alphaLength' variable
    for ($i = 0; $i < 8; $i++) {//Loop n (8) times - where n is number of characters in the random password
        $n = rand(0, $alphaLength);//Select a random number between 0 and charset length - 1
        $pass[] = $alphabet[$n];//Add the randomly chosen character to the 'pass' array
    }
    return implode($pass); //Turn the 'pass' array into a string
  }

  //Check if password reset form has been submitted
  if (isset($_POST['r-email-address'])){//If user has submited the password reset form
    //Successful validation flag
    $successVal = true;

    //Check if email address is valid
    $email = $_POST['r-email-address'];//Store user email input in variable
    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);//Sanitize email

    //Validate sanitized email and compare it to the original user input
    if ((filter_var($emailS, FILTER_VALIDATE_EMAIL) == false) || ($emailS != $email)){//If email validation is unsuccessful or the validated email doesn't equal to the user input
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_email'] = "Input correct email address!";//Email error message
    }

    require_once "connect.php";//Include the 'connect.php' file
    mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);//Set up a new connection with the database
      if ($connection->connect_errno!=0){//If there were errors when trying to connect to the database
        throw new Exception(mysqli_connect_errno());//Throw an exception containing the error number
      }else{
        if($successVal == true){//If password reset form validation is successful
          //Code below is commented because it cannot be used on a home server where website is currently stored

          /*$email = htmlentities($email, ENT_QUOTES, "UTF-8");//Sanitize email (replace any '' and "" with HTML entities)

          $result = $connection->query(sprintf("SELECT user_id FROM users WHERE email='%s'", mysqli_real_escape_string($connection,$email)));//Variable to store result of the SQL query which selects the user from the db

          if (!$result){//If there were errors with the SQL query above
            throw new Exception($connection->error);//Throw a new exception containing the error
          }

          $emailsNum = $result->num_rows;//Assign number of users in the database with the matching email address (can be either 0 or 1)

          if($emailsNum > 0){//If the user email has been found in the database
            $regex = "/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+=?^_-].{8,}$/";//Set regular expression to validate the randomly generated password
            $rand_pass = randomPassword();//Generate a random password and assign it to the 'rand_pass' variable

            do{//Loop until the random password matches the requirements of the regular expression
              $rand_pass = randomPassword();//Generate a random password and assign it to the 'rand_pass' variable
            }while(!preg_match($regex, $rand_pass));

            $pass_hash = password_hash($rand_pass, PASSWORD_DEFAULT);//Create hash for the randomly generated password

            if ($connection->query(sprintf("UPDATE users SET password = '$pass_hash' WHERE email='%s'", mysqli_real_escape_string($connection,$email))));{//Update the user password in the database with the random password hash
              $msg = "Your new password is: $rand_pass"//Set the contents of the email

              if(mail($email,"Account password reset (Smith's Computer Service)",$msg)){//Send email containing the new random password to the email provided by the user
                $_SESSION['pass_reset_success'] = true;//Set 'pass_reset_success' flag to success
                header('Location: pass_reset_succes.php');//Direct user to the 'pass_reset_success.php' file/page
              }
            }else{
              throw new Exception($connection->error);//Throw a new exception containing the error
            }

          }else{
            $_SESSION['e_email'] = "Incorrect email address!";//Set error message for 'email' field
          }*/
        }else{
          $_SESSION['e_email'] = "Incorrect email address!";//Set error message for 'email' field
        }

        $connection->close();//Close the connection with the database
      }
    }
    catch(Exception $e){//In case 'try' throws an exception
      echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';//Display the server error message
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
  <script src="js/passreset_val.js"></script>
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

  <div id="pass-reset-main">
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

    <div id="pass-reset-form" class="container">
      <div class="heading">
        <h1>Reset password</h1>
      </div>

      <form id="pass-reset-f" method="post" onsubmit="return valEmailReset()">
        <label for="r-email-address" class="s-form-label">Email address:</label><br>
        <input type="email" name="r-email-address" id="pass-reset-email" required><br>
        <?php
          if (isset($_SESSION['e_email'])){//If email address error is set
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_email'].'</div>';//Display the error message
            unset($_SESSION['e_email']);//Unset the error variable, so the message doesn't show up again
          }
        ?>
        <input type="submit" value="Reset password">
      </form>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

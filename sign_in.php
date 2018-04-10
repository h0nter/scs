<?php

  session_start();//Start user session for global variables

  //If loggedIn flag exists in the session and is true (user is signed in)
  if ((isset($_SESSION['loggedIn'])) && ($_SESSION['loggedIn'] == true)){
    header('Location: myaccount.php');//Send user to their account page
    exit();//Exit this file
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
  <script type="text/javascript" src="js/sign_in_val.js"></script>
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

  <div id="sign-in-main">
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
          <li><a href="sign_in.php" style="color: #5B0606">Sign In</a></li>
        </ul>
      </div>
    </div>

    <div id="sign-in-form" class="container">
      <div class="heading">
        <h1>Sign In</h1>
      </div>

      <!--Pass the values of this form to the 'login.php' file using post method-->
      <form id="sign-in-f" action="login.php" method="post" onsubmit="return !!(valEmailLog() & valPasswordLog());">
        <label for="email-address" class="s-form-label">Email address:</label><br>
        <input type="email" name="email-address" id="sign-in-email" required><br>

        <label for="user-password" class="s-form-label">Password:</label><br>
        <input type="password" name="user-password" id="sign-in-password" required><br>

        <div id="register-reset-links">
          <h3>
            <?php
              if (isset($_SESSION['loginError'])){//If there was a log-in error
                echo $_SESSION['loginError'];//Show log-in error message
              }

            ?>
          </h3>

          <h3><a href="create_account.php">Don't have an account? Register now!</a></h3>
          <h3><a href="passreset.php">Forgot your password?</a></h3>
        </div>

        <input type="submit" value="Sign In">
      </form>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

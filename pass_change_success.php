<?php

  session_start();//Start user session for global variables

  //If successReg flag doesn't exist in the session (user hasn't registered a new account)
  if (!isset($_SESSION['pass_change_success'])){
    header('Location: passchange.php');//Send user to the Details Change page
    exit();//Exit this file
  }else{//If the successReg flag exists in the session
    unset($_SESSION['pass_change_success']);//Unset the 'pass_change_success' variable, so the user can't access this page again (utnil password changed again)
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

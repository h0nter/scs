<?php

  session_start();//Start user session for global variables

  //If loggedIn flag doesn't exist (user isn't logged in)
  if (!isset($_SESSION['loggedIn'])){
    header('Location: sign_in.php');//Send user to the Sign In page
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

  <!-- Landing page & nav-bar -->
  <div id="account-main" style="background-image: url(images/gradient.jpg);">

    <div id="landing-page-account">
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

        <div id="header-account" class="container">
          <div class="row" style="text-align: center;">
            <?php
              echo "<h1>Hi ".$_SESSION['first_name']."</h1>";//Display welcome message with user's name
            ?>
            <h3>It's nice to see you again</h3>
            <h3><a href="logout.php">Log out</a></h3><!--Log out button-->
          </div>
        </div>
    </div>

    <div id="account-menu" class="container">
      <div id="menu-stripe">
        <div id="init-circle">
          <?php
            echo "<h1>".substr($_SESSION['first_name'],0,1)."</h1>";//Get first letter from user's name to show in the circle
          ?>
        </div>

        <div id="menu-bars">
          <div class="m-bar" style="background-image: url(images/Menu-bar1.png); width: 48.5rem;">
            <h3 style="font-size: 4.3rem;"><a href="mybookings.php">My Bookings</a></h3>
          </div>

          <div class="m-bar" style="background-image: url(images/Menu-bar2.png); width: 42.1rem;">
            <h3 style="font-size: 4.2rem;"><a href="details_edit.php">Edit My Details</a></h3>
          </div>

          <div class="m-bar" style="background-image: url(images/Menu-bar3.png); width: 36.2rem;">
            <h3 style="font-size: 3.6rem;"><a href="passchange.php">Change Password</a></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

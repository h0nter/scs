<?php
  session_start();//Start session for use of global variables

  require_once "booking_processing.php";//Link the booking form processing script

  //Contact form validation
  if (isset($_POST['email-contact'])){//If 'email-contact' value has been submitted in a form - contact form has been submitted
    $contactSVal = true;//Set 'contactSVal' validation flag to true

    //Check if email address is valid
    $email = $_POST['email-contact'];//Store user email input in variable
    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);//Sanitize email

    //Validate sanitized email and compare it to the original user input
    if ((filter_var($emailS, FILTER_VALIDATE_EMAIL) == false) || ($emailS != $email)){//If email sanitization is unsuccessful or sanitized email isn't equal to the user input
      $contactSVal = false;//Set 'contactSVal' flag to false
      $_SESSION['e_cemail'] = "Input correct email address!";//Email error message
    }

    //Check if the service description is valid
    $contact_message = $_POST['message-contact'];//Store contact message input in variable

    if ($contact_message == ""){//If 'contact_message' variable is empty
      $contactSVal = false;//Set 'contactSVal' flag to false
      $_SESSION['e_cmessage'] = "This field cannot be empty";//Set error message for 'message-contact' field
    }

    if ($contactSVal == true){//If validation is successful
      /*$msg = "From: $email
      Message: $contact_message";//Create an email containing both user email and their contact message

      if(mail("contact@smithcompservice.co.uk","Message from $email",$msg)){//If email has been sent successfully
        $_SESSION['contact_form_success'] = true;//Set global/session 'contact_form_success' variable to true - indicates that contact message has been sent successfully
        header('Location: contact_form_success.php');//Direct user to 'contact_form_success.php'
        exit();//Exit the file - stop further translation/execution
      }*/
      header('Location: index.php');//Direct user to the main page - ONLY FOR THE PROTOTYPE TESTING PURPOSE!!! - To be commented once service is moved to hosting that allows for sending emails
      exit();//Exit the file - stop further translation/execution
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
  <script type="text/javascript" src="js/navbar.js"></script>
  <script type="text/javascript" src="js/functions.js"></script>
  <script type="text/javascript" src="js/booking_form_val.js"></script>
  <script type="text/javascript" src="js/contact_val.js"></script>
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
  <div id="landing-page" style="background-image: url(images/cpu_27_blur_fade.jpg);">
    <div class="nav-bar">
      <div id="nav">
        <ul>
          <li><a href="index.php#landing-page" id="home-nav" style="color: #5B0606">Home</a></li>
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

      <div id="header" class="container">
        <div class="row" style="text-align: center;">
          <h1>S C S</h1>
          <h3>Welcome to Smith's Computer Service</h3>
          <h5>A professional computer service located in Brighton</h5>
        </div>
      </div>

  </div>

  <!-- About -->
  <div id="about">
    <div class="container">
      <div class="row">
        <h4>Passion for technology and years of experience</h4>
      </div>
    </div>

    <div id="about-slide-in" style="background-image: url(images/union_1.png);">
      <p>
        Id salutandi iracundia duo, qui dicam timeam mentitum no, vim cetero placerat id. Clita homero docendi ea duo. Cu vim partem constituto repudiandae, ea illum antiopam vis, per meliore molestiae adipiscing ne. Dicta iudicabit ius ei, idque debet eos an. Amet ponderum periculis ex vis, augue eirmod postulant vix et.
      </p>
    </div>

    <div id="about-s-gallery">
      <div class="slide-image">
        <img src="images/s_gallery1.png" />
      </div>

      <div class="slide-image">
        <img src="images/s_gallery2.png" />
      </div>

      <div class="slide-image">
        <img src="images/s_gallery3.png" />
      </div>

      <div class="slide-image">
        <img src="images/s_gallery4.png" />
      </div>

      <div class="slide-image">
        <img src="images/s_gallery5.png" />
      </div>

      <div class="slide-image">
        <img src="images/s_gallery6.png" />
      </div>
    </div>
  </div>


<div class="container">

  <hr />

  <!-- Services -->
  <div id="services">
    <div class="heading">
      <h1>Our offer</h1>
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

    <div class="offer-img">
      <img src="images/os_logos.jpg">
    </div>

  </div>

  <hr />

  <!-- Contact -->
  <div id="contact">
    <div class="heading">
      <h1>Contact Us</h1>
    </div>

    <div id="map">

    </div>

    <script>
      function initMap(){//Function to initialize the map
        var location = {lat: 50.822530, lng: -0.137163};//Variable keeping location to show on the map
        var map = new google.maps.Map(document.getElementById("map"), {//Variable which assigns Google Maps API response to the 'map' div
          zoom: 6,//Sets zoom on location in the map
          center: location//Sets map to be centered on location in 'location' variable
        });

        var marker = new google.maps.Marker({//New marker is added on the map
          position: location,//The marker position is set to 'location' variable
          map: map//Map that the marker is added to is 'map' variable
        });
      }

    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZ4AQCd5ymJedSTmKmuQk5HnXvdBEsH8Q&callback=initMap">//Google maps API is added to the webiste, using initMap() funtion</script>

    <div id="contact-slide-in" style="background-image: url(images/union_2.png)">
      <p>
        Id salutandi iracundia duo, qui dicam timeam mentitum no, vim cetero placerat id. Clita homero docendi ea duo. Cu vim partem constituto repudiandae, ea illum antiopam vis, per meliore molestiae adipiscing ne. Dicta iudicabit ius ei, idque debet eos an. Amet ponderum periculis ex vis, augue eirmod postulant vix et.
      </p>
    </div>

    <div id="contact-form">
      <form id="c-form" method="post" onsubmit="return !!(valContactMessage() & valContactEmail());">
        <div id="email-and-send">
          <input type="text" name="email-contact" id="email-contact" placeholder="Your e-mail"/>

          <input id="submit-contact" type="submit" value="SEND MESSAGE&#8594;"/>
        </div>
        <?php
          if (isset($_SESSION['e_cemail'])){//If contact_email error exists (user has made an error - validation unsuccessful)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_cemail'].'</div>';//Display the error message
            unset($_SESSION['e_cemail']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>

        <div id="contact-text-input">
          <textarea name="message-contact" id="message-contact" maxlength="4000" rows="17" placeholder="Your message..."></textarea>
        </div>
        <?php
          if (isset($_SESSION['e_cmessage'])){//If contact_message error exists (user has made an error - validation unsuccessful)
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_cmessage'].'</div>';//Display the error message
            unset($_SESSION['e_cmessage']);//Unset the error variable so it doesn't show up until the next error
          }
        ?>

      </form>
    </div>

  </div>

</div>

<br/>

  <!-- Footer -->
  <div id="footer">
    <div style="width: 33.3%">

    </div>

    <div class="container">
      <h5>
        Copyright © 2017-2018 Smith's Computer Service All rights reserved
      </h5>
    </div>

    <div id="dev-signature">
      <h6>Designed and developed by Tymoteusz Makowski</h6>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

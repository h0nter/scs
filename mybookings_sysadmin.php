<?php

  session_start();//Start session for use of global variables

  //If loggedIn flag doesn't exist (user isn't logged in)
  if (!isset($_SESSION['loggedIn'])){
    header('Location: sign_in.php');//Send user to the Sign In page
    exit();//Exit this file
  }

  if(!isset($_SESSION['admin'])){//If user isn't an administrator
    header('Location: myaccount.php');//Send user to My Account page
    exit();//Exit this file
  }

  require_once "connect.php";//Attach 'connect.php' file
  mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

  try{
    $connection = new mysqli($host, $db_user, $db_password, $db_name);//Establish a new database connection
    //Check if the connection with database was successful
    if($connection->connect_errno!=0){
      throw new Exception(mysqli_connect_errno());//In case of connection error, throw an exception
    }else{
      $db_result = $connection->query("SELECT * FROM bookings");//Store results of the bookings SELECT query in the 'db_result' variable

      if (!db_result){//If there was an error with the SQL query
        throw new Exception($connection->error);//Throw an exception containing the error
      }

      $_SESSION['bookings_num'] = $db_result->num_rows;//Store number of bookings in the global 'bookings_num' variable

      //Get all the user bookings from the database and store them in an array
      if ($_SESSION['bookings_num'] > 0){//If user has made at least one booking

        if(!$connection->query("CREATE TEMPORARY TABLE allbookings LIKE bookings")){//SQL query to create a temporary table with columns pattern of the 'bookings' table
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if(!$connection->query("TRUNCATE TABLE allbookings")){//SQL query to empty the contents of the temporary 'allbookings' table - in case any data was input on CREATE
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if (!$connection->query("INSERT INTO allbookings SELECT * FROM bookings ")){//SQL query to copy all bookings from 'bookings' table to 'allbookings' table
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if (!$connection->query("ALTER TABLE allbookings MODIFY booking_id INT NOT NULL")){//SQL query to remove auto increment from 'booking_id' column
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if (!$connection->query("ALTER TABLE allbookings DROP PRIMARY KEY")){//SQL query to remove primary key from the 'booking_id' column
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        if (!$connection->query("ALTER TABLE allbookings ADD id INT NOT NULL AUTO_INCREMENT UNIQUE FIRST")){//SQL to add new primary key to 'allbookings' table
          throw new Exception($connection->error);//In case of the SQL query error, throw an exception containing the error
        }

        //Output all user bookings into a variable
        for ($i = 1; $i <= $_SESSION['bookings_num']; $i++){//Loop to get all of the user's bookings
          $allbookings = $connection->query("SELECT * FROM allbookings WHERE id='$i'");//Get a single user booking

          if (!$allbookings){//If there was an error with the SQL query
            throw new Exception($connection->error);//Throw an exception containing the error
          }

          $booking_records[$i] = $allbookings->fetch_assoc();//Add associative array of a single booking record into a single element of an array
        }

        $_SESSION['all_bookings'] = $booking_records;//Assign the array created by looping to a global array

        unset($booking_records);
      }else{
        $_SESSION['no_bookings'] = "No bookings were made yet";//In case of no bookings being made, display an appropriate message
      }

      $connection->close();//Close the connection with the database
    }
  }
  catch(Exception $e){
    echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';//Show a server error message
    //echo '<br />Developer info: '.$e;//Display the detailed description of an error - DEVELOPER USE ONLY!!!
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
    //Get booking details
    $(document).ready(function(){//When the file loads (do the function)
      $(".mb").click(function(){//When object of '.mb' class is pressed
        window.but_id = $(this).attr('mbbutton');//Assign id of the selected booking to the but_id variable
        $("#booking-details").load("bd_col_sysadmin.php", {butID: window.but_id});//Load booking data using AJAX through 'bd_col.php', passing the booking id as parameter
      });

      //Cancel a booking
      $("#b-cancel").click(function(){//When booking cancel button is pressed
        if (window.but_id !== 'undefined'){//Check if a booking is selected
          if (confirm("You are about to cancel the booking, are you sure?\n(This action cannot be undone)") == true){
            $.post("booking_cancel_sysadmin.php", {butID: window.but_id}, function(data, status){//Cancel booking using AJAX through 'booking_cancel.php' file, passing the booking id as parameter,
              alert(status);//Show message box informing about booking being cancelled successfully
              location.reload();//Reload the page, so the booking list is updated
            });
          }
        }else{
          alert("No booking has been selected!")
        }
      });

      //Open booking form
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

            $all_bookings = $_SESSION['all_bookings'];//Assign value of global 'all_bookings' variable to local 'all_bookings' variable
            $bookings_num = $_SESSION['bookings_num'];//Assign value of global 'bookings_num' variable to local 'bookings_num' variable

            for ($i = 1; $i <= $bookings_num; $i++){//Loop to display all the bookings
              if ($i % 2 == 0){//Check if the booking number is odd or even
                $bg_color = '#C4C5C7';//If booking number is even, set background color to light grey
              }else{
                $bg_color = '#E1E3E5';//If booking number is odd, set background color to dark grey
              }

              $org_date_format = $all_bookings[$i]['date'];
              $new_date_format = date("d-m-Y", strtotime($org_date_format));

              //Display a booking in the list
              echo '<button id="mb-'.$i.'" class="no-style mb" mbbutton="'.$i.'"><li style="background-color: '.$bg_color.'">'.$all_bookings[$i]['comp_make'].' | '.$all_bookings[$i]['comp_model'].', '.$all_bookings[$i]['yop'].' | '.$all_bookings[$i]['type_os'].' | '.$all_bookings[$i]['devices_num'].' unit(s) | '.$new_date_format.'</li></button>';
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

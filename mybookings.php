<?php

  session_start();

  if(!isset($_SESSION['loggedIn'])){
    header('Location: sign_in.php');
    exit();
  }

  require_once "connect.php";//Attach 'connect.php' file
  mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

  try{
    $connection = new mysqli($host, $db_user, $db_password, $db_name);//Establish a new database connection
    //Check if the connection with database was successful
    if($connection->connect_errno!=0){
      throw new Exception(mysqli_connect_errno());//In case of connection error, throw an exception
    }else{
      $user_id = $_SESSION['user_id'];

      $db_result = $connection->query("SELECT * FROM bookings WHERE user_id='$user_id'");

      if (!db_result){
        throw new Exception($connection->error);
      }

      $_SESSION['bookings_num'] = $db_result->num_rows;

      if ($_SESSION['bookings_num'] > 0){

        if(!$connection->query("CREATE TABLE IF NOT EXISTS userbookings LIKE bookings")){
          throw new Exception($connection->error);
        }

        if ($connection->query("INSERT INTO userbookings SELECT * FROM bookings WHERE user_id='$user_id'")){
          throw new Exception($connection->error);
        }

        if (!$connection->query("ALTER TABLE userbookings DROP PRIMARY KEY")){
          throw new Exception($connection->error);
        }

        if (!$connection->query("ALTER TABLE userbookings ADD id INT NOT NULL AUTO_INCREMENT UNIQUE FIRST")){
          throw new Exception($connection->error);
        }

        for ($i = 0; $i < $_SESSION['bookings_num']; $i++){
          $userbookings = $connection->query("SELECT * FROM userbookings WHERE id='$i'");

          $booking_records[$i] = $userbookings->fetch_assoc();
        }

        $_SESSION['user_bookings'] = $booking_records;

        /*if(!connection->query("DROP TABLE userbookings")){
          throw new Exception($connection->error);
        }*/
      }else{
        $_SESSION['no_bookings'] = "You haven't made any bookings yet";
      }

      $connection->close();
    }
  }
  catch(Exception $e){
    echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';
    echo '<br />Developer info: '.$e;
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
  <script src="js/functions.js"></script>
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
      <div id="booking-form">
        <form id="b-form" action="" onsubmit="return !!(valYearOfProdbook() & valForenamebook() & valSurnamebook() & valEmailbook() & valPhoneNumbook() & valAddressbook() & valAddress2book() & valCitybook() & valPostcodebook() & valDescriptionbook());">
          <div class="heading">
            <h3>Booking form</h3>
          </div>

          <div id="computer-type-s">
            <label for="computer-type" class="d-form-label">Computer type:</label><br>
            <select name="computer-type" id="computer-type" required>
              <option></option>
              <option value="PC">Desktop PC/iMac</option>
              <option value="Laptop">Laptop/Notebook/Macbook</option>
              <!--<option value="Macbook">Macbook</option>
              <option value="iMac">iMac</option>-->
            </select>
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

            <label for="model" class="d-form-label">Computer model:</label>
            <input type="text" name="model" id="comp-model"><br>

            <label for="year" class="d-form-label">Year of production:</label>
            <input type="text" name="year" id="year-prod">
          </div>

          <div id="service-details">
            <div class="label-item-rel">
              <label for="type-os" class="d-form-label">Type of service:</label>
              <select name="type-os" id="type-os" required>
                <option></option>
                <option value="OS install">OS install/re-install</option>
                <option value="cleaning">Device cleaning</option>
                <option value="hw-update">Hardware update</option>
                <option value="pc-build">Building a new PC</option>
                <option value="screen-replacment">Screen replacment</option>
                <option value="hard-drive-recovery">Hard-drive data recovery</option>
                <option value="Other">Other</option>
              </select><br>
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
            </div>
          </div>

          <div id="delivery-method">
            <h4>DELIVERY METHOD:</h4>
            <input type="radio" name="d-method" value="in-person"> In-person<br>

            <input type="radio" name="d-method" value="collect-delivery"> Collect & Delivery (extra cost)<br>
          </div>

          <div id="date-select">
            <h4>SELECT THE DATE:</h4>
            <input type="date" name="booking-date" id="booking-date">
          </div>

          <div id="personal-information">
            <div style="grid-column: 1/3; grid-row: 1;">
              <h4>PERSONAL INFORMATION:</h4>
            </div>
            <div id="col-1">
              <input type="text" name="forename" id="booking-forename" placeholder="Forename*"><br>

              <input type="text" name="surname" id="booking-surname" placeholder="Surname*"><br>

              <input type="email" name="email-address" id="booking-email" placeholder="E-mail address*"><br>

              <input type="text" name="phone-num" id="booking-phone-num" placeholder="Phone Number*"><br>
            </div>

            <div id="col-2">
              <input type="text" name="address-line1" id="booking-addl1" placeholder="Address"><br>

              <input type="text" name="address-line2" id="booking-addl2" placeholder="Address (line 2)"><br>

              <input type="text" name="city" id="booking-city" placeholder="City"><br>

              <input type="text" name="postcode" id="booking-postcode" placeholder="Postcode" style="max-width: 15rem;"><br>
            </div>
          </div>

          <div id="description">
            <h4>FAULT/PROBLEM/SERVICE DESCRIPTION:</h4>
            <textarea name="service-description" id="service-description" maxlength="1000" rows="5" placeholder="Max. 1000 characters"></textarea>
          </div>

          <div id="form-submit">
            <input type="submit" value="Submit">
          </div>
        </form>
      </div>
      <div id="close-x" onclick="off()">
        <img src="images/close-cross2.png" />
      </div>
    </div>
  </div>

  <div class="nav-bar">
    <div id="nav">
      <ul>
        <li><a href="index.php" id="home-nav">Home</a></li>
        <li><a href="index.php" id="about-nav">About</a></li>
        <li><a href="index.php" id="services-nav">Services</a></li>
        <li><a href="index.php" id="prices-nav">Prices</a></li>
        <li><a href="index.php" id="contact-nav">Contact</a></li>
        <li><a href="myaccount.php" style="color: #5B0606">My Account</a></li>
        <li><button class="astext" onclick="on()">Booking</button></li>
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
          <li>List view</li>
          <li>List view</li>
          <li>List view</li>
          <li>List view</li>
          <?php

            $user_bookings = $_SESSION['user_bookings'];
            $bookings_num = $_SESSION['bookings_num'];
            for ($i = 0; $i < $bookings_num; $i++){
              echo '<li>'.$user_bookings[$i]['date'].'</li>';
            }

          ?>
        </ul>
      </div>

      <div id="booking-details">
        <h3>Booking details</h3>
      </div>

      <div id="cancel-booking-button">
        <h3>Cancel booking</h3>
      </div>
    </div>
  </div>
</body>
</html>

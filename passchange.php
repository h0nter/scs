<?php
  session_start();//Start user session for global variables

  //If loggedIn flag doesn't exist (user isn't logged in)
  if (!isset($_SESSION['loggedIn'])){
    header('Location: sign_in.php');//Send user to the Sign In page
    exit();//Exit this file
  }

  //Check if the form has been submited
  if (isset($_POST['current-password'])){
    //Successful validation flag
    $successVal = true;

    //Check if the current password is valid
    $passC = $_POST['current-password'];//Assign 'current-password' input to 'passC' variable
    $regex = "/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+=?^_-].{8,}$/";//Set regular expression to validate the current password

    if(!preg_match($regex, $passC)){//If current password validation is unsuccessful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_passwordC'] = "Incorrect password!";//Set error message for 'current-password' field
    }

    //Check if the new passwords are valid
    $pass1 = $_POST['new-password'];//Assign 'new-password' input to 'pass1' variable
    $pass2 = $_POST['confirm-password'];//Assign 'confirm-password' input to 'pass2' variable
    $regex = "/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+=?^_-].{8,}$/";//Set regular expression to validate the new password

    if (!preg_match($regex, $pass1)){//If new password validation is unsuccessful
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_password'] = "Password must have more than 8 characters, at least 1 capital letter and at least 1 number!";//Set error message for 'new-password' field
    }

    if ($pass1 != $pass2){//If 'new-password' isn't equal with the value in 'confirm-password' input
      $successVal = false;//Set successful validation flag to false
      $_SESSION['e_password'] = "Entered passwords aren't identical";//Set error message for 'new-password' field
    }

    $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);//Create a hash for the new password

    require_once "connect.php";//Attach 'connect.php' file
    mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings, throw exceptions

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);//Establish a new database connection
      //Check if the connection with database was successful
      if($connection->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());//In case of connection error, throw an exception
      }else{
        $c_user_id = $_SESSION['user_id'];

        $c_user_pass = $connection->query("SELECT password FROM users WHERE user_id='$c_user_id'");//Variable to store result of the SQL query which selects the user's current password from the db

        if (!$c_user_pass){//If the SQL query is unsuccessful
          throw new Exception($connection->error);//Throw an exception containing the error
        }

        if(!password_verify($passC, $c_user_pass)){//If comparing current password input by the user and the one fetched from the database is unsuccessful
          $successVal = false;//Set successful validation flag to false
          $_SESSION['e_passwordC'] = "Incorrect password!";//Set error message for 'current-password' field
        }

        //Change user password in the database
        if(successVal == true){//If validation of all fields was successful
          if($connection->query("UPDATE users SET password='$pass_hash' WHERE user_id='$c_user_id'")){//Update password hash in the 'password' field for the currently logged in user
            $_SESSION['pass_change_success'] = true;//Set 'pass_change_success' global flag to true
            header('Location: pass_change_success.php');//Direct user to the 'pass_change_success.php' file/page
          }else{
            throw new Exception($connection->error);//If the SQL query is unsuccessful, throw an exception containing the error
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
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/passchange_val.js"></script>
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

  <div id="password-change-main">
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

    <div id="password-change-form" class="container">
      <div class="heading">
        <h1>Change Password</h1>
      </div>

      <form id="pass-change-form" method="post" onsubmit="return !!(valCurrentPswrd() & valNewPswrd());">
        <label for="current-password" class="p-form-label">Current Password:</label> <input type="password" name="current-password" id="pass-change-crntpass" required><br>
        <?php
          if (isset($_SESSION['e_passwordC'])){//If 'current-password' error is set
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_passwordC'].'</div>';//Display the error message
            unset($_SESSION['e_passwordC']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>

        <label for="new-password" class="p-form-label">New Password:</label> <input type="password" name="new-password" id="pass-change-newpass" required><br>
        <?php
          if (isset($_SESSION['e_password'])){//If 'new-password' error is set
            echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_password'].'</div>';//Display the error message
            unset($_SESSION['e_password']);//Unset the error variable so it doesn't show up until the next error
          }

        ?>

        <label for="confirm-password" class="p-form-label">Confirm Password:</label> <input type="password" id="pass-change-confirmpass" name="confirm-password" required><br>

        <input type="submit" value="Confirm">
      </form>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>

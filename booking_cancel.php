<?php
  //This piece of code is accessed/run using AJAX

  session_start();//Start session for use of global variables

  $user_bookings = $_SESSION['user_bookings'];//load 'user_booking' value to a local variable
  $bookings_num = $_SESSION['bookings_num'];//load 'bookings_num' value to a local variable

  $butID = $_POST['butID'];//load button id (id of the chosen booking) to a local variable

  require_once "connect.php";//Include the 'connect.php' file
  mysqli_report(MYSQLI_REPORT_STRICT);//Instead of warnings throw exceptions

  //Connect to the database and remove the selected booking from it
  try{
    $connection = new mysqli($host, $db_user, $db_password, $db_name);//Establish a new database connection
    //Check if the connection with database was successful
    if($connection->connect_errno!=0){
      throw new Exception(mysqli_connect_errno());//In case of connection error, throw an exception
    }else{
      $booking_id = $user_bookings[$butID]['booking_id'];//Get the booking ID of the selected booking

      if(!$connection->query("DELETE FROM bookings WHERE booking_id='$booking_id'")){//Remove the booking from the db
        throw new Exception($connection->error);//In case of an error with the SQL query, throw an exception
      }

      $connection->close();//Close the connection with the database
    }
  }
  catch(Exception $e){
    echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';//Show a server error message
    //echo '<br />Developer info: '.$e;//Display the detailed description of an error - DEVELOPER USE ONLY!!!
  }
?>

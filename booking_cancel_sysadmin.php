<?php
  //This piece of code is accessed/run using AJAX

  session_start();//Start session for use of global variables

  $all_bookings = $_SESSION['all_bookings'];//load 'user_booking' value to a local variable
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
      $booking_id = $all_bookings[$butID]['booking_id'];//Get the booking ID of the selected booking
      $org_date_format = $all_bookings[$butID]['booking_date'];//Get the date of the selected booking
      $new_date_format = date("d-m-Y", strtotime($org_date_format));//Conver the date to dd-mm-yyyy format

      $db_result = $connection->query("SELECT user_id FROM bookings WHERE booking_id='$booking_id'");//Get id of the user whose booking is being cancelled

      if (!$db_result){//In case of the SQL query error
        throw new Exception($connection->error);//Throw an exception containing the error
      }

      $id_record = $db_result->fetch_assoc();//Get associative array of record with user id
      $user_id = $id_record['user_id'];//Get user ud from the associative array

      $db_email = $connection->query("SELECT email FROM users WHERE user_id='$user_id'");//Get the email of the user whose booking is being cancelled

      if (!$db_email){//In case of the SQL query error
        throw new Exception($connection->error);//Throw an exception containing the error
      }

      $email_record = $db_email->fetch_assoc();//Get associative array of the record with user email
      $email = $email_record['email'];//Get user email from the associative array

      if($connection->query("DELETE FROM bookings WHERE booking_id='$booking_id'")){//Remove the booking from the db
        //The code is commented because it cannot be run on a home server
        /*$msg = "We're really sorry...\nYour booking number: '$booking_id' on '$new_date_format' had to be canceled."//Set the contents of the email

        if(!mail($email,"Booking Cancelation(Smith's Computer Service)",$msg)){//Send email containing the new random password to the email provided by the user
          throw new Exception("Email couldn't be send");//In case of an error with the SQL query, throw an exception
        }*/
      }else{
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

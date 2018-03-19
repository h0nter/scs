<?php

  session_start();

  $user_bookings = $_SESSION['user_bookings'];
  $bookings_num = $_SESSION['bookings_num'];

  $butID = $_POST['butID'];

  if ($butIDs != $butIDc){
    exit();
  }else{
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try{
      $connection = new mysqli($host, $db_user, $db_password, $db_name);//Establish a new database connection
      //Check if the connection with database was successful
      if($connection->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());//In case of connection error, throw an exception
      }else{
        $booking_id = $user_bookings[$butID]['booking_id'];

        if(!$connection->query("DELETE FROM bookings WHERE booking_id='$booking_id'")){
          throw new Exception($connection->error);
        }

        $connection->close();
      }
    }
    catch(Exception $e){
      echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';
      echo '<br />Developer info: '.$e;
    }
  }
?>

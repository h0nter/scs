<?php

  session_start();//Start user session for global variables

  //If email and password don't exist in the POST table (user didn't complete the Sign In form)
  if ((!isset($_POST['email-address'])) || (!isset($_POST['user-password']))){
    header('Location: sign_in.php');//Send user to the Sign In page
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
      //Set-up variables for email and password input by user in sign-in form
      $email = $_POST['email-address'];
      $password = $_POST['user-password'];

      //Sanitize email (replace any '' and "" with HTML entities)
      $email = htmlentities($email, ENT_QUOTES, "UTF-8");

      $db_result = $connection->query(sprintf("SELECT * FROM users WHERE email='%s'", mysqli_real_escape_string($connection,$email)));//Variable to store result of the SQL query which selects the user from the db

      if (!$db_result){
        throw new Exception($connection->error);
      }

      $users_num = $db_result->num_rows;//Number of users found in the db
      if ($users_num > 0){//Check if any users were found in the db
        $record = $db_result->fetch_assoc();//Store user record data in an associative array

        if(password_verify($password, $record['password'])){
          $_SESSION['loggedIn'] = true;//User is signed in

          //Assign values from the record table to global variables
          $_SESSION['user_id'] = $record['user_id'];
          $_SESSION['first_name'] = $record['first_name'];
          $_SESSION['last_name'] = $record['last_name'];
          $_SESSION['email'] = $record['email'];
          $_SESSION['phone_num'] = $record['phone_num'];
          $_SESSION['address'] = $record['address'];
          $_SESSION['address2'] = $record['address2'];
          $_SESSION['city'] = $record['city'];
          $_SESSION['postcode'] = $record['postcode'];

          unset($_SESSION['loginError']);//Remove log-in error variable
          $db_result->free_result();//Free up the space in memory 'locked' by the SQL query result variable
          header('Location: myaccount.php');//Login is successful, send user to their account page
        }else{//If no users were found in the db
          $_SESSION['loginError'] = '<span style="color: red">Incorrect email or password!</span>';//Variable with message in case of an error
          header('Location: sign_in.php');//Send user back to the Sign In page
        }
      }else{//If no users were found in the db
        $_SESSION['loginError'] = '<span style="color: red">Incorrect email or password!</span>';//Variable with message in case of an error
        header('Location: sign_in.php');//Send user back to the Sign In page
      }

      $connection->close();//Close the connection with the db
    }
  }
  catch(Exception $e){
    echo '<span style="color: red;">Server error! Sorry for the inconvinience, please try again at a different time.</span>';
    //echo '<br />Developer info: '.$e;
  }
?>

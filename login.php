<?php

  session_start();//Start user session for global variables

  require_once "connect.php";//Attach 'connect.php' file

  //Establish a new database connection
  $connection = @new mysqli($host, $db_user, $db_password, $db_name);

  //Check if the connection with database was successful
  if($connection->connect_errno!=0){
    echo "Error: ".$connection->connect_errno;//In case of an error, show the error number.
  }else{
    //Set-up variables for email and password input by user in sign-in form
    $email = $_POST['email-address'];
    $password = $_POST['user-password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";//SQL query variable to select user from db

    if ($db_result = @$connection->query($sql)){//Variable to store result of the SQL query
      $users_num = $db_result->num_rows;//Number of users found in the db
      if ($users_num > 0){//Check if any users were found in the db
        $record = $db_result->fetch_assoc();//Store user record data in an associative table

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

        $db_result->free_result();//Free up the space in memory 'locked' by the SQL query result variable
        header('Location: myaccount.php');//Login is successful, send user to their account page
      }else{//If no users were found in the db
        
      }
    }

    $connection->close();//Close the connection with the db
  }
?>

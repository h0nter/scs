<?php
/*THIS FILE SHALL NOT BE UPLOADED TO THE SERVER!!!
ONLY FOR THE MAINTENANCE PURPOSE------------------
--------------------------------------------------*/
  session_start();

  $email = $_POST['email_address'];
  $pass = $_POST['user_password'];

  $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

  $_SESSION['phashed'] = $pass_hash;
  $_SESSION['emailadd'] = $email;

  header('Location: passdb_show.php');
  exit();
?>

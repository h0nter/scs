<?php

  session_start();//Start user session for global variables

  session_unset();//Destroy the session

  header('Location: sign_in.php')//Send user to the Sign In page

?>

<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>PassDB show hash</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <h2>SHOW HASH</h2>
  <br />
  <br />
  For email: <?php echo $_SESSION['emailadd']; ?> <br />
  Hash is: <?php echo $_SESSION['phashed']; ?>
  <br />
  <br />
  <a href="sign_in.php">Press here to return</a>
</body>
</html>

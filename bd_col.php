<?php

  session_start();

  $user_bookings = $_SESSION['user_bookings'];
  $bookings_num = $_SESSION['bookings_num'];

  $butID = $_POST['butID'];

echo<<<EOL
  <div id="b-details-heading">
    <h3>Booking details</h3>
  </div>
EOL;

  /*Column 1
  –––––––––––––––––––––––––––––––––––––––––––––––––– */
  echo '<div id="bd-col1">';

  echo '<h4>Device:</h4><h5 id="d-type">Type: '.$user_bookings[$butID]['comp_type'].'</h5>';

  echo '<h5 id="d-make">Make: '.$user_bookings[$butID]['comp_make'].'</h5>';

  echo '<h5 id="d-model">Model: '.$user_bookings[$butID]['comp_model'].'</h5>';

  echo '<h5 id="d-yop">YOP: '.$user_bookings[$butID]['yop'].'</h5>';

  echo '<h5 id="d-num">Quantity: '.$user_bookings[$butID]['devices_num'].'</h5>';

  echo '</div>';

  /*Column 2
  –––––––––––––––––––––––––––––––––––––––––––––––––– */
  echo '<div id="bd-col2">';

  echo '<h4>Service:</h4><h5 id="s-type">Type: '.$user_bookings[$butID]['type_os'].'</h5>';

  echo '<h5 id="s-dmethod">Delivery: '.$user_bookings[$butID]['del_method'].'</h5>';

  echo '<h5 id="s-date">Date: '.$user_bookings[$butID]['date'].'</h5>';

  echo '<h5 id="s-dscr">Description:</h5><textarea rows="4" readonly>'.$user_bookings[$butID]['service_note'].'</textarea>';

  echo '</div>';
?>

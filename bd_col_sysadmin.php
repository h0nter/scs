<?php
  //This piece of code is accessed/run using AJAX

  session_start();//Start session for use of global variables

  $all_bookings = $_SESSION['all_bookings'];//load 'user_bookings' value to local variable
  $bookings_num = $_SESSION['bookings_num'];//load 'bookings_num' value to local variable

  $butID = $_POST['butID'];//load id of a button (booking number) to a local variable

//Display the heading for the booking details section
echo<<<EOL
  <div id="b-details-heading">
    <h3>Booking details</h3>
  </div>
EOL;

  /*Column 1
  –––––––––––––––––––––––––––––––––––––––––––––––––– */
  echo '<div id="bd-col1">';//Open the div for the first column of the booking details section

  echo '<h4>Device:</h4><h5 id="d-type">Type: '.$all_bookings[$butID]['comp_type'].'</h5>';//Display type of the computer for the selected booking

  echo '<h5 id="d-make">Make: '.$all_bookings[$butID]['comp_make'].'</h5>';//Display make of the computer for the selected booking

  echo '<h5 id="d-model">Model: '.$all_bookings[$butID]['comp_model'].'</h5>';//Display the model of the computer for the selected booking

  echo '<h5 id="d-yop">YOP: '.$all_bookings[$butID]['yop'].'</h5>';//Display the year of prodcution of the device for the selected booking

  echo '<h5 id="d-num">Quantity: '.$all_bookings[$butID]['devices_num'].'</h5>';//Display the number of devices for the selected booking

  echo '</div>';//Close the div for the first column of the booking details section

  /*Column 2
  –––––––––––––––––––––––––––––––––––––––––––––––––– */
  echo '<div id="bd-col2">';//Open the div for the second column of the booking details section

  echo '<h4>Service:</h4><h5 id="s-type">Type: '.$all_bookings[$butID]['type_os'].'</h5>';//Display type of service for the selected booking

  echo '<h5 id="s-dmethod">Delivery: '.$all_bookings[$butID]['del_method'].'</h5>';//Display the delivery method for the selected booking

  echo '<h5 id="s-date">Date: '.$all_bookings[$butID]['date'].'</h5>';//Display the date of the selected booking

  echo '<h5 id="s-dscr">Description:</h5><textarea rows="4" readonly>'.$all_bookings[$butID]['service_note'].'</textarea>';//Display the description provided for the selected booking

  echo '</div>';//Close the div for the second column of the booking details section
?>

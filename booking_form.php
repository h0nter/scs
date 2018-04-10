<?php
if ($_SESSION['loggedIn'] == true){//If user is logged in
//Display the booking form
echo <<<EOL
<div id="booking-form">
<form id="b-form" method="post" onsubmit="return !!(valYearOfProdbook() & valForenamebook() & valSurnamebook() & valEmailbook() & valPhoneNumbook() & valAddressbook() & valAddress2book() & valCitybook() & valPostcodebook() & valDescriptionbook());">
<div class="heading">
<h3>Booking form</h3>
</div>

<div id="computer-type-s">
<label for="computer-type" class="d-form-label">Computer type:</label><br>
<select name="computer-type" id="computer-type" required>
  <option></option>
  <option value="PC/iMac">Desktop PC/iMac</option>
  <option value="Laptop/Macbook">Laptop/Notebook/Macbook</option>
  <!--<option value="Macbook">Macbook</option>
  <option value="iMac">iMac</option>-->
</select>
EOL;
  if (isset($_SESSION['e_comptype'])){//If comp_type error exists (user has made an error)
    echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_comptype'].'</div>';//Display the error message
    unset($_SESSION['e_comptype']);//Unset the error variable so it doesn't show up until the next error
  }
echo <<<EOL
</div>

<div id="computer-details">
<label for="make" class="d-form-label">Computer make:</label>
<select name="make" id="comp-make" required>
  <option></option>
  <option value="HP">HP</option>
  <option value="Lenovo">Lenovo</option>
  <option value="Dell">Dell</option>
  <option value="Asus">Asus</option>
  <option value="Acer">Acer</option>
  <option value="Apple">Apple</option>
  <option value="Alienware">Alienware</option>
  <option value="Other">Other</option>
</select><br>
EOL;
  if (isset($_SESSION['e_make'])){//If comp_make error exists (user has made an error)
    echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_make'].'</div>';//Display the error message
    unset($_SESSION['e_make']);//Unset the error variable so it doesn't show up until the next error
  }
echo <<<EOL
<label for="model" class="d-form-label">Computer model:</label>
<input type="text" name="model" id="comp-model"><br>
EOL;
  if (isset($_SESSION['e_model'])){//If comp_model error exists (user has made an error)
    echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_model'].'</div>';//Display the error message
    unset($_SESSION['e_model']);//Unset the error variable so it doesn't show up until the next error
  }
echo <<<EOL
<label for="year" class="d-form-label">Year of production:</label>
<input type="text" name="year" id="year-prod">
EOL;
  if (isset($_SESSION['e_year'])){//If year_of_prod error exists (user has made an error)
    echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_year'].'</div>';//Display the error message
    unset($_SESSION['e_year']);//Unset the error variable so it doesn't show up until the next error
  }
echo <<<EOL
</div>

<div id="service-details">
<div class="label-item-rel">
  <label for="type-os" class="d-form-label">Type of service:</label>
  <select name="type-os" id="type-os" required>
    <option></option>
    <option value="os-install">OS install/re-install</option>
    <option value="cleaning">Device cleaning</option>
    <option value="hw-update">Hardware update</option>
    <option value="pc-build">Building a new PC</option>
    <option value="screen-replacement">Screen replacment</option>
    <option value="hard-drive-recovery">Hard-drive data recovery</option>
    <option value="other">Other</option>
  </select><br>
EOL;
    if (isset($_SESSION['e_service'])){//If service_type error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_service'].'</div>';//Display the error message
      unset($_SESSION['e_service']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
</div>

<div class="label-item-rel">
  <label for="devices-num" class="d-form-label">Number of devices:</label>
  <select name="devices-num" id="devices-num" required>
    <option></option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="more">More</option>
  </select><br>
EOL;
    if (isset($_SESSION['e_dnum'])){//If devices_number error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_dnum'].'</div>';//Display the error message
      unset($_SESSION['e_dnum']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
</div>
</div>

<div id="delivery-method">
<h4>DELIVERY METHOD:</h4>
<input type="radio" name="d-method" value="in-person"> In-person<br>

<input type="radio" name="d-method" value="collect-delivery"> Collect & Delivery (extra cost)<br>
EOL;
  if (isset($_SESSION['e_dmethod'])){//If delivery_method error exists (user has made an error)
    echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_dmethod'].'</div>';//Display the error message
    unset($_SESSION['e_dmethod']);//Unset the error variable so it doesn't show up until the next error
  }
echo <<<EOL
</div>

<div id="date-select">
<h4>SELECT THE DATE:</h4>
<input type="date" name="booking-date" id="booking-date" min="
EOL;
$cDate = date("Y-m-d");//Get the current date from the server time
$aDate = new DateTime($cDate);//Translate the date string into date format
$aDate->modify('+1 day');//Increase date by 1 day - bookings have to be made at least 1 day in advance
echo $aDate->format('Y-m-d').'" required>';//Output the date into 'min' date input property in the Y-m-d format

  if (isset($_SESSION['e_date'])){//If booking_date error exists (user has made an error)
    echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_date'].'</div>';//Display the error message
    unset($_SESSION['e_date']);//Unset the error variable so it doesn't show up until the next error
  }
echo <<<EOL
</div>

<div id="personal-information">
<div style="grid-column: 1/3; grid-row: 1;">
  <h4>PERSONAL INFORMATION:</h4>
</div>
<div id="col-1">
  <input type="text" name="b-forename" id="booking-forename" placeholder="Forename*" required><br>
EOL;
    if (isset($_SESSION['e_bforename'])){//If booking_forename error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bforename'].'</div>';//Display the error message
      unset($_SESSION['e_bforename']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
  <input type="text" name="b-surname" id="booking-surname" placeholder="Surname*" required><br>
EOL;
    if (isset($_SESSION['e_bsurname'])){//If booking_surname error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bsurname'].'</div>';//Display the error message
      unset($_SESSION['e_bsurname']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
  <input type="email" name="b-email-address" id="booking-email" placeholder="E-mail address*" required><br>
EOL;
    if (isset($_SESSION['e_bemail'])){//If booking_email error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bemail'].'</div>';//Display the error message
      unset($_SESSION['e_bemail']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
  <input type="text" name="b-phone-num" id="booking-phone-num" placeholder="Phone Number*" required><br>
EOL;
    if (isset($_SESSION['e_bphonenum'])){//If booking_phone_number error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bphonenum'].'</div>';//Display the error message
      unset($_SESSION['e_bphonenum']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
</div>

<div id="col-2">
  <input type="text" name="b-address-line1" id="booking-addl1" placeholder="Address" required><br>
EOL;
    if (isset($_SESSION['e_baddress'])){//If booking_address error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_baddress'].'</div>';//Display the error message
      unset($_SESSION['e_baddress']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
  <input type="text" name="b-address-line2" id="booking-addl2" placeholder="Address (line 2)"><br>
EOL;
    if (isset($_SESSION['e_baddress'])){//If booking_address error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_baddress'].'</div>';//Display the error message
      unset($_SESSION['e_baddress']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
  <input type="text" name="b-city" id="booking-city" placeholder="City" required><br>
EOL;
    if (isset($_SESSION['e_bcity'])){//If booking_city error exists (user has made an error)
      echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bcity'].'</div>';//Display the error message
      unset($_SESSION['e_bcity']);//Unset the error variable so it doesn't show up until the next error
    }
echo <<<EOL
  <input type="text" name="b-postcode" id="booking-postcode" placeholder="Postcode" style="max-width: 15rem;" required><br>
</div>
EOL;
  if (isset($_SESSION['e_bpostcode'])){//If booking_postcode error exists (user has made an error)
    echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_bpostcode'].'</div>';//Display the error message
    unset($_SESSION['e_bpostcode']);//Unset the error variable so it doesn't show up until the next error
  }
echo <<<EOL
</div>

<div id="description">
<h4>FAULT/PROBLEM/SERVICE DESCRIPTION:</h4>
<textarea name="service-description" id="service-description" maxlength="1000" rows="5" placeholder="Max. 1000 characters" required></textarea>
EOL;
  if (isset($_SESSION['e_serviceds'])){//If booking_service_description error exists (user has made an error)
    echo '<div style="color:red; font-size: 1.7rem;">'.$_SESSION['e_serviceds'].'</div>';//Display the error message
    unset($_SESSION['e_serviceds']);//Unset the error variable so it doesn't show up until the next error
  }
echo <<<EOL
</div>

<div id="form-submit">
<input type="submit" value="Submit">
</div>
</form>
</div>

<div id="close-x" onclick="off()">
  <img src="images/close-cross2.png" />
</div>
EOL;
  }

?>

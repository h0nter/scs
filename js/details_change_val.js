//Validate forename
function valForenameDet(){
  var forename = document.forms["d-edit-form"]["forename"].value;//Assign 'forename' value from the details edit form to the 'forename' variable
  const forenameObj = document.getElementById("details-forename");//Declare a constant referring to the 'details-forename' input field object
  const regex = /^[a-zA-Z]{2,30}$/;//Declare a regular expression to validate the forename (Letters only, between 2 and 30 characters long)

  if (regex.test(forename)){//If 'forename' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    forenameObj.classList.remove('valid-field');//Remove normal styling from the 'details-forename' element of the page
    forenameObj.classList.add('invalid-field');//Add red border and background to the 'details-forename' element of the page
    alert("Incorrect forename!\nForename has to consist of letters only and be in range 2-30 characters.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate surname
function valSurnameDet(){
  var surname = document.forms["d-edit-form"]["surname"].value;//Assign 'surname' value from the details edit form to the 'surname' variable
  const surnameObj = document.getElementById("details-surname");//Declare a constant referring to the 'details-surname' input field object
  const regex = /^([a-zA-Z]+[-\s]?[a-zA-Z]{1,29})$/;//Declare a regular expression to validate the surname (Letters + '-' or ' ' separator between two parts, between 1 and 29 characters long)

  if (regex.test(surname)){//If 'surname' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    surnameObj.classList.remove('valid-field');//Remove normal styling from the 'details-surname' element of the page
    surnameObj.classList.add('invalid-field');//Add red border and background to the 'details-surname' element of the page
    alert("Incorrect surname!\nSurname has to consist of letters only and be in range 2-30 characters\nIn case of double-barrelled surnames, separate 2 parts with \"-\" symbol.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate email address
function valEmailDet(){
  var email = document.forms["d-edit-form"]["email-address"].value;//Assign 'email-address' value from the details edit form to the 'email' variable
  const emailObj = document.getElementById("details-email");//Declare a constant referring to the 'details-email' input field object
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|edu|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;//Declare a regular expression to validate the email address (Upper and lower-case letters, numbers or special characters, followed by max. one '.', followed by upper and lower-case letters, numbers or special characters, followed by '@', followed by at least one LCase letter or number, followed by max. one '.', followed by exactly 2 lower-case letters or any of the allowed top-level domains)

  if (regex.test(email)){//If 'email' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    emailObj.classList.remove('valid-field');//Remove normal styling from the 'details-email' element of the page
    emailObj.classList.add('invalid-field');//Add red border and background to the 'details-email' element of the page
    alert("Incorrect email address!\nEnsure that it matches the format (domain names may differ):\nemailaddress@domain.com");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate phone number
function valPhoneNumDet(){
  var phoneNum = document.forms["d-edit-form"]["phone-num"].value;//Assign 'phone-num' value from the details edit form to the 'phoneNum' variable
  const phoneNumObj = document.getElementById("details-phone-num");//Declare a constant referring to the 'details-phone-num' input field object
  const regex = /^[0-9]{11,14}$/;//Declare a regular expression to validate the phone number (digits only, between 11 and 14 characters long)

  if (regex.test(phoneNum) || phoneNum == ""){//If 'phoneNum' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    phoneNumObj.classList.remove('valid-field');//Remove normal styling from the 'details-phone-num' element of the page
    phoneNumObj.classList.add('invalid-field');//Add red border and background to the 'details-phone-num' element of the page
    alert("Incorrect phone number!\nMake sure that you're entering a valid UK phone number, consisting of number only.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate address (line-1)
function valAddressDet(){
  var address = document.forms["d-edit-form"]["address-line1"].value;//Assign 'address-line1' value from the details edit form to the 'address' variable
  const addressObj = document.getElementById("details-addressl1");//Declare a constant referring to the 'details-addressl1' input field object
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;//Declare a regular expression to validate the address line-1 (LCase and UCase letters, digits and spaces, between 2 and 50 characters long)

  if (regex.test(address) || address == ""){//If 'address' variable validation with the regex above is successful OR address is empty
    return true;//Return true
  }else{//If validation is unsuccessful
    addressObj.classList.remove('valid-field');//Remove normal styling from the 'details-addressl1' element of the page
    addressObj.classList.add('invalid-field');//Add red border and background to the 'details-addressl1' element of the page
    alert("Incorrect address (line 1)!\nIt can only contain letters, numbers and spaces\nand has to be between 2-50 characters long.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate address (line-2)
function valAddress2Det(){
  var address2 = document.forms["d-edit-form"]["address-line2"].value;//Assign 'address-line2' value from the booking form to the 'address2' variable
  const address2Obj = document.getElementById("details-addressl2");//Declare a constant referring to the 'details-addressl2' input field object
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;//Declare a regular expression to validate the address line-2 (LCase and UCase letters, digits and spaces, between 2 and 50 characters long)

  if (regex.test(address2) || address2 == ""){//If 'address' variable validation with the regex above is successful OR address2 is empty
    return true;//Return true
  }else{//If validation is unsuccessful
    address2Obj.classList.remove('valid-field');//Remove normal styling from the 'details-addressl2' element of the page
    address2Obj.classList.add('invalid-field');//Add red border and background to the 'details-addressl2' element of the page
    alert("Incorrect address (line 2)!\nIt can only contain letters, numbers and spaces\nand has to be between 2-50 characters long.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate city
function valCityDet(){
  var city = document.forms["d-edit-form"]["city"].value;//Assign 'city' value from the booking form to the 'city' variable
  const cityObj = document.getElementById("details-city");//Declare a constant referring to the 'details-city' input field object
  const regex = /^[a-zA-Z]{2,20}$/;//Declare a regular expression to validate the city (LCase and UCase letters, between 2 and 20 characters long)

  if (regex.test(city) || city == ""){//If 'city' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    cityObj.classList.remove('valid-field');//Remove normal styling from the 'details-city' element of the page
    cityObj.classList.add('invalid-field');//Add red border and background to the 'details-city' element of the page
    alert("Incorrect city!\nEnsure that:\n-It only contains upper and lowercase letters\n-Is between 2 and 20 characters long");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate postcode
function valPostcodeDet(){
  var postcode = document.forms["d-edit-form"]["postcode"].value;//Assign 'postcode' value from the booking form to the 'postcode' variable
  const postcodeObj = document.getElementById("details-postcode");//Declare a constant referring to the 'details-postcode' input field object
  //Declare a regular expression to validate the postcode (LCase and UCase letters, digits, matching the UK postcode validation standards available in here: https://en.wikipedia.org/wiki/Postcodes_in_the_United_Kingdom#Validation)
  const regex = /^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/;

  if (regex.test(postcode) postcode = ""){//If 'postcode' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    postcodeObj.classList.remove('valid-field');//Remove normal styling from the 'details-postcode' element of the page
    postcodeObj.classList.add('invalid-field');//Add red border and background to the 'details-postcode' element of the page
    alert("Incorrect postcode!\nMake sure that you're entering a valid UK postcode.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

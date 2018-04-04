//Validate forename
function valForenameAcc(){
  var forename = document.forms["account-create-f"]["forename"].value;//Assign 'forename' value from the create account form to the 'forename' variable
  const forenameObj = document.getElementById("new-account-forename");//Declare a constant referring to the 'new-account-forename' input field object
  const regex = /^[a-zA-Z]{2,30}$/;//Declare a regular expression to validate the forename (Letters only, between 2 and 30 characters long)

  if (regex.test(forename)){//If 'forename' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    forenameObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-forename' element of the page
    forenameObj.classList.add('invalid-field');//Add red border and background to the 'new-account-forename' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate surname
function valSurnameAcc(){
  var surname = document.forms["account-create-f"]["surname"].value;//Assign 'surname' value from the create account form to the 'surname' variable
  const surnameObj = document.getElementById("new-account-surname");//Declare a constant referring to the 'new-account-surname' input field object
  const regex = /^([a-zA-Z]+[\s]?[-\s]?[\s]?[a-zA-Z]{1,29})$/;//Declare a regular expression to validate the surname (Letters + '-' or ' ' separator between two parts, between 1 and 29 characters long)

  if (regex.test(surname)){//If 'surname' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    surnameObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-surname' element of the page
    surnameObj.classList.add('invalid-field');//Add red border and background to the 'new-account-surname' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate email address
function valEmailAcc(){
  var email = document.forms["account-create-f"]["email-address"].value;//Assign 'email-address' value from the create account form to the 'email' variable
  const emailObj = document.getElementById("new-account-email");//Declare a constant referring to the 'new-account-email' input field object
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|edu|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;//Declare a regular expression to validate the email address (Upper and lower-case letters, numbers or special characters, followed by max. one '.', followed by upper and lower-case letters, numbers or special characters, followed by '@', followed by at least one LCase letter or number, followed by max. one '.', followed by exactly 2 lower-case letters or any of the allowed top-level domains)

  if (regex.test(email)){//If 'email' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    emailObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-email' element of the page
    emailObj.classList.add('invalid-field');//Add red border and background to the 'new-account-email' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate passwords
function valPasswords(){
  var newPassword = document.forms["account-create-f"]["u-password"].value;//Assign 'u-password' value from the create account form to the 'newPassword' variable
  const newPasswordObj = document.getElementById("new-account-password");//Declare a constant referring to the 'new-account-password' input field object

  var confirmPassword = document.forms["account-create-f"]["pass-confirm"].value;//Assign 'pass-confirm' value from the create account form to the 'confirmPassword' variable
  const confrimPasswordObj = document.getElementById("new-account-passconf");//Declare a constant referring to the 'new-account-passconf' input field object

  const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+/=?^_-].{8,}$/;//Declare a regular expression to validate the password (At least one UCase letter and one digit, any amount of letter, digits and special characters, 8 or more characters long)

  if (regex.test(newPassword)){//If 'newPassword' variable validation with the regex above is successful
    if (newPassword == confirmPassword){//If 'newPassword' is equal to 'confirmPassword' variable
      return true;//Return true
    }else{//If inputs aren't matching
      newPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-password' element of the page
      newPasswordObj.classList.add('invalid-field');//Add red border and background to the 'new-account-password' element of the page
      confrimPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-passconf' element of the page
      confrimPasswordObj.classList.add('invalid-field');//Add red border and background to the 'new-account-passconf' element of the page
      return false;//Return false - validation unsuccessful
    }
  }else{//If validation with regular expression is unsuccessful
    newPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-password' element of the page
    newPasswordObj.classList.add('invalid-field');//Add red border and background to the 'new-account-password' element of the page
    confrimPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-passconf' element of the page
    confrimPasswordObj.classList.add('invalid-field');//Add red border and background to the 'new-account-passconf' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate phone number
function valPhoneNumAcc(){
  var phoneNum = document.forms["account-create-f"]["phone-num"].value;//Assign 'phone-num' value from the create account form to the 'phoneNum' variable
  const phoneNumObj = document.getElementById("new-account-phonenum");//Declare a constant referring to the 'new-account-phonenum' input field object
  const regex = /^[0-9]{11,14}$/;//Declare a regular expression to validate the phone number (digits only, between 11 and 14 characters long)

  if (regex.test(phoneNum) || phoneNum == ""){//If 'phoneNum' variable validation with the regex above is successful OR 'phoneNum' is empty
    return true;//Return true
  }else{//If validation is unsuccessful
    phoneNumObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-phonenum' element of the page
    phoneNumObj.classList.add('invalid-field');//Add red border and background to the 'new-account-phonenum' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate address (line-1)
function valAddressAcc(){
  var address = document.forms["account-create-f"]["address-line1"].value;//Assign 'address-line1' value from the create account form to the 'address' variable
  const addressObj = document.getElementById("new-account-addl1");//Declare a constant referring to the 'new-account-addl1' input field object
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;//Declare a regular expression to validate the address line-1 (LCase and UCase letters, digits and spaces, between 2 and 50 characters long)

  if (regex.test(address) || address == ""){//If 'address' variable validation with the regex above is successful OR 'address' is empty
    return true;//Return true
  }else{//If validation is unsuccessful
    addressObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-addl1' element of the page
    addressObj.classList.add('invalid-field');//Add red border and background to the 'new-account-addl1' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate address (line-2)
function valAddress2Acc(){
  var address2 = document.forms["account-create-f"]["address-line2"].value;//Assign 'address-line2' value from the create account form to the 'address2' variable
  const address2Obj = document.getElementById("new-account-addl2");//Declare a constant referring to the 'new-account-addl2' input field object
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;//Declare a regular expression to validate the address line-1 (LCase and UCase letters, digits and spaces, between 2 and 50 characters long)

  if (regex.test(address2) || address2 == ""){//If 'address2' variable validation with the regex above is successful OR 'address2' is empty
    return true;//Return true
  }else{//If validation is unsuccessful
    address2Obj.classList.remove('valid-field');//Remove normal styling from the '' element of the page
    address2Obj.classList.add('invalid-field');//Add red border and background to the 'new-account-addl2' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate city
function valCityAcc(){
  var city = document.forms["account-create-f"]["city"].value;//Assign 'city' value from the create account form to the 'city' variable
  const cityObj = document.getElementById("new-account-city");//Declare a constant referring to the 'new-account-city' input field object
  const regex = /^[a-zA-Z]{2,20}$/;//Declare a regular expression to validate the address line-2 (LCase and UCase letters, between 2 and 20 characters long)

  if (regex.test(city) || city == ""){//If 'city' variable validation with the regex above is successful OR 'city' is empty
    return true;//Return true
  }else{//If validation is unsuccessful
    cityObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-city' element of the page
    cityObj.classList.add('invalid-field');//Add red border and background to the new-account-city' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate city
function valPostcodeAcc(){
  var postcode = document.forms["account-create-f"]["postcode"].value;//Assign 'postcode' value from the create account form to the 'postcode' variable
  const postcodeObj = document.getElementById("new-account-postcode");//Declare a constant referring to the 'new-account-postcode' input field object
  //Declare a regular expression to validate the postcode (LCase and UCase letters, digits, matching the UK postcode validation standards available in here: https://en.wikipedia.org/wiki/Postcodes_in_the_United_Kingdom#Validation)
  const regex = /^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/;

  if (regex.test(postcode) || postcode == ""){//If 'postcode' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    postcodeObj.classList.remove('valid-field');//Remove normal styling from the 'new-account-postcode' element of the page
    postcodeObj.classList.add('invalid-field');//Add red border and background to the 'new-account-postcode' element of the page
    return false;//Return false - validation unsuccessful
  }
}

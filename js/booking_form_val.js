//Validate year of production
function valYearOfProdbook(){
  var yop = document.forms["b-form"]["year"].value;//Assign 'year' value from the booking form to the 'yop' variable
  const yearProd = document.getElementById("year-prod");//Declare a constant referring to the 'year' input field object
  const regex = /^((19||20)+([0-9]{2}))$/;//Declare a regular expression to validate the year of production ('19' or '20' followed by any two digits)

  if (regex.test(yop) || yop == ""){//If 'yop' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    yearProd.classList.remove('valid-field');//Remove normal styling from the 'year-prod' element of the page
    yearProd.classList.add('invalid-field');//Add red border and background to the 'year-prod' element of the page
    alert("Incorrect year of production!\nEnter a numeric value in range 1900-2099.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate forename
function valForenamebook(){
  var forename = document.forms["b-form"]["b-forename"].value;//Assign 'forename' value from the booking form to the 'forename' variable
  const forenameObj = document.getElementById("booking-forename");//Declare a constant referring to the 'forename' input field object
  const regex = /^[a-zA-Z]{2,30}$/;//Declare a regular expression to validate the forename (Letters only, between 2 and 30 characters long)

  if (regex.test(forename)){//If 'forename' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    forenameObj.classList.remove('valid-field');//Remove normal styling from the 'booking-forename' element of the page
    forenameObj.classList.add('invalid-field');//Add red border and background to the 'booking-forename' element of the page
    alert("Incorrect forename!\nForename has to consist of letters only and be in range 2-30 characters.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate surname
function valSurnamebook(){
  var surname = document.forms["b-form"]["b-surname"].value;//Assign 'surname' value from the booking form to the 'surname' variable
  const surnameObj = document.getElementById("booking-surname");//Declare a constant referring to the 'surname' input field object
  const regex = /^([a-zA-Z]+[-\s]?[a-zA-Z]{1,29})$/;//Declare a regular expression to validate the surname (Letters + '-' or ' ' separator between two parts, between 1 and 29 characters long)

  if (regex.test(surname)){//If 'surname' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    surnameObj.classList.remove('valid-field');//Remove normal styling from the 'booking-surname' element of the page
    surnameObj.classList.add('invalid-field');//Add red border and background to the 'booking-surname' element of the page
    alert("Incorrect surname!\nSurname has to consist of letters only and be in range 2-30 characters\nIn case of double-barrelled surnames, separate 2 parts with \"-\" symbol.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate email address
function valEmailbook(){
  var email = document.forms["b-form"]["b-email-address"].value;//Assign 'email-address' value from the booking form to the 'email' variable
  const emailObj = document.getElementById("booking-email");//Declare a constant referring to the 'booking-email' input field object
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;//Declare a regular expression to validate the email address (Upper and lower-case letters, numbers or special characters, followed by max. one '.', followed by upper and lower-case letters, numbers or special characters, followed by '@', followed by at least one LCase letter or number, followed by max. one '.', followed by exactly 2 lower-case letters or any of the allowed top-level domains)

  if (regex.test(email)){//If 'email' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    emailObj.classList.remove('valid-field');//Remove normal styling from the 'booking-email' element of the page
    emailObj.classList.add('invalid-field');//Add red border and background to the 'booking-email' element of the page
    alert("Incorrect email address!\nEnsure that it matches the format (domain names may differ):\nemailaddress@domain.com");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate phone number
function valPhoneNumbook(){
  var phoneNum = document.forms["b-form"]["b-phone-num"].value;//Assign 'phone-num' value from the booking form to the 'phoneNum' variable
  const phoneNumObj = document.getElementById("booking-phone-num");//Declare a constant referring to the 'booking-phone-num' input field object
  const regex = /^[0-9]{11,14}$/;//Declare a regular expression to validate the phone number (digits only, between 11 and 14 characters long)

  if (regex.test(phoneNum)){//If 'phoneNum' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    phoneNumObj.classList.remove('valid-field');//Remove normal styling from the 'booking-phone-num' element of the page
    phoneNumObj.classList.add('invalid-field');//Add red border and background to the 'booking-phone-num' element of the page
    alert("Incorrect phone number!\nMake sure that you're entering a valid UK phone number, consisting of number only.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate address (line-1)
function valAddressbook(){
  var address = document.forms["b-form"]["b-address-line1"].value;//Assign 'address-line1' value from the booking form to the 'address' variable
  const addressObj = document.getElementById("booking-addl1");//Declare a constant referring to the 'booking-addl1' input field object
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;//Declare a regular expression to validate the address line-1 (LCase and UCase letters, digits and spaces, between 2 and 50 characters long)

  if (regex.test(address)){//If 'address' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    addressObj.classList.remove('valid-field');//Remove normal styling from the 'booking-addl1' element of the page
    addressObj.classList.add('invalid-field');//Add red border and background to the 'booking-addl1' element of the page
    alert("Incorrect address (line 1)!\nIt can only contain letters, numbers and spaces\nand has to be between 2-50 characters long.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate address (line-2)
function valAddress2book(){
  var address2 = document.forms["b-form"]["b-address-line2"].value;//Assign 'address-line2' value from the booking form to the 'address2' variable
  const address2Obj = document.getElementById("booking-addl2");//Declare a constant referring to the 'booking-addl2' input field object
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;//Declare a regular expression to validate the address line-2 (LCase and UCase letters, digits and spaces, between 2 and 50 characters long)

  if (regex.test(address2) || address2 == ""){//If 'address' variable validation with the regex above is successful OR address2 is empty
    return true;//Return true
  }else{//If validation is unsuccessful
    address2Obj.classList.remove('valid-field');//Remove normal styling from the 'booking-addl2' element of the page
    address2Obj.classList.add('invalid-field');//Add red border and background to the 'booking-addl2' element of the page
    alert("Incorrect address (line 2)!\nIt can only contain letters, numbers and spaces\nand has to be between 2-50 characters long.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate city
function valCitybook(){
  var city = document.forms["b-form"]["b-city"].value;//Assign 'city' value from the booking form to the 'city' variable
  const cityObj = document.getElementById("booking-city");//Declare a constant referring to the 'booking-city' input field object
  const regex = /^[a-zA-Z]{2,20}$/;//Declare a regular expression to validate the city (LCase and UCase letters, between 2 and 20 characters long)

  if (regex.test(city)){//If 'city' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    cityObj.classList.remove('valid-field');//Remove normal styling from the 'booking-city' element of the page
    cityObj.classList.add('invalid-field');//Add red border and background to the 'booking-city' element of the page
    alert("Incorrect city!\nEnsure that:\n-It only contains upper and lowercase letters\n-Is between 2 and 20 characters long");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate postcode
function valPostcodebook(){
  var postcode = document.forms["b-form"]["b-postcode"].value;//Assign 'postcode' value from the booking form to the 'postcode' variable
  const postcodeObj = document.getElementById("booking-postcode");//Declare a constant referring to the 'booking-postcode' input field object
  //Declare a regular expression to validate the postcode (LCase and UCase letters, digits, matching the UK postcode validation standards available in here: https://en.wikipedia.org/wiki/Postcodes_in_the_United_Kingdom#Validation)
  const regex = /^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/;

  if (regex.test(postcode)){//If 'postcode' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    postcodeObj.classList.remove('valid-field');//Remove normal styling from the 'booking-postcode' element of the page
    postcodeObj.classList.add('invalid-field');//Add red border and background to the 'booking-postcode' element of the page
    alert("Incorrect postcode!\nMake sure that you're entering a valid UK postcode.");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate booking decription
function valDescriptionbook(){
  var description = document.forms["b-form"]["service-description"].value;//Assign 'service-description' value from the booking form to the 'description' variable
  const descriptionObj = document.getElementById("service-description");//Declare a constant referring to the 'service-description' input field object
  const regex = /^[a-zA-Z0-9!#$%&'*+/=?^_,\.`{|}~-\s]{3,1000}$/;//Declare a regular expression to validate the service description (LCase and UCase letters, numbers and special characters, between 3 and 1000 characters long)

  if (regex.test(description)){//If 'description' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    descriptionObj.classList.remove('valid-field');//Remove normal styling from the 'service-description' element of the page
    descriptionObj.classList.add('invalid-field');//Add red border and background to the 'service-description' element of the page
    alert("Incorrect booking description!\nMake sure that your input is between 3-1000 characters long.");//Show error message
    return false;//Return false
  }
}

/*function valCompTypebook(){
  var comptype = document.forms["b-form"]["computer-type"].value;
  const comptypeObj = document.getElementById("computer-type");

  if (comptype == "Macbook" || comptype == "iMac"){
    document.getElementById("comp-make").innerHTML = "<option value=\"Apple\">Apple</option>";
  }else if(comptype != ""){
    document.getElementById("comp-make").innerHTML = "<option></option>\
    <option value=\"HP\">HP</option>\
    <option value=\"Lenovo\">Lenovo</option>\
    <option value=\"Dell\">Dell</option>\
    <option value=\"Asus\">Asus</option>\
    <option value=\"Acer\">Acer</option>\
    <option value=\"Alienware\">Alienware</option>\
    <option value=\"Other\">Other</option>";
  }
}*/

//Validate year of production
function valYearOfProdbook(){
  var yop = document.forms["b-form"]["year"].value;//Assign 'year' value from the booking form to the 'yop' variable
  const yearProd = document.getElementById("year-prod");//Declare a constant referring to the 'year' input field object
  const regex = /^((19||20)+([0-9]{2}))$/;//Declare a regular expression to validate the year of production ('19' or '20' followed by any two digits)

  if (regex.test(yop)){//If 'yop' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    yearProd.classList.remove('valid-field');//Remove normal styling from the 'year-prod' element of the page
    yearProd.classList.add('invalid-field');//Add red border and background to the 'year-prod' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate forename
function valForenamebook(){
  var forename = document.forms["b-form"]["forename"].value;//Assign 'forename' value from the booking form to the 'forename' variable
  const forenameObj = document.getElementById("booking-forename");//Declare a constant referring to the 'forename' input field object
  const regex = /^[a-zA-Z]{2,30}$/;//Declare a regular expression to validate the forename (Letters only, between 2 and 30 characters long)

  if (regex.test(forename)){//If 'forename' variable validation with the regex above is successful
    return true;//Return true
  }else{
    forenameObj.classList.remove('valid-field');//Remove normal styling from the 'booking-forename' element of the page
    forenameObj.classList.add('invalid-field');//Add red border and background to the 'booking-forename' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate surname
function valSurnamebook(){
  var surname = document.forms["b-form"]["surname"].value;//Assign 'surname' value from the booking form to the 'surname' variable
  const surnameObj = document.getElementById("booking-surname");//Declare a constant referring to the 'surname' input field object
  const regex = /^([a-zA-Z]+[-\s]?[a-zA-Z]{1,29})$/;//Declare a regular expression to validate the surname (Letters + '-' or ' ' separator between two parts, between 1 and 29 characters long)

  if (regex.test(surname)){//If 'surname' variable validation with the regex above is successful
    return true;//Return true
  }else{
    surnameObj.classList.remove('valid-field');//Remove normal styling from the 'booking-surname' element of the page
    surnameObj.classList.add('invalid-field');//Add red border and background to the 'booking-surname' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate email address
function valEmailbook(){
  var email = document.forms["b-form"]["email-address"].value;//Assign 'email-address' value from the booking form to the 'email' variable
  const emailObj = document.getElementById("booking-email");//Declare a constant referring to the 'booking-email' input field object
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;//Declare a regular expression to validate the email address (Upper and lower-case letters, numbers or special characters, followed by max. one '.', followed by upper and lower-case letters, numbers or special characters, followed by '@', followed by at least one LCase letter or number, followed by max. one '.', followed by exactly 2 lower-case letters or any of the allowed top-level domains)

  if (regex.test(email)){//If 'email' variable validation with the regex above is successful
    return true;//Return true
  }else{
    emailObj.classList.remove('valid-field');//Remove normal styling from the 'booking-email' element of the page
    emailObj.classList.add('invalid-field');//Add red border and background to the 'booking-email' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate phone number
function valPhoneNumbook(){
  var phoneNum = document.forms["b-form"]["phone-num"].value;//Assign 'phone-num' value from the booking form to the 'phoneNum' variable
  const phoneNumObj = document.getElementById("booking-phone-num");//Declare a constant referring to the 'booking-phone-num' input field object
  const regex = /^[0-9]{11,14}$/;//Declare a regular expression to validate the phone number (digits only, between 11 and 14 characters long)

  if (regex.test(phoneNum)){//If 'phoneNum' variable validation with the regex above is successful
    return true;//Return true
  }else{
    phoneNumObj.classList.remove('valid-field');//Remove normal styling from the 'booking-phone-num' element of the page
    phoneNumObj.classList.add('invalid-field');//Add red border and background to the 'booking-phone-num' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate address (line-1)
function valAddressbook(){
  var address = document.forms["b-form"]["address-line1"].value;//Assign 'address-line1' value from the booking form to the 'address' variable
  const addressObj = document.getElementById("booking-addl1");//Declare a constant referring to the 'booking-addl1' input field object
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;//Declare a regular expression to validate the address line-1 (LCase and UCase letters, digits and spaces, between 2 and 50 characters long)

  if (regex.test(address)){//If 'address' variable validation with the regex above is successful
    return true;//Return true
  }else{
    addressObj.classList.remove('valid-field');//Remove normal styling from the 'booking-addl1' element of the page
    addressObj.classList.add('invalid-field');//Add red border and background to the 'booking-addl1' element of the page
    return false;//Return false
  }
}

//Validate address (line-2)
function valAddress2book(){
  var address2 = document.forms["b-form"]["address-line2"].value;//Assign 'address-line2' value from the booking form to the 'address2' variable
  const address2Obj = document.getElementById("booking-addl2");//Declare a constant referring to the 'booking-addl2' input field object
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;//Declare a regular expression to validate the address line-2 (LCase and UCase letters, digits and spaces, between 2 and 50 characters long)

  if (regex.test(address2) || address2 == ""){//If 'address' variable validation with the regex above is successful OR address2 is empty
    return true;//Return true
  }else{
    address2Obj.classList.remove('valid-field');//Remove normal styling from the 'booking-addl2' element of the page
    address2Obj.classList.add('invalid-field');//Add red border and background to the 'booking-addl2' element of the page
    return false;//Return false
  }
}

//Validate city
function valCitybook(){
  var city = document.forms["b-form"]["city"].value;//Assign 'city' value from the booking form to the 'city' variable
  const cityObj = document.getElementById("booking-city");//Declare a constant referring to the 'booking-city' input field object
  const regex = /^[a-zA-Z]{2,20}$/;//Declare a regular expression to validate the address line-2 (LCase and UCase letters, between 2 and 20 characters long)

  if (regex.test(city)){//If 'city' variable validation with the regex above is successful
    return true;//Return true
  }else{
    cityObj.classList.remove('valid-field');//Remove normal styling from the 'booking-city' element of the page
    cityObj.classList.add('invalid-field');//Add red border and background to the 'booking-city' element of the page
    return false;//Return false
  }
}

//Validate postcode
function valPostcodebook(){
  var postcode = document.forms["b-form"]["postcode"].value;//Assign 'postcode' value from the booking form to the 'postcode' variable
  const postcodeObj = document.getElementById("booking-postcode");//Declare a constant referring to the 'booking-postcode' input field object
  //Declare a regular expression to validate the postcode (LCase and UCase letters, digits, matching the UK postcode validation standards available in here: https://en.wikipedia.org/wiki/Postcodes_in_the_United_Kingdom#Validation)
  const regex = /^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/;

  if (regex.test(postcode)){//If 'postcode' variable validation with the regex above is successful
    return true;//Return true
  }else{
    postcodeObj.classList.remove('valid-field');//Remove normal styling from the 'booking-postcode' element of the page
    postcodeObj.classList.add('invalid-field');//Add red border and background to the 'booking-postcode' element of the page
    return false;//Return false - validation unsuccessful
  }
}

//Validate booking decription
function valDescriptionbook(){
  var description = document.forms["b-form"]["service-description"].value;//Assign 'service-description' value from the booking form to the 'description' variable
  const descriptionObj = document.getElementById("service-description");//Declare a constant referring to the 'service-description' input field object
  const regex = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]{3,1000}$/;//Declare a regular expression to validate the service description (LCase and UCase letters, numbers and special characters, between 3 and 1000 characters long)

  if (regex.test(description)){//If 'description' variable validation with the regex above is successful
    return true;//Return true
  }else{
    descriptionObj.classList.remove('valid-field');//Remove normal styling from the 'service-description' element of the page
    descriptionObj.classList.add('invalid-field');//Add red border and background to the 'service-description' element of the page
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

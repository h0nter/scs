function valForenameDet(){
  var forename = document.forms["d-edit-form"]["forename"].value;
  const forenameObj = document.getElementById("details-forename");
  const regex = /^[a-zA-Z]{2,30}$/;

  if (regex.test(forename)){
    return true;
  }else{
    forenameObj.classList.remove('valid-field');
    forenameObj.classList.add('invalid-field');
    return false;
  }
}

function valSurnameDet(){
  var surname = document.forms["d-edit-form"]["surname"].value;
  const surnameObj = document.getElementById("details-surname");
  const regex = /^([a-zA-Z]+[-\s]?[a-zA-Z]{1,29})$/;

  if (regex.test(surname)){
    return true;
  }else{
    surnameObj.classList.remove('valid-field');
    surnameObj.classList.add('invalid-field');
    return false;
  }
}

function valEmailDet(){
  var email = document.forms["d-edit-form"]["email-address"].value;
  const emailObj = document.getElementById("details-email");
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;

  if (regex.test(email)){
    return true;
  }else{
    emailObj.classList.remove('valid-field');
    emailObj.classList.add('invalid-field');
    return false;
  }
}

function valPhoneNumDet(){
  var phoneNum = document.forms["d-edit-form"]["phone-num"].value;
  const phoneNumObj = document.getElementById("details-phone-num");
  const regex = /^[0-9]{11,14}$/;

  if (regex.test(phoneNum)){
    return true;
  }else{
    phoneNumObj.classList.remove('valid-field');
    phoneNumObj.classList.add('invalid-field');
    return false;
  }
}

function valAddressDet(){
  var address = document.forms["d-edit-form"]["address-line1"].value;
  const addressObj = document.getElementById("details-addressl1");
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;

  if (regex.test(address)){
    return true;
  }else{
    addressObj.classList.remove('valid-field');
    addressObj.classList.add('invalid-field');
    return false;
  }
}

function valAddress2Det(){
  var address2 = document.forms["d-edit-form"]["address-line2"].value;
  const address2Obj = document.getElementById("details-addressl2");
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;

  if (regex.test(address2) || address2 == ""){
    return true;
  }else{
    address2Obj.classList.remove('valid-field');
    address2Obj.classList.add('invalid-field');
    return false;
  }
}

function valCityDet(){
  var city = document.forms["d-edit-form"]["city"].value;
  const cityObj = document.getElementById("details-city");
  const regex = /^[a-zA-Z]{2,20}$/;

  if (regex.test(city)){
    return true;
  }else{
    cityObj.classList.remove('valid-field');
    cityObj.classList.add('invalid-field');
    return false;
  }
}

function valPostcodeDet(){
  var postcode = document.forms["d-edit-form"]["postcode"].value;
  const postcodeObj = document.getElementById("details-postcode");
  const regex = /^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/;

  if (regex.test(postcode)){
    return true;
  }else{
    postcodeObj.classList.remove('valid-field');
    postcodeObj.classList.add('invalid-field');
    return false;
  }
}

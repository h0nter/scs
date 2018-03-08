function valForenameAcc(){
  var forename = document.forms["account-create-f"]["forename"].value;
  const forenameObj = document.getElementById("new-account-forename");
  const regex = /^[a-zA-Z]{2,30}$/;

  if (regex.test(forename)){
    return true;
  }else{
    forenameObj.classList.remove('valid-field');
    forenameObj.classList.add('invalid-field');
    return false;
  }
}

function valSurnameAcc(){
  var surname = document.forms["account-create-f"]["surname"].value;
  const surnameObj = document.getElementById("new-account-surname");
  const regex = /^([a-zA-Z]+[\s]?[-\s]?[\s]?[a-zA-Z]{1,29})$/;

  if (regex.test(surname)){
    return true;
  }else{
    surnameObj.classList.remove('valid-field');
    surnameObj.classList.add('invalid-field');
    return false;
  }
}

function valEmailAcc(){
  var email = document.forms["account-create-f"]["email-address"].value;
  const emailObj = document.getElementById("new-account-email");
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|edu|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;

  if (regex.test(email)){
    return true;
  }else{
    emailObj.classList.remove('valid-field');
    emailObj.classList.add('invalid-field');
    return false;
  }
}

function valPasswords(){
  var newPassword = document.forms["account-create-f"]["u-password"].value;
  const newPasswordObj = document.getElementById("new-account-password");

  var confirmPassword = document.forms["account-create-f"]["pass-confirm"].value;
  const confrimPasswordObj = document.getElementById("new-account-passconf");

  const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+/=?^_-].{8,}$/;

  if (regex.test(newPassword)){
    if (newPassword == confirmPassword){
      return true;
    }else{
      newPasswordObj.classList.remove('valid-field');
      newPasswordObj.classList.add('invalid-field');
      confrimPasswordObj.classList.remove('valid-field');
      confrimPasswordObj.classList.add('invalid-field');
      return false;
    }
  }else{
    newPasswordObj.classList.remove('valid-field');
    newPasswordObj.classList.add('invalid-field');
    confrimPasswordObj.classList.remove('valid-field');
    confrimPasswordObj.classList.add('invalid-field');
    return false;
  }
}

function valPhoneNumAcc(){
  var phoneNum = document.forms["account-create-f"]["phone-num"].value;
  const phoneNumObj = document.getElementById("new-account-phonenum");
  const regex = /^[0-9]{11,14}$/;

  if (regex.test(phoneNum) || phoneNum == ""){
    return true;
  }else{
    phoneNumObj.classList.remove('valid-field');
    phoneNumObj.classList.add('invalid-field');
    return false;
  }
}

function valAddressAcc(){
  var address = document.forms["account-create-f"]["address-line1"].value;
  const addressObj = document.getElementById("new-account-addl1");
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;

  if (regex.test(address) || address == ""){
    return true;
  }else{
    addressObj.classList.remove('valid-field');
    addressObj.classList.add('invalid-field');
    return false;
  }
}

function valAddress2Acc(){
  var address2 = document.forms["account-create-f"]["address-line2"].value;
  const address2Obj = document.getElementById("new-account-addl2");
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;

  if (regex.test(address2) || address2 == ""){
    return true;
  }else{
    address2Obj.classList.remove('valid-field');
    address2Obj.classList.add('invalid-field');
    return false;
  }
}

function valCityAcc(){
  var city = document.forms["account-create-f"]["city"].value;
  const cityObj = document.getElementById("new-account-city");
  const regex = /^[a-zA-Z]{2,20}$/;

  if (regex.test(city) || city == ""){
    return true;
  }else{
    cityObj.classList.remove('valid-field');
    cityObj.classList.add('invalid-field');
    return false;
  }
}

function valPostcodeAcc(){
  var postcode = document.forms["account-create-f"]["postcode"].value;
  const postcodeObj = document.getElementById("new-account-postcode");
  const regex = /^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/;

  if (regex.test(postcode) || postcode == ""){
    return true;
  }else{
    postcodeObj.classList.remove('valid-field');
    postcodeObj.classList.add('invalid-field');
    return false;
  }
}

function valYearOfProdbook(){
  var yop = document.forms["b-form"]["year"].value;
  const yearProd = document.getElementById("year-prod");
  const regex = /^((19||20)+([0-9]{2}))$/;

  if (regex.test(yop)){
    return true;
  }else{
    yearProd.classList.remove('valid-field');
    yearProd.classList.add('invalid-field');
    return false;
  }
}

function valForenamebook(){
  var forename = document.forms["b-form"]["forename"].value;
  const forenameObj = document.getElementById("booking-forename");
  const regex = /^[a-zA-Z]{2,30}$/;

  if (regex.test(forename)){
    return true;
  }else{
    forenameObj.classList.remove('valid-field');
    forenameObj.classList.add('invalid-field');
    return false;
  }
}

function valSurnamebook(){
  var surname = document.forms["b-form"]["surname"].value;
  const surnameObj = document.getElementById("booking-surname");
  const regex = /^([a-zA-Z]+[-\s]?[a-zA-Z]{1,29})$/;

  if (regex.test(surname)){
    return true;
  }else{
    surnameObj.classList.remove('valid-field');
    surnameObj.classList.add('invalid-field');
    return false;
  }
}

function valEmailbook(){
  var email = document.forms["b-form"]["email-address"].value;
  const emailObj = document.getElementById("booking-email");
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;

  if (regex.test(email)){
    return true;
  }else{
    emailObj.classList.remove('valid-field');
    emailObj.classList.add('invalid-field');
    return false;
  }
}

function valPhoneNumbook(){
  var phoneNum = document.forms["b-form"]["phone-num"].value;
  const phoneNumObj = document.getElementById("booking-phone-num");
  const regex = /^[0-9]{11,14}$/;

  if (regex.test(phoneNum)){
    return true;
  }else{
    phoneNumObj.classList.remove('valid-field');
    phoneNumObj.classList.add('invalid-field');
    return false;
  }
}

function valAddressbook(){
  var address = document.forms["b-form"]["address-line1"].value;
  const addressObj = document.getElementById("booking-addl1");
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;

  if (regex.test(address)){
    return true;
  }else{
    addressObj.classList.remove('valid-field');
    addressObj.classList.add('invalid-field');
    return false;
  }
}

function valAddress2book(){
  var address2 = document.forms["b-form"]["address-line2"].value;
  const address2Obj = document.getElementById("booking-addl2");
  const regex = /^[a-zA-Z0-9\s]{2,50}$/;

  if (regex.test(address2) || address2 == ""){
    return true;
  }else{
    address2Obj.classList.remove('valid-field');
    address2Obj.classList.add('invalid-field');
    return false;
  }
}

function valCitybook(){
  var city = document.forms["b-form"]["city"].value;
  const cityObj = document.getElementById("booking-city");
  const regex = /^[a-zA-Z]{2,20}$/;

  if (regex.test(city)){
    return true;
  }else{
    cityObj.classList.remove('valid-field');
    cityObj.classList.add('invalid-field');
    return false;
  }
}

function valPostcodebook(){
  var postcode = document.forms["b-form"]["postcode"].value;
  const postcodeObj = document.getElementById("booking-postcode");
  const regex = /^(([a-zA-Z]{2}\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d[a-zA-Z]\s\d[a-zA-Z]{2})|([a-zA-Z]\d\s\d[a-zA-Z]{2})|([a-zA-Z]\d{2}\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d\s\d[a-zA-Z]{2})|([a-zA-Z]{2}\d{2}\s\d[a-zA-Z]{2}))$/;

  if (regex.test(postcode)){
    return true;
  }else{
    postcodeObj.classList.remove('valid-field');
    postcodeObj.classList.add('invalid-field');
    return false;
  }
}

function valDescriptionbook(){
  var description = document.forms["b-form"]["service-description"].value;
  const descriptionObj = document.getElementById("service-description");
  const regex = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]{3,1000}$/;

  if (regex.test(description)){
    return true;
  }else{
    descriptionObj.classList.remove('valid-field');
    descriptionObj.classList.add('invalid-field');
    return false;
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

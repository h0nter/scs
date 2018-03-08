function valEmailReset(){
  var email = document.forms["pass-reset-f"]["email-address"].value;
  const emailObj = document.getElementById("pass-reset-email");
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|edu|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;

  if (regex.test(email)){
    return true;
  }else{
    emailObj.classList.remove('valid-field');
    emailObj.classList.add('invalid-field');
    return false;
  }
}

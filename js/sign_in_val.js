function valEmailLog(){
  var email = document.forms["sign-in-f"]["email-address"].value;
  const emailObj = document.getElementById("sign-in-email");
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;

  if (regex.test(email)){
    return true;
  }else{
    emailObj.classList.remove('valid-field');
    emailObj.classList.add('invalid-field');
    return false;
  }
}

function valPasswordLog(){
  var password = document.forms["sign-in-f"]["user-password"].value;
  const passwordObj = document.getElementById("sign-in-password");
  const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+/=?^_-].{8,}$/;

  if (regex.test(password)){
    return true;
  }else{
    passwordObj.classList.remove('valid-field');
    passwordObj.classList.add('invalid-field');
    return false;
  }
}

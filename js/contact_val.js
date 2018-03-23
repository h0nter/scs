function valContactMessage(){
  var message = document.forms["c-form"]["message-contact"].value;
  const messageObj = document.getElementById("message-contact");
  const regex = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]{1,4000}$/;

  if (regex.test(message)){
    return true;
  }else{
    messageObj.classList.remove('valid-field');
    messageObj.classList.add('invalid-field');
    return false;
  }
}

function valContactEmail(){
  var email = document.forms["c-form"]["email-contact"].value;
  const emailObj = document.getElementById("email-contact");
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;

  if (regex.test(email)){
    return true;
  }else{
    emailObj.classList.remove('valid-field');
    emailObj.classList.add('invalid-field-contact');
    return false;
  }
}

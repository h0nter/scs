//Minimum 8 characters
//Minimum 1 capital letter
//Minimum 1 number
//Can contain UCase, LCase characters, digits and special characters
//New Password matches Confirm Password

function valCurrentPswrd(){
  var crntPassword = document.forms["pass-change-form"]["current-password"].value;
  const crntPasswordObj = document.getElementById("pass-change-crntpass");
  const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+/=?^_-].{8,}$/;

  if (regex.test(crntPassword)){
    return true;
  }else{
    crntPasswordObj.classList.remove('valid-field');
    crntPasswordObj.classList.add('invalid-field');
    return false;
  }
}

function valNewPswrd(){
  var newPassword = document.forms["pass-change-form"]["new-password"].value;
  const newPasswordObj = document.getElementById("pass-change-newpass");

  var confirmPassword = document.forms["pass-change-form"]["confirm-password"].value;
  const confrimPasswordObj = document.getElementById("pass-change-confirmpass");

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

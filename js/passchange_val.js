/*REQUIREMENTS FOR A PASSWORD
--------------------------------------------*/
//Minimum 8 characters
//Minimum 1 capital letter
//Minimum 1 number
//Can contain UCase, LCase characters, digits and special characters
//New Password matches Confirm Password

//Validate current password
function valCurrentPswrd(){
  var crntPassword = document.forms["pass-change-form"]["current-password"].value;//Assign 'current-password' value from the password change form to the 'crntPassword' variable
  const crntPasswordObj = document.getElementById("pass-change-crntpass");//Declare a constant referring to the 'pass-change-crntpass' input field object
  const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+/=?^_-].{8,}$/;//Declare a regular expression to validate the password (At least one UCase letter and one digit, any amount of letter, digits and special characters, 8 or more characters long)

  if (regex.test(crntPassword)){//If 'crntPassword' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    crntPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'pass-change-crntpass' element of the page
    crntPasswordObj.classList.add('invalid-field');//Add red border and background to the 'pass-change-crntpass' element of the page
    alert("Incorrect password format!\nPassword should consist of:\n- At least 1 uppercase letter\n- At least 1 digit\n- Minimum 8 characters");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

//Validate new password
function valNewPswrd(){
  var newPassword = document.forms["pass-change-form"]["new-password"].value;//Assign 'new-password' value from the password change form to the 'newPassword' variable
  const newPasswordObj = document.getElementById("pass-change-newpass");//Declare a constant referring to the 'pass-change-newpass' input field object

  var confirmPassword = document.forms["pass-change-form"]["confirm-password"].value;//Assign 'confirm-password' value from the password change form to the 'confirmPassword' variable
  const confrimPasswordObj = document.getElementById("pass-change-confirmpass");//Declare a constant referring to the 'pass-change-confirmpass' input field object

  const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+/=?^_-].{8,}$/;//Declare a regular expression to validate the password (At least one UCase letter and one digit, any amount of letter, digits and special characters, 8 or more characters long)

  if (regex.test(newPassword)){//If 'newPassword' variable validation with the regex above is successful
    if (newPassword == confirmPassword){//If 'newPassword' is equal to 'confirmPassword' variable
      return true;//Return true
    }else{//If inputs aren't matching
      newPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'pass-change-newpass' element of the page
      newPasswordObj.classList.add('invalid-field');//Add red border and background to the 'pass-change-newpass' element of the page
      confrimPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'pass-change-confirmpass' element of the page
      confrimPasswordObj.classList.add('invalid-field');//Add red border and background to the 'pass-change-confirmpass' element of the page
      alert("Incorrect password format!\nPassword should consist of:\n- At least 1 uppercase letter\n- At least 1 digit\n- Minimum 8 characters");//Show error message
      return false;//Return false - validation unsuccessful
    }
  }else{
    newPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'pass-change-newpass' element of the page
    newPasswordObj.classList.add('invalid-field');//Add red border and background to the 'pass-change-newpass' element of the page
    confrimPasswordObj.classList.remove('valid-field');//Remove normal styling from the 'pass-change-confirmpass' element of the page
    confrimPasswordObj.classList.add('invalid-field');//Add red border and background to the 'pass-change-confirmpass' element of the page
    alert("Incorrect password format!\nPassword should consist of:\n- At least 1 uppercase letter\n- At least 1 digit\n- Minimum 8 characters");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

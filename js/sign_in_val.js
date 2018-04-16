function valEmailLog(){
  var email = document.forms["sign-in-f"]["email-address"].value;//Assign 'email-address' value from the sign in form to the 'email' variable
  const emailObj = document.getElementById("sign-in-email");//Declare a constant referring to the 'sign-in-email' input field object
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|edu|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;//Declare a regular expression to validate the email address (Upper and lower-case letters, numbers or special characters, followed by max. one '.', followed by upper and lower-case letters, numbers or special characters, followed by '@', followed by at least one LCase letter or number, followed by max. one '.', followed by exactly 2 lower-case letters or any of the allowed top-level domains)

  if (regex.test(email)){//If 'email' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    emailObj.classList.remove('valid-field');//Remove normal styling from the 'sign-in-email' element of the page
    emailObj.classList.add('invalid-field');//Add red border and background to the 'sign-in-email' element of the page
    alert("Incorrect email address!\nEnsure that it matches the format (domain names may differ):\nemailaddress@domain.com");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

function valPasswordLog(){
  var password = document.forms["sign-in-f"]["user-password"].value;//Assign 'user-password' value from the sign in form to the 'password' variable
  const passwordObj = document.getElementById("sign-in-password");//Declare a constant referring to the 'sign-in-password' input field object
  const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!#$%&'*+/=?^_-]{8,}$/;//Declare a regular expression to validate the password (At least one UCase letter and one digit, any amount of letter, digits and special characters, 8 or more characters long)

  if (regex.test(password)){//If 'password' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    passwordObj.classList.remove('valid-field');//Remove normal styling from the 'sign-in-password' element of the page
    passwordObj.classList.add('invalid-field');//Add red border and background to the 'sign-in-password' element of the page
    document.forms["sign-in-f"]["user-password"].value = "";//Reset the input field value
    alert("Incorrect password format!\nPassword should consist of:\n- At least 1 uppercase letter\n- At least 1 digit\n- Minimum 8 characters");//Show error
    return false;//Return false - validation unsuccessful
  }
}

//Validate contact message
function valContactMessage(){
  var message = document.forms["c-form"]["message-contact"].value;//Assign 'message-contact' value from the contact form to the 'message' variable
  const messageObj = document.getElementById("message-contact");//Declare a constant referring to the 'message-contact' input field object
  const regex = /^[a-zA-Z0-9!#$%&'*+,\./=?^_`{|}~-\s]{1,4000}$/;//Declare a regular expression to validate the contact message (UCase and LCase letters, digits and special characters, between 1 and 4000 characters long)

  if (regex.test(message)){//If 'message' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    messageObj.classList.remove('valid-field');//Remove normal styling from the 'message-contact' element of the page
    messageObj.classList.add('invalid-field');//Add red border and background to the 'message-contact' element of the page
    alert("Incorrect message input!\nEnsure that it's between 1 and 4000 characters");
    return false;//Return false - validation unsuccessful
  }
}

function valContactEmail(){
  var email = document.forms["c-form"]["email-contact"].value;//Assign 'email-contact' value from the contact form to the 'email' variable
  const emailObj = document.getElementById("email-contact");//Declare a constant referring to the 'email-contact' input field object
  const regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/;//Declare a regular expression to validate the email address (Upper and lower-case letters, numbers or special characters, followed by max. one '.', followed by upper and lower-case letters, numbers or special characters, followed by '@', followed by at least one LCase letter or number, followed by max. one '.', followed by exactly 2 lower-case letters or any of the allowed top-level domains)

  if (regex.test(email)){///If 'email' variable validation with the regex above is successful
    return true;//Return true
  }else{//If validation is unsuccessful
    emailObj.classList.remove('valid-field');//Remove normal styling from the 'email-contact' element of the page
    emailObj.classList.add('invalid-field-contact');//Add red border and background to the 'email-contact' element of the page
    alert("Incorrect email address!\nEnsure that it matches the format (domain names may differ):\nemailaddress@domain.com");//Show error message
    return false;//Return false - validation unsuccessful
  }
}

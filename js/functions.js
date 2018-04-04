/*$(window).scroll(function(){

  var wScroll= $(this).scrollTop();

  /*$('#header').css({
    'transform' : 'scale(0.'+ (1 + scroll/8) +',0.'+ (1 + wScroll/8) +')'
  })*/

//});

/*Open and close the booking form
–––––––––––––––––––––––––––––––––––––––––––––––––– */
//Open the booking form
function on() {
    document.getElementById("overlay").style.display = "flex";//Make booking form visible
}

//Close the booking form
function off() {
    //Set up an array with fields selectors
    var resetObjects = [document.getElementById("year-prod"),document.getElementById("booking-forename"),document.getElementById("booking-surname"),document.getElementById("booking-email"),document.getElementById("booking-phone-num"),document.getElementById("booking-addl1"),document.getElementById("booking-addl2"),document.getElementById("booking-city"),document.getElementById("booking-postcode"),document.getElementById("service-description")]

    document.getElementById("overlay").style.display = "none"; //Close the booking form

    //Reset the styling of the form fields
    for (i=0;i<10;i++){//Loop for all fields to be reset
      resetObjects[i].classList.remove("invalid-field");//Select item i from the array and remove invalid styling from it
      resetObjects[i].classList.add("valid-field");//Set the styling to standard for the item i
    }

    document.getElementById("b-form").reset(); //Reset the booking form
}

$(window).scroll(function(){

  var wScroll= $(this).scrollTop();

  /*$('#header').css({
    'transform' : 'scale(0.'+ (1 + scroll/8) +',0.'+ (1 + wScroll/8) +')'
  })*/

});

/*Open and close the booking form
–––––––––––––––––––––––––––––––––––––––––––––––––– */
function on() {
    document.getElementById("overlay").style.display = "flex";
}

function off() {
    //set up array with fields selectors
    var resetObjects = [document.getElementById("year-prod"),document.getElementById("booking-forename"),document.getElementById("booking-surname"),document.getElementById("booking-email"),document.getElementById("booking-phone-num"),document.getElementById("booking-addl1"),document.getElementById("booking-addl2"),document.getElementById("booking-city"),document.getElementById("booking-postcode"),document.getElementById("service-description")]

    document.getElementById("overlay").style.display = "none"; //close booking form

    //reset the styling of the form fields
    for (i=0;i<10;i++){
      resetObjects[i].classList.remove("invalid-field");
      resetObjects[i].classList.add("valid-field");
    }

    document.getElementById("b-form").reset(); //reset booking form
}

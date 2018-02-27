$(window).scroll(function(){

  var wScroll= $(this).scrollTop();

  /*$('#header').css({
    'transform' : 'scale(0.'+ (1 + scroll/8) +',0.'+ (1 + wScroll/8) +')'
  })*/

});

/*Open and close the booking form
–––––––––––––––––––––––––––––––––––––––––––––––––– */
function on() {
    document.getElementById("overlay").style.display = "flex"; //open booking form
}

function off() {
    document.getElementById("overlay").style.display = "none"; //close booking form
    document.getElementById("b-form").reset(); //reset booking form
}

$(window).scroll(function(){

  var wScroll= $(this).scrollTop();

  /*$('#header').css({
    'transform' : 'scale(0.'+ (1 + scroll/8) +',0.'+ (1 + wScroll/8) +')'
  })*/

});

function on() {
    document.getElementById("overlay").style.display = "flex";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}

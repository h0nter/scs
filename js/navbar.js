$(window).scroll(function(){

  var wScroll= $(this).scrollTop();

  console.log(wScroll);

  if (wScroll < $(window).height() - 400) {
    $('#home-nav').css({'color': '#5B0606'});
  }else{
    $('#home-nav').css({'color': 'white'});
  }

  if ((wScroll > ($('#about').offset().top - 400)) && (wScroll < ($('#about').offset().top + $('#about').height() - 350))) {
    $('#about-nav').css({'color': '#5B0606'});
  }else{
    $('#about-nav').css({'color': 'white'});
  }

  if ((wScroll > ($('#services').offset().top - 500)) && (wScroll < ($('#services').offset().top + $('#services').height() - 400))) {
    $('#services-nav').css({'color': '#5B0606'});
    $('#prices-nav').css({'color': '#5B0606'});
  }else{
    $('#services-nav').css({'color': 'white'});
    $('#prices-nav').css({'color': 'white'});
  }

  if ((wScroll > ($('#contact').offset().top - 550)) && (wScroll < ($('#contact').offset().top + $('#contact').height()))) {
    $('#contact-nav').css({'color': '#5B0606'});
  }else{
    $('#contact-nav').css({'color': 'white'});
  }

});

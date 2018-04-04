//Hihlight navigation bar elements on scroll
$(window).scroll(function(){//When user scrolls (up or down)

  var wScroll= $(this).scrollTop();//Assign the value of pixels from the top that user has scrolled

  //console.log(wScroll);//Output the wScroll value to the console - testing purpose

  if (wScroll < $(window).height() - 300) {//If scroll position on the website is less than height of the window - 300
    $('#home-nav').css({'color': '#5B0606'});//Change the color of the 'Home' button on the nav-bar to dark red
  }else{//If scroll position is different
    $('#home-nav').css({'color': 'white'});//Set the 'Home' button to white
  }

  if ((wScroll > ($('#about').offset().top - 400)) && (wScroll < ($('#about').offset().top + $('#about').height() - 350))) {//If scroll position on the website is between distance of top of the about section from the top of the page - 400 AND less than distance of the bottom of the about section from the top of the page - 350
    $('#about-nav').css({'color': '#5B0606'});//Change the color of the 'About' button on the nav-bar to dark red
  }else{//If scroll position is different
    $('#about-nav').css({'color': 'white'});//Set the 'About' button to white
  }

  if ((wScroll > ($('#services').offset().top - 500)) && (wScroll < ($('#services').offset().top + $('#services').height() - 400))) {//If scroll position on the website is between distance of top of the services section from the top of the page - 500 AND less than distance of the bottom of the services section from the top of the page - 400
    $('#services-nav').css({'color': '#5B0606'});//Change the color of the 'Services' button on the nav-bar to dark red
    $('#prices-nav').css({'color': '#5B0606'});//Change the color of the 'Prices' button on the nav-bar to dark red
  }else{//If scroll position is different
    $('#services-nav').css({'color': 'white'});//Set the 'Serivces' button to white
    $('#prices-nav').css({'color': 'white'});//Set the 'Prices' button to white
  }

  if ((wScroll > ($('#contact').offset().top - 550)) && (wScroll < ($('#contact').offset().top + $('#contact').height()))) {//If scroll position on the website is between the distance of top of the contact section from the top of the page - 550 AND less than distance of the bottom of the contac section from the top of the page
    $('#contact-nav').css({'color': '#5B0606'});//Change the color of the 'Contact' button on the nav-bar to dark red
  }else{//If scroll position is different
    $('#contact-nav').css({'color': 'white'});//Set the 'Contact' button to white
  }

});

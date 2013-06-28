
$(document).scroll(function() {

    if( $(this).scrollTop() > 2800 ) {	
    $('#login-mosaic').fadeIn(1000);
      $('#login-mosaic').css({display:'block',  position: 'fixed', left:0, top:50});
    }else if( $(this).scrollTop() < 2400 ) {
    $('#login-mosaic').css({display:'none',  position: 'fixed', left:0, top:50});
    }
    else{
    $('#login-mosaic').fadeOut(500);
    }

});

var h=10;

function ScaleMosaic(){
	h=$(document).width()/($('#pic1-1').width()+$('#pic1-2').width()+$('#pic1-3').width()+$('#pic1-4').width()+50);

$('#row1').css('height',$('#row1').height()*h);

$('#pic1-1').css('width',$('#pic1-1').width()*h);
$('#pic1-1').css('height',$('#pic1-1').height()*h);
$('#pic1-2').css('width',$('#pic1-2').width()*h);
$('#pic1-2').css('height',$('#pic1-2').height()*h);
$('#pic1-3').css('width',$('#pic1-3').width()*h);
$('#pic1-3').css('height',$('#pic1-3').height()*h);
$('#pic1-4').css('width',$('#pic1-4').width()*h);
$('#pic1-4').css('height',$('#pic1-4').height()*h);

h=$(document).width()/($('#pic2-1').width()+$('#pic2-2').width()+$('#pic2-3').width()+$('#pic2-4').width()+$('#pic2-5').width()+60);

$('#row2').css('height',$('#row2').height()*h);

$('#pic2-1').css('width',$('#pic2-1').width()*h);
$('#pic2-1').css('height',$('#pic2-1').height()*h);
$('#pic2-2').css('width',$('#pic2-2').width()*h);
$('#pic2-2').css('height',$('#pic2-2').height()*h);
$('#pic2-3').css('width',$('#pic2-3').width()*h);
$('#pic2-3').css('height',$('#pic2-3').height()*h);
$('#pic2-4').css('width',$('#pic2-4').width()*h);
$('#pic2-4').css('height',$('#pic2-4').height()*h);
$('#pic2-5').css('width',$('#pic2-5').width()*h);
$('#pic2-5').css('height',$('#pic2-5').height()*h);

h=$(document).width()/($('#pic3-1').width()+$('#pic3-2').width()+$('#pic3-3').width()+$('#pic3-4').width()+50);

$('#row3').css('height',$('#row3').height()*h);

$('#pic3-1').css('width',$('#pic3-1').width()*h);
$('#pic3-1').css('height',$('#pic3-1').height()*h);
$('#pic3-2').css('width',$('#pic3-2').width()*h);
$('#pic3-2').css('height',$('#pic3-2').height()*h);
$('#pic3-3').css('width',$('#pic3-3').width()*h);
$('#pic3-3').css('height',$('#pic3-3').height()*h);
$('#pic3-4').css('width',$('#pic3-4').width()*h);
$('#pic3-4').css('height',$('#pic3-4').height()*h);
}

$(document).ready(function() {
ScaleMosaic();
});

window.onresize = function() {
ScaleMosaic();
}

$(document).scroll(function() {

    if( $(this).scrollTop() > 2800 ) {	
    $('#login-mosaic').fadeIn(700);
      $('#login-mosaic').css({display:'block',  position: 'fixed', left:0, top:50});
    }else if( $(this).scrollTop() < 2400 ) {
    $('#login-mosaic').css({display:'none',  position: 'fixed', left:0, top:50});
    }
    else{
    $('#login-mosaic').fadeOut(400);
    }

});


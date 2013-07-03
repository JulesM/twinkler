 window.onload =function() {
	if ($(window).height()>$('#page-body').height())
	{
		document.getElementById('page-body').style.height = $(window).height()  + 'px';
		$('#content').css('height',$('#page-body').height()-$('#page-header').height());
	}
};
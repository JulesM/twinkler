

 window.onload =function() {
	if ($(window).height()>$('#page-body').height())
	{
		document.getElementById('page-body').style.height = $(window).height()  + 'px';
		$('#content').css('height',$('#page-body').height()-$('#page-header').height());
	}
};

 window.onresize =function() {
	if ($(window).height()>$('#page-body').height())
	{
		document.getElementById('page-body').style.height = $(window).height()  + 'px';
		$('#content').css('height',$('#page-body').height()-$('#page-header').height());
	}


};

/*--------CHARTS--------*/

var data = {
	labels : ["Julio","Nono","Tsonga","Guigui"],
	datasets : [
		{
			fillColor :["rgba(249,126,118,0.5)","rgba(168,189,68,0.5)","rgba(249,126,118,0.5)","rgba(168,189,68,0.5)"	],
			strokeColor : "rgba(220,220,220,1)",
			data : [-65,20,-90,81]
		}
	]
}





var ctx = document.getElementById("balanceChart").getContext("2d");
new Chart(ctx).Bar(data,{
    scaleOverlay : false,

	scaleShowLabels : false
});


/*--------DIV HEIGHTS----------*/
var max=Math.max($("#balance").height(),$("#expense-timeline").height());
$('#balance').css('height',max);
$('#expense-timeline').css('height',max);



var max=Math.max($("#balance").height(),$("#expense-timeline").height());



/*-------TOOLTIPS--------*/
    $(function () {
        $("[rel='tooltip']").tooltip({placement: 'bottom'});
    });



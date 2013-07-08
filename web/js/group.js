

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

var graphColor=function(graphData){
	var chartColor=[];
	for(var i=0; i<graphData.length;i++){
		if(graphData[i]>=0){
			chartColor.push("rgba(168,189,68,0.5)");
		}else{			
			chartColor.push("rgba(249,126,118,0.5)");
		}
	};
	return chartColor
}


var colorFill=graphColor(balances);



				var data = {
							labels : members,
							datasets : [
										{
											fillColor : colorFill,
											strokeColor : "rgba(220,220,220,1)",
											data : balances
										}
										]
									}


var ctx = document.getElementById("balanceChart").getContext("2d");
new Chart(ctx).Bar(data,{
    scaleOverlay : false,

	scaleShowLabels : false
});


/*--------DIV HEIGHTS----------*/

/*-------TOOLTIPS--------*/
    $(function () {
        $("[rel='tooltip']").tooltip({placement: 'top'});
    });


/*-------Accordion--------*/




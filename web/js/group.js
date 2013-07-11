
/*--------CHARTS & TIMLINE SIZE--------*/

var members_nb= members.length;
 window.onload =function() {

	$('#timeline').height(Math.max($('#balance-expense-container').height(),$('#timeline-expense-container').height())-65+'px');

	if($('#balanceChart').width()>$('#balance').width()){
		$('#balanceChart').width($('#balance').width());
		}else{
		$('#balanceChart').width(members_nb*100 + 'px');}
}

 window.onresize =function() {

	$('#timeline').height(Math.max($('#balance-expense-container').height(),$('#timeline-expense-container').height())-65+'px');
}


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


/*-------TOOLTIPS--------*/
    $(function () {
        $("[rel='tooltip']").tooltip({placement: 'top'});
    });


/*-------Pinpoint buttons on timeline (date)--------*/

     $('.pinpoint-button').hover(function () {
        this.src = 'http://twinkler.co/img/frame/tmln-btn-hover.png';
    }, function () {
        this.src = 'http://twinkler.co/img/frame/tmln-btn.png';
    });

var today=new Date();
var dd=today.getDate();
var mm=today.getMonth()+1;

if(dd<10){dd='0'+dd};
 if(mm<10){mm='0'+mm};

$('#today-pinpoint').attr('title', dd +"/"+mm);





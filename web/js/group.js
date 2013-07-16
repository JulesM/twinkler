
/*--------CHARTS & TIMLINE SIZE--------*/
var activePage = document.URL.split("/").pop();
var members_nb= members.length;
var navbarHeight=$("#navbar-row").height();

 window.onload =function() {
	$("#navbar-"+activePage).addClass("navbar-item");
	$('#timeline').height(Math.max($('#balance-expense-container').height(),$('#timeline-expense-container').height())-65+'px');
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

var members_chart=[];
for (var i = 0; i < members.length; i++) {
	members_chart[i]='';

}


var colorFill=graphColor(balances);
var data = {
			labels : members_chart,
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


/*-------labels------*/
$('#chart-labels').width($('#balanceChart').width());
		for(var i=0; i<members.length;i++){
			if (activePage==="expenses"){
				if (balances[i]>=0){
				var column_member="<td style='width:70px; min-width:70px; color:#A8BD44; vertical-align:top;overflow: hidden; padding:0'> <div>"+ members[i]+" </td>	";			
				var column_balance="<td style='width:70px; min-width:70px; color:#A8BD44; vertical-align:top;overflow: hidden; padding:0'> "+ balances[i]+currency+" </td>	";
				}else{

				var column_member="<td style='width:70px; min-width:70px; color:#F97E76;vertical-align:top;overflow: hidden; padding:0'> "+ members[i]+" </td>	";			
				var column_balance="<td style='width:70px; min-width:70px; color:#F97E76;vertical-align:top;overflow: hidden; padding:0'> "+ balances[i]+currency+" </td>	";

				}
			}else{
				if (balances[i]>=0){
				var column_member="<td style='width:100px; color:#A8BD44;vertical-align:top;'> "+ members[i]+" </td>	";			
				var column_balance="<td style='width:100px; color:#A8BD44;vertical-align:top;'> "+ balances[i]+currency+" </td>	";
				}else{

				var column_member="<td style='width:100px; color:#F97E76;vertical-align:top;'> "+ members[i]+" </td>	";			
				var column_balance="<td style='width:100px; color:#F97E76;vertical-align:top;'> "+ balances[i]+currency+" </td>	";

				}

			}


			$('#member-row').append(column_member);
			$('#balance-row').append(column_balance);
	};





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


/*----chart scroll-----*/
$(document).ready(

  function() { 

    $("#balance-slimscroll").niceScroll();

  }

);

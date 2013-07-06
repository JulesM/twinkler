

var tracker = 1
$("#accordion-arrow").click(function(){ 

            if(tracker===2){
                $(this).rotate({animateTo:90});
                tracker =1;
            }else{
                $(this).rotate({animateTo:0});
                tracker =2;
            }
    
   
});

$(".accordion-group-title").accordion({collapsible: true, active:false});
$(document).ready(function(){
	$(".green, .yellow, .red, .blue, .purple").mouseover(function(){
		var count = this.childElementCount;
		var actualheight = 50*count+"px";
		$(this).stop().animate({height:actualheight},{queue:false,duration:600,easing:'easeOutBounce'});
	});
	
	$(".green, .yellow, .red, .blue, .purple").mouseout(function(){
	$(this).stop().animate({height:'50px'},{queue:false,duration:600,easing:'easeOutBounce'});
	});
});
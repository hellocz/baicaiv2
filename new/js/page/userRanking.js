$(function(){
	// tabClass(".tabBox li","li","active",".urlistBox",".urlist");
	
	$(".selected").find("li").click(function(){
		$(this).siblings("li").removeClass("active");
		$(this).addClass("active");
	});
});
$(function(e) {
	//置顶区切换特效
	$(".articlesHot").Xslider({
		unitdisplayed: 1,
		numtoMove: 1,
		speed: 300,
		scrollobj:".hot-box",
		scrollobjSize: Math.ceil($(".hot-box").children("li.hot-list").length / 1) * 904,
//		loop:"cycle",
	});
	radio();
	select("#select-1");
	select("#select-2");
	tabSub(".tabNav",".listBox",".listItem");
	ButtonTabs(".hotNew span","active");
	
	pages("pages-circleAll");
	pages("pages-circleSd");
	pages("pages-circleJy");
	pages("pages-circleZx");
	pages("pages-circleHt");
	pages("pages-circleZz");
	
	$(".tabNav li").click(function(){
		var huati_display = $('#huati').css('display');
		var zuozhe_display = $('#zuozhe').css('display');
		if(huati_display == 'block' || zuozhe_display == 'block'){
			$(".select-2").hide();
			$(".hotNew").show();
			$(".radio-1").hide();
		}else{
			$(".select-2").show();
			$(".hotNew").hide();
			$(".radio-1").show();
		}
	});
});
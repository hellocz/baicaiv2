$(function(){
	$(".sidebar-mall").css("right",($(document.body).width() - 1200)/2-56);
	mallClick(".title-box",".list-box",".sidebar-mall")
	mallClick(".sidebar-mall",".list-box",".title-box")
	
	//滚动条计算右边悬浮菜单
	$(window).on('scroll',function(){
		var a = ".title-box";
		var b = ".list-box";
		var c = ".sidebar-mall";
		var $scroll=$(this).scrollTop();
		$(b).find(".list").each(function(index){
			var d = $(this).offset().top;
			if(d > $scroll){//妤煎眰鐨則op澶т簬婊氬姩鏉＄殑璺濈
				$(c).find("a").removeClass("active");
				$(c).find('a:eq('+index+')').addClass("active");
				
				$(a).find("a").removeClass("active");
				$(a).find('a:eq('+index+')').addClass("active");
				return false;
			}
		});
	});
});

//点击字母滚动到相应位置
function mallClick(a,b,c){
	$(a).find("a").click(function() {
		var i = $(this).index();
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
		$(c).find("a").siblings().removeClass("active");
		$(c).find('a:eq('+i+')').addClass("active");
		$("html,body").animate({
			scrollTop: $(b).find('.list:eq('+i+')').offset().top - 60
		},100);
	});
}
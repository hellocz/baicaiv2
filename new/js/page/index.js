$(function(e) {
	//置顶区切换特效
	$(".i-atop").Xslider({
		unitdisplayed: 1,
		numtoMove: 1,
		speed: 300,
		scrollobj:".atop-box",
		scrollobjSize: Math.ceil($(".atop-box").children("li.i-list1").length / 1) * 896,
//		loop:"cycle",
	});
	
	//最新优惠tab菜单
	$("#i-news-title li").click(function(){
		var ethis = $("#i-news-title li");
		ethis.removeClass("fc-green font-w-b");
		$(this).addClass("fc-green font-w-b");
		$(".i-new-list").find("ul").stop().hide();
		$("#tab" + (ethis.index(this)+1)).show();
	});
	
	
	//瀑布流与横向排列切换特效
	$("#arr1").click(function(){
//  	var ii = layer.load(1,{
//			shade: [0.3,'#000'],
//			shadeClose : true
//		});
    	setTimeout(function(){
    		$("#arr1").removeClass("no");
			$("#arr2").addClass("no1");
			$(".i-list").find("li").css("width","286.66px");
			$(".i-list").find("li").removeClass("transverse clearfix");
			$(".i-list").find("li").addClass("fl flow");
			$(".i-list").find("li").children(".user").show();
//  		layer.close(ii);
    	}, 0);
	});
	$("#arr2").click(function(){
//		var ii = layer.load(1,{
//			shade: [0.3,'#000'],
//			shadeClose : true
//		});
    	setTimeout(function(){
    		$("#arr2").removeClass("no1");
    		$("#arr1").addClass("no");
    		$(".i-list").find("li").css("width","856px");
    		$(".i-list").find("li").removeClass("fl flow");
    		$(".i-list").find("li").addClass("transverse clearfix");
    		$(".i-list").find("li").children(".user").hide()
//  		layer.close(ii);
    	}, 0);
	});
	
	//卡片位向上滑出特效
	$(".i-list").find(".flow").hover(function(){
		$(this).find(".info-box").stop().slideDown("show");
	},function(){
		$(this).find(".info-box").hide();
	});
	
	
});


$(document).ready(function() {
	var navOffset = $("#news-tab").offset().top;
	$(window).scroll(function() {
		var scrollPos = $(window).scrollTop();
		if(scrollPos >= navOffset) {
			$("#news-tab").addClass("fixed");
		} else {
			$("#news-tab").removeClass("fixed");
		}
	});
	
	var navOffset1 = $("#right-ad").offset().top;
	$(window).scroll(function() {
		var scrollPos = $(window).scrollTop();
		if(scrollPos >= navOffset1) {
			$("#right-ad").addClass("fixed1");
		} else {
			$("#right-ad").removeClass("fixed1");
		}
	});
});

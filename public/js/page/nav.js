$(document).ready(function() {
	
	//顶部导航菜单
	var subleft = $(document.body).width();
		subleft = ($(document.body).width() - 1200)/2;
//		console.log(subleft)
	$('.nav-box > ul > li').hover(function() {
		/*图标向上旋转*/
		unScroll();
		$(this).find("i").removeClass().addClass('hover-up');
		$(this).find(".sub").css("left", subleft);
		$(this).find(".triangle_border_up").show();
		$(this).find(".sub").show();
		$("body").append('<div id="mark"></div>');
	}, function() {
		/*图标向下旋转*/
		$(this).find("i").removeClass().addClass('hover-down');
		$(this).find(".triangle_border_up").hide();
		$(this).find(".sub").hide();
		$("#mark").remove();
		removeUnScroll();
	});
	
	$(window).scroll(function () {
		if ($(window).scrollTop() >= 90) {
			$("#header").css({
				"height":"54px",
			});
			$("#header .top .nav-box .nav").css({
				"height":"54px",
				"line-height":"54px",
			});
			$(".newMsg").css({
				"top":"54px",
			});
			$("#header .top #logo").hide();
			$("#header .top .index").show();
			$("#header .top .top-search").css("margin-top","8px");
			$("#header .top .top-right").css("margin-top","8px");
			$("#header .top .top-right .arrow_up").css("margin-top","9px");
			$("#header .top .top-right .member-info .arrow_up").css("margin-top","2px");
		} else {
			$("#header").css({
				"height":"90px",
			});
			$(".newMsg").css({
				"top":"90px",
			});
			$("#header .top .nav-box .nav").css({
				"height":"90px",
				"line-height":"90px",
			});
			$("#header .top #logo").show();
			$("#header .top .index").hide();
			$("#header .top .top-search").css("margin-top","26px");
			$("#header .top .top-right").css("margin-top","26px");
			$("#header .top .top-right .arrow_up").css("margin-top","27px");
			$("#header .top .top-right .member-info .arrow_up").css("margin-top","20px");
		}
	});
	
	//下拉菜单内容
	
	/*下拉内容里的菜单切换*/
	subTab("yh");
	subTab("fenlei");
	subTab("gd");
//	$(".l-tab > p").hover(function(){
//		var ethis = $(".l-tab p");
////		console.log((ethis.index(this)+1))
//		$(".l-tab").find("p").removeClass('active');
//		$(this).addClass('active');
//		$(".info").find("ul").hide();
//		$("#tab-list-" + (ethis.index(this)+1)).show();
//	});
//	
//	$(".t-tab .cd").hover(function(){
//		$(".t-tab .cd").removeClass("active");
//		$(this).addClass("active");
//	});
	
	/*商场*/
	
	
	$('.r-sub').hover(function() {
		/*图标向上旋转*/
		$(this).find("i").removeClass().addClass('hover-up');
		unScroll();
		$(this).children('.arrow_up').show();
		$(this).children('.sub-box').show();
		$("body").append('<div id="mark"></div>');
	}, function() {
		/*图标向下旋转*/
		$(this).find("i").removeClass().addClass('hover-down');
		$(this).children('.arrow_up').hide();
		$(this).children('.sub-box').hide();
		$("#mark").remove();
		removeUnScroll();
	});
	
	/*顶部其他下拉菜单*/
	
	
	// /*顶部显示/隐藏登录或用户信息*/
	// $("#login").click(function(){
	// 	$(".member-info").show();
	// 	$(".member-btn").hide();
	// 	$(".i-member .login").hide();
	// 	$(".i-member .info").show();
	// 	$(".yjr").toggle();
	// 	$(".wjr").toggle()
	// });
	// $("#outlogin").click(function(){
	// 	$(".member-info").hide();
	// 	$(".member-btn").show();
	// 	$(".i-member .login").show();
	// 	$(".i-member .info").hide();
	// 	$(".yjr").toggle()
	// 	$(".wjr").toggle();
	// });
});

//禁止滚动条滚动
function unScroll() {
    var top = $(document).scrollTop();
    $(document).on('scroll.unable',function (e) {
        $(document).scrollTop(top);
    })
}

//释放滚动条滚动
function removeUnScroll() {
    $(document).unbind("scroll.unable");
}


//顶部子菜单切换选项内容
function subTab(tabClass){
//	console.log("." + tabClass + " > .l-tab > p")
	$("." + tabClass + " > .l-tab > p").hover(function(){
		var tab = "#" + tabClass + "-list-"
		var ethis = $("." + tabClass + " > .l-tab p");
//		console.log((ethis.index(this)+1))
		$("." + tabClass + " .l-tab").find("p").removeClass('active');
		$(this).addClass('active');
//		console.log(tab + (ethis.index(this)+1))
		$("." + tabClass + " .info").children("ul").hide();
		$(tab + (ethis.index(this)+1)).show();
	});
	
	$("." + tabClass + " .t-tab span").hover(function(){
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
		$(this).parent().find(".d-tab").hide();
		$(this).parent().find(".d-tab").eq($(this).index()-1).show();
	});

	$("." + tabClass + " .d-tab span").hover(function(){
		$("." + tabClass + " .d-tab span").removeClass("active");
		$(this).addClass("active");
	});
}



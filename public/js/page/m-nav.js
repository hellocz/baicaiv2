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
	
	/*下拉内容里的菜单切换*/
	subTab("yh");
	subTab("fenlei");
	subTab("gd");
	
	
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
		$("." + tabClass + " .t-tab span").removeClass("active");
		$(this).addClass("active");
	});
}



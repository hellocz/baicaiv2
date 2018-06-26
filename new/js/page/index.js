$(function(e) {
	//置顶区切换特效
	$(".i-atop").Xslider({
		unitdisplayed: 1,
		numtoMove: 1,
		speed: 300,
		scrollobj:".atop-box",
		scrollobjSize: Math.ceil($(".atop-box").children("li.atop-list").length / 1) * 896,
//		loop:"cycle",
	});
	
	// //最新优惠tab菜单
	// $("#i-news-title li").click(function(){
	// 	var ethis = $("#i-news-title li");
	// 	ethis.removeClass("fc-green font-w-b");
	// 	$(this).addClass("fc-green font-w-b");
	// 	$(".i-new-list").find("ul").stop().hide();
	// 	$("#tab" + (ethis.index(this)+1)).show();
	// });
	
	function setCookie(name,value)
	{
	var Days = 30;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
	}
	function getCookie(name)
	{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	return unescape(arr[2]);
	else
	return null;
	}
	function delCookie(name)
	{
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval=getCookie(name);
	if(cval!=null)
	document.cookie= name + "="+cval+";expires="+exp.toGMTString();
	}
	
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
			delCookie('dss');
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
    		$(".i-list").find("li").children(".user").hide();
    		setCookie('dss', 'lb');
//  		layer.close(ii);
    	}, 0);
	});
	
	//卡片位向上滑出特效
	$(".i-list").find(".flow").hover(function(){
		$(this).find(".info-box").stop().slideDown("show");
	},function(){
		$(this).find(".info-box").hide();
		$(this).find(".moreUrl").hide();
	});


	//滚动后置顶菜单
	navFixed("news-tab","fixed");
	navFixed("right-ad","fixed1");
	
	moreUrl(".cz2 .btn-more",".moreUrl");
	moreUrl(".moreLink .btn-gd",".moreUrl");
});

//layui分页插件
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	//总页数大于页码总数
	laypage.render({
		elem: 'pages-index'
		,count: 70 //数据总数
		,jump: function(obj){
//			console.log(obj)
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
});

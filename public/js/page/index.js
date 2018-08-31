$(function(e) {
	//置顶区切换特效
	$(".i-atop").Xslider({
		unitdisplayed: 4,
		numtoMove: 4,
		unitlen: 212+12,
		speed: 300,
		scrollobj:".atop-box",
		// scrollobjSize: Math.ceil($(".atop-box").children("li.atop-list").length / 1) * 896,
		// loop:"cycle",
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
		$(this).find(".moreUrl").hide();
	});


	//滚动后置顶菜单
	navFixed("news-tab","fixed");
	navFixed("right-ad","fixed1");
	
	moreUrl(".cz2 .btn-more",".moreUrl");
	moreUrl(".moreLink .btn-gd",".moreUrl");
	
	// //最新消息调用此方法即可
	// newMsg();
});

//layui分页插件
layui.use(['element','laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer
	,element = layui.element;
	//总页数大于页码总数
	laypage.render({
		elem: 'pages-index'
		,count: 70 //数据总数
		,jump: function(obj,first){
//			console.log(obj)
			if(!first){
				$(".page-loading").show();
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
});

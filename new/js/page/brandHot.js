//layui分页插件
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	//总页数大于页码总数
	laypage.render({
		elem: 'pages-brand'
		,count: 70 //数据总数
		,jump: function(obj){
//			console.log(obj)
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
});

$(function(){
	hoverMore();
	clickMore();
});

function hoverMore(){
	$(".brandHot .item").hover(function(){
		var a = $(this).find(".list-box");
		if(a.is(":hidden")){
			$(this).find(".hover-more").show();
		}
	},function(){
		$(this).find(".hover-more").hide();
		$(this).find(".list-box").hide();
	});
}

function clickMore(){
	$(".item .hover-more").click(function(){
		$(this).siblings(".list-box").show();
		var a = $(this);
		setTimeout(function(){
			a.hide();
		},0)
	});
}

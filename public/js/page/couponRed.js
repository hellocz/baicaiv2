//layui分页插件
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	
	//卖的最好分页
	laypage.render({
		elem: 'pages-mdzh'
		,count: 70 //数据总数
		,jump: function(obj,first){
//			console.log(obj)
			if(!first){
				$("#pages-mdzh").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-mdzh").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//价格最低分页
	laypage.render({
		elem: 'pages-jgzd'
		,count: 70 //数据总数
		,jump: function(obj,first){
//			console.log(obj)
			if(!first){
				$("#pages-jgzd").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-jgzd").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//优惠最大分页
	laypage.render({
		elem: 'pages-yhzd'
		,count: 70 //数据总数
		,jump: function(obj,first){
//			console.log(obj)
			if(!first){
				$("#pages-yhzd").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-yhzd").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//折扣最高分页
	laypage.render({
		elem: 'pages-zkzg'
		,count: 70 //数据总数
		,jump: function(obj,first){
//			console.log(obj)
			if(!first){
				$("#pages-zkzg").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-zkzg").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
});

$(function(){
	tabClass(".cr-tab li","li","active",".cr-list",".list-box");
});
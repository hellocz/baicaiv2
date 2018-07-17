// $(function(){
// 	tabClass(".tabBox li","li","active",".uhList",".list");
// });

//layui分页插件
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	
	//动态分页
	laypage.render({
		elem: 'pages-userdt'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-userdt").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-userdt").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//原创分页
	laypage.render({
		elem: 'pages-useryc'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-useryc").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-useryc").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//爆料分页
	laypage.render({
		elem: 'pages-userbl'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-userbl").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-userbl").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//投票分页
	laypage.render({
		elem: 'pages-usertp'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-usertp").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-usertp").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//评论分页
	laypage.render({
		elem: 'pages-userpl'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-userpl").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-userpl").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//邀请分页
	laypage.render({
		elem: 'pages-useryq'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-useryq").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-useryq").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//收藏分页
	laypage.render({
		elem: 'pages-usersc'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-usersc").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-usersc").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//关注分页
	laypage.render({
		elem: 'pages-usergz'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-usergz").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-usergz").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
});
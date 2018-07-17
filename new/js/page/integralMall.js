$(function(){
	inTab();
});

//layui分页插件
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	
	//积分抽奖分页
	laypage.render({
		elem: 'pages-incj'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-incj").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-incj").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//积分兑换分页
	laypage.render({
		elem: 'pages-indh'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-indh").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-indh").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
});

function inTab(){
	$(".title").find("span").click(function(){
		$(this).parent().find("span").removeClass("active");
		$(this).addClass("active");
		$(".listBox").find(".listItem").stop().hide();
		var thisIndex = $(this).parent().find("span").index(this);
		$(".listBox .listItem").eq(thisIndex).show();
		var info = $(this).text();
		if(info =="积分兑换"){
			$("#mydh").show();
			$("#mycj").hide();
			$("#newlist").hide();
		}else{
			$("#mydh").hide();
			$("#mycj").show();
			$("#newlist").show();
		}
	});
}
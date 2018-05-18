/*
 * 引入layui框架
 * 以下依赖不可删除否则会出错
 * 具体框架用法可访问layui官网查看
 * */

//layui分页插件
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	//总页数大于页码总数
	laypage.render({
		elem: 'demo-page'
		,count: 70 //数据总数
		,jump: function(obj){
//			console.log(obj)
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
});

//layui选项卡插件
layui.use('element', function(){
	var element = layui.element;
});


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

//layui表单插件
layui.use('form', function(){
  var form = layui.form;
  //各种基于事件的操作，下面会有进一步介绍
  //监听提交
  // form.on('submit(formDemo)', function(data){
  //   layer.msg(JSON.stringify(data.field));
  //   return false;
  // });
});

$(function(){
	//搜索显示更多的商场
	$(".check-more").click(function(){
		$(this).hide();
		$("#checkMore").show();
	});
	//tab菜单切换
	// tabClass(".r-list-box .tabNav a","a","active",".r-list-box",".list-box");
	// select(".operation",1);
	arrClick(".item",".cross",".vertical");
	crossUp(".cross",".infoBox");
	treeNav(".treeNav ul span");
	moreUrl(".cz2 .btn-more",".moreUrl");
	
	
	$(".operation").find(".z-new").click(function(){
		$(".operation").find(".z-new").removeClass("z-active");
		$(this).addClass("z-active");
	});
});
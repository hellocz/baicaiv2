$(function(e) {
	// tabSub(".tabNav",".rightInfo",".listBox");
	// pages("pages-rz");
	$('#pages').length && ajaxPages('pages', page, content);
	
	// $("#user").load("../public/user-m.html");
});

//注意进度条依赖 element 模块，否则无法进行正常渲染和功能性操作
layui.use('element', function(){
  var element = layui.element;
});
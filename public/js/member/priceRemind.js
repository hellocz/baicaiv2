$(function(e) {
	// pages("pages-gz");
	ajaxPages('pages', page, content);
	// $("#user").load("../public/user-m.html");
	
	//编辑显示
	$(".item .bj .bt1").click(function(){
		$(".edit").hide();
		$(this).siblings(".edit").show();
		$(this).siblings(".edit").find(".qx").click(function(){
			$(this).parents(".edit").hide();
		});
		$(this).siblings(".edit").find(".btn-3").click(function(){
			$(this).parents(".edit").hide();
		});
		
		$(document).click(function(event){
			var _con = $(".item .bj");
			if(!_con.is(event.target) && _con.has(event.target).length === 0){
				$(".edit").hide();
			}
		});
	});
});

//layui表单插件
layui.use('form', function(){
  var form = layui.form;
  //各种基于事件的操作，下面会有进一步介绍
  //监听提交
  form.on('submit(formDemo)', function(data){
    layer.msg(JSON.stringify(data.field));
    return false;
  });
});
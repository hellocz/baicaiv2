$(function(e) {
	tabSub(".tabNav",".information",".infoList");
	
	//邮箱验证码刷新
	$('#J_captcha_img_email').click(function(){
		var timenow = new Date().getTime(),
		url = $(this).attr('data-url').replace(/js_rand/g,timenow);
		$(this).attr("src", url);
	});
	$('#J_captcha_change_email').click(function(){
		$('#J_captcha_img_email').trigger('click');
	});
	//手机验证码刷新
	$('#J_captcha_img').click(function(){
		var timenow = new Date().getTime(),
		url = $(this).attr('data-url').replace(/js_rand/g,timenow);
		$(this).attr("src", url);
	});
	$('#J_captcha_change').click(function(){
		$('#J_captcha_img').trigger('click');
	});
	
});

//修改操作--修改用户名、签名等
function modifyBtn(id){
	$("#"+id).hide();
	$("#"+id).siblings("div").show();
}
//保存操作--保存用户名、签名等
function saveBtn(id){
	$("#"+id).show();
	$("#"+id).siblings("div").hide();
}
//取消操作--取消用户名、签名等
function cancelBtn(id){
	$("#"+id).show();
	$("#"+id).siblings("div").hide();
}

//显示/隐藏编辑地址
function modifyAddress(type){
	var show = $(".addressModify");
	if(type==1){
		show.show();
	}else{
		show.hide();
	}
}
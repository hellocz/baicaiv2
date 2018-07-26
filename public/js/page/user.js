layui.use('layer', function(){
	var layer = layui.layer;
});
//弹出对话层
function dialogPopup(content){
	layer.open({
		type: 1,
		title: false,
		closeBtn: 1,
		shadeClose: false,
		shade:0.7,
		anim:2,
		skin: 'loginPopup',
		area: '430px',
		content: content //html or $('#id')
	});
}

function tipsShow(msg, input){
	layer.tips(msg, input, {
		tips: [2, '#33CC99'],
		time: 2000
	});
}

$(".protocol").on("click", function(){
	dialogPopup($('#J_protocol'));
});

function ajaxCheck(type, value) {
	var result = false;

	$.ajax({
		type: 'GET',
		url: '/?m=user&a=ajax_check&type='+type+'&'+type+'='+value,
		data:{},
		dataType: 'json',
		async: false, //同步
		cache: false,
		success: function (res) {
			if(res.status == 0){
				result = 1; //存在
			}else{
				result = 0; //不存在
			}
		}
	});

	return result;
}

function ajaxSubmit(form) {
	var result = false;

	$.ajax({
		type: 'POST',
		url: form.attr("action"),
		data:form.serialize(),
		dataType: 'json',
		async: false, //同步
		cache: false,
		success: function (res) {
			result = res
		}
	});

	return result;
}

function phoneSend(id) {

	var mobile = $("#"+id).val();

	var re = /^1\d{10}$/
	if(mobile.length == 0){
		tipsShow('手机号不能为空', '#'+id);
		return false;
	}else if(!re.test(mobile)){
		tipsShow('手机号必须是11位数字', '#'+id);
		return false;
	}

	var check = false;

	$.ajax({
		type: 'POST',
		url: '/index.php?m=user&a=phone_send',
		data:{mobile:mobile},
		dataType: 'json',
		async: false, //同步
		cache: false,
		success: function (result) {
			if(result.status == 0){
				// $(".msg").text(result.msg);
				tipsPopup('tips_1', result.msg);
				check = true;
			}else{
				tipsShow(result.msg, '#'+id);
			}
		}
	});

	return check;
}

//用户名密码登录表单验证
$("#J_login_btn1").on('click', function(){
	var username = $("#username1").val();
	var password = $("#password1").val();
	
	if(username.length == 0){
		tipsShow('用户名/手机号/邮箱不能为空', '#username1');
		return false;
	}else if(password.length == 0){
		tipsShow('密码不能为空', '#password1');
		return false;
	}

	if($(this).is('div')){
		//该按钮为div, AJAX提交
		result = ajaxSubmit($("#J_login_form1"));
		if(result.status == 1){
			//成功
			tipsPopup('tips_1', result.msg);
			window.location.reload();
			return true;
		}else{
			tipsShow(result.msg, '#password1');
			return false;
		}
	}else{
		//该按钮为submit button
		return true;
	}
});

//手机验证码登录表单验证
$("#J_login_btn2").on('click', function(){
	var mobile = $("#mobile2").val();
	var phone_verify = $("#phone_verify2").val();

	var re = /^1\d{10}$/
	if(mobile.length == 0){
		tipsShow('手机号不能为空', '#mobile2');
		return false;
	}else if(!re.test(mobile)){
		tipsShow('手机号必须是11位数字', '#mobile2');
		return false;
	}else if(phone_verify.length == 0){
		tipsShow('手机验证码不能为空', '#phone_verify2');
		return false;
	}

	if($(this).is('div')){
		//该按钮为div, AJAX提交
		result = ajaxSubmit($("#J_login_form2"));
		if(result.status == 1){
			//成功
			tipsPopup('tips_1', result.msg);
			window.location.reload();
			return true;
		}else{
			tipsShow(result.msg, '#phone_verify2');
			// tipsPopup('tips_2', result.msg);
			return false;
		}
	}else{
		//该按钮为submit button
		return true;
	}
});

function changeType(type){
	if(type==1){
		$("#type1").show();
		$("#type2").hide();
	}else if(type==2){
		$("#type1").hide();
		$("#type2").show();
	}
}

//用户注册表单验证
$("#J_register_btn3").on('click', function(){
	var mobile = $("#mobile3").val();
	var phone_verify = $("#phone_verify3").val();
	var username = $("#username3").val();
	var password = $("#password3").val();
	

	var re = /^1\d{10}$/
	if(mobile.length == 0){
		tipsShow('手机号不能为空', '#mobile3');
		return false;
	}else if(!re.test(mobile)){
		tipsShow('手机号必须是11位数字', '#mobile3');
		return false;
	}else if(phone_verify.length == 0){
		tipsShow('手机验证码不能为空', '#phone_verify3');
		return false;
	}else if(username.length == 0){
		tipsShow('用户名/手机号/邮箱不能为空', '#username3');
		return false;
	}else if(password.length == 0){
		tipsShow('密码不能为空', '#password3');
		return false;
	}

	result = ajaxCheck('mobile', mobile);
	if(result == 1){
		tipsShow('该手机号已注册', '#mobile3');
		return false;
	}

	result = ajaxCheck('username', username);
	if(result == 1){
		tipsShow('这个用户名已经被别人抢走啦，换一个吧', '#username3');
		return false;
	}

	if($(this).is('div')){
		//该按钮为div, AJAX提交
		result = ajaxSubmit($("#J_register_form3"));
		if(result.status == 1){
			tipsPopup('tips_1', result.msg);
			window.location.reload();
			return true;
		}else{
			tipsPopup('tips_2', result.msg);
			return false;
		}
	}else{
		//该按钮为submit button
		return true;
	}
});

//验证码刷新
$('#J_captcha_img').click(function(){
	var timenow = new Date().getTime(),
	url = $(this).attr('data-url').replace(/js_rand/g,timenow);
	$(this).attr("src", url);
});
$('#J_captcha_change').click(function(){
	$('#J_captcha_img').trigger('click');
});

//找回密码表单验证
$("#J_findpwd_btn").on('click', function(){
	var mobile = $("#mobile").val();
	var phone_verify = $("#phone_verify").val();
	var captcha = $("#captcha").val();
	
	var re = /^1\d{10}$/
	if(mobile.length == 0){
		tipsShow('手机号不能为空', '.input3');
		return false;
	}else if(!re.test(mobile)){
		tipsShow('手机号必须是11位数字', '.input3');
		return false;
	}else if(phone_verify.length == 0){
		tipsShow('手机验证码不能为空', '.input4');
		return false;
	}else if(captcha.length == 0){
		tipsShow('图片验证码不能为空', '.input5');
		return false;
	}

	return true;
});

//重置密码表单验证
$("#J_resetpwd_btn").on('click', function(){
	var newPassword = $("#newPassword").val();
	var confirmPassword = $("#confirmPassword").val();
	
	if(newPassword.length == 0){
		tipsShow('新密码不能为空', '#a1');
		return false;
	}else if(confirmPassword.length == 0){
		tipsShow('确认新密码不能为空', '#a2');
		return false;
	}else if(newPassword !== confirmPassword){
		tipsShow('两次密码不一致', '#a1');
		return false;
	}

	return true;
});
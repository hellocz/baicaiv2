$(function(e) {
	// tabSub(".tabNav",".information",".infoList");
	
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

	var index_email = null, index_mobile = null;

	//点击修改邮箱按钮
	$('.J_email_btn').click(function(){
		//验证码刷新
		$('#J_captcha_img_email').trigger('click');
		$("input[name=email]").val('');
		$("#captcha_email").val('');
		index_email = dialogPopup($('#modifyEmail'),'450px');
	});
	$('.J_email_submit').click(function(){
		var url = $(this).data('url');
		var email = $("input[name=email]").val(); //要验证的对象
		var captcha = $("#captcha_email").val();

		var reg = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$"); //正则表达式
		if(email == ""){ //输入不能为空
			tipsShow('请输入邮箱地址', "input[name=email]");
			return false;
		}else if(!reg.test(email)){ //正则验证不通过，格式不对
			tipsShow('邮箱地址格式不正确，请重新输入', "input[name=email]");
			return false;
		}else if(captcha.length == 0){
			tipsShow('图片验证码不能为空', '.input_email');
			return false;
		}

		$.post(url,{data:email,captcha:captcha},function(result){
			layer.msg(result.msg,{time: 2000});
			if(result.status == 1){
				$('.J_email').html(result.data);
				layer.close(index_email);
			}
		},'json');		
	});

	//点击修改手机按钮
	$('.J_mobile_btn').click(function(){
		//验证码刷新
		$('#J_captcha_img').trigger('click');
		$("input[name=mobile]").val('');
		$("#captcha_mobile").val('');
		$("#phone_verify").val('');
		index_mobile = dialogPopup($('#modifyPhone'),'450px');
	});
	$('.J_mobile_submit').click(function(){
		var url = $(this).data('url');
		var mobile = $("input[name=mobile]").val(); //要验证的对象
		var captcha = $("#captcha_mobile").val();
		var phone_verify = $("#phone_verify").val();

		var reg = new RegExp("^1[0-9]{10}$"); //正则表达式
		if(mobile == ""){ //输入不能为空
			tipsShow('请输入手机号码', "input[name=mobile]");
			return false;
		}else if(!reg.test(mobile)){ //正则验证不通过，格式不对
			tipsShow('手机号码格式不正确，请重新输入', "input[name=mobile]");
			return false;
		}else if(captcha.length == 0){
			tipsShow('图片验证码不能为空', '.input_mobile');
			return false;
		}else if(phone_verify.length == 0){
			tipsShow('手机验证码不能为空', '.input4');
			return false;
		}

		$.post(url,{data:mobile,captcha:captcha,phone_verify:phone_verify},function(result){
			layer.msg(result.msg,{time: 2000});
			if(result.status == 1){
				$('.J_mobile').html(result.data);
				layer.close(index_mobile);
			}
		},'json');	
	});

	//基本资料修改
	$('.J_profile_submit').click(function(){
		var form = $("#J_profile_form");	
		$.ajax({
			type: 'POST',
			url: form.attr("action"),
			data:form.serialize(),
			dataType: 'json',
			async: false, //同步
			cache: false,
			success: function (result) {
				layer.msg(result.msg,{time: 2000});
			}
		});
	});
	
});

//修改操作--修改用户名、签名等
function modifyBtn(id){
	$("#"+id).hide();
	$("#"+id).siblings("div").show();
}
//保存操作--保存用户名、签名等
function saveBtn(id, obj){
	var url = $(obj).data('url');
	var value = $("input[name='"+id+"']").val();
	$.post(url,{data:value},function(result){
		layer.msg(result.msg,{time: 500});
		if(result.status == 1){
			$("#"+id+"> .J_"+id).html(result.data);
			$("#"+id).show();
			$("#"+id).siblings("div").hide();
		}
	},'json');
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
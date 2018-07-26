$(function(){

	// /*列表页的赞
	// $(".Jz_submit").on('click',function(){//商品点赞
	// 	var obj=$(this);
	// 	$.get("/index.php?m=ajax&a=zan",{id:$(this).attr("data"),t:$(this).attr("data-t")},function(result){
	// 		if(result.status==1){
	// 			obj.html(parseInt(obj.html())+1);
	// 		}else{
	// 			tips(result.msg,0);
	// 		}
	// 	},'json')
	// });
	// */
	
	// /*列表页的收藏*/
	// $(".Jl_likes").on('click',function(){//收藏商品
	// 	if(PINER.uid==""){
	// 		$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
	// 		return false;
	// 	}
	// 	var obj=$(this);
	// 	$.post("/index.php?m=ajax&a=setlikes",{id:obj.attr("data-id"),xid:obj.attr("data-xid")},function(result){
	// 		if(result.status==1){
	// 			tips(result.msg,1);
	// 			obj.html(result.data.likes);
	// 			if(result.data.t=='qx'){
	// 				obj.removeClass("sz_11_l").addClass("sz_11");
	// 			}else{
	// 				obj.removeClass("sz_11").addClass("sz_11_l");
	// 			}
	// 		}else{
	// 			tips(result.msg,0);
	// 		}
	// 	},'json');
	// });
	// //关注
	// $(".J_fo_btn").on("click",function(){
	// 	var obj=$(this).parent();
	// 	var uid=obj.attr("data-id");		
	// 	$.get(PINER.root+ '/?m=user&a=follow',{uid:uid},function(data){
	// 		if(data.status==0){
	// 			$(".tip-c").html(data.msg);
	// 			$('.tipbox').show().removeClass('tip-success').addClass("tip-error");
	// 			setTimeout("$('.tipbox').hide();", 2000);  
	// 		}else{
	// 			$(".tip-c").html(data.msg);
	// 			$('.tipbox').show().removeClass('tip-error').addClass("tip-success");
	// 			setTimeout("$('.tipbox').hide();", 2000); 
	// 			obj.html('<span class="fo_u_ok">已关注</span><a href="javascript:;" class="J_unfo_u green">取消</a>');
	// 		}
	// 	},'json')
	// });
	// $(".J_unfo_u").on("click",function(){
	// 	var obj=$(this).parent();
	// 	var uid=obj.attr('data-id');
	// 	$.get(PINER.root+ '/?m=user&a=unfollow',{uid:uid},function(data){
	// 		if(data.status==0){
	// 			$(".tip-c").html(data.msg);
	// 			$('.tipbox').show().removeClass('tip-success').addClass("tip-error");
	// 			setTimeout("$('.tipbox').hide();", 2000);  
	// 		}else{
	// 			$(".tip-c").html(data.msg);
	// 			$('.tipbox').show().removeClass('tip-error').addClass("tip-success");
	// 			setTimeout("$('.tipbox').hide();", 2000); 
	// 			obj.html('<div class="J_fo_btn w_r3_d">关注</div>');
	// 		}
	// 	},'json');
	// });

	//评论
	if(PINER.uid==""){
		// $("#J_cmt_content").attr("readonly", true).attr('placeholder','');
		$("#J_cmt_content").attr("readonly", true);
		// $("#J_login").show();
	}
	$("#J_lo_btn").click(function(){
		// $.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
		LoginPopup();
	});
	$("#J_cmt_submit").on('click', function(){
		if(PINER.uid==""){
			$("#J_lo_btn").trigger("click");return false;
		}
		var itemid = $("#itemid").val(),
			xid = $("#xid").val(),
			content = $("#J_cmt_content").val();
		$.ajax({
			url: PINER.root + '/?g=ab&m=ajax&a=comment',
			type: 'POST',
			data: {
				itemid: itemid,
				xid:xid,
				content: content
			},
			dataType: 'json',
			success: function(result){
				if(result.status == 1){
					$("#J_cmt_content").val('');
					comments = parseInt($("#pls").text());
					$("#pls1").text(comments + 1);
					$("#pls").text(comments + 1);
					$(".not-comments").addClass("none");
					// tips('感谢评论，积分+1',1);
					tipsPopup('tips_4','感谢您的评论，积分<span style=color:#ff0000>+1</span>');

					cmt = $("#comment > ul > li").clone(true);

					//楼层
					lc = result.data.lc;
					if(lc == "1"){
						lc = '沙发';
					}else if(lc == "2"){
						lc = '板凳';
					}else if(lc == "3"){
						lc = '地板';
					}else{
						lc = lc + '楼';
					}
					cmt.find(".comment_lc").html(lc);

					//评论内容
					info = result.data.info;
					cmt.find(".comment_info").html(AnalyticEmotion(info));
					cmt.find(".J_hf_content").attr('placeholder','回复：'+info);

					//绑定新浪表情
					$(cmt.find(".face")).SinaEmotion(cmt.find(".emotion"));

					//隐藏ID
					cmt.find(".J_hf_submit").attr('data-id', result.data.id);
					cmt.find(".J_hf_submit").attr('psid', result.data.id);

					//客户端
					client = '';
					if(info.indexOf('|android')!=-1){
						client = '·来自Android客户端';
					}else if(info.indexOf('|iphone')!=-1){
						client = '·来自iphone客户端';
					}
					cmt.find(".comment_addtime").html('刚刚'+client);
					cmt.find("textarea").attr('placeholder','回复：'+info);

					cmt.prependTo($("#comment_list > ul"));

					// $("#comment_list > ul").prepend(result.data.html);
				}else{
					// tips(result.msg, 0);
					tipsPopup('tips_2', result.msg);
				}
			}
		});
	});
	// $(".J_hf").on("click",function(){
	// 	var name = $(this).parents('.lrhf').siblings('.hf_zr').find('span').html();
	// 	$(".sbhf").remove();
	// 	$(this).parents('.lh_a1').append('<div class="w_spxx_7 sbhf" style="width: 700px;float: right;margin-top:10px"><textarea id="J_hf_content" name="content" class="emotion" style="width: 680px;height:60px;">回复 '+ name +':</textarea><i id="face" style="line-height: 25px;  height: 25px;  display: block;  width: 100px; cursor:pointer"><img src="http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif" style="vertical-align: middle;"/>表情</i><input type="button" id="J_hf_submit" data-id="'+$(this).attr('data-id')+'"  psid="'+$(this).attr('psid')+'" value="回复" class="w_fbpl"></div>');
	// 	$(this).parents('.lh_a1').find('#face').SinaEmotion($(this).parents('.lh_a1').find('.emotion'));
	// 	// 测试本地解析
	// 	$(this).parents('.lh_a1').find(".J_pl_i").each(function(){
	// 		$(this).html(AnalyticEmotion($(this).html()));
	// 	});
	// 	$("#J_hf_submit").on("click",function(){
	// 	if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
	// 	var id=$(this).attr("data-id"),content=$("#J_hf_content").val();
	// 	var psid=$(this).attr("psid");
	// 	$.post(PINER.root+"/?m=ajax&a=hf",{id:id,content:content,psid:psid},function(result){
	// 		if(result.status == 1){
	// 			$(".sbhf").remove();
	// 			tips('回复成功',1);
	// 				$('.hflr'+psid).append(result.data);
	// 		}else{
	// 			tips(result.msg, 0);
	// 		}
	// 	},'json');
	// });
	// });
	// $(".J_hf1").on("click",function(){
	// 	$(".sbhf").remove();
	// 	$(this).parents('.yl_ba_hf').append('<div class="w_spxx_7 sbhf" style="width: 700px;float: right;margin-top:10px"><textarea id="J_hf_content" name="content" class="emotion" style="width: 680px;height:60px;"></textarea><i id="face" style="line-height: 25px;  height: 25px;  display: block;  width: 100px; cursor:pointer"><img src="http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif" style="vertical-align: middle;"/>表情</i><input type="button" id="J_hf_submit" data-id="'+$(this).attr('data-id')+'" psid="'+$(this).attr('psid')+'" value="回复" class="w_fbpl"></div>');
	// 	$(this).parents('.yl_ba_hf').find('#face').SinaEmotion($(this).parents('.yl_ba_hf').find('.emotion'));
	// 	// 测试本地解析
	// 	$(this).parents('.yl_ba_hf').find(".J_pl_i").each(function(){
	// 		$(this).html(AnalyticEmotion($(this).html()));
	// 	});
	// 	$("#J_hf_submit").on("click",function(){
	// 	if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
	// 	var id=$(this).attr("data-id"),content=$("#J_hf_content").val();
	// 	var psid=$(this).attr("psid");
	// 	$.post(PINER.root+"/?m=ajax&a=hf",{id:id,content:content,psid:psid},function(result){
	// 		if(result.status == 1){
	// 			$(".sbhf").remove();
	// 			tips('回复成功',1);
	// 				$('.hflr'+psid).append(result.data);
	// 		}else{
	// 			tips(result.msg, 0);
	// 		}
	// 	},'json');
	// });
	// });

	$(".list .content").on("click",".J_hf_submit", function() {
	// $(".J_hf_submit").on("click", function() {
		// if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
		if(PINER.uid==""){
			$("#J_lo_btn").trigger("click");return false;
		}
		var id=$(this).attr("data-id"), content=$(this).parents().children(".write-hf").children().children(".J_hf_content").val();
		var psid=$(this).attr("psid");
		obj = $(this);
		$.post(PINER.root+"/?g=ab&m=ajax&a=hf",{id:id,content:content,psid:psid},function(result){
			if(result.status == 1){
				obj.attr('placeholder','');
				obj.parents().children(".write-hf").toggle();
				comments = parseInt($("#pls").text());
				$("#pls1").text(comments + 1);
				$("#pls").text(comments + 1);
				// tips('回复成功',1);
				tipsPopup('tips_1', '回复成功');

				reply = obj.parents().children(".reply");
				if(reply.children(".reply-box").length > 0){
					reply.children(".reply-box").wrap('<div class="reply-box zk'+ result.data.id+'"></div>');
				}else{
					reply.prepend('<div class="reply-box zk'+ result.data.id+'"></div>');
				}

				//客户端
				client = '';
				if(result.data.info.indexOf('|android')!=-1){
					client = '·来自Android客户端';
				}else if(result.data.info.indexOf('|iphone')!=-1){
					client = '·来自iphone客户端';
				}

				$('.zk'+result.data.id).append('<div class="p10">'+
								'<p class="fc-aux-a font-w-b">'+ result.data.lc+'楼<span class="fc-blue ml-12">'+result.data.uname+'</span></p>'+
								'<p class="mt-5 ml-34">'+AnalyticEmotion(result.data.info)+'</p>'+
								'<p class="font-12 fc-aux-a mt-5 ml-34">'+
									'<span class="mr-10 hf cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="/new/images/ie8/a_43@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="/new/images/svg_sprite/icon_symbol.svg#icon-a_43"></use>'+
										'</svg>'+
										' 回复'+
									'</span>'+
									'<span class="mr-10 cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="/new/images/ie8/c_6@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="/new/images/svg_sprite/icon_symbol.svg#icon-c_6"></use>'+
										'</svg>'+
										' 赞（0）'+
									'</span>'+
									'<span class="mr-15 cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="/new/images/ie8/c_7@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="/new/images/svg_sprite/icon_symbol.svg#icon-c_7"></use>'+
										'</svg>'+
										' 踩（0）'+
									'</span>'+
									'<span>刚刚'+client+'</span>'+
								'</p>'+
								'<div class="write write-hf radius-3 mt-5 ml-34" style="margin-top:5px; margin-left: 34px;">'+
									'<div class="info">'+
										'<textarea placeholder="" rows="3" class="J_hf_content emotion-'+result.data.id+'">回复 '+result.data.uname+'：</textarea>'+
									'</div>'+
									'<div class="member clearfix">'+
										'<img src="'+result.data.uavatar+'" class="radius-100" width="24" height="24">'+
										'<span class="fc-aux-9 ml-5">'+result.data.uname+'</span>'+
										'<div class="fr">'+
											'<span class="mr-15 face-'+result.data.id+'">'+
												'<svg class="icon">'+
													'<!--[if lte IE 8]><desc><img src="/new/images/ie8/a_33@2x.png" width="8" height="8"></desc><![endif]-->'+
													'<use xlink:href="/new/images/svg_sprite/icon_symbol.svg#icon-a_33"></use>'+
												'</svg>'+
											'</span>'+
											'<button type="reset" class="no-btn fc-aux-9 mr-20 qx cursor-pointer">取消</button>'+
											'<button type="submit" class="button btn-1 cursor-pointer J_hf_submit" data-id="'+result.data.id+'" psid="'+result.data.pid+'">回复</button>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>');

				//绑定新浪表情
				$('.face-'+result.data.id).SinaEmotion($('.emotion-'+result.data.id));

			}else{
				// tips(result.msg, 0);
				tipsPopup('tips_2', result.msg);
			}
		},'json');
	});

	//商品点赞
	$(".J_zan").click(function(){
		if(PINER.uid==""){
			LoginPopup();
		}
		$.get("/index.php?g=ab&m=ajax&a=zan&t=item",{id:$(this).data("id")},function(result){
			if(result.status==1){
				// tips('点赞成功',1);
				tipsPopup('tips_1', '顶成功');
			}else{
				// tips(result.msg,0);
				tipsPopup('tips_2', result.msg);
			}
		},'json')
	});

	//详细页收藏商品
	$(".J_fav").click(function(){
		if(PINER.uid==""){
			LoginPopup();
		}
		var obj=$(this);
		var tar=$(".S_like");
		$.post("/index.php?g=ab&m=ajax&a=setlikes",{id:obj.attr("data-id"),xid:obj.attr("data-xid")},function(result){
			if(result.status==1){
				// tips(result.msg,1);
				tipsPopup('tips_1', result.msg);
				// tar.html(result.data.likes);
			}else{
				tipsPopup('tips_2', result.msg);
			}
		},'json');
	});

	//文章举报
	$(".J_jb").click(function(){
		if(PINER.uid==""){
			LoginPopup();
		}
		jbObj = $(this).parent().parent(".jbBox");
		reasonid = jbObj.find(".active").attr('data-reasonid');
		reason = jbObj.find("input").val();

		if(typeof reasonid == "undefined"){
			tipsPopup('tips_3', "请选择举报原因");
			return false;
		}

		$.get(PINER.root+'/?g=ab&m=ajax&a=jb',{itemid:$(this).data("id"),xid:$(this).data("xid"),reasonid:reasonid,reason:reason},function(result){
			if(result.status==1){
				tipsPopup('tips_1', result.msg);
			}else{
				tipsPopup('tips_2', result.msg);
			}
		},'json');

		jbObj.hide();
		jbObj.find(".input").hide();
		jbObj.find("i").removeClass("active");
		jbObj.find("input").val('').attr("placeholder", "输入举报原因");		
	});

	//评论点赞
	$(".J_zan_cmt").on('click',function(){
		if(PINER.uid==""){
			LoginPopup();
		}
		var obj=$(this);
		$.post(PINER.root+"/?g=ab&m=ajax&a=comment_zan",{id:$(this).data("id")},function(result){
			if(result.status==1){
				obj.children("span").text(result.data);
			}else{
				tipsPopup('tips_2', result.msg);
			}
		},'json');
	});

	// //签到
	// $("#J_sign").click(function(){
	// 	if(PINER.uid==""){
	// 		$.get(PINER.root+"/index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
	// 		return false;
	// 	}
	// 	$.get(PINER.root+'/?m=user&a=sign',function(result){
	// 		if(result.status==0){
	// 			tips(result.msg,0);
	// 			//alert(result.msg);
	// 		}else{
	// 			tips(result.msg,1);
	// 			//alert(result.msg);
	// 		}
	// 	},'json');
	// });

	//分享, 第一次点击加载，第二次加载时百度分享JS不会执行
	var objs = $(".T_share");
	itemid = objs.eq(0).data("id");
	$.ajax({
		url: PINER.root + '/?g=ab&m=ajax&a=share&t=item&id=' + itemid,
		async: false,
		type: 'GET',
		dataType: 'json',
		success: function(result){
			if(result.status == 1){
				// obj.siblings(".shareBox").prepend(result.data);
				var len = objs.length;
				for(i=0; i < len; i++){
					objs.eq(i).siblings(".shareBox").prepend(result.data);
				}
			}
		}
	});
	// $(".T_share").one("click",function(){
	// 	var obj=$(this);
	// 	// if(obj.data("id")=="") return false;
	// 	$.get(PINER.root+"/?g=ab&m=ajax&a=share&t=item",{id:obj.data("id")},function(result){
	// 		if(result.status==1){
	// 			// obj.siblings(".shareBox").html(result.data);
	// 			obj.siblings(".shareBox").prepend(result.data);
	// 			// obj.data("id")="";
	// 		}
	// 	},'json');
	// 	// opdg("url:/index.php?m=ajax&a=share&id="+$(this).attr("data-id")+"&t="+t,480,450,'用户分享');
	// });

	//显示回复
	$(".list .content").on("click",".hf", function() {
		if(PINER.uid==""){
			$("#J_lo_btn").trigger("click");return false;
		}

		$(".comments").find(".write-hf").hide();
		// $(this).parents().children(".write-hf").show();
		$(this).parent().siblings(".write-hf").show();
		$('html, body').animate({
			scrollTop: $(this).parents().children(".write-hf").offset().top-117,
		},'fast');

		// $($(this).parent().siblings(".write-hf").find(".face")).SinaEmotion($(this).parent().siblings(".write-hf").find(".emotion"));

	});
});

// function tips(msg,st){
// 	$(".tip-c").html(msg);
// 	setTimeout("$('.tipbox').hide();", 2000); 
// 	if(st==1){
// 		$('.tipbox').show().removeClass('tip-error').addClass("tip-success");
// 	}else{
// 		$('.tipbox').show().removeClass('tip-success').addClass("tip-error");
// 	}
// }

// function opdg(content,w,h,title){  
// 	var dg = new $.dialog({id:'selectorder',title:title, lock:false,content:content,width:w,height:h,background:'#000',opacity:1, max: false, min: false,resize:false});    
// }

// function jz_submit_click(obj){
// 		var obj=$(obj);
// 		$.get("/index.php?m=ajax&a=zan",{id:$(obj).attr("data"),t:$(obj).attr("data-t")},function(result){
// 			if(result.status==1){
// 				obj.html(parseInt(obj.html())+1);
// 			}else{
// 				tips(result.msg,0);
// 			}
// 		},'json')
// 	}
// function vote_submit_click(obj){
// 		var obj=$(obj);
// 		//if(obj.attr("voted") ==0){
// 		//	obj.attr("voted",1);
// 		$.get("/index.php?m=ajax&a=vote",{id:$(obj).attr("data"),t:$(obj).attr("data-t")},function(result){
// 			if(result.status==1){
// 				obj.parent().prev().html(parseInt(obj.parent().prev().html())+1);
// 			}else{
// 				tips(result.msg,0);
// 			}
// 		},'json')
// 		//}
// 		//else{
// 		//	tips("不能重复投票！",0);
// 		//}
// 	}

//弹出登录层
function LoginPopup111(type){
	var isLogin = "";
	var isReg = "none"
	if(type==1){
		isLogin = "none";
		isReg = "";
	}
	layer.open({
		type: 1,
		title: false,
		closeBtn: 1,
		shadeClose: false,
		shade:0.7,
		anim:2,
		skin: 'loginPopup',
		area: '430px',
		content: '<div class="loginBox '+ isLogin +'">'+
					'<form id="J_dlogin_form" action="/index.php?m=user&a=login" method="post">'+
				 	'<div class="text-center">'+
				 		'<p class="font-36">欢迎回来</p>'+
				 		'<p class="font-16 fc-aux-a mt-8">登录账户开启更多功能</p>'+
				 	'</div>'+
				 	'<div class="mt-40"><input type="text" name="username" placeholder="用户名/手机号/邮箱" class="input-3 loginInput input1"></div>'+
				 	'<div class="mt-15"><input type="password" name="password" placeholder="登录密码" class="input-3 loginInput input2"></div>'+
				 	'<div class="clearfix mt-15 font-13 fc-gray">'+
				 		'<div class="fl"><label class="checkBox"><input type="checkbox" name="remember"><span></span>记住密码</label></div>'+
				 		'<div class="fr"><a href="./page/retrievePassword.html">忘记密码?</a></div>'+
				 	'</div>'+
				 	'<div class="button btn-3 cursor-pointer mt-24" id="login">登录</div>'+
				 	'<div class="font-14 mt-32 text-center"><span class="fc-green loginType cursor-pointer">手机快捷登录</span> or 没有账户？<span class="fc-green cursor-pointer registeredButton">注册</span></div>'+
				 	'</form>'+
				 '</div>'+
				 '<div class="mobileBox none">'+
				 	'<div class="text-center">'+
				 		'<p class="font-36">欢迎回来</p>'+
				 		'<p class="font-16 fc-aux-a mt-8">登录账户开启更多功能</p>'+
				 	'</div>'+
				 	'<div class="mt-40 mobile"><input type="text" placeholder="手机号码" maxlength="11" class="input-3 loginInput input3"><input type="button" class="yzm" onclick="settime(this)" value="获取验证码"></div>'+
				 	'<div class="mt-15"><input type="text" placeholder="手机验证码" maxlength="6" class="input-3 loginInput input4"></div>'+
				 	'<div class="button btn-3 cursor-pointer mt-24">登录</div>'+
				 	'<div class="font-14 mt-32 text-center"><span class="fc-green loginType cursor-pointer">用户名密码登录</span> or 没有账户？<span class="fc-green cursor-pointer registeredButton">注册</span></div>'+
				 '</div>'+
				 '<div class="registeredBox '+ isReg +'">'+
				 	'<div class="text-center">'+
				 		'<p class="font-36">创建账户</p>'+
				 		'<p class="font-16 fc-aux-a mt-8">做一个精明的消费者</p>'+
				 	'</div>'+
				 	'<div class="mt-40 mobile"><input type="text" placeholder="手机号码" maxlength="11" class="input-3 loginInput input3"><input type="button" class="yzm" onclick="settime(this)" value="获取验证码"></div>'+
				 	'<div class="mt-15"><input type="text" placeholder="手机验证码" maxlength="6" class="input-3 loginInput input4"></div>'+
				 	'<div class="mt-15"><input type="text" placeholder="用户名" class="input-3 loginInput input1"></div>'+
				 	'<div class="mt-15"><input type="password" placeholder="设置登录密码" class="input-3 loginInput input2"></div>'+
				 	'<div class="button btn-3 cursor-pointer mt-24">创建账户</div>'+
				 	'<div class="mt-5 fc-aux-9">尊敬的用户，点击创建账户按钮即说明您已阅读并同意白菜哦<span class="fc-green">《用户服务协议》</span>以及<span class="fc-green">《隐私条款》</span></div>'+
				 	'<div class="font-14 mt-20 text-center">已有账号？<span class="fc-green cursor-pointer loginButton">登录</span></div>'+
				 '</div>'
	});

	$("#login").click(function(){
		$("#J_dlogin_form").submit();
	});

	$(".loginPopup .loginType").click(function(){
		if($(".loginPopup .loginBox").is(":hidden")){
			$(".loginPopup .loginBox").show();
			$(".loginPopup .mobileBox").hide();
		}else{
			$(".loginPopup .loginBox").hide();
			$(".loginPopup .mobileBox").show();
		}
	});
	
	$(".loginPopup .registeredButton").click(function(){
		$(".loginPopup .loginBox").hide();
		$(".loginPopup .mobileBox").hide();
		$(".loginPopup .registeredBox").show();
	});
	
	$(".loginPopup .loginButton").click(function(){
		$(".loginPopup .loginBox").show();
		$(".loginPopup .mobileBox").hide();
		$(".loginPopup .registeredBox").hide();
	});
}

$(window).load(function(){
	//替换表情
	$(".comment_info").each(function(){
		$(this).html(AnalyticEmotion($(this).html()));
	});
});

function photo(){
	var img = document.getElementById("ban_pic");
	
	if(!img) return false;

	if(img.attachEvent){
		img.attachEvent("mouseover", function(e) {
		    var box = img.getBoundingClientRect();
		    if((e.clientX - box.left) < ((box.right - box.left) / 2)){
		    	$("#prev").show();
		    	$("#next").hide();
		    }else{
		    	$("#next").show();
		    	$("#prev").hide();
		    }
		});
	}else{
		img.addEventListener("mouseover", function(e) {
		    var box = img.getBoundingClientRect();
		    if((e.clientX - box.left) < ((box.right - box.left) / 2)){
		    	$("#prev").show();
		    	$("#next").hide();
		    }else{
		    	$("#next").show();
		    	$("#prev").hide();
		    }
		});
	}
	if(img.attachEvent){
		img.attachEvent("mouseout", function() {
		    $("#prev").hide();
		    $("#next").hide();
		});
	}else{
		img.addEventListener("mouseout", function() {
		    $("#prev").hide();
		    $("#next").hide();
		});
	}
}

function sinaEmo(){
	//绑定新浪表情
	// objs = $("#comment_list").find(".emotion");
	// objs = $(".comments").find(".emotion");
	objs = $(".comments > div:not(#comment)").find(".emotion");
	var len = objs.length;
	for(i=0; i < len; i++){
		// $('#face-'+(i+1)).SinaEmotion($('#emotion-'+(i+1)));
		$(objs.eq(i).parent().parent(".write").find(".face")).SinaEmotion(objs.eq(i));
	}
}

//显示举报弹层
function toReport(){
	$(".jb").click(function(){
		$(".jbBox").hide();
		$(this).siblings(".jbBox").show();
	});

	$(document).click(function(event){
		var _con = $(".jb");
		var _con1 = $(".jbBox");
		if(!_con.is(event.target) && _con.has(event.target).length === 0 && !_con1.is(event.target) && _con1.has(event.target).length === 0){
			$(".jbBox").hide();
			$(".jbBox .input").hide();
			$(".jbBox  ul li").children("i").removeClass("active");
		}
	});
	
	$(".other").click(function(){
		var active = $(this).children("i").is(".active");
		if(!active){
			$(this).parent().siblings(".input").show();
		}else{
			$(this).parent().siblings(".input").hide();
		}
	});
	
	$(".jbBox ul li").click(function(){
		var active = $(this).children("i").is(".active");
		if(!active){
			$(this).children("i").addClass("active");
			//移除其它选项
			$(this).siblings().children("i").removeClass("active");
		}else{
			$(this).children("i").removeClass("active");
		}
	});
	
	$(".jbBox .button1 button").click(function(){
		// $(".jbBox").hide();
		// $(".jbBox .input").hide();
		// $(".jbBox ul li").children("i").removeClass("active");
	});

}
$(function(){

	
	// $(".z_submit").click(function(){//商品点赞
	// 	$.get("/index.php?m=ajax&a=zan&t="+t,{id:$(this).attr("data")},function(result){
	// 		if(result.status==1){
	// 			tips('点赞成功',1);
	// 		}else{
	// 			tips(result.msg,0);
	// 		}
	// 	},'json')
	// });
	// $(".J_fav").click(function(){//详细页收藏商品
	// 	if(PINER.uid==""){
	// 		$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
	// 		return false;
	// 	}
	// 	var obj=$(this);
	// 	var tar=$(".S_like");
	// 	$.post("/index.php?m=ajax&a=setlikes",{id:obj.attr("data-id"),xid:obj.attr("data-xid")},function(result){
	// 		if(result.status==1){
	// 			tips(result.msg,1);
	// 			tar.html(result.data.likes);
	// 		}else{
	// 			tips(result.msg,0);
	// 		}
	// 	},'json');
	// });
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
		$("#J_cmt_content").attr("readonly", true).attr('placeholder','');
		$("#J_login").show();
	}
	$("#J_lo_btn").click(function(){
		$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
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
					tips('感谢评论，积分+1',1);

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
					cmt.find(".comment_info").html(info);
					cmt.find("textarea").attr('placeholder','回复：'+info);

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
				}else{
					tips(result.msg, 0);
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
	// $(".list .content").on("click",".hf", function() {
	$(".J_hf_submit").on("click", function() {
		if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
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
				tips('回复成功',1);
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
								'<p class="mt-5 ml-34">'+result.data.info+'</p>'+
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
							'</div>');
			}else{
				tips(result.msg, 0);
			}
		},'json');
	});
	// $(".J_zan").on('click',function(){
	// 	var obj=$(this);
	// 	$.post(PINER.root+"/?m=ajax&a=comment_zan",{id:$(this).attr("data-id")},function(result){
	// 		if(result.status==1){
	// 			obj.children("i").text(result.data);
	// 		}else{
	// 			tips(result.msg,0);
	// 		}
	// 	},'json');
	// });
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
	// //无货举报
	// $(".J_jb,.J_jbc").click(function(){
	// 	if(PINER.uid==""){
	// 		$.get(PINER.root+"/index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
	// 		return false;
	// 	}
	// 	$.get(PINER.root+'/?m=ajax&a=jb',{itemid:$(this).attr('data-id'),xid:$(this).attr('data-xid')},function(result){
	// 		if(result.status==0){
	// 			tips(result.msg,0);
	// 		}else{
	// 			tips(result.msg,1);
	// 		}
	// 	},'json');
	// });
	// //分享
	// $(".T_share").click(function(){
	// 	opdg("url:/index.php?m=ajax&a=share&id="+$(this).attr("data-id")+"&t="+t,480,450,'用户分享');
	// });
});

function tips(msg,st){
	$(".tip-c").html(msg);
	setTimeout("$('.tipbox').hide();", 2000); 
	if(st==1){
		$('.tipbox').show().removeClass('tip-error').addClass("tip-success");
	}else{
		$('.tipbox').show().removeClass('tip-success').addClass("tip-error");
	}
}

function opdg(content,w,h,title){  
	var dg = new $.dialog({id:'selectorder',title:title, lock:false,content:content,width:w,height:h,background:'#000',opacity:1, max: false, min: false,resize:false});    
}
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
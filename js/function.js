$(function(){
	$(".z_submit").click(function(){//商品点赞
		$.get("/index.php?m=ajax&a=zan&t="+t,{id:$(this).attr("data")},function(result){
			if(result.status==1){
				tips('点赞成功',1);
			}else{
				tips(result.msg,0);
			}
		},'json')
	});
	$(".J_fav").click(function(){//详细页收藏商品
		if(PINER.uid==""){
			$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
			return false;
		}
		var obj=$(this);
		var tar=$(".S_like");
		$.post("/index.php?m=ajax&a=setlikes",{id:obj.attr("data-id"),xid:obj.attr("data-xid")},function(result){
			if(result.status==1){
				tips(result.msg,1);
				tar.html(result.data.likes);
			}else{
				tips(result.msg,0);
			}
		},'json');
	});
	/*列表页的赞
	$(".Jz_submit").on('click',function(){//商品点赞
		var obj=$(this);
		$.get("/index.php?m=ajax&a=zan",{id:$(this).attr("data"),t:$(this).attr("data-t")},function(result){
			if(result.status==1){
				obj.html(parseInt(obj.html())+1);
			}else{
				tips(result.msg,0);
			}
		},'json')
	});
	*/
	
	/*列表页的收藏*/
	$(".Jl_likes").on('click',function(){//收藏商品
		if(PINER.uid==""){
			$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
			return false;
		}
		var obj=$(this);
		$.post("/index.php?m=ajax&a=setlikes",{id:obj.attr("data-id"),xid:obj.attr("data-xid")},function(result){
			if(result.status==1){
				tips(result.msg,1);
				obj.html(result.data.likes);
				if(result.data.t=='qx'){
					obj.removeClass("sz_11_l").addClass("sz_11");
				}else{
					obj.removeClass("sz_11").addClass("sz_11_l");
				}
			}else{
				tips(result.msg,0);
			}
		},'json');
	});
	//关注
	$(".J_fo_btn").on("click",function(){
		var obj=$(this).parent();
		var uid=obj.attr("data-id");		
		$.get(PINER.root+ '/?m=user&a=follow',{uid:uid},function(data){
			if(data.status==0){
				$(".tip-c").html(data.msg);
				$('.tipbox').show().removeClass('tip-success').addClass("tip-error");
				setTimeout("$('.tipbox').hide();", 2000);  
			}else{
				$(".tip-c").html(data.msg);
				$('.tipbox').show().removeClass('tip-error').addClass("tip-success");
				setTimeout("$('.tipbox').hide();", 2000); 
				obj.html('<span class="fo_u_ok">已关注</span><a href="javascript:;" class="J_unfo_u green">取消</a>');
			}
		},'json')
	});
	$(".J_unfo_u").on("click",function(){
		var obj=$(this).parent();
		var uid=obj.attr('data-id');
		$.get(PINER.root+ '/?m=user&a=unfollow',{uid:uid},function(data){
			if(data.status==0){
				$(".tip-c").html(data.msg);
				$('.tipbox').show().removeClass('tip-success').addClass("tip-error");
				setTimeout("$('.tipbox').hide();", 2000);  
			}else{
				$(".tip-c").html(data.msg);
				$('.tipbox').show().removeClass('tip-error').addClass("tip-success");
				setTimeout("$('.tipbox').hide();", 2000); 
				obj.html('<div class="J_fo_btn w_r3_d">关注</div>');
			}
		},'json');
	});
	//评论
	if(PINER.uid!=""){
		$("#J_cmt_content").removeAttr("readonly").attr('placeholder','我也来说两句~~');
		$("#J_login").remove();
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
			url: PINER.root + '/?m=ajax&a=comment',
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
					tips('感谢评论，积分+1',1);
					$("#J_cmt_list").prepend(AnalyticEmotion(result.data));
				}else{
					tips(result.msg, 0);
				}
			}
		});
	});
	$("body").delegate("#J_cmt_page a","click", function(){
		var url = $(this).attr('url');
		$.get(url, function(result){
			if(result.status == 1){
				$("#J_cmt_list").html(AnalyticEmotion(result.data.list));
				$("#J_cmt_page").html(result.data.page);
			}else{
				tips(result.msg, 0);
			}
		},'json');
		return false;
	});
	$("body").delegate("#J_cmt_page_hot a","click", function(){
		var url = $(this).attr('url');
		$.get(url, function(result){
			if(result.status == 1){
				$("#J_cmt_list_hot").html(AnalyticEmotion(result.data.list));
				$("#J_cmt_page_hot").html(result.data.page);
			}else{
				tips(result.msg, 0);
			}
		},'json');
		return false;
	});
	$(".J_hf").on("click",function(){
		var name = $(this).parents('.lrhf').siblings('.hf_zr').find('span').html();
		$(".sbhf").remove();
		$(this).parents('.lh_a1').append('<div class="w_spxx_7 sbhf" style="width: 700px;float: right;margin-top:10px"><textarea id="J_hf_content" name="content" class="emotion" style="width: 680px;height:60px;">回复 '+ name +':</textarea><i id="face" style="line-height: 25px;  height: 25px;  display: block;  width: 100px; cursor:pointer"><img src="http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif" style="vertical-align: middle;"/>表情</i><input type="button" id="J_hf_submit" data-id="'+$(this).attr('data-id')+'"  psid="'+$(this).attr('psid')+'" value="回复" class="w_fbpl"></div>');
		$(this).parents('.lh_a1').find('#face').SinaEmotion($(this).parents('.lh_a1').find('.emotion'));
		// 测试本地解析
		$(this).parents('.lh_a1').find(".J_pl_i").each(function(){
			$(this).html(AnalyticEmotion($(this).html()));
		});
		$("#J_hf_submit").on("click",function(){
		if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
		var id=$(this).attr("data-id"),content=$("#J_hf_content").val();
		var psid=$(this).attr("psid");
		$.post(PINER.root+"/?m=ajax&a=hf",{id:id,content:content,psid:psid},function(result){
			if(result.status == 1){
				$(".sbhf").remove();
				tips('回复成功',1);
					$('.hflr'+psid).append(result.data);
			}else{
				tips(result.msg, 0);
			}
		},'json');
	});
	});
	$(".J_hf1").on("click",function(){
		$(".sbhf").remove();
		$(this).parents('.yl_ba_hf').append('<div class="w_spxx_7 sbhf" style="width: 700px;float: right;margin-top:10px"><textarea id="J_hf_content" name="content" class="emotion" style="width: 680px;height:60px;"></textarea><i id="face" style="line-height: 25px;  height: 25px;  display: block;  width: 100px; cursor:pointer"><img src="http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif" style="vertical-align: middle;"/>表情</i><input type="button" id="J_hf_submit" data-id="'+$(this).attr('data-id')+'" psid="'+$(this).attr('psid')+'" value="回复" class="w_fbpl"></div>');
		$(this).parents('.yl_ba_hf').find('#face').SinaEmotion($(this).parents('.yl_ba_hf').find('.emotion'));
		// 测试本地解析
		$(this).parents('.yl_ba_hf').find(".J_pl_i").each(function(){
			$(this).html(AnalyticEmotion($(this).html()));
		});
		$("#J_hf_submit").on("click",function(){
		if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
		var id=$(this).attr("data-id"),content=$("#J_hf_content").val();
		var psid=$(this).attr("psid");
		$.post(PINER.root+"/?m=ajax&a=hf",{id:id,content:content,psid:psid},function(result){
			if(result.status == 1){
				$(".sbhf").remove();
				tips('回复成功',1);
					$('.hflr'+psid).append(result.data);
			}else{
				tips(result.msg, 0);
			}
		},'json');
	});
	});
	$("#J_hf_submit").on("click",function(){
		if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
		var id=$(this).attr("data-id"),content=$("#J_hf_content").val();
		var psid=$(this).attr("psid");
		$.post(PINER.root+"/?m=ajax&a=hf",{id:id,content:content,psid:psid},function(result){
			if(result.status == 1){
				$(".sbhf").remove();
				tips('回复成功',1);
					$('.hflr'+psid).append(result.data);
			}else{
				tips(result.msg, 0);
			}
		},'json');
	});
	$(".J_zan").on('click',function(){
		var obj=$(this);
		$.post(PINER.root+"/?m=ajax&a=comment_zan",{id:$(this).attr("data-id")},function(result){
			if(result.status==1){
				obj.children("i").text(result.data);
			}else{
				tips(result.msg,0);
			}
		},'json');
	});
	//签到
	$("#J_sign").click(function(){
		if(PINER.uid==""){
			$.get(PINER.root+"/index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
			return false;
		}
		$.get(PINER.root+'/?m=user&a=sign',function(result){
			if(result.status==0){
				tips(result.msg,0);
				//alert(result.msg);
			}else{
				tips(result.msg,1);
				//alert(result.msg);
			}
		},'json');
	});
	//无货举报
	$(".J_jb,.J_jbc").click(function(){
		if(PINER.uid==""){
			$.get(PINER.root+"/index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');
			return false;
		}
		$.get(PINER.root+'/?m=ajax&a=jb',{itemid:$(this).attr('data-id'),xid:$(this).attr('data-xid')},function(result){
			if(result.status==0){
				tips(result.msg,0);
			}else{
				tips(result.msg,1);
			}
		},'json');
	});
	//分享
	$(".T_share").click(function(){
		opdg("url:/index.php?m=ajax&a=share&id="+$(this).attr("data-id")+"&t="+t,480,450,'用户分享');
	});
	//显示名片
/*	$(".J_card").on({
		mouseover: function(){
			layer_html='<div id="J_card_layer" class="user_card"><div id="J_card_info"></div><div class="J_card_arrow card_arrow"></div></div>';
			loading_html='<div class="card_info"><p class="card_loading">正在获取用户信息</p></div><div class="card_toolbar"></div>';
			h = null,
			n = null;
			clearTimeout(h);
			clearTimeout(n);
			
			//计算显示位置
			var p = $(this).offset(),
				l = p.left,
				d = $(this).width(),
				q = d / 2 - 8,
				w = $(window).width();
				l + 300 > w && (l = l - 300 + d, q = 300 - d / 2 - 8),
				uid = $(this).attr('data-uid');
			if(!uid) return !1; //缺少属性
			//显示加载
			!$('#J_card_layer')[0] && $('body').append(layer_html);
			$('#J_card_info').html(loading_html);
			$('#J_card_layer').css({
				top: p.top - 143 + "px",
				left: l + "px"
			});
			$("#J_card_layer .J_card_arrow").css("margin-left", q + "px");
			$("#J_card_layer").show();
			h = setTimeout(function(){
				clearTimeout(h);
				// $("#J_card_layer").show();
			}, 200);
			$("#J_card_layer").hover(
				function() {
					clearTimeout(h);
					$("#J_card_layer").show();
				},
				function() {
					$("#J_card_layer").hide();
				}
			);
			//获取内容
			if($('body').data(uid) != void(0) && $('body').data(uid) != ''){
				$("#J_card_info").html($('body').data(uid));
			}else{
				n = setTimeout(function(){
					$.getJSON(PINER.root + '/?m=space&a=card', {uid:uid}, function(result){
						if(result.status == 1){
							$("#J_card_info").html(result.data);
							$("body").data(uid, result.data);
							clearTimeout(h);
						}else{
							clearTimeout(h);
							clearTimeout(n);
							tips(result.msg,0);
						}
					});
				}, 500);
			}
		},
		mouseout: function(){
			console.log(111);
			$("#J_card_layer").hide();
			clearTimeout(h);
			clearTimeout(n);
			h = setTimeout(function() {
				// $("#J_card_layer").hide();
			}, 500);
		}
	});	
	*/
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
function jz_submit_click(obj){
		var obj=$(obj);
		$.get("/index.php?m=ajax&a=zan",{id:$(obj).attr("data"),t:$(obj).attr("data-t")},function(result){
			if(result.status==1){
				obj.html(parseInt(obj.html())+1);
			}else{
				tips(result.msg,0);
			}
		},'json')
	}
function vote_submit_click(obj){
		var obj=$(obj);
		//if(obj.attr("voted") ==0){
		//	obj.attr("voted",1);
		$.get("/index.php?m=ajax&a=vote",{id:$(obj).attr("data"),t:$(obj).attr("data-t")},function(result){
			if(result.status==1){
				obj.parent().prev().html(parseInt(obj.parent().prev().html())+1);
			}else{
				tips(result.msg,0);
			}
		},'json')
		//}
		//else{
		//	tips("不能重复投票！",0);
		//}
	}
document.write('<script src="/static/js/wap/weui.min.js"></script>');
document.write('<script src="/static/js/wap/jquery-1.8.3.min.js"></script>');
document.write("<link rel='stylesheet' type='text/css' href='/static/js/wap/weui.css'>");
$(function(){
	//评论
	if(PINER.uid!=""){
		$("#J_cmt_content").removeAttr("readonly").attr('placeholder','我也来说两句~~');
		$("#J_login").remove();
	}
	$("#J_lo_btn").click(function(){
		window.location="index.php?g=wap&m=user&a=login";
	});
	$("#J_cmt_submit").live('click', function(){
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
					$("#J_cmt_list").prepend(AnalyticEmotion(result.data));
				}else{
					tips(result.msg, 0);
				}
			}
		});
	});
	$("#J_cmt_page a").live("click",function(){
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
	$(".J_hf").live("click",function(){
		$(".sbhf").remove();
		$(this).parents('.w_spxx8_r').append('<div class="w_spxx_7 sbhf" style="width: 700px;float: right;margin-top:10px"><textarea id="J_hf_content" name="content" style="width: 680px;height:60px;"></textarea><input type="button" id="J_hf_submit" data-id="'+$(this).attr('data-id')+'" value="回复" class="w_fbpl"></div>');
	});
	$("#J_hf_submit").live("click",function(){
		if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
		var id=$(this).attr("data-id"),content=$("#J_hf_content").val();
		$.post(PINER.root+"/?m=ajax&a=hf",{id:id,content:content},function(result){
			if(result.status == 1){
				$(".sbhf").remove();
				$("#J_cmt_list").prepend(result.data);
			}else{
				tips(result.msg, 0);
			}
		},'json');
	});	   
	
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
	/*列表页的赞*/
	$(".Jz_submit").live('click',function(){//商品点赞
		var obj=$(this);
		$.get("/index.php?m=ajax&a=zan",{id:$(this).attr("data"),t:$(this).attr("data-t")},function(result){
			if(result.status==1){
				obj.html(result.data);
			}else{
				tips(result.msg,0);
			}
		},'json')
	});
	/*列表页的收藏*/
	$(".Jl_likes").live('click',function(){//收藏商品
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
	$(".J_fo_btn").live("click",function(){
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
	$(".J_unfo_u").live("click",function(){
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

	$(".J_zan").live('click',function(){
		var obj=$(this);
		$.post(PINER.root+"/?m=ajax&a=comment_zan",{id:$(this).attr("data-id")},function(result){
			if(result.status==1){
				obj.children("i").text(result.data);
			}else{
				tips(result.msg,0);
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
	$("#T_share").click(function(){
		opdg("url:/index.php?m=ajax&a=share&id="+$(this).attr("data-id")+"&t="+t,480,450,'用户分享');
	});
	//显示名片
	$(".J_card").live({
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
				top: p.top - 145 + "px",
				left: l + "px"
			});
			$("#J_card_layer .J_card_arrow").css("margin-left", q + "px");
			h = setTimeout(function(){
				clearTimeout(h);
				$("#J_card_layer").show();
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
			clearTimeout(h);
			clearTimeout(n);
			h = setTimeout(function() {
				$("#J_card_layer").hide();
			}, 500);
		}
	});	
});
$(document).ready(function() {
	photo();
	$(".sidebar-l").css("left",($(document.body).width() - 1200)/2-58);
	
	//显示举报
	$(".list li").hover(function(){
		$(this).find(".jb3").show();
	},function(){
		$(this).find(".jb3").hide();
	});
	
	//显示用户信息
	$(".list .head > .user").hover(function(){
		$(this).children(".user-info").show();
	},function(){
		$(this).children(".user-info").hide();
	});

	
	//右边悬浮菜单按钮颜色
	$(".sidebar-l div .btn").hover(function(){
		var index = $(".sidebar-l div .btn").index(this);
		var color = "#666666";
		
		switch(index){
			case 0:
			color = "#33CC99"
			break;
			
			case 1:
			color = "#00A2FF"
			break;
			
			case 2:
			color = "#F5A623"
			break;
			
			case 3:
			color = "#888888"
			break;
		}
		
		$(this).find(".icon").css("fill",color);
	},function(){
		$(this).find(".icon").css("fill","#666666");
	});
	
	buyButton();
	zhankaiCon();
	
	//加载新浪表情插件
	sinaEmo();

	//最新评论/最热评论
	newCom();
	
	//举报弹层
	toReport();
	
	//分享弹层
	shareShow(".share-l .shareButton",".share-l",".shareBox");
	shareShow(".saoma .saomaButton",".saoma",".saomaBox");
	shareShow(".share-c .shareButton",".share-c",".shareBox");
	shareShow(".smgm .smgmButton",".smgm",".qrCodeBox");
	moreLink(".moreButton",".moreUrl");

	// //展开回复
	// $(".djzk").click(function(){
	// 	for(i=2; i < 5; i++){
	// 		$('.zk'+i).wrap('<div class="reply-box zk'+ (i+1)+'"></div>');
	// 		$('.zk'+i).after('<div class="p10">'+
	// 							'<p class="fc-aux-a font-w-b">'+ (i+1) +'楼<span class="fc-blue ml-12">和尚下山来</span></p>'+
	// 							'<p class="mt-5 ml-34">一个同学，自家在当地学校门口开小卖部，小卖部门口的一块场地出租，隔天那块地就被一台娃娃机“占领”，其实每天路过的学生情侣多半是会留步花上几块钱象征性的夹几次娃娃。</p>'+
	// 							'<p class="font-12 fc-aux-a mt-5 ml-34">'+
	// 								'<span class="mr-10 hf cursor-pointer">'+
	// 									'<svg class="icon">'+
	// 										'<!--[if lte IE 8]><desc><img src="../images/ie8/a_43@2x.png" width="14" height="14"></desc><![endif]-->'+
	// 										'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-a_43"></use>'+
	// 									'</svg>'+
	// 									' 回复'+
	// 								'</span>'+
	// 								'<span class="mr-10 cursor-pointer">'+
	// 									'<svg class="icon">'+
	// 										'<!--[if lte IE 8]><desc><img src="../images/ie8/c_6@2x.png" width="14" height="14"></desc><![endif]-->'+
	// 										'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-c_6"></use>'+
	// 									'</svg>'+
	// 									' 赞（299）'+
	// 								'</span>'+
	// 								'<span class="mr-15 cursor-pointer">'+
	// 									'<svg class="icon">'+
	// 										'<!--[if lte IE 8]><desc><img src="../images/ie8/c_7@2x.png" width="14" height="14"></desc><![endif]-->'+
	// 										'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-c_7"></use>'+
	// 									'</svg>'+
	// 									' 踩（68）'+
	// 								'</span>'+
	// 								'<span>20小时前·来自Android客户端</span>'+
	// 							'</p>'+
	// 						'</div>');
	// 	}

	// 	var  info = $(".fz").html();
	// 	//console.log(info);
	// 	$(".zk2").remove();
	// 	$(".zk3").prepend('<div class="reply-box">'+
	// 						info +
	// 					'</div>');
		
	// });
	
	// //显示评论列表
	// $("#tjpl").click(function(){
	// 	$(".list").toggle();
	// 	$(".pages").toggle();
	// 	$(".not-comments").toggle();
	// 	if($(".not-comments").is(':hidden')){
	// 		$("#pls").text("78")
	// 	}else{
	// 		$("#pls").text("0")
	// 	}
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

	$(".list .content").on("click",".J_hf_submit", function() {
	// $(".J_hf_submit").on("click", function() {
		// if(PINER.uid==""){$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');}
		if(PINER.uid==""){
			$("#J_lo_btn").trigger("click");return false;
		}
		var id=$(this).attr("data-id"), content=$(this).parents().children(".write-hf").children().children(".J_hf_content").val();
		var psid=$(this).attr("psid");
		obj = $(this);
		$.post(PINER.root+"/?m=ajax&a=hf",{id:id,content:content,psid:psid},function(result){
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
											'<!--[if lte IE 8]><desc><img src="/public/images/ie8/a_43@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-a_43"></use>'+
										'</svg>'+
										' 回复'+
									'</span>'+
									'<span class="mr-10 cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="/public/images/ie8/c_6@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-c_6"></use>'+
										'</svg>'+
										' 赞（0）'+
									'</span>'+
									'<span class="mr-15 cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="/public/images/ie8/c_7@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-c_7"></use>'+
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
													'<!--[if lte IE 8]><desc><img src="/public/images/ie8/a_33@2x.png" width="8" height="8"></desc><![endif]-->'+
													'<use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-a_33"></use>'+
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
	
	//取消回复
	$(".list .content").on("click",".qx",function(){
		$(this).parents().children(".write-hf").hide();
	});

	//详细页收藏商品
	$(".J_fav").click(function(){
		if(PINER.uid==""){
			LoginPopup();
		}
		var obj=$(this);
		var tar=$(".S_like");
		$.post("/index.php?m=ajax&a=setlikes",{id:obj.attr("data-id"),xid:obj.attr("data-xid")},function(result){
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

		$.get(PINER.root+'/?m=ajax&a=jb',{itemid:$(this).data("id"),xid:$(this).data("xid"),reasonid:reasonid,reason:reason},function(result){
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
		$.post(PINER.root+"/?m=ajax&a=comment_zan",{id:$(this).data("id")},function(result){
			if(result.status==1){
				obj.children("span").text(result.data);
			}else{
				tipsPopup('tips_2', result.msg);
			}
		},'json');
	});

	//分享, 第一次点击加载，第二次加载时百度分享JS不会执行
	var objs = $(".T_share");
	itemid = objs.eq(0).data("id");
	$.ajax({
		url: PINER.root + '/?m=ajax&a=share&t=item&id=' + itemid,
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
	// 	$.get(PINER.root+"/?m=ajax&a=share&t=item",{id:obj.data("id")},function(result){
	// 		if(result.status==1){
	// 			// obj.siblings(".shareBox").html(result.data);
	// 			obj.siblings(".shareBox").prepend(result.data);
	// 			// obj.data("id")="";
	// 		}
	// 	},'json');
	// 	// opdg("url:/index.php?m=ajax&a=share&id="+$(this).attr("data-id")+"&t="+t,480,450,'用户分享');
	// });
	

});

//图片切换设置
jq('#photo').banqh({
	box:"#photo",//总框架
	pic:"#ban_pic",//大图框架
	pnum:"#ban_num",//小图框架
	prev_btn:"#prev_btn",//小图左箭头
	next_btn:"#next_btn",//小图右箭头
	prev:"#prev",//大图左箭头
	next:"#next",//大图右箭头
	autoplay:false,//是否自动播放
	interTime:5000,//图片自动切换间隔
	delayTime:0,//切换一张图片时间
	pop_delayTime:400,//弹出框切换一张图片时间
	order:0,//当前显示的图片（从0开始）
	picdire:true,//大图滚动方向（true为水平方向滚动）
	mindire:true,//小图滚动方向（true为水平方向滚动）
	min_picnum:5,//小图显示数量
	pop_up:false//大图是否有弹出框
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

//layui分页插件
layui.use(['element','laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer
	,element = layui.element;
	//总页数大于页码总数
	laypage.render({
		elem: 'pages-comments'
		,count: 70 //数据总数
		,jump: function(obj){
//			console.log(obj)
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
});

function buyButton(){
	//console.log($("#gotoBuy").offset().top)
	var navOffset = $("#gotoBuy").offset().top;
	$(window).scroll(function() {
		var scrollPos = $(window).scrollTop();
		if(scrollPos > navOffset) {
			$("#buyButton").show();
		} else {
			$("#buyButton").hide();
		}
	});
}

function zhankaiCon() {
    var c = $(".layui-tab-item a img");
    c.hover(function(){
    	if((c.index(this)+1)%3 == 0){
    		$(this).parent("a").addClass("active1");
    	}else{
    		$(this).parent("a").addClass("active");
    	}
    },function(){
    	if((c.index(this)+1)%3 == 0){
    		$(this).parent("a").removeClass("active1");
    	}else{
    		$(this).parent("a").removeClass("active");
    	}
    });
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

//最新or最热评论切换
function newCom(){
	$(".newsCom").click(function(event){
		event.stopPropagation();
		display = $(this).children(".op").css("display");
		if(display=="block"){
			$(this).children(".op").hide();
		}else{
			$(this).children(".op").slideDown(200);
		}
	});
	$(".newsCom .op li").click(function(){
		$(this).parent().find("li").removeClass("active");
		$(this).addClass("active");
		var textInfo = $(this).text();
		$("#newsComContent").text(textInfo);
	});
	
	$(document).click(function(event){
		var _con = $(".newsCom .op");
		if(!_con.is(event.target) && _con.has(event.target).length === 0){
			$(".newsCom .op").hide();
		}
	});
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

$(window).load(function(){
	//替换表情
	$(".comment_info").each(function(){
		$(this).html(AnalyticEmotion($(this).html()));
	});
});


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

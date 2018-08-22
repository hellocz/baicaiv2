$(function(){

	//用户关注
	$(".J_follow_user").on("click",function(){
		if(PINER.uid==""){
			LoginPopup();
			return false;
		}
		var obj=$(this);
		$.ajax({
			type: 'GET',
			url: '/index.php?m=user&a=follow',
			data:{uid:obj.data('uid')},
			dataType: 'json',
			async: false, //同步
			cache: false,
			success: function (res) {
				if(res.status==0){
					tipsPopup('tips_2', res.msg);
				}else{
					obj.addClass("none");
					obj.siblings(".J_unfollow_user").removeClass("none");
					tipsPopup('tips_1', res.msg);
				}
			}
		});
	});

	//取消用户关注
	$(".J_unfollow_user").on("click",function(){
		if(PINER.uid==""){
			LoginPopup();
			return false;
		}
		var obj=$(this);
		$.ajax({
			type: 'GET',
			url: '/index.php?m=user&a=unfollow',
			data:{uid:obj.data('uid')},
			dataType: 'json',
			async: false, //同步
			cache: false,
			success: function (res) {
				if(res.status==0){
					tipsPopup('tips_2', res.msg);
				}else{
					obj.addClass("none");
					obj.siblings(".J_follow_user").removeClass("none");
					tipsPopup('tips_1', res.msg);
				}
			}
		});
	});

	//TAG关注
	$(".J_follow_tag").on('click', function(){
		if(PINER.uid==""){
			LoginPopup();
			return false;
		}
		obj = $(this);
		$.post("/index.php?m=user&a=follow_tag_create",{tag:obj.data("tag")},function(result){
			if(result.status==1){
				// obj.hide();
				// obj.siblings(".J_unfollow_tag").show();
				$(".J_follow_tag[data-tag='"+obj.data("tag")+"'").hide();
				$(".J_unfollow_tag[data-tag='"+obj.data("tag")+"'").show();
				tipsPopup('tips_1', result.msg)
			}else{
				tipsPopup('tips_2', result.msg)
			}
		},'json');
	});

	//取消TAG关注
	$(".J_unfollow_tag").on('click', function(){
		if(PINER.uid==""){
			LoginPopup();
			return false;
		}
		obj = $(this);
		$.post("/index.php?m=user&a=follow_tag_del",{tag:obj.data("tag")},function(result){
			if(result.status==1){
				// obj.hide();
				// obj.siblings(".J_follow_tag").show();
				$(".J_unfollow_tag[data-tag='"+obj.data("tag")+"'").hide();
				$(".J_follow_tag[data-tag='"+obj.data("tag")+"'").show();
				tipsPopup('tips_1', result.msg)
			}else{
				tipsPopup('tips_2', result.msg)
			}
		},'json');
	});

	//签到
	$(".J_sign").click(function(){
		if(PINER.uid==""){
			LoginPopup();
			return false;
		}
		$.get(PINER.root+'/?m=user&a=sign',function(result){
			if(result.status==0){
				tipsPopup('tips_2', result.msg)
			}else{
				tipsPopup('tips_1', result.msg)
			}
		},'json');
	});


	//商品点赞
	$(".J_zan").click(function(){
		if(PINER.uid==""){
			LoginPopup();
		}
		$.get("/index.php?m=ajax&a=zan&t=item",{id:$(this).data("id")},function(result){
			if(result.status==1){
				// tips('点赞成功',1);
				tipsPopup('tips_1', '顶成功');
			}else{
				// tips(result.msg,0);
				tipsPopup('tips_2', result.msg);
			}
		},'json')
	});


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

});







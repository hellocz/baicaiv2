document.write('<script src="/static/js/wap/weui.min.js"></script>');
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
	$("#J_cmt_submit").click(function(){
		if(PINER.uid==""){
			$("#J_lo_btn").trigger("click");return false;
		}
		var itemid = $("#itemid").val(),
			xid = $("#xid").val(),
			content = $("#J_cmt_content").val();
		$.ajax({
			url: PINER.root + '/?g=wap&m=ajax&a=comment',
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
					weui.Loading.success(result.msg);
				}
			}
		});
	});
	$(".w_by").on("click",".J_hf",function(){
		$(".sbhf").remove();
		$(this).parents('li').append('<div class="w_spxx_7 sbhf" style="width: 96%;padding: 2%;background: #eeeeee;border: none;color: #909090;float: left;"><textarea id="J_hf_content" name="content" style="width: 100%;height:60px;"></textarea><input type="button" id="J_hf_submit" data-id="'+$(this).attr('data-id')+'" value="回复" style="float: right;margin: 2% 0 0 0;   width: 60px;height: 30px;background: #3dc399;border: none;border-radius: 4px;line-height: 30px;text-align: center;color: #fff;font-size: 1em;"></div>');
	});
	$(".w_by").on('click','.J_zan',function(){
		var obj=$(this);
		$.post(PINER.root+"/?g=wap&m=ajax&a=comment_zan",{id:$(this).attr("data-id")},function(result){
			if(result.status==1){
				obj.children("i").text(result.data);
			}else{
				weui.Loading.success(result.msg);
			}
		},'json');
	});
	$(".w_xzzr4").on("click","#J_hf_submit",function(){
		if(PINER.uid==""){window.location="index.php?g=wap&m=user&a=login";}
		var id=$(this).attr("data-id"),content=$("#J_hf_content").val();
		$.post(PINER.root+"/?g=wap&m=ajax&a=hf",{id:id,content:content},function(result){
			if(result.status == 1){
				$(".sbhf").remove();
				$("#J_cmt_list").prepend(AnalyticEmotion(result.data));
			}else{
				weui.Loading.success(result.msg);
			}
		},'json');
	})
	$(".w_xzzr4").on("click","#J_cmt_page a",function(){
		var url = $(this).attr('url');
		$.get(url, function(result){
			if(result.status == 1){
				$("#J_cmt_list").html(AnalyticEmotion(result.data.list));
				$("#J_cmt_page").html(result.data.page);
			}else{
				weui.Loading.success(result.msg);
			}
		},'json');
		return false;
	});
});
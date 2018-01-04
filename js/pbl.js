$(function() { 
	function loadMeinv() {
		$('.jiazai').show();

		$.get('/index.php?m=ajax&a=getpbl', {para:para ,p:page,pagesize:pagesize}, function (result){
			if(result.status==1){
				$('.jiazai').hide();
				$("#C_drc").append(result.data.resp);
				$("#J_page").html(result.data.pagebar);
				if(pageend<page||pageend==null) {
					$('#J_page').show();
				}else{
					$('#J_page').show();
				}
			}
		},'json');		
	}
	page=page+1;
	//无限加载
	
	$(window).scroll(function(){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		if(pageend>=page||pageend==null){
			$(".adsbygoogle").attr("info",scrollTop + "|" + windowHeight + "|" + scrollHeight);
		if (scrollTop + windowHeight + 30 >= scrollHeight) {

		if($(".w_gllb_1").css('display') == 'none'){
				loadMeinv();//加载新图片
				page=page+1;
			}
			}
		}
	})
})
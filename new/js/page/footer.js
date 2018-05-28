$(document).ready(function() {
	//侧边栏
	$(window).scroll(function () {
		if ($(window).scrollTop() >= 100) {
			$('#actGotop').fadeIn(300);
		} else {
			$('#actGotop').fadeOut(300);
		}
	});
	$('#actGotop').click(function () {
		$('html,body').animate({ scrollTop: '0px' }, 800);
	});
	
	$("#sidebar-r p a").hover(function(){
		var index = $("#sidebar-r p a").index(this);
		var color = "#7777777";
		
		switch(index){
			case 0:
			color = "#007AFF"
			break;
			
			case 1:
			color = "#4DBB3B"
			break;
			
			case 2:
			color = "#EB3D3D"
			break;
			
			case 3:
			color = "#F6AB27"
			break;
			
			case 4:
			color = "#24B26E"
			break;
			
			case 5:
			color = "#344AA3"
			break;
			
			case 6:
			color = "#51576B"
			break;
		}
		
		$(this).find(".icon").css("fill",color);
	},function(){
		$(this).find(".icon").css("fill","#777777");
	});
	
	//底部图标变色
	$(".ftb").hover(function(){
		$(this).find(".icon").css("fill",'#33CC99');
	},function(){
		$(this).find(".icon").css("fill","#FFFFFF");
	});
	
	$(".ftb").hover(function(){
		$(this).find(".icon").css("fill",'#33CC99');
	},function(){
		$(this).find(".icon").css("fill","#FFFFFF");
	});
	
});
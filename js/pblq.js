$(function() { 
	
	
	$(window).scroll(function(){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		if (scrollTop + windowHeight >= scrollHeight) {
			if($('.inactive').length>0){
				$('.jiazai').show();
				$('.inactive').slice(0,20).removeClass("inactive");
				$('.jiazai').hide();
			}
			}
		
	})
})
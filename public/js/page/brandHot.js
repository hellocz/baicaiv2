$(function(){
	hoverMore();
	clickMore();
});

function hoverMore(){
	$(".brandHot .item").hover(function(){
		var a = $(this).find(".list-box");
		if(a.is(":hidden")){
			$(this).find(".hover-more").show();
		}
	},function(){
		$(this).find(".hover-more").hide();
		$(this).find(".list-box").hide();
	});
}

function clickMore(){
	$(".item .hover-more").click(function(){
		$(this).siblings(".list-box").show();
		var a = $(this);
		setTimeout(function(){
			a.hide();
		},0)
	});
}

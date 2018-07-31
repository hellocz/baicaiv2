$(function(e) {
	pages("pages-sc");
	$("#user").load("../public/user-m.html");
	select("#select");
	
	//鼠标滑过出现删除和移动到
	$(".item-2").hover(function(){
		$(this).find(".cz").show();
		//移动到...
		var width = $(this).find(".select-2").width();
			width = width - 2;
		var display = "";
		
		$(this).find(".select-2").children(".op").css("width",width);
		$(this).find(".select-2").click(function(event){
			event.stopPropagation();
			// console.log(this)
			display = $(this).children("ul").css("display");
			if(display=="block"){
				$(this).children(".op").hide();
				
			}else{
				$(this).children(".op").slideDown(200);
			}
		});
		
		$(this).find(".select-2").find("li").click(function(event){
			event.stopPropagation();
			
			$(this).parent().hide();
		});
	},function(){
		$(this).find(".cz").hide();
		$(this).find(".select-2").find(".op").hide();
	});
});


function changeStatus(){
	var status = $("#status").text();
	if(status=="公开"){
		$("#status").text("不公开");
	}else{
		$("#status").text("公开");
	}
}
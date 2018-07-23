$(function(){
	inTab();
	pages("pages-incj");
	pages("pages-indh");
});

function inTab(){
	$(".title").find("span").click(function(){
		$(this).parent().find("span").removeClass("active");
		$(this).addClass("active");
		$(".listBox").find(".listItem").stop().hide();
		var thisIndex = $(this).parent().find("span").index(this);
		$(".listBox .listItem").eq(thisIndex).show();
		var info = $(this).text();
		if(info =="积分兑换"){
			$("#mydh").show();
			$("#mycj").hide();
			$("#newlist").hide();
		}else{
			$("#mydh").hide();
			$("#mycj").show();
			$("#newlist").show();
		}
	});
}
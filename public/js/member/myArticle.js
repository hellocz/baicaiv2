$(function(e) {
	// tabSub(".tabNav",".rightInfo",".listBox");
	// pages("pages-qb");
	// pages("pages-yc");
	// pages("pages-bl");
	// pages("pages-xx");
	$('#pages').length && ajaxPages('pages', page, content);
	
	// $("#user").load("../public/user-m.html");
	//筛选按钮切换
	// ButtonTabs(".operation li","active");
});
$(function(e) {
	// tabSub(".tabNav",".rightInfo",".listBox");
	// pages("pages-qb");
	// pages("pages-yc");
	// pages("pages-bl");
	// pages("pages-xx");
	$('#pages').length > 0 && ajaxPages('pages', page_count, page_size, page_curr, page_ajax_url, page_content_obj);
	
	// $("#user").load("../public/user-m.html");
	//筛选按钮切换
	// ButtonTabs(".operation li","active");
});
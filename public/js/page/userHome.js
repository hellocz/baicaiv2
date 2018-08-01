$(function(){
	// tabClass(".tabBox li","li","active",".uhList",".list");
	// pages("pages-userdt");
	// pages("pages-useryc");
	// pages("pages-userbl");
	// pages("pages-usertp");
	// pages("pages-userpl");
	// pages("pages-useryq");
	// pages("pages-usersc");
	// pages("pages-usergz");
	$('#pages').length > 0 && ajaxPages('pages', page_count, page_size, page_curr, page_ajax_url, page_content_obj);
});


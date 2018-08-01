$(function(e) {
	// tabSub(".tabNav",".rightInfo",".listBox");
	// pages("pages-dt");
	// pages("pages-yc");
	// pages("pages-bl");
	// pages("pages-tp");
	// pages("pages-pl");
	// pages("pages-yq");
	// pages("pages-sc");
	// pages("pages-gz");
	
	// $("#user").load("../public/user-m.html");

	$('#pages').length > 0 && ajaxPages('pages', page_count, page_size, page_curr, page_ajax_url, page_content_obj);
});
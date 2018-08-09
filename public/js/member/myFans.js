$(function(e) {
	// tabSub(".tabNav",".rightInfo",".listBox");
	// pages("pages-gz");
	// pages("pages-fs");
	
	// $("#user").load("../public/user-m.html");
	$('#pages').length && ajaxPages('pages', page, content);
});
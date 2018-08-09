$(function(e) {
	// tabSub(".tabNav",".rightInfo",".listBox");
	// pages("pages-zj");
	// pages("pages-cj");
	$('#pages').length && ajaxPages('pages', page, content);
	
	// $("#user").load("../public/user-m.html");
});
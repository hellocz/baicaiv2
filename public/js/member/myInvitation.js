$(function(e) {
	tabSub(".tabNav",".rightInfo",".listBox");
	pages("pages-md");
	pages("pages-dd");
	pages("pages-wd");
	
	$("#user").load("../public/user-m.html");
	
	shareShow(".partnerBox .button .btn-3",".button",".shareBox");
});
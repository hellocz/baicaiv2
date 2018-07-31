$(function(e) {
	tabSub(".tabNav",".rightInfo",".listBox");
	pages("pages-card");
	
	$("#user").load("../public/user-m.html");
	
	$(".radio").click(function(){
		if($(this).find("i").is('.active')){
			$(this).find("i").removeClass("active");
		}else{
			$(this).find("i").addClass("active");
		}
	});
});


//分享复制链接
function copyCode(a,b){
	var content = $(a).data("copy");  
//	console.log(content)
    var clipboard = new Clipboard(b, {  
        text: function() {  
            return content;  
        }  
    });  
    clipboard.on('success', function(e) {
		$(a).text("已复制");
		$(a).css({
			"border-color":"#CFCFCF",
			"background-color":"#CFCFCF",
			"color":"#FFFFFF"
		})
    });  

    clipboard.on('error', function(e) {  
    	layer.msg("复制失败");
        console.log(e);  
    });  
}
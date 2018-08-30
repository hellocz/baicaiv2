$(document).ready(function() {

    $('#face').SinaEmotion($('#J_msg_content'));

    $('#J_msg_send').on('click', function(){

        var to_id = $(this).attr('data-to_id'),
        content = $('#J_msg_content').val();
        $.ajax({
            url: PINER.root + '/?m=message&a=publish',
            type: 'POST',
            data: {
                to_id: to_id,
                content: content
            },
            dataType: 'json',
            success: function(result){
                if(result.status == 1){
                    //列表动态添加
                    $('#J_msg_list').prepend(AnalyticEmotion(result.data));
                    $('#J_msg_content').val('');
                }else{
                    tipsPopup('tips_2', result.msg);
                }
            }
        });
    });

});

function makeExpandingArea(el) {  
    var setStyle = function(el) {  
        el.style.height = 'auto';  
        el.style.height = el.scrollHeight + 'px';  
        // console.log(el.scrollHeight);  
    }  
    var delayedResize = function(el) {  
        window.setTimeout(function() {  
			setStyle(el)  
		},0);
    }  
    if (el.addEventListener) {  
        el.addEventListener('input', function() {  
            setStyle(el)  
        }, false);  
        setStyle(el)  
    } else if (el.attachEvent) {  
        el.attachEvent('onpropertychange', function() {  
            setStyle(el)  
        });  
        setStyle(el)  
    }  
    if (window.VBArray && window.addEventListener) { //IE9  
        el.attachEvent("onkeydown", function() {  
            var key = window.event.keyCode;  
            if (key == 8 || key == 46) delayedResize(el);  

        });  
        el.attachEvent("oncut", function() {  
            delayedResize(el);  
        }); //处理粘贴  
    }  
}  
makeExpandingArea(document.getElementById('J_msg_content'));


$(window).load(function(){
    //替换表情
    $(".info").each(function(){
        $(this).html(AnalyticEmotion($(this).html()));
    });
});
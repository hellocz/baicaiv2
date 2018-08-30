$(function() {
    $('#pages').length && ajaxPages('pages', page, content);

    // //删除单个消息
    // $('.J_message_del').on('click', function(){
    //     var mid = $(this).attr('data-mid');
    //     $.getJSON(PINER.root + '/?m=message&a=del', {mid:mid}, function(result){
    //         if (result.status == '1') {
    //             $('#ml_'+mid).slideUp('fast', function(){
    //                 $(this).remove();
    //             });
    //         } else {
    //             tips(result.msg,0);
    //         }
    //     });
    // });

    //删除单个对话
    $('.J_talk_del').on('click', function(){
        var obj = $(this);
        var ftid = obj.data('ftid');
        $.getJSON(PINER.root + '/?m=message&a=del_talk', {ftid:ftid}, function(result){
            layer.msg(result.msg);
            if (result.status == '1') {
                obj.parents('.talk').remove();
            }
        });
    });

    //删除所有对话
    $('.J_all_del').on('click', function(){
        confirm('提示','是否删除全部消息？',function() {
	        $.getJSON(PINER.root + '/?m=message&a=del_all', {}, function(result){
			layer.msg(result.msg);
			if (result.status == '1'){ //删除成功
				window.location.reload();
			}
	        });
        });
    });

     //全部设为已读
    $('.J_all_read').on('click', function(){
        $.getJSON(PINER.root + '/?m=message&a=read_all', {}, function(result){
		if (result.status == '1'){ 
			window.location.reload();
		}
        });
    });   

});
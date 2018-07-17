$(document).ready(function () {
    //获得文本框对象
    var t = $("#text_box");
    //初始化数量为1,并失效减
    $('#min').attr('disabled', true);
    //数量增加操作
    $("#add").click(function () {
        // 给获取的val加上绝对值，避免出现负数
        t.val(Math.abs(parseInt(t.val())) + 1);
        if (parseInt(t.val()) != 1) {
            $('#min').attr('disabled', false);
        };
    })
    //数量减少操作
    $("#min").click(function () {
        t.val(Math.abs(parseInt(t.val())) - 1);
        if (parseInt(t.val()) == 1) {
            $('#min').attr('disabled', true);
        };
    })
});


//layui分页插件
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	
	laypage.render({
		elem: 'pages-inld'
		,count: 70 //数据总数
		,jump: function(obj,first){
			if(!first){
				$("#pages-inld").siblings(".page-loading").show();
				setTimeout(function(){
					$("#pages-inld").siblings(".page-loading").hide();
				},500)
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
});
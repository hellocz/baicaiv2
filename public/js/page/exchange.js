// $(function(){
// 	inTab();
// });
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
//积分抽奖、兑换order分页
ajaxPages('pages-order', page, content);
//积分抽奖分页
ajaxPages('pages-exchange', page, content);
//积分兑换分页
ajaxPages('pages-lucky', page, content);


function inTab(){
	$(".title").find("span").click(function(){
		$(this).parent().find("span").removeClass("active");
		$(this).addClass("active");
		$(".listBox").find(".listItem").stop().hide();
		var thisIndex = $(this).parent().find("span").index(this);
		$(".listBox .listItem").eq(thisIndex).show();
		var info = $(this).text();
		if(info =="积分兑换"){
			$("#mydh").show();
			$("#mycj").hide();
			$("#newlist").hide();
		}else{
			$("#mydh").hide();
			$("#mycj").show();
			$("#newlist").show();
		}
	});
}
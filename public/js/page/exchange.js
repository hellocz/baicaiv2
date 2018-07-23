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
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	
	//积分抽奖-详情页分页
	laypage.render({
		elem: 'pages-inld'
		,count: page_count //数据总数
		,limit: page_size //数据总数
		,curr: page
		,jump: function(obj,first){
			if(!first){
				$("#pages-inld").siblings(".page-loading").show();
				// setTimeout(function(){
				// 	$("#pages-inld").siblings(".page-loading").hide();
				// },500)

				$.get(page_url, {p:obj.curr,pagesize:obj.limit}, function (result){
					if(result.status==1){
						$("#pages-inld").siblings(".page-loading").hide();
						page_content_obj.html(result.data.list);
					}
				},'json');
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
});

//layui分页插件
layui.use(['laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer;
	
	//积分抽奖分页
	laypage.render({
		elem: 'pages-incj'
		,count: page_count //数据总数
		,limit: page_size //数据总数
		,curr: page
		,jump: function(obj,first){
			if(!first){
				$("#pages-incj").siblings(".page-loading").show();
				// setTimeout(function(){
				// 	$("#pages-incj").siblings(".page-loading").hide();
				// },500)

				$.get(page_url, {p:obj.curr,pagesize:obj.limit}, function (result){
					if(result.status==1){
						$("#pages-incj").siblings(".page-loading").hide();
						page_content_obj.html(result.data.list);
					}
				},'json');
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
	//积分兑换分页
	laypage.render({
		elem: 'pages-indh'
		,count: page_count //数据总数
		,limit: page_size //数据总数
		,curr: page
		,jump: function(obj,first){
			if(!first){
				$("#pages-indh").siblings(".page-loading").show();
				// setTimeout(function(){
				// 	$("#pages-indh").siblings(".page-loading").hide();
				// },500)

				$.get(page_url, {p:obj.curr,pagesize:obj.limit}, function (result){
					if(result.status==1){
						$("#pages-indh").siblings(".page-loading").hide();
						page_content_obj.html(result.data.list);
					}
				},'json');
			}
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
	
});

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
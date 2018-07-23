$(document).ready(function() {
	
	//显示举报
	$(".list li").hover(function(){
		$(this).find(".jb3").show();
	},function(){
		$(this).find(".jb3").hide();
	});
	
	//显示用户信息
	$(".list .head > .user").hover(function(){
		$(this).children(".user-info").show();
	},function(){
		$(this).children(".user-info").hide();
	});
	
	//显示回复
	$(".list .content").on("click",".hf", function() {
		$(".comments").find(".write-hf").hide();
		$(this).parents().children(".write-hf").show();
		$('html, body').animate({
			scrollTop: $(this).parents().children(".write-hf").offset().top-117,
		},'fast');
	});
	
	//取消回复
	$(".list .content").on("click",".qx",function(){
		$(this).parents().children(".write-hf").hide();
	});
	
	//展开回复
	$(".djzk").click(function(){
		for(i=2; i < 5; i++){
			$('.zk'+i).wrap('<div class="reply-box zk'+ (i+1)+'"></div>');
			$('.zk'+i).after('<div class="p10">'+
								'<p class="fc-aux-a font-w-b">'+ (i+1) +'楼<span class="ml-12"><a href="userHome.html" class="a-green hover-underline">和尚下山来</a></span></p>'+
								'<p class="mt-5 ml-34">一个同学，自家在当地学校门口开小卖部，小卖部门口的一块场地出租，隔天那块地就被一台娃娃机“占领”，其实每天路过的学生情侣多半是会留步花上几块钱象征性的夹几次娃娃。</p>'+
								'<p class="font-12 fc-aux-a mt-5 ml-34">'+
									'<span class="mr-10 hf cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="../images/ie8/a_43@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-a_43"></use>'+
										'</svg>'+
										' 回复'+
									'</span>'+
									'<span class="mr-10 cursor-pointer" onclick="tipsPopup(\'tips_1\',\'投票成功\')">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="../images/ie8/c_6@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-c_6"></use>'+
										'</svg>'+
										' 赞（299）'+
									'</span>'+
									'<span class="mr-15 cursor-pointer" onclick="tipsPopup(\'tips_1\',\'投票成功\')">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="../images/ie8/c_7@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-c_7"></use>'+
										'</svg>'+
										' 踩（68）'+
									'</span>'+
									'<span>20小时前·<a href="download.html" target="_blank" class="hover-underline">来自Android客户端</a></span>'+
								'</p>'+
							'</div>');
		}

		var  info = $(".fz").html();
		//console.log(info);
		$(".zk2").remove();
		$(".zk3").prepend('<div class="reply-box">'+
							info +
						'</div>');
		
	});
	
	//显示评论列表
	$("#tjpl").click(function(){
		$(".list").toggle();
		$(".pages").toggle();
		$(".not-comments").toggle();
		if($(".not-comments").is(':hidden')){
			$("#pls").text("78")
		}else{
			$("#pls").text("0")
		}
	});
	
	//加载新浪表情插件
	sinaEmo();

	//最新评论/最热评论
	newCom();
	
	//举报弹层
	toReport();
	
	//分享弹层
	shareShow(".op2 .shareButton",".op2",".shareBox");
});

//layui分页插件
layui.use(['element','laypage', 'layer'], function(){
	var laypage = layui.laypage
	,layer = layui.layer
	,element = layui.element;
	//总页数大于页码总数
	laypage.render({
		elem: 'pages-comments'
		,count: 70 //数据总数
		,jump: function(obj){
//			console.log(obj)
		}
		,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
		,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
	});
});

function sinaEmo(){
	//绑定新浪表情
	var len = $(".comments").find(".emotion").length;
    for(i=0; i < len; i++){
    	$('#face-'+(i+1)).SinaEmotion($('#emotion-'+(i+1)));
    }
}

//最新or最热评论切换
function newCom(){
	$(".newsCom").click(function(event){
		event.stopPropagation();
		display = $(this).children(".op").css("display");
		if(display=="block"){
			$(this).children(".op").hide();
		}else{
			$(this).children(".op").slideDown(200);
		}
	});
	$(".newsCom .op li").click(function(){
		$(this).parent().find("li").removeClass("active");
		$(this).addClass("active");
		var textInfo = $(this).text();
		$("#newsComContent").text(textInfo);
	});
	
	$(document).click(function(event){
		var _con = $(".newsCom .op");
		if(!_con.is(event.target) && _con.has(event.target).length === 0){
			$(".newsCom .op").hide();
		}
	});
}

//显示举报弹层
function toReport(){
	$(".jb").click(function(){
		$(".jbBox").hide();
		$(this).siblings(".jbBox").show();
	});
	
	$(document).click(function(event){
		var _con = $(".jb");
		var _con1 = $(".jbBox");
		if(!_con.is(event.target) && _con.has(event.target).length === 0 && !_con1.is(event.target) && _con1.has(event.target).length === 0){
			$(".jbBox").hide();
			$(".jbBox .input").hide();
			$(".jbBox  ul li").children("i").removeClass("active");
		}
	});
	
	$(".other").click(function(){
		var active = $(this).children("i").is(".active");
		if(!active){
			$(this).parent().siblings(".input").show();
		}else{
			$(this).parent().siblings(".input").hide();
		}
	});
	
	$(".jbBox ul li").click(function(){
		var active = $(this).children("i").is(".active");
		if(!active){
			$(this).children("i").addClass("active");
		}else{
			$(this).children("i").removeClass("active");
		}
	});
	
	$(".jbBox .button1 button").click(function(){
		$(".jbBox").hide();
		$(".jbBox .input").hide();
		$(".jbBox ul li").children("i").removeClass("active");
	});

}


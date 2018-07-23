$(document).ready(function() {
	photo();
	$(".sidebar-l").css("left",($(document.body).width() - 1200)/2-58);
	
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
								'<p class="fc-aux-a font-w-b">'+ (i+1) +'楼<span class="fc-blue ml-12">和尚下山来</span></p>'+
								'<p class="mt-5 ml-34">一个同学，自家在当地学校门口开小卖部，小卖部门口的一块场地出租，隔天那块地就被一台娃娃机“占领”，其实每天路过的学生情侣多半是会留步花上几块钱象征性的夹几次娃娃。</p>'+
								'<p class="font-12 fc-aux-a mt-5 ml-34">'+
									'<span class="mr-10 hf cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="../images/ie8/a_43@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-a_43"></use>'+
										'</svg>'+
										' 回复'+
									'</span>'+
									'<span class="mr-10 cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="../images/ie8/c_6@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-c_6"></use>'+
										'</svg>'+
										' 赞（299）'+
									'</span>'+
									'<span class="mr-15 cursor-pointer">'+
										'<svg class="icon">'+
											'<!--[if lte IE 8]><desc><img src="../images/ie8/c_7@2x.png" width="14" height="14"></desc><![endif]-->'+
											'<use xlink:href="../images/svg_sprite/icon_symbol.svg#icon-c_7"></use>'+
										'</svg>'+
										' 踩（68）'+
									'</span>'+
									'<span>20小时前·来自Android客户端</span>'+
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
	
	//右边悬浮菜单按钮颜色
	$(".sidebar-l div .btn").hover(function(){
		var index = $(".sidebar-l div .btn").index(this);
		var color = "#666666";
		
		switch(index){
			case 0:
			color = "#33CC99"
			break;
			
			case 1:
			color = "#00A2FF"
			break;
			
			case 2:
			color = "#F5A623"
			break;
			
			case 3:
			color = "#888888"
			break;
		}
		
		$(this).find(".icon").css("fill",color);
	},function(){
		$(this).find(".icon").css("fill","#666666");
	});
	
	buyButton();
	zhankaiCon();
	
	//加载新浪表情插件
	sinaEmo();

	//最新评论/最热评论
	newCom();
	
	//举报弹层
	toReport();
	
	//分享弹层
	shareShow(".share-l .shareButton",".share-l",".shareBox");
	shareShow(".saoma .saomaButton",".saoma",".saomaBox");
	shareShow(".share-c .shareButton",".share-c",".shareBox");
	shareShow(".smgm .smgmButton",".smgm",".qrCodeBox");
	moreLink(".moreButton",".moreUrl")
});

//图片切换设置
jq('#photo').banqh({
	box:"#photo",//总框架
	pic:"#ban_pic",//大图框架
	pnum:"#ban_num",//小图框架
	prev_btn:"#prev_btn",//小图左箭头
	next_btn:"#next_btn",//小图右箭头
	prev:"#prev",//大图左箭头
	next:"#next",//大图右箭头
	autoplay:false,//是否自动播放
	interTime:5000,//图片自动切换间隔
	delayTime:0,//切换一张图片时间
	pop_delayTime:400,//弹出框切换一张图片时间
	order:0,//当前显示的图片（从0开始）
	picdire:true,//大图滚动方向（true为水平方向滚动）
	mindire:true,//小图滚动方向（true为水平方向滚动）
	min_picnum:5,//小图显示数量
	pop_up:false//大图是否有弹出框
});

function photo(){
	var img = document.getElementById("ban_pic");
	if(img.attachEvent){
		img.attachEvent("mouseover", function(e) {
		    var box = img.getBoundingClientRect();
		    if((e.clientX - box.left) < ((box.right - box.left) / 2)){
		    	$("#prev").show();
		    	$("#next").hide();
		    }else{
		    	$("#next").show();
		    	$("#prev").hide();
		    }
		});
	}else{
		img.addEventListener("mouseover", function(e) {
		    var box = img.getBoundingClientRect();
		    if((e.clientX - box.left) < ((box.right - box.left) / 2)){
		    	$("#prev").show();
		    	$("#next").hide();
		    }else{
		    	$("#next").show();
		    	$("#prev").hide();
		    }
		});
	}
	if(img.attachEvent){
		img.attachEvent("mouseout", function() {
		    $("#prev").hide();
		    $("#next").hide();
		});
	}else{
		img.addEventListener("mouseout", function() {
		    $("#prev").hide();
		    $("#next").hide();
		});
	}
}

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

function buyButton(){
	//console.log($("#gotoBuy").offset().top)
	var navOffset = $("#gotoBuy").offset().top;
	$(window).scroll(function() {
		var scrollPos = $(window).scrollTop();
		if(scrollPos > navOffset) {
			$("#buyButton").show();
		} else {
			$("#buyButton").hide();
		}
	});
}

function zhankaiCon() {
    var c = $(".layui-tab-item a img");
    c.hover(function(){
    	if((c.index(this)+1)%3 == 0){
    		$(this).parent("a").addClass("active1");
    	}else{
    		$(this).parent("a").addClass("active");
    	}
    },function(){
    	if((c.index(this)+1)%3 == 0){
    		$(this).parent("a").removeClass("active1");
    	}else{
    		$(this).parent("a").removeClass("active");
    	}
    });
}


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


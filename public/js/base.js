$(document).ready(function() {
	//svg兼容性
	svg4everybody();
	
	//判断浏览器是否支持placeholder属性
	supportPlaceholder = 'placeholder' in document.createElement('input'),
		placeholder = function(input) {

			var text = input.attr('placeholder'),
				defaultValue = input.defaultValue;

			if(!defaultValue) {

				input.val(text).addClass("phcolor");
			}

			input.focus(function() {

				if(input.val() == text) {

					$(this).val("");
				}
			});

			input.blur(function() {

				if(input.val() == "") {

					$(this).val(text).addClass("phcolor");
				}
			});

			//输入的字符不为灰色
			input.keydown(function() {

				$(this).removeClass("phcolor");
			});
		};

	//当浏览器不支持placeholder属性时，调用placeholder函数
	if(!supportPlaceholder) {

		$('input').each(function() {

			text = $(this).attr("placeholder");

			if($(this).attr("type") == "text") {

				placeholder($(this));
			}
		});
	}
	
});

//置顶菜单
function navFixed(a,b){
	var navOffset = $("#"+a).offset().top;
	$(window).scroll(function() {
		var scrollPos = $(window).scrollTop();
		if(scrollPos >= navOffset) {
			$("#"+a).addClass(b);
		} else {
			$("#"+a).removeClass(b);
		}
	});
}

//目录分类
function anchorTop(b, a) {
	if($(b).length) {
		var c = $(b).offset().top;
		e = $("#header").height();
		$(window).scroll(function() {
			var f = $(window).scrollTop();
			if(f >= c - e) {
				$(b).addClass("fixed");
				$(a).css("paddingTop", "180px");
			} else {
				$(b).removeClass("fixed");
				$(a).css("paddingTop", 0);
			}
		});
	}
}

function anchorClick(a) {
	$(a).find("li").click(function() {
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
		var d = $(a).outerHeight(true) + $("#header").height();
		var c = $(a).find("li").index(this);
		console.log(c)
		var b = $("#list-" + (c + 1)).offset().top;
		$("html,body").animate({
				scrollTop: b - d
			},
			150);
		return false;
	});
}

//  = tab菜单切换 = 
//	$(".r-list-box .tabNav a").click(function(){
//		$(this).parent().find("a").removeClass("active");
//		$(this).addClass("active");
//		$(".r-list-box").find(".list-box").stop().hide();
//		var thisIndex = $(this).parent().find("a").index(this);
//		$(".r-list-box .list-box").eq(thisIndex).show();
//	});
// a:触发按钮 , b:触发按钮标签, c:按钮添加样式, d:父元素 , e:需要切换的元素class
function tabClass(a,b,c,d,e){
	$(a).click(function(){
		$(this).parent().find(b).removeClass(c);
		$(this).addClass(c);
		$(d).find(e).stop().hide();
		var thisIndex = $(this).parent().find(b).index(this);
		$(d+" "+e).eq(thisIndex).show();
	});
}

function tabSub(a,b,c){
	$(a + " li").click(function(){
		$(this).parent().find("li").removeClass("active");
		$(this).addClass("active");
		$(b).find(c).stop().hide();
		var thisIndex = $(this).parent().find("li").index(this);
		$(b+" "+c).eq(thisIndex).show();
	});
}

//下拉菜单控件 select-1
function select(a,b){
	var width = $(a).width();
		width = width - 2;
	var display = "";
	
	$(a +" .op").css("width",width);
	
	$(a).click(function(event){
		event.stopPropagation();
		display = $(a +" ul").css("display");
		if(display=="block"){
			$(this).children(".op").hide();
			if(b == 1){
				$(this).children(".select").css("background-image","url(../images/ie8/a_16@2x.png)");
			}
		}else{
			$(this).children(".op").slideDown(200);
			if(b == 1){
				$(this).children(".select").css("background-image","url(../images/ie8/a_16s@2x.png)");
			}
		}
	});
	
	$(a +" .op li").click(function(){
		$(this).parent().find("li").removeClass("active");
		$(this).addClass("active");
		var textInfo = $(this).text();
		$(a +" .select").text(textInfo);
	});
	
	$(document).click(function(event){
		var _con = $(a +" .op");
		if(!_con.is(event.target) && _con.has(event.target).length === 0){
			_con.hide();
			if(b == 1){
				$(a +" .select").css("background-image","url(../images/ie8/a_16@2x.png)");
			}
		}
	});
}

//排版切换
function arrClick(a,b,c){
	$(".operation .arr-1").click(function(){
//		$(this).addClass("active");
//		$(this).siblings(".arr-2").removeClass("active")
		$(this).css("background-position","-28px 0");
		$(this).siblings(".arr-2").css("background-position","0 -28px")
		$(a).find(c).hide();
		$(a).find(b).show();
		$(a).parent().addClass("clearfix");
		$(this).parent().parent().siblings(".attribute").hide();
	})
	$(".operation .arr-2").click(function(){
//		$(this).addClass("active");
//		$(this).siblings(".arr-2").removeClass("active")
		$(this).css("background-position","-28px -28px");
		$(this).siblings(".arr-1").css("background-position","0 0")
		$(a).find(b).hide();
		$(a).find(c).show();
		$(a).parent().removeClass("clearfix");
		
		$(this).parent().parent().siblings(".attribute").show();
	})
}

//卡片向上展开
function crossUp(a,b){
	$(a).hover(function(){
		$(this).find(b).stop().slideDown("show");
	},function(){
		$(this).find(b).hide();
	});
}

// 单选按钮
function radio(){
	$(".radio-1 div").click(function(){
		$(this).siblings().children("i").removeClass("active")
		$(this).children("i").addClass("active")
	});
}


function ButtonTabs(a,b){
	$(a).click(function(){
		$(this).siblings().removeClass(b);
		$(this).addClass(b);
	});
}


function pages(a){
	layui.use(['laypage', 'layer'], function(){
		var laypage = layui.laypage
		,layer = layui.layer;
		//总页数大于页码总数
		laypage.render({
			elem: a
			,count: 70 //数据总数
			,jump: function(obj,first){
				if(!first){
					$("#"+a).siblings(".page-loading").show();
					setTimeout(function(){
						$("#"+a).siblings(".page-loading").hide();
					},500)
				}
			}
			,prev:'<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>'
			,next:'<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>'
		});
	});
}

//下拉更多连接
function moreUrl(a,b){
	$(a).hover(function(){
		$(this).siblings(b).show();
	});
}

function moreLink(a,b){
	$(a).hover(function(){
		$(this).find(b).show();
	},function(){
		$(this).find(b).hide();
	});
}

//滚动到页面底部
function GoToBottom(){
	var h = $(document).height()-$(window).height();
            $(document).scrollTop(h); 
}


//分享复制链接
function copylink(a,b){
	var content = $(a).data("copy");  
//	console.log(content)
    var clipboard = new Clipboard(b, {  
        text: function() {  
            return content;  
        }  
    });  
    clipboard.on('success', function(e) {  
//      alert("复制成功");  
		layer.msg("复制成功");
    });  

    clipboard.on('error', function(e) {  
    	layer.msg("复制失败");
        console.log(e);  
    });  
}

//点击按钮展示分享层
function shareShow(a,b,c){
	$(a).click(function(){
		// console.log($(this).siblings())
		$(this).siblings(c).show();
	});
	$(document).click(function(event){
		var _con = $(b);
		if(!_con.is(event.target) && _con.has(event.target).length === 0){
			$(b+" "+c).hide();
		}
	});
}


//  ========== 
//  = tips提示方法
//	= 传入参数: icon = tips_1成功图标，tips_2失败图标，tips_3警告图标，tips_4评论图标，tips_5签到图标
//	=         info = 提示的文字内容（可使用html标签）
//  ========== 
function tipsPopup(icon,info){
	layui.use(['layer'], function(){
		layer.open({
			type: 1,
			title: false,
			closeBtn: 1,
			shadeClose: false,
			time:5000,
			shade:0.01,
			skin: 'tipsBox',
			anim:0,
			area: '230px',
			content: '<div id="tipsPopup"><div class="tips '+ icon +'"></div><div class="info">'+ info +'</div></div>'
		});
	});
}

//

function askPopup(info){
	layui.use(['layer'], function(){
		layer.confirm(info, {
			title:'提示',
			skin:'askBox',
		}, function(index){
			layer.close(index);
			tipsPopup('tips_1','已成功兑换<br><a href="myExchange.html" class="fc-green">查看我的兑换</a>');
		});
	});
}


//10秒后自动跳转
function ChangeTime() {
	var time;
	time = $("#time").text();
	time = parseInt(time);
	time--;
	if(time <= 0) {
		window.location.href = "../index.html";
	} else {
		$("#time").text(time);
		setTimeout(ChangeTime, 1000);
	}
}

//弹出登录层
function LoginPopup(type){
	var isLogin = "";
	var isReg = "none"
	if(type==1){
		isLogin = "none";
		isReg = "";
	}
	layer.open({
		type: 1,
		title: false,
		closeBtn: 1,
		shadeClose: false,
		shade:0.7,
		anim:2,
		skin: 'loginPopup',
		area: '430px',
		content: '<div class="loginBox '+ isLogin +'">'+
				 	'<div class="text-center">'+
				 		'<p class="font-36">欢迎回来</p>'+
				 		'<p class="font-16 fc-aux-a mt-8">登录账户开启更多功能</p>'+
				 	'</div>'+
				 	'<div class="mt-40"><input type="text" placeholder="用户名/手机号/邮箱" class="input-3 loginInput input1"></div>'+
				 	'<div class="mt-15"><input type="password" placeholder="登录密码" class="input-3 loginInput input2"></div>'+
				 	'<div class="clearfix mt-15 font-13 fc-gray">'+
				 		'<div class="fl"><label class="checkBox"><input type="checkbox"><span></span>记住密码</label></div>'+
				 		'<div class="fr"><a href="./page/retrievePassword.html">忘记密码?</a></div>'+
				 	'</div>'+
				 	'<div class="button btn-3 cursor-pointer mt-24">登录</div>'+
				 	'<div class="font-14 mt-32 text-center"><span class="fc-green loginType cursor-pointer">手机快捷登录</span> or 没有账户？<span class="fc-green cursor-pointer registeredButton">注册</span></div>'+
					'<div class="thirdLogin"><a href="#" class="wx mr-15">微信登录</a><a href="#" class="qq mr-15">QQ登录</a><a href="#" class="wb">微博登录</a></div>'+
				 '</div>'+
				 '<div class="mobileBox none">'+
				 	'<div class="text-center">'+
				 		'<p class="font-36">欢迎回来</p>'+
				 		'<p class="font-16 fc-aux-a mt-8">登录账户开启更多功能</p>'+
				 	'</div>'+
				 	'<div class="mt-40 mobile"><input type="text" placeholder="手机号码" maxlength="11" class="input-3 loginInput input3"><input type="button" class="yzm" onclick="settime(this)" value="获取验证码"></div>'+
				 	'<div class="mt-15"><input type="text" placeholder="手机验证码" maxlength="6" class="input-3 loginInput input4"></div>'+
				 	'<div class="button btn-3 cursor-pointer mt-24">登录</div>'+
				 	'<div class="font-14 mt-32 text-center"><span class="fc-green loginType cursor-pointer">用户名密码登录</span> or 没有账户？<span class="fc-green cursor-pointer registeredButton">注册</span></div>'+
					'<div class="thirdLogin"><a href="#" class="wx mr-15">微信登录</a><a href="#" class="qq mr-15">QQ登录</a><a href="#" class="wb">微博登录</a></div>'+
				 '</div>'+
				 '<div class="registeredBox '+ isReg +'">'+
				 	'<div class="text-center">'+
				 		'<p class="font-36">创建账户</p>'+
				 		'<p class="font-16 fc-aux-a mt-8">做一个精明的消费者</p>'+
				 	'</div>'+
				 	'<div class="mt-40 mobile"><input type="text" placeholder="手机号码" maxlength="11" class="input-3 loginInput input3"><input type="button" class="yzm" onclick="settime(this)" value="获取验证码"></div>'+
				 	'<div class="mt-15"><input type="text" placeholder="手机验证码" maxlength="6" class="input-3 loginInput input4"></div>'+
				 	'<div class="mt-15"><input type="text" placeholder="用户名" class="input-3 loginInput input1"></div>'+
				 	'<div class="mt-15"><input type="password" placeholder="设置登录密码" class="input-3 loginInput input2"></div>'+
				 	'<div class="button btn-3 cursor-pointer mt-24">创建账户</div>'+
				 	'<div class="mt-5 fc-aux-9">尊敬的用户，点击创建账户按钮即说明您已阅读并同意白菜哦<span class="fc-green">《用户服务协议》</span>以及<span class="fc-green">《隐私条款》</span></div>'+
				 	'<div class="font-14 mt-20 text-center">已有账号？<span class="fc-green cursor-pointer loginButton">登录</span></div>'+
				 '</div>'
	});
	$(".loginPopup .loginType").click(function(){
		if($(".loginPopup .loginBox").is(":hidden")){
			$(".loginPopup .loginBox").show();
			$(".loginPopup .mobileBox").hide();
		}else{
			$(".loginPopup .loginBox").hide();
			$(".loginPopup .mobileBox").show();
		}
	});
	
	$(".loginPopup .registeredButton").click(function(){
		$(".loginPopup .loginBox").hide();
		$(".loginPopup .mobileBox").hide();
		$(".loginPopup .registeredBox").show();
	});
	
	$(".loginPopup .loginButton").click(function(){
		$(".loginPopup .loginBox").show();
		$(".loginPopup .mobileBox").hide();
		$(".loginPopup .registeredBox").hide();
	});
}

var countdown = 3;

function settime(val){
	if (countdown == 0) {  
		val.removeAttribute("disabled");
		$(val).css("color","#33CC99")
		val.value="获取验证码";
		countdown = 3;
	} else {
		val.setAttribute("disabled", true);
		$(val).css("color","#CCCCCC")
		val.value="重新发送 " + countdown + "s";
		countdown--;
		
		setTimeout(function() {
			settime(val)
		},1000)
	}
}

//搜索树状菜单
function treeNav(a){
	$(a).click(function(){
		if($(this).siblings("li").is(':hidden')){
			$(this).siblings("li").show();
			$(this).parent().addClass("active");
		}else{
			$(this).siblings("li").hide();
			$(this).parent().removeClass("active");
		}
	})
}

function newMsg(){
	$(".newMsg").show();
	$(".newMsgTitle").click(function(){
		if($(this).siblings("ul").is(':hidden')){
			$(this).siblings("ul").show();
			$(this).parent().addClass("newMsg-down");
		}else{
			$(this).siblings("ul").hide();
			$(this).parent().removeClass("newMsg-down");
		}
	});
}
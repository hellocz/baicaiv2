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
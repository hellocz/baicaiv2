function currentUser(ticket) {
    if (ticket == null || ticket.length <= 0 || ticket == "") {
        return { id: 0, name: "", client: getCookie('client'), version: getCookie('version') };
    } else {
        var details = ticket.split('&');
        return {
            id: details[0],
            name: decodeURIComponent(details[1]),
            pic: decodeURIComponent(details[3].split('|')[0]),
            client: getCookie('client'),
            version: getCookie('version')
        };
    }
}
function isLogin() {
    if (_user.id == undefined || _user.id <= 0) {
        return false;
    }
    return true;
}
var _user = { id: 0, name: "", pic: "", client: "", version: "" };
_user = currentUser(getCookie("certification"));

function getCookie(c_name) {
    if (document.cookie.length > 0) {//先查询cookie是否为空，为空就return ""
        c_start = document.cookie.indexOf(c_name + "=");　　
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) c_end = document.cookie.length;
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return ""
}

function setCookie(name, value, day, domain) {
    var _cookie = name + "=" + escape(value);
    if (day) {
        var exp = new Date;
        exp.setTime(exp.getTime() + 60 * 60 * 24 * day * 1e3), _cookie += ";expires=" + exp.toGMTString()
    }
    domain && (_cookie += ";domain=" + escape(domain)), document.cookie = _cookie
}

function delCookie(name) {
    var exp = new Date;
    exp.setTime(exp.getTime() - 1);
    var cval = getCookie(name);
    null != cval && (document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString())
}


function setLocal(name,value){
    if(window.localStorage){
        localStorage.removeItem(name);
        localStorage.setItem(name,value);
    } else {
        var Days = 1000;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
    };
    return false;
}
function getLocal(name) {
    if(window.localStorage){
        var arr,reg = new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        arr = localStorage.getItem(name);
        return arr;
    } else {
        var arr,reg = new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr = document.cookie.match(reg)){
            return unescape(arr[2]);
        }else{
            return null;
        }
    };
}
function delLocal(name){
    if(window.localStorage){
        localStorage.removeItem(name);
    } else {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=getCookie(name);
        if(cval!=null){document.cookie= name + "="+cval+";expires="+exp.toGMTString();}
    };
}

// 检测手机号码
function isMobileNumber(mobileNumber) {
    if (mobileNumber == '') {
        return "手机号码不能为空";
    }
    if (!/^(\+86)?[1][34578]\d{9}$/.test(mobileNumber)) {
        return "请输入正确的手机号码";
    }

    return null;
}
// 检测手机验证码
function isVerifyCode(verifyCode) {
    if (verifyCode == '') {
        return "验证码不能为空";
    }

    if (!/^\d{6}$/.test(verifyCode)) {
        return "请输入手机接收到的6位验证码";
    }
    return null;
}

// 全局弹窗
function globalPop(popElem) {
    if (popElem) {
        popElem.show();
    }
    // 创建遮罩层
    $("body").append("<div id='overlay'></div>");
}

// 关闭弹窗
function closePop(par) {
    if (par == "hide") {
        $(".ui_popbox").hide();
        $("#ui_layoutbg").hide();
    } else if (par == "remove") {
        $(".ui_popbox").remove();
        $("#ui_layoutbg").remove();
    } else {
        $("#ui_layoutbg").remove();
    }
}
//显示弹窗
function showPop() {
    $("#show_enterphone_pop,#ui_layoutbg").show();
}

/*--获取参数--*/
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|#|$)");
    var r = window.location.search.substr(1).match(reg);

    if (r != null) {
        return unescape(r[2]);
    } else {
        return null;
    }
}
var mtime = null;

// 加载弹窗 ms为时间
function lodingPop() {
    $("body").append("<div class='resultok popbox'><span class='popbox_icon'><img src='https://i.huim.com/h5/base/loading-icon.gif' style='width:30px' /></span><p class='popbox_text'>加载中</p></div>");
}
// 勾弹窗 cont为内容 ms为时间
function successPop(cont, ms) {
    $("body").append("<div class='resultok popbox'><span class='popbox_icon'><img src='https://i.huim.com/h5/base/correct-ic.png' style='width:45px'/></span><p class='popbox_text'>" + cont + "</p></div>");
    if (ms) {
        clearTimeout(mtime);
        mtime = setTimeout("$('#overlay,.resultok').remove()", ms);
    }
}

// 提示弹窗 cont为内容
function promptPop(cont) {
    if ($(".pop_promptbox").length) {return;};
    $("body").append("<div class='pop_promptbox popbox'>" + cont + "</div>");
    var w = $(".popbox").width();
    var h = $(".popbox").height();
    $(".popbox").css({
        "width": w,
        "margin-left": -(w + 30) / 2,
        "margin-top": -h / 2
    });
    mtime = setTimeout("$('.pop_promptbox').remove()", 2000);
}

// 分享到微信好友、朋友圈和qq uid是用户的id，分享时候需要带上uid=123
function runShare(type) {
    if (type == "friends") {
        if (_user.client == 'ios') {
            runShareFriends(shareData['title'], shareData['desc'], shareData['link'], shareData['imgUrl'], "testmark");
            return;
        }
        window.JSInterface.runShareFriends(shareData['title'], shareData['desc'], shareData['link'], shareData['imgUrl'], "testmark");
    }else if (type == "timeline") {
        if (_user.client == 'ios') {
            runShareTimeline(shareData['title'], shareData['desc'], shareData['link'], shareData['imgUrl'], "testmark");
            return;
        }
        window.JSInterface.runShareTimeline(shareData['title'], shareData['desc'], shareData['link'], shareData['imgUrl'], "testmark");
    }else if (type == "qq") {
        if (_user.client == 'ios') {
            runShareQQ(shareData['title'], shareData['desc'], shareData['link'], shareData['imgUrl'], "testmark");
            return;
        }
        window.JSInterface.runShareQQ(shareData['title'], shareData['desc'], shareData['link'], shareData['imgUrl'], "testmark");
    }
}

//客户端分享传值
function runNavShare(spar){
    if (_user.client == 'ios') {
        runNavBarShare(spar.title, spar.desc, spar.link, spar.imgurl, spar.mark);
    } else if (_user.client == 'az') {
        window.JSInterface.runNavBarShare(spar.title, spar.desc, spar.link, spar.imgurl, spar.mark);
    }
}

//分享页ff=fx a标签跳转到下载页
function runDownload(){
    if (getUrlParam('ff') == 'fx') {
        $("a").on('click',function () {
            location.href = "https://m.huim.com/clicktotal.html";
        });
    }
}

//分享页ff=fx a标签跳转到下载页 使用魔窗 url为跳转app的链接 className为点击的元素class
function mcDownload(url,className){
    if (getUrlParam('ff') == 'fx') {
        var options = [
            {
                mlink: 'http://a.mlinks.cc/AAS5?homeid='+url,
                button: document.querySelectorAll('.'+className)
            }
        ];
        new Mlink(options);
    }
}

// openLoginView跳转到登录
function loginView() {
    if (_user.client == 'ios') {
        openLoginView();
        return;
    }
    window.JSInterface.openLoginView();
}

// openBindPhone跳转到绑定手机页
function openBindPhoneIOS() {
    promptPop("openBindPhone");
    openBindPhone();
}

// openAddAddress跳转到填写地址
function openBindPhoneIOS() {
    promptPop("openAddAddress");
    openAddAddress();
}

/* 
type  朋友圈：timeline  好友：friends
status 成功：success   失败：error    取消：cancel
mark 分享标识
*/
function isShareSuccess(type, status, mark) {
    // 分享到朋友圈成功
    if (status == 'success' && type == 'timeline' && mark == 'lyc') {

        //promptPop("分享到朋友圈成功" + mark);
        var id = $(".active_state1").attr("lang");
        $.ajax({
            type: 'POST',
            async: false,
            url: '/ajax/lingyuanchou',
            data: "conid=" + id,
            cache: false,
            success: function (data) {
                if (data.error) { promptPop(data.result.remark); return false; }

                if (data.result.type == 0) {// 成功
                    $(".active_state1").hide();
                    $('.active_state2').show();
                    window.location.href = "/lingyuanchou/choujianghao?conid=" + id;
                } else if (data.result.type == 2) {// 未登录                
                    loginView();
                    return false;
                } else if (data.result.type == 3) {
                    promptPop(data.result.remark);
                    return false;
                }
            }
        });

    }

    // 取消分享给好友
    if (type == 'qq' && mark == 'huim.com' && _user.client == 'az') {
        promptPop("取消分享给好友" + mark);
    }


    // 赚积分抽奖分享成功
    if (status == 'success' && mark == 'lucky') {

        $.ajax({
            type: 'POST',
            async: false,
            url: '/ajax/ShareSuccess',
            cache: false,
            success: function (data) {
                if (data.error) { promptPop(data.result.remark); return false; }
                if (data.result.type == 0) {
                    $("#lukcy_start").attr('lang', "0");
                    luckyS = 0;
                    $(".ui_popbox,#ui_layoutbg").hide();
                    // 后台分配抽奖
                    runGoodLuck();
                }
            }
        });
    }

    // 双11免单活动
    if (status == 'success' && mark == 'md1111') {
        $.ajax({
            type: 'POST',
            async: false,
            url: '/ajax/miandan11share',
            cache: false,
            success: function (data) {
                if (data.type == 0) {
                    promptPop("你已成功获得1个抽奖号");
                } else if (data.type == 2) {
                    loginView();
                    return false; 
                }
            }
        });
    }
    if (status == 'success' && mark == 'hb1111') {
        $(".redbox .share_btn2,.redbox .redbox_txt").show();
        $(".redbox .share_btn1").hide();
    }


    // 赚积分抽奖享失败、或取消
    if (status == 'cancel' && mark == 'lucky') {
        $("#lottery a").removeClass("run");
    }
};

//runJumpBridge(url);
// 跳转到app内
function runJump(par) {
    if (_user.client == 'ios') {
        runJumpBridge(par);
    } else if (_user.client == 'az') {
        window.JSInterface.runJumpBridge(par);
    }
}

var durl = "'https://appimg.huim.com/download/huimapp5.1.apk'";

// 检查版本更新
var _updataHtml = '<div id="show_updata_pop" class="ui_popbox" style="none">' +
    '<div class="show_updata_cot">' +
        '<p class="up_title">有新版本更新</p>' +
        '<p class="up_notice">搜券通找券<br />内部券一搜即达</p>' +
        //'<a class="up_btn border_t" href="javascript:window.JSInterface.forceUpdate();">立即更新</a>' +  
        '<a class="up_btn border_t" href="javascript:;" onclick="goUpdate()">立即更新</a>' +
    '</div>' +
'</div>' +
'<div id="ui_layoutbg" style="display:block"></div><script>function goUpdate(){if(typeof window.JSInterface.forceUpdate === "function"){window.JSInterface.forceUpdate();}else{window.JSInterface.runOpenBrowser('+durl+')}}</script>';

var _updataHtml1 = '<div id="show_updata_pop" class="ui_popbox" style="none">' +
    '<div class="show_updata_cot">' +
        '<p class="up_title">有新版本更新</p>' +
        '<p class="up_notice">搜券通找券<br />内部券一搜即达</p>' +
        '<a class="up_btn border_t" href="https://itunes.apple.com/cn/app/id1040360122?mt=8">立即更新</a>' +
    '</div>' +
'</div>' +
'<div id="ui_layoutbg" style="display:block"></div>';

if (_user.client == "az" && _user.version < 37 && location.pathname.indexOf('mdetail') < 0) {
    $("body").append(_updataHtml);
}
if (_user.client == "ios" && _user.version < 37 && location.pathname.indexOf('mdetail') < 0) {
    $("body").append(_updataHtml1);
}

// 惰性加载图片
function lazyLoading(_images) {
    $(window).scroll(function () {
        for (var i = 0; i < _images.length; i++) {
            var image = _images.eq(i);
            if (image.attr("data-original") && (image.offset().top < $(window).scrollTop() + $(window).height())) {
                image.attr("src", image.attr("data-original"));
                image.removeAttr("data-original");
                image.removeClass("lazyload");
            }
        }

    });
}
// 图片懒加载
lazyLoading($("img.lazyload"));

//go top
function goTop() {
    $('<i id="gotop" class="icon"></i>').appendTo("body");
    function topAction() {
        h = $(window).height();
        t = $(window).scrollTop();
        if (t > h) {
            $("#gotop").addClass('gotop_show');
        } else {
            $("#gotop").removeClass('gotop_show');
        }
    }
    $("#gotop").on("touchend", function (event) {
        $(window).scrollTop(0);
        $("#gotop").removeClass('gotop_show');
        event.preventDefault();
    });
    var count = 0;
    $(window).scroll(function (b) {
        count++;
        if (count % 2 === 0) {
            return;
        }
        topAction();
    });
}

//验证登录
function login(){
    if (_user.client == 'ios' || _user.client == 'az') {
        $.ajax({
            type: 'POST',
            url: '/ajax/IsLogin',
            success: function (data) {
                if (data.type == 2){
                    loginView();
                    return false;
                }
            },
            error:function(){
                promptPop('系统繁忙,请重试');
            }
        });
    }
}

if (location.hostname.indexOf("aomang") > -1) {
    //var str = $("#biao1").html();
    //var str1 = str.replace(/￥qQyy059J8g4￥/, "￥ZpUg05O7aXe￥");
   // $("#biao1").html(str1);
    $("#biao2").html("￥ZpUg05O7aXe￥");
    $(".redbox a").attr('value', '￥ZpUg05O7aXe￥');
    $('.getboxbtn').attr('href', 'https://s.click.taobao.com/vHnFOZw');
}
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo ($page_seo["title"]); ?></title>

<meta name="keywords" content="<?php echo ($page_seo["keywords"]); ?>" />

<meta name="description" content="<?php echo ($page_seo["description"]); ?>" />

<link href="/css/bc_css.css" type="text/css" rel="stylesheet"/>

<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">

<link rel="stylesheet" href="/css/icon.css" type="text/css">

<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>

<script src="/js/index.js" type="text/javascript"></script>

<link href="__STATIC__/css/card.min.css" rel="stylesheet"/>

<script type="text/javascript" src="/js/jquery.flexslider-min.js"></script>


<link rel="stylesheet" type="text/css" href="/static/css/default/base.css" />
<style>
.onShow, .onFocus, .onError, .onCorrect, .onLoad, .onTime{float:left;}
.onError{display:block;}
</style>
</head>

<body style="background:#f5f5f5">
<div class="w_head_bd">
   <div class="w_head">
     <div class="w_hea_le">
       <div class="w_logo w1"><a href="/" title="白菜网首页"><img src="/images/w_logo.png" title="白菜网首页" alt="白菜网首页"/></a></div>
       <div class="w_h_l1 w1"><a href="/" title="首页" <?php if(isset($bcid) && $bcid == '0'): ?>style="color: #3dc399;"<?php endif; ?>>首页</a></div>
       <div class="w_h_l2 w1">
        <a href="<?php echo U('book/index');?>" title="分类" class="w_h_12_a" >分类</a>
        <div class="w_l2_z" >
          <i class="w_xsj1"></i>
          
          <!--<ul>
		  <?php $item_cate = M("item_cate")->where('pid=0 and is_index=1')->select();?>
		  <?php if(is_array($item_cate)): $i = 0; $__LIST__ = $item_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
                <?php if($val['cate_html'] != '' ): ?><img  src="http://img.baicaio.com//data/upload/item_cate/<?php echo ($val['img']); ?>"  style="position: absolute;margin: 15px;"/>
                    <a href="<?php echo str_replace('/c', '/', U('book/cate', array('cid'=>$val['cate_html']))) ?>" title="<?php echo ($val['name']); ?>" class="w_nav<?php echo ($i); ?>"><?php echo ($val['name']); ?></a>
                <?php else: ?>
                    <a href="<?php echo U('book/cate', array('cid'=>$val['id']));?>" title="<?php echo ($val['name']); ?>" class="w_nav<?php echo ($i); ?>"><?php echo ($val['name']); ?></a><?php endif; ?>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          -->
            <ul>

      <?php $item_cate = M("item_cate")->where('pid=0 and status=1')->select();?>

      <?php if(is_array($item_cate)): $i = 0; $__LIST__ = $item_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
            <?php if($val['cate_html'] != '' ): ?><a href="<?php echo str_replace('/c', '/', U('book/cate', array('cid'=>$val['cate_html']))) ?>" title="<?php echo ($val['name']); ?>" class="w_nav<?php echo ($i); ?>"><?php echo ($val['name']); ?></a>
                <?php else: ?>
                    <a href="<?php echo U('book/cate', array('cid'=>$val['id']));?>" title="<?php echo ($val['name']); ?>" class="w_nav<?php echo ($i); ?>"><?php echo ($val['name']); ?></a><?php endif; ?>

            </li><?php endforeach; endif; else: echo "" ;endif; ?>

          </ul>
        </div>
       </div>
       <div class="w_h_l3 w1"><a href="<?php echo U('book/gny',array('tp'=>'0'));?>" <?php if($tp == '0'): ?>style="color: #3dc399;"<?php endif; ?>  title="国内">国内</a></div>
       <div class="w_h_l4 w1"><a href="<?php echo U('book/gny',array('tp'=>'1'));?>" <?php if($tp == '1'): ?>style="color: #3dc399;"<?php endif; ?>  title="海淘">海淘</a></div>
       <div class="w_h_l5 w1"><a href="<?php echo U('book/index',array('tag'=>'9.9包邮'));?>" title="9.9包邮" <?php if($bcid==='best'): ?>style="color: #3dc399;"<?php endif; ?>>9.9包邮</a></div>
       <div class="w_h_l6 w1"><a href="<?php echo U('book/baicai');?>" style="color: #d62222;"  <?php if($tp == '2'): ?>style="color: #d62222;"<?php endif; ?> title="白菜">白菜</a></div>
       <div class="w_h_l7 w1"><a href="<?php echo U('article/index',array('id'=>10));?>" <?php if($bcid == 10): ?>style="color: #3dc399;"<?php endif; ?> title="晒单">晒单</a></div>
       
       <div class="w_h_l8 w1">
          <a href="javascript:;" title="其他" class="w_h_18_a">其他</a>
          <div class="w_xs2">
          <i class="w_xsj"></i>
          <ul>
        <!--    <li><a href="<?php echo U('zr/index');?>" title="闲置转让">闲置转让</a></li>-->
            <li><a href="<?php echo U('article/index',array('id'=>9));?>"  title="攻略">攻略</a></li>
            <li><a href="<?php echo U('tick/index');?>" title="优惠劵">优惠劵</a></li>
            <li><a href="<?php echo U('exchange/lucky');?>" title="抽奖专区">抽奖专区</a></li>
            <li><a href="<?php echo U('exchange/index');?>" title="礼品兑换">礼品兑换</a></li>
            <li><a href="<?php echo U('orig/index');?>" title="商城导航">商城导航</a></li>
          </ul>
          </div>
      </div>

            <form class="form_search" action="<?php echo U('search/index');?>"  method="get">
                 <button type="submit" class="btn_search icon-search"><!--[if lt IE 8]>Go<![endif]--></button>
                <input id="s" name="q" type="search" class="text_search" value="<?php if($strpos1): echo ($strpos1); else: ?>白菜帮你搜<?php endif; ?>" onblur="if(this.value==&#39;&#39;) {this.value=&#39;白菜帮你搜&#39;;this.style.color=&#39;#999&#39;;}" onfocus="if(this.value==&#39;白菜帮你搜&#39;) {this.value=&#39;&#39;;this.style.color=&#39;#333&#39;;}" style="color: rgb(153, 153, 153);" _hover-ignore="1">
            </form>
     </div>

     <div class="w_hea_rig lb_dw">

     <div class="lb_aa">
         <!--<a href="" title=""><img src="/images/xiaobiao2.png" alt="" /></a>-->
     </div>

           <div class="w_h_l8 w1">
               <a href="javascript:;" title="爆料" class="w_h_18_a bl_tx"><img style="width:20px; height:20px;"  src="/images/bl_t.png" alt="" /></a>
               <div class="w_xs2">
                   <i class="w_xsj"></i>
                   <ul>
                       <li><a href="<?php echo U('item/share_item');?>" title="我要爆料">我要爆料</a></li>
                       <li><a href="<?php echo U('article/publish',array('t'=>'gl'));?>" title="发表攻略">发表攻略</a></li>
                       <li><a href="<?php echo U('article/publish',array('t'=>'sd'));?>" title="我要晒单">我要晒单</a></li>
                       <li><a href="<?php echo U('zr/publish');?>" title="发布转让">发布转让</a></li>
                   </ul>
               </div>
           </div>

	 <?php if(!empty($visitor)): ?><div class="w_h_l8  w1">
             <a href="<?php echo U('user/index', array('uid'=>$visitor['id']));?>" title="用户名" class="w_h_18_a grtx_a"><img src="<?php echo avatar($visitor['id'],'32');?>" alt="个人头像" /></a>
             <span><?php echo ($visitor['username']); ?></span>

			 <div class="w_xs2">
                 <i class="w_xsj"></i>
                 <ul class="xiaoxs_a">
                     <li><a href="<?php echo U('message/system');?>" title="我的消息">我的消息</a><?php if((isset($visitor['message'])) AND ($visitor['message'] != 0)): ?><span><?php echo ($visitor['message']); ?></span><?php endif; ?></li>
                     <li><a href="<?php echo U('user/index', array('uid'=>$visitor['id']));?>" title="个人中心">个人中心</a></li>
                     <li><a href="<?php echo U('user/publish');?>" title="我的文章">我的文章</a></li>
                     <li><a href="<?php echo U('user/logout');?>" title="安全退出">安全退出</a></li>
                 </ul>
             </div>
         </div>
         <div class="sxs" style="display: none;">
             <i class="gb"></i>
             <a href="<?php echo U('message/system');?>"><em></em>条新消息</a>
         </div>
     <!--<a href="<?php echo U('user/index', array('uid'=>$visitor['id']));?>" class="mb_name"><?php echo ($visitor["username"]); ?></a>
	 <a href="<?php echo U('user/logout');?>">退出</a>-->
	 <?php else: ?>
	 <a href="<?php echo U('user/index');?>" title="登录" class="w_dl">登录</a>|<a href="<?php echo U('user/register');?>" title="注册">注册</a><?php endif; ?>
	 </div>
   </div>
</div>
<div class="clear"></div>

<div class="w_bl_bd">
  <div class="w_bl">
  <h2>注册</h2>
  <div class="w_dl_bd">
    <div class="w_dl_lef">
	<form id="J_register_form" action="<?php echo U('user/register');?>" method="post">
      <ul>
        <li class="w_dl_l1"><img src="/images/w_dl1.png"/><input type="text" placeholder="用户名/邮箱/手机号" class="w_dl_1" name="username" id="J_username"/></li>
        <li class="w_dl_l1"><img src="/images/w_dl2.png"/><input type="password" placeholder="设置密码" class="w_dl_1" name="password" id="J_password"/></li>
        <li class="w_grzc3">
         <div><font style="font-size:12px;">安全程度：</font><em class="def" >弱</em><em class="def" >中</em><em class="def">强</em></div>
        </li> 
        <li class="w_dl_l1" style="margin-top:0px;"><img src="/images/w_dl2.png"/><input type="password" placeholder="确认密码" class="w_dl_1" name="repassword" id="J_repassword"/></li>
        <li class="w_dl_l1"><img src="/images/w_dl1.png"/><input type="text" placeholder="邮箱" class="w_dl_1" name="email" id="J_email"/></li>
        <li><input type="text" placeholder="验证码" class="w_dl_2" name="captcha" id="J_captcha"/>
		<div class="w_yzm"><img src="<?php echo U('captcha/'.time());?>" id="J_captcha_img"  alt="<?php echo L('captcha');?>" data-url="<?php echo U('captcha/js_rand');?>"></div><a href="javascript:;" id="J_captcha_change" class="w_hyz"><?php echo L('change_captcha');?></a></li>
        <li class="w_grzc7">
          <span style="margin-left:29px">
				<input tabindex="1" type="checkbox" value="1" checked="" name="agreement"> 
          	<label><a href="javascript:;">我已阅读并同意<span style="font-size:12px;" id="J_protocol_btn">《用户注册协议》</span></a></label>
			</span>
        </li>
        <li><input type="submit" id="J_regsub" value="同意协议并注册" class="w_dl_4"/></li>
      </ul>
	  </form>
    </div>
    <div class="w_dl_rig">
    已是白菜哦会员 ? 请直接<a href="<?php echo U('user/login');?>" title=" 登录"> 登录</a><br/><em></em>
    </div>
  </div>
  </div>
 </div>
<div class="clear"></div>
<!--bottom-->
<div class="w_bot_bd">
  <div class="w_bot">
   <!-- <div class="w_ewm"><img src="/images/w_erm.jpg" title="" alt=""/></div> -->
   
   
   <!--
   <div class="w_bot_1">
   
    <?php $tag_article_class = new articleTag;$about_nav = $tag_article_class->cate(array('type'=>'cate','cateid'=>'1','return'=>'about_nav','cache'=>'0',)); if(is_array($about_nav)): $i = 0; $__LIST__ = $about_nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="<?php echo U('aboutus/index', array('id'=>$val['id']));?>" title="<?php echo ($val["name"]); ?>"><?php echo ($val["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
    
   </div> 
     -->
      
   <!--<div class="w_bot_3" style="margin-top:0;padding-top: 33px;">
     <p>版权所有&copy;白菜哦-高性价比海淘购物推荐 所有资讯均受著作权保护，未经许可不得使用，不得转载、摘编。 湘ICP备13002285号 <a href="<?php echo U('sitemap/index');?>" title="网站地图">网站地图</a>&nbsp;<a href="<?php echo U('aboutus/index', array('id'=>$val['id']));?>" title="关于我们">关于我们</a> <em>
   <script src="http://s13.cnzz.com/stat.php?id=3738275&web_id=3738275" language="JavaScript"></script>
  <script type="text/javascript">
    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F49113e6b733eb50457f8170c967ff321' type='text/javascript'%3E%3C/script%3E"));
    </script>
    </em><img src="/images/gan.png" alt="公安备案">湘公网安备 43011102000623号
    </p>
   </div>   -->  
   <div class="w_bot_3" style="margin-top:0;padding-top: 33px;">
     <p><a href="<?php echo U('sitemap/index');?>" title="网站地图">网站地图</a>&nbsp;<a href="<?php echo U('aboutus/index', array('id'=>$val['id']));?>" title="关于我们">关于我们</a> <em>
   <script src="http://s13.cnzz.com/stat.php?id=3738275&web_id=3738275" language="JavaScript"></script>
      <script type="text/javascript">
    (function(win,doc){
        var s = doc.createElement("script"), h = doc.getElementsByTagName("head")[0];
        if (!win.alimamatk_show) {
            s.charset = "gbk";
            s.async = true;
            s.src = "https://alimama.alicdn.com/tkapi.js";
            h.insertBefore(s, h.firstChild);
        };
        var o = {
            pid: "mm_27883119_3410238_93410083",/*推广单元ID，用于区分不同的推广渠道*/
            appkey: "",/*通过TOP平台申请的appkey，设置后引导成交会关联appkey*/
            unid: "",/*自定义统计字段*/
            type: "click" /* click 组件的入口标志 （使用click组件必设）*/
        };
        win.alimamatk_onload = win.alimamatk_onload || [];
        win.alimamatk_onload.push(o);
    })(window,document);
</script>
   <!--
   <script type="text/javascript">
    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F49113e6b733eb50457f8170c967ff321' type='text/javascript'%3E%3C/script%3E"));
    </script>
    -->
    <script src=" http://hm.baidu.com/h.js?49113e6b733eb50457f8170c967ff321" type="text/javascript"></script>
    </em></p>
     <p>版权所有&copy;白菜哦-高性价比海淘购物推荐 所有资讯均受著作权保护，未经许可不得使用，不得转载、摘编。 湘ICP备13002285号<img src="/images/gan.png" alt="公安备案">湘公网安备 43011102000623号</p>
   </div>                                                      
  </div>
</div>

<div class="l_ewm">
  <span>二维码</span>
  <div class="l_ewm_img"><img src="/images/w_erm.jpg" title="" alt=""/></div>
</div>

<div class="wtfk">
<a class="wtfk_a" href="/aboutus-index-id-15" title="问题反馈">问题反馈</a>
</div>

<div class="actGotop">
    <a href="javascript:;" title="返回顶部"></a>
</div>
<div class="tipbox " style="z-index: 3001; left: 40%; top: 323.126px; "><div class="tip-l"></div><div class="tip-c"></div><div class="tip-r"></div></div>
<!--返回顶部begin-->
<script type="text/javascript">
$(function () {
	$(window).scroll(function () {
		if ($(window).scrollTop() >= 100) {
			$('.actGotop').fadeIn(300);
		} else {
			$('.actGotop').fadeOut(300);
		}
		//顶部滚动
		if($(document).scrollTop()>0){
			$(".w_head_bd").css({"position":"fixed", "top":"0", "z-index":"1200"});
		}else{
			$(".w_head_bd").css({"position":"", "top":"", "z-index":""});
		}
	});
	$('.actGotop').click(function () {
		$('html,body').animate({ scrollTop: '0px' }, 800);
	});
});

var PINER = {
    root: "__ROOT__",
    uid: "<?php echo $visitor['id'];?>", 
    async_sendmail: "<?php echo $async_sendmail;?>",
    config: {
        wall_distance: "<?php echo C('pin_wall_distance');?>",
        wall_spage_max: "<?php echo C('pin_wall_spage_max');?>"
    },
    //URL
    url: {}
};

var t = null;

t = setInterval(function(){
    if(PINER.uid==""){
        return false;
    }
    $.get(PINER.root+'/?m=user&a=messg',function(result){
        if(result.msg>0){
        $('.sxs em').html(result.msg);
            $('.sxs').show();
        }
    },'json');

},10000);

$('.sxs .gb').click(function(){
    $('.sxs').hide();
})
</script>

<script src="/static/js/jquery/plugins/formvalidator.js"></script>
<script src="/static/js/lhg/lhgdialog.min.js?self=true&skin=idialog" type="text/javascript"></script>
<script src="/js/function.js"></script>
<script>
//语言项目
var lang = {};
lang.please_input = "请输入";lang.username = "用户名";lang.password = "密码";lang.login_title = "用户登陆";lang.share_title = "我要分享";lang.confirm_unfollow = "确定要取消关注么？";lang.wait = "请稍后......";lang.user_protocol = "网络服务使用协议";lang.email = "邮件地址";lang.email_tip = "请填写正确的常用邮箱，以便找回密码";lang.email_format_error = "邮件格式不正确";lang.email_exists = "电子邮件地址已经被使用";lang.username_tip = "最多20个字符，中文算两个字符";lang.username_exists = "这昵称太热门了，被别人抢走啦，换一个吧";lang.password_tip = "20个字符，数字、字母或者符号";lang.password_too_short = "密码太短啦，至少要6位哦";lang.password_too_long = "密码太长";lang.repassword_tip = "这里要重复输入一次密码";lang.repassword_empty = "请重复输入一次密码";lang.passwords_not_match = "两次输入的密码不一致";lang.captcha_tip = "输入图片中的字符";lang.captcha_empty = "请输入验证码";lang.uploading_cover = "封面上传中，请稍后......";lang.consignee = "收货人";lang.address = "详细地址";lang.mobile = "手机";
//验证
$.formValidator.initConfig({formid:'J_register_form',autotip:true});
$('#J_email').formValidator({onshow:' ',onfocus:lang.email_tip, oncorrect: ' '})
.inputValidator({min:1,onerror:lang.please_input+lang.email})
.regexValidator({regexp:'email',datatype:'enum',onerror:lang.email_format_error})
.ajaxValidator({
	type: 'get',
	url: PINER.root + '/?m=user&a=ajax_check',
	data: 'type=email',
	datatype: 'json',
	async:'false',
	success: function(result){
		return result.status == '1' ? !0 : !1;
	},
	buttons: $('#J_regsub'),
	onerror: lang.email_exists,
	onwait : lang.wait
});
$('#J_username').formValidator({onshow:' ',onfocus:lang.username_tip, oncorrect: ' '})
.inputValidator({min:1,onerror:lang.please_input+lang.username})
.inputValidator({max:20,onerror:lang.username_tip})
.ajaxValidator({
	type: 'get',
	url: PINER.root + '/?m=user&a=ajax_check',
	data: 'type=username',
	datatype: 'json',
	async:'false',
	success: function(result){
		return result.status == '1' ? !0 : !1;
	},
	buttons: $('#J_regsub'),
	onerror: lang.username_exists,
	onwait : lang.wait
});
$('#J_password').formValidator({onshow:' ',onfocus:lang.password_tip, oncorrect: ' '})
.inputValidator({min:6,onerror:lang.password_too_short})
.inputValidator({max:20,onerror:lang.password_too_long});
$('#J_repassword').formValidator({onshow:' ',onfocus:lang.repassword_tip, oncorrect: ' '})
.inputValidator({min:1,onerror:lang.repassword_empty})
.compareValidator({desid:'J_password',operateor:'=',onerror:lang.passwords_not_match});
//密码复杂度
$('#J_password').keyup(function (e)
{
    var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");
    if (false == enoughRegex.test($(this).val()))
    {
        $('.def:eq(0)').addClass('default');
		$('.def:gt(0)').removeClass('default');
    }
    else if (strongRegex.test($(this).val()))
    {
        $('.def').addClass('default');
    }
    else if (mediumRegex.test($(this).val()))
    {
        $('.def:lt(2)').addClass('default');
		$('.def:eq(2)').removeClass('default');
    }
    else
    {
        $('.def:eq(0)').addClass('default');
		$('.def:gt(0)').removeClass('default');
    }
    return true;
}
);

$('#J_captcha_img').click(function(){
	var timenow = new Date().getTime(),
	//url = $(this).attr('data-url').replace(/js_rand/g,timenow);
	//$(this).attr("src", url);
	$(this).attr("src","<?php echo U('index/verify_code');?>&"+timenow)
});
$('#J_captcha_change').click(function(){
	$('#J_captcha_img').trigger('click');
});
//协议
$('#J_protocol_btn').live('click', function(){
	var content = $('#J_protocol').html();
	var dg = new $.dialog({id:'selectorder',title:lang.user_protocol,lock:true,content:content,width:"524px",height:"262px",fixed:true}); 
});
</script>
<div id="J_protocol" class="hide"><pre class="dialog_protocol clr6" style="height:500px; overflow-y:scroll" ><?php echo C('pin_reg_protocol');?></pre></div>
</body>
</html>
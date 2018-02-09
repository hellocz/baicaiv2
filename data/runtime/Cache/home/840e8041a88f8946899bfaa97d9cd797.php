<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo ($page_seo["title"]); ?></title>

<meta name="keywords" content="<?php echo ($page_seo["keywords"]); ?>" />

<meta name="description" content="<?php echo ($page_seo["description"]); ?>" />
<meta name="360-site-verification" content="52d9b1bb4b02391c169381b95ad45301" />

<link href="/css/bc_css.css?v=2018012401" type="text/css" rel="stylesheet"/>

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

<style id="table">.selectTdClass{background-color:#edf5fa !important}table.noBorderTable td,table.noBorderTable th,table.noBorderTable caption{border:1px dashed #ddd !important}table{
word-break: break-all;  margin-bottom:10px;border-collapse:collapse;display:table;}td,th{padding: 5px 10px;border: 1px solid #DDD;}caption{border:1px dashed #DDD;border-bottom:0;padding:3px;text-align:center;}th{border-top:1px solid #BBB;background-color:#F7F7F7;}table tr.firstRow th{border-top-width:2px;}.ue-table-interlace-color-single{ background-color: #fcfcfc; } .ue-table-interlace-color-double{ background-color: #f7faff; }td p{margin:0;padding:0;}
table a{ color:#3dc399; text-decoration:none;outline:none;}
</style>

<script type="text/javascript" src="/js/jquery.flexslider-min.js"></script>



	<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>

	<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.js"> </script>

	<script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

</head>



<body style="background:#f5f5f5">

<div class="w_head_bd">
   <div class="w_head">
     <div class="w_hea_le">
       <div class="w_logo w1"><a href="/" title="白菜网首页"><img src="/images/w_logo.png" title="白菜网海淘攻略" alt="海淘攻略"/></a></div>
       <h1 style="display:none">海淘攻略|亚马逊海淘攻略|天猫优惠劵</h1>
       <div class="w_h_l1 w1"><a href="/" title="首页" alt="海淘攻略" <?php if(isset($bcid) && $bcid == '0'): ?>style="color: #3dc399;"<?php endif; ?>>首页</a></div>
       <div class="w_h_l2 w1">
        <a href="<?php echo U('book/index');?>" title="分类" alt="海淘攻略" class="w_h_12_a" >分类</a>
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

      <?php $item_cate = M("item_cate")->where('pid=0 and status=1 and is_index=1')->select();?>

      <?php if(is_array($item_cate)): $i = 0; $__LIST__ = $item_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
            <?php if($val['cate_html'] != '' ): ?><a href="<?php echo str_replace('/c', '/', U('book/cate', array('cid'=>$val['cate_html']))) ?>" title="<?php echo ($val['name']); ?>" class="w_nav<?php echo ($i); ?>"><?php echo ($val['name']); ?></a>
                <?php else: ?>
                    <a href="<?php echo U('book/cate', array('cid'=>$val['id']));?>" title="<?php echo ($val['name']); ?>" alt="海淘攻略" class="w_nav<?php echo ($i); ?>"><?php echo ($val['name']); ?></a><?php endif; ?>

            </li><?php endforeach; endif; else: echo "" ;endif; ?>

          </ul>
        </div>
       </div>
       <div class="w_h_l3 w1"><a href="<?php echo U('book/gny',array('tp'=>'0'));?>" <?php if($tp == '0'): ?>style="color: #3dc399;"<?php endif; ?>  title="国内" alt="国内海淘">国内</a></div>
       <div class="w_h_l4 w1"><a href="<?php echo U('book/gny',array('tp'=>'1'));?>" <?php if($tp == '1'): ?>style="color: #3dc399;"<?php endif; ?>  title="海淘" alt="海淘攻略">海淘</a></div>
       <div class="w_h_l5 w1"><a href="<?php echo U('book/index',array('tag'=>'9.9包邮'));?>" title="9.9包邮"  alt="9.9特价包邮"<?php if($bcid==='best'): ?>style="color: #3dc399;"<?php endif; ?>>9.9包邮</a></div>
       <div class="w_h_l6 w1"><a href="<?php echo U('book/baicai');?>" style="color: #d62222;"  <?php if($tp == '2'): ?>style="color: #d62222;"<?php endif; ?> title="白菜" alt="海淘攻略">白菜</a></div>
       <div class="w_h_l7 w1"><a href="<?php echo U('article/index',array('id'=>10));?>" <?php if($bcid == 10): ?>style="color: #3dc399;"<?php endif; ?> title="晒单" alt="白菜哦晒单" >晒单</a></div>
       
       <div class="w_h_l8 w1">
          <a href="javascript:;" title="其他" alt="海淘攻略" class="w_h_18_a">其他</a>
          <div class="w_xs2">
          <i class="w_xsj"></i>
          <ul>
        <!--    <li><a href="<?php echo U('zr/index');?>" title="闲置转让">闲置转让</a></li>-->
            <li><a href="<?php echo U('article/index',array('id'=>9));?>"  title="海淘攻略" alt="海淘攻略">海淘攻略</a></li>
            <li><a href="<?php echo U('tick/index');?>" title="优惠劵" alt="海淘优惠劵">优惠劵</a></li>
            <li><a href="<?php echo U('exchange/lucky');?>" title="抽奖专区" alt="海淘优惠劵">抽奖专区</a></li>
            <li><a href="<?php echo U('exchange/index');?>" title="礼品兑换" alt="海淘优惠劵">礼品兑换</a></li>
            <li><a href="<?php echo U('orig/index');?>" title="商城导航" alt="海淘优惠劵">商城导航</a></li>
          </ul>
          </div>
      </div>

            <form class="form_search" action="<?php echo U('search/index');?>"  method="get">
                 <button type="submit" class="btn_search icon-search"><!--[if lt IE 8]>Go<![endif]--></button>
                <input id="s" name="q" type="search" class="text_search" value="<?php if($strpos1): echo ($strpos1); else: ?>回血计划<?php endif; ?>" onblur="if(this.value==&#39;&#39;) {this.value=&#39;回血计划&#39;;this.style.color=&#39;#999&#39;;}" onfocus="if(this.value==&#39;回血计划&#39;) {this.value=&#39;&#39;;this.style.color=&#39;#333&#39;;}" style="color: rgb(153, 153, 153);" _hover-ignore="1">
            </form>
     </div>

     <div class="w_hea_rig lb_dw">

     <div class="lb_aa">
         <!--<a href="" title=""><img src="/images/xiaobiao2.png" alt="" /></a>-->
     </div>

           <div class="w_h_l8 w1">
               <a href="javascript:;" title="爆料" alt="海淘攻略" class="w_h_18_a bl_tx"><img style="width:20px; height:20px;"  src="/images/bl_t.png" alt="" /></a>
               <div class="w_xs2">
                   <i class="w_xsj"></i>
                   <ul>
                       <li><a href="<?php echo U('item/share_item');?>" title="我要爆料" alt="我要爆料海淘攻略">我要爆料</a></li>
                       <li><a href="<?php echo U('article/publish',array('t'=>'gl'));?>" title="发表攻略" alt="发表海淘攻略">发表攻略</a></li>
                       <li><a href="<?php echo U('article/publish',array('t'=>'sd'));?>" title="我要晒单" alt="我要晒海淘攻略单">我要晒单</a></li>
                       <li><a href="<?php echo U('zr/publish');?>" title="发布转让" alt="发布转让海淘优惠劵">发布转让</a></li>
                   </ul>
               </div>
           </div>

   <?php if(!empty($visitor)): ?><div class="w_h_l8  w1">
             <a href="<?php echo U('user/index', array('uid'=>$visitor['id']));?>" title="用户名" alt="海淘用户名" class="w_h_18_a grtx_a"><img src="<?php echo avatar($visitor['id'],'32');?>" alt="海淘攻略" /></a>
             <span><?php echo ($visitor['username']); ?></span>

       <div class="w_xs2">
                 <i class="w_xsj"></i>
                 <ul class="xiaoxs_a">
                     <li><a href="<?php echo U('message/system');?>" title="我的消息" alt="我的海淘攻略信息">我的消息</a><?php if((isset($visitor['message'])) AND ($visitor['message'] != 0)): ?><span><?php echo ($visitor['message']); ?></span><?php endif; ?></li>
                     <li><a href="<?php echo U('user/index', array('uid'=>$visitor['id']));?>" title="个人中心">个人中心</a></li>
                     <li><a href="<?php echo U('user/keysfollow');?>" title="我的关注"  alt="我的关注海淘优惠劵">我的关注</a></li>
                     <li><a href="<?php echo U('user/publish');?>" title="我的文章" alt="海淘优惠劵">我的文章</a></li>
                     <li><a href="<?php echo U('user/logout');?>" title="安全退出" alt="海淘优惠劵">安全退出</a></li>
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

  <h2>发布晒单</h2>

  <table class="w_fbgl">

  <form id="info_form" action="<?php echo u('article/insert');?>" method="post" enctype="multipart/form-data">

  <input type="hidden" name="cate_id" value="10"/>

  <input type="hidden" name="t" value="sd"/>

  <tr  height="60px">

	  <td  class="w_fbgl_1"><em>*</em> 文章标题：</td>

	  <td>

	   <input type="text" id="title" name="title" value="" class="w_gl_in1"/>

	  </td>

	</tr>

	<tr  height="40px">

	  <td  class="w_fbgl_1"><em>*</em>购物商城：</td>

	  <td>

		<input type="text" id="sc" name="sc" value="" class="w_gl_in1"/>

	  </td>

	</tr>

    <tr  height="170px">

	  <td class="w_fbgl_1"><em>*</em>商品图片：</td>

	  <td>

	     <div class="w_tp_bd">

          <div class="w_tpk"><img src="/images/jia_pic.png" id="btn_img"/></div>

          <p style="color:#646464;">从下方的图片中选择一张图片作为封面图片，或者从本地上传，请选择不带水印的图片，谢谢！</p>

          <p style="color:#999999;">支持小于300k格式为jpg、jpeg、png的图片，截图请注意隐藏个人信息</p>

          <div class="w_cczx">

            <em>上传封面图片</em>

			<input type="file" name="J_img" id="J_img" class="w_bl_in2" >

			<input type="hidden" name="img" id="img" value=""/>

          </div>

         </div>

	  </td>

	</tr>

	<tr  height="120px">

	  <td  class="w_fbgl_1"><em>*</em>  商品评分：</td>

	  <td>

	   <div class="w_5x">

         <ul>

           <li><span>商品质量</span><i></i><div class="w_5x_b"><img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/><input type="hidden" class="g" name="g_zl" value="5"/></div></li>

           <li><span>配送服务</span><i></i><div class="w_5x_b"><img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/><input type="hidden" class="g" name="g_fw" value="5"/></div></li>

           <li><span>客户服务</span><i></i><div class="w_5x_b"><img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/>&nbsp;&nbsp;<img src="/images/star.png"/><input type="hidden" class="g" name="g_kh" value="5"/></div></li>

         </ul>

       </div>

	  </td>

	</tr>

	<tr  height="200px">

	  <td colspan="2">

        <p style="color:#646464;">晒单必须上传三张以上的清晰大图，否则将不能通过审核。</p>

      <div class="w_tbamx">

		  <script id="info"   type="text/plain" style="width:782px;height:228px;"></script>

		  <!--<textarea name="info" id="info" style="width: 762px; height: 228px; visibility: hidden; resize: none; display: none;"></textarea>--></div>
		  <input type="hidden" name="info" class="info"/>
      </td>

	</tr>

	<tr>

	  <td colspan="2">

	  <input type="submit" value="提交" class="w_gl_in2" style="margin-top: 68px;" />

	  <input type="button" value="保存草稿" class="J_cg w_gl_in3" style="margin-top: 68px;" />

	  <input type="hidden" name="status" value="0"/>

	 </td>

	</tr>

	</form>

  </table>

 </div>

 </div>

<div id="jcrop" >

	<img src="" id="target" alt="" />

	<form id="coords">



		<div class="inline-labels">

			<input type="text" size="4" id="x1" name="x1" />

			<input type="text" size="4" id="y1" name="y1" />

			<input type="text" size="4" id="w" name="w" />

			<input type="text" size="4" id="h" name="h" />

			<input type="button" id="sb" value="确定"/>

		</div>

	</form>

</div>

<style>

	#clipArea {

		margin: 20px;

		height: 300px;}

	#car{

		display: block;

		left: 50%;

		top: 50%;

		width: 600px;

		height: 300px;

		position: fixed;

		margin-left: -300px;

		margin-top: -150px;

		display: none;

		z-index: 999;

	}

</style>

<div id="car">

	<div id="clipArea"></div>

	<button id="clipBtn">裁剪</button>

	<p class="clipArea_tips"><span>*</span>滑动鼠标滑轮，可进行裁剪区域缩放。</p>

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
     <p><a href="/sitemap.xml" title="网站地图">网站地图</a>&nbsp;<a href="<?php echo U('aboutus/index', array('id'=>2));?>" title="关于我们">关于我们</a> <em>
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
     <p>版权所有&copy;长沙佰成通网络科技有限公司 所有资讯均受著作权保护，未经许可不得使用，不得转载、摘编。 <a href="http://www.miibeian.gov.cn" rel=nofollow>湘ICP备13002285号</a><img src="/images/gan.png" alt="公安备案">湘公网安备 43011102000623号</p>
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


<script src="/js/function.js" type="text/javascript"></script>

<script src="/js/ajaxfileupload.js" type="text/javascript"></script>

<script src="/static/js/kindeditor/kindeditor.js"></script>





<script src="/js/car/iscroll-zoom.js"></script>

<script src="/js/car/hammer.js"></script>

<script src="/js/car/lrz.all.bundle.js"></script>

<script src="/js/car/jquery.photoClip.js"></script>

<script>



	var clipArea = new bjj.PhotoClip("#clipArea", {

		size: [200, 200],

		outputSize: [200, 200],

		file: "#J_img",

		source: "/images/jia_pic.png",

		//view: "#view",

		ok: "#clipBtn",

		loadStart: function() {

			console.log("照片读取中");

		},

		loadComplete: function() {

			console.log("照片读取完成");

		},

		clipFinish: function(dataURL) {

			$('#clipBtn').html('保存中....');

			$.post('/index.php?m=article&a=uploadimg1',{data:dataURL},function(result){

				if(result.status ==1){

					$('#clipBtn').html('裁剪');

					$('#btn_img').attr('src', result.data);

					$('#img').val(result.data);

					$('#car').hide();

				}

			},'json')

		}

	});



	$('#J_img').on('change',function () {

		$('#car').show();

	});



	$('#sb').click( function(){

		var x = $("#x1").val();

		var y = $("#y1").val();

		var pic_name = $("#target").attr('src');

		$.post('/?m=article&a=uploadimg1',{pic_name:pic_name,x:x,y:y},function(data){

			if(data.status==1){

				$('#btn_img').attr('src', data.data);

				$('#img').val(data.data);

				$('#jcrop').hide();

			}else{



				alert(data.error);

				return false;

			}



		},"json");



	})





	$(".J_cg").click(function(){

	$("input[name='status']").val(2);

	$("#info_form").submit();

});

$("#btn_img").click(function(){

	$("#J_img").trigger("click");

});

/*$("#J_img").live('change',function () {

	ajaxFileUpload();

});*/

function ajaxFileUpload() {

	$('#btn_img').attr('src', '/images/bcloading.gif');	

	$.ajaxFileUpload

	(

		{

			url: PINER.root + '/?m=article&a=uploadimg', //用于文件上传的服务器端请求地址

			secureuri: false, //是否需要安全协议，一般设置为false

			fileElementId: 'J_img', //文件上传域的ID

			dataType: 'json', //返回值类型 一般设置为json

			success: function (result, status)  //服务器成功响应处理函数

			{

				if(result.status =='1'){

					$('#target').attr('src',result.data);

					$('#jcrop').show();

					sd();

					//$('#btn_img').attr('src', result.data);

					//$('#img').val(result.data);

				}

			},

			error: function (data, status, e)//服务器响应失败处理函数

			{

				$(".tip-c").html(e);

				$('.tipbox').show().removeClass('tip-success').addClass("tip-error");

				setTimeout("$('.tipbox').hide();", 2000); 

			}

		}

	)

	return false;

}

function sd(){



	var jcrop_api;



	$('#target').Jcrop({

		onChange:   showCoords,

		onSelect:   showCoords,

		onRelease:  clearCoords,

		setSelect: [ 0, 0, 200, 200 ],

		minSize:[100,100],

		boxWidth:700,

		boxHeight:400



	},function(){

		jcrop_api = this;



	});

	$('#coords').on('change','input',function(e){

		var x1 = $('#x1').val(),

				x2 = $('#x2').val();

		var y1 = $('#y1').val(),

				y2 = $('#y2').val();

		jcrop_api.setSelect([x1,y1,x2,y2]);

	});



};

	function showCoords(c)

	{

		$('#x1').val(c.x);

		$('#y1').val(c.y);

		$('#w').val(c.w);

		$('#h').val(c.h);

	};



function clearCoords()

{

	$('#coords input').val('');

};

$(".w_5x_b img").hover(function(){

	var index=$(".w_5x_b").index($(this).parent());

	var k=$(".w_5x_b:eq("+index+") img").index(this);

	for(var i=0;i<5;i++){

		if(i<=k){

			$(".w_5x_b:eq("+index+") img:eq("+i+")").attr("src","/images/star.png");

		}else{

			$(".w_5x_b:eq("+index+") img:eq("+i+")").attr("src","/images/star_1.png");

		}

	}	

},function(){});

$(function(){

	$("form").submit(function(){
		var info = ue.getContent(); 
		$(".info").val(info);
		if($("#title").val()==""){tips("标题不能为空",'0');return false;}

		if($("#orig_id").val()=="0"){tips("请选择购物商城",'0');return false;}

		if($("#img").val()==""){tips("请选择图片",'0');return false;}

	});

})

var editor;

KindEditor.ready(function(K) {

	editor = K.create('#info', {

		uploadJson : '/index.php?g=admin&m=attachment&a=editer_upload',

		fileManagerJson : '/index.php?g=admin&m=attachment&a=editer_manager',

		allowFileManager : true,

		items:['undo','redo','bold','fontsize','forecolor','emoticons','link','unlink', 'image','multiimage','media']

	});

	K('#info_form').bind('submit', function() {

		editor.sync();

	});

});

var is_confirm=true;

// 关闭窗口时弹出确认提示

$(window).bind('beforeunload', function(){

    // 只有在标识变量is_confirm不为false时，才弹出确认提示

    if(window.is_confirm !== false)

        return "您有未保存的内容，您确定关闭吗？";

});

// 提交表单时，不弹出确认提示框

$('form').bind('submit', function(){

    is_confirm = false;  

});

var ue = UE.getEditor('info');

</script>
</body>

</html>
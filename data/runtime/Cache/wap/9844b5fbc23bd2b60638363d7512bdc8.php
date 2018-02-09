<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta http-equiv="Cache-Control" content="no-cache"/>

<meta content="telephone=no" name="format-detection" />

<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0"/>

<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">

<link rel="apple-touch-icon-precomposed" sizes="114x114" href="">

<link rel="apple-touch-icon-precomposed" sizes="57x57" href="">

<title><?php echo ($page_seo["title"]); ?></title>

<meta name="keywords" content="<?php echo ($page_seo["keywords"]); ?>" />

<meta name="description" content="<?php echo ($page_seo["description"]); ?>" />

<link href="__STATIC__/css/card.min.css" rel="stylesheet"/>

<link href="/static/css/wap/w_css.css?v=2017121502" type="text/css" rel="stylesheet"/>

<script src="/static/js/wap/jquery-1.11.0.min.js" type="text/javascript"></script>





<script src="/static/js/wap/tab.js" type="text/javascript"></script>

</head>



<body style="background:#f5f5f5;">

<nav class="w_h2">

<a href="<?php echo U('index/index');?>" title="<?php echo ($item["uname"]); ?>" class="w_h2_r"><img src="/static/images/wap/w_fz.png" title="首页" alt="首页"/></a>
<!--

<a href="<?php echo U('wap/space/index', array('uid'=>$item['uid']));?>" title="<?php echo ($item["uname"]); ?>" class="w_h2_r"><img src="/static/images/wap/w_fz.png" title="<?php echo ($item["uname"]); ?>" alt="<?php echo ($item["uname"]); ?>"/></a>

<em><?php echo ($item["uname"]); ?></em>
-->

<a href="javascript:history.go(-1);" title="返回" class="w_h2_l"><img src="/static/images/wap/w_t_lef.png" title="返回" alt="返回"/></a>

<h2>文章内容</h2>

</nav>

<div class="w_center content">

  <div class="w_bjtjy">

   <h2><?php echo ($item["title"]); ?><span style="color: #d62222 !important;"><?php echo ($item["price"]); ?></span></h2>

   <div class="w_bjtjy_1">

   <!-- <img src="<?php echo avatar($item['uid'], 48);?>" title="<?php echo ($item["uname"]); ?>" alt="<?php echo ($item["uname"]); ?>" />--><span style="color: #d62222 !important;"><?php echo ($item["price"]); ?></span>|<span><?php echo (fdate($item["add_time"])); ?></span>

   </div>

   <div class="w_bjtjy_2">

	 <?php echo ($item["content"]); ?>	

   </div>

   <div class="w_bjtjy_3">

   <?php if(is_array($item['go_link'])): $i = 0; $__LIST__ = $item['go_link'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if($i==1 && count($item['go_link'])==1): ?><a href="__ROOT__/?g=wap&m=item&a=tgo&to=<?php echo base64_encode($r['link']);?>" rel="nofollow"  target="_blank" title="<?php echo ($item["title"]); ?>" class="w_clb_a" onClick="$('.w_bjtjy_3 ul').slideToggle(500)"><?php echo ($item["title"]); ?><i class="w_clb_x"></i></a>

	<?php elseif($i==1 && count($item['go_link']) > 1): ?>

	 <a href="javascript:;" rel="nofollow" title="<?php echo ($item["title"]); ?>" class="w_clb_a" onClick="$('.w_bjtjy_3 ul').slideToggle(500)"><?php echo ($item["title"]); ?><i class="w_clb_x"></i></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>	

   <?php if(count($item['go_link']) > 1): ?><ul>

	 <?php if(is_array($item['go_link'])): $i = 0; $__LIST__ = $item['go_link'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li><a href="__ROOT__/?m=item&a=tgo&to=<?php echo base64_encode($r['link']);?>" rel="nofollow" target="_blank"  title="<?php echo ($item["title"]); ?>"><?php echo ($r["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

	 </ul><?php endif; ?>

   </div>

   <div class="w_bjtjy_4">

     <span class="z_submit w_bjtjy_41" data="<?php echo ($item["id"]); ?>"><img src="/static/images/wap/w_dzz.png" title="点赞" alt="点赞" /><em id="zan"><?php echo ($item["zan"]); ?></em></span>

     <span class="J_fav w_bjtjy_42"  data-id="<?php echo ($item["id"]); ?>" data-xid="1"><img src="/static/images/wap/w_scc.png" title="收藏" alt="收藏"/>收藏</span>

     <a class="w_bj_link" href="__ROOT__/?g=wap&m=item&a=tgo&to=<?php echo base64_encode($r['link']);?>" title="">直达链接</a>

   </div>

  </div>
<!--
  <div class="w_xzzr3">

     <h3>猜您喜欢</h3>

     <ul  id="con_zk_1">


	 <?php if(is_array($day_list)): $i = 0; $__LIST__ = $day_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mitem): $mod = ($i % 2 );++$i;?><li>

       <a href="<?php echo U('wap/item/index', array('id'=>$mitem['id']));?>" title="<?php echo ($mitem["title"]); ?>">

        <div class="w_zk_img">

         <img src="<?php echo attach($mitem['img'],'item');?>" title="<?php echo ($mitem["title"]); ?>" alt="<?php echo ($mitem["title"]); ?>"/>

        </div>

        <address><span><?php echo (fdate($mitem["add_time"])); ?></span><?php echo ($mitem["orig_name"]); ?></address>

        <h2><?php echo ($mitem["title"]); ?></h2>

        <div class="w_jg"><em></em></div>

        </a>

      </li><?php endforeach; endif; else: echo "" ;endif; ?>

    </ul>

  </div>  
  -->


  <a name="pl"></a>

  <link rel="stylesheet" type="text/css" href="/css/jquery.sinaEmotion.css" />
<script type="text/javascript" src="/js/jquery.sinaEmotion.js"></script>
<div class="w_xzzr4">
    <h3>全部评论</h3>
    <div class="w_xzzr4_1">
      <textarea readonly id="J_cmt_content" name="content"  class="emotion"></textarea>
      <div id="J_login">需要您<a href="javascript:;" title="登录" id="J_lo_btn">登录</a>后才可以发起讨论</div>
	  <i id="face" style="line-height: 25px;  height: 25px;  display: block;  width: 100px; cursor:pointer"><img src="http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif" style="vertical-align: middle;">表情</i>
	  <input type="hidden" name="itemid" id="itemid" value="<?php echo ($itemid); ?>"/><input type="hidden" name="xid" id="xid" value="<?php echo ($xid); ?>"/>
      <input type="button" value="发表评论" class="w_bt1" id="J_cmt_submit" data-id="<?php echo ($item["id"]); ?>"/>
    </div>
	<?php  $comment_mod = M('comment'); $pagesize = 4; $map = array('itemid' => $itemid,'xid'=>$xid,'status'=>1); $count = $comment_mod->where($map)->count('id'); $pager = new Page($count, $pagesize); $pager->path = "wap/ajax/comment_list"; $pager->parameter ="itemid=$itemid&xid=$xid"; $pager_bar = $pager->jshow(); $sql = "select * from ((select * from try_comment where itemid=$itemid and xid=$xid and status=1 order by zan desc,id desc limit 3) union (select * from try_comment where itemid=$itemid and xid=$xid and status=1  and id not in(select id from (select * from try_comment where itemid=$itemid and xid=$xid and status=1 order by zan desc, id desc limit 3) as foo) order by id desc)) as t limit $pager->firstRow , $pager->listRows "; $cmt_list = M()->query($sql); ?>
    <ul class="w_by" id="J_cmt_list">
		<?php if(is_array($cmt_list)): $i = 0; $__LIST__ = $cmt_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
		  <div class="w_by1"><span><?php echo (fdate($val["add_time"])); ?></span><em><?php echo ($val["uname"]); ?></em> <?php if($val['pid'] != 0): ?>回复 <em><i style="color:#0DACDF">@<?php echo get_uname($val['uid']);?>：</i></em><?php endif; ?><i style="display:none"><?php echo ($val["lc"]); ?>楼</i></div>
		  <div class="w_by3 J_pl_i"><?php echo ($val["info"]); ?></div>
		  <div class="w_by4"><a href="javascript:;" class="w_dred J_zan" data-id="<?php echo ($val["id"]); ?>">顶（<i><?php echo ($val["zan"]); ?></i>）</a><a href="javascript:;" class="J_hf" data-id="<?php echo ($val["id"]); ?>" title="回复">回复</a></div>
		 </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="w_pag" id="J_cmt_page"><?php echo ($pager_bar); ?></div>
  </div>
  <script type="text/javascript">
	 $(window).load(function(){
		// 绑定表情
		$('#face').SinaEmotion($('.emotion'));
		// 测试本地解析
		$(".J_pl_i").each(function(){
			$(this).html(AnalyticEmotion($(this).html()));
		});
	 });
	</script> 

    <div class="w_xzzr4">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- wap bottom -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8168598499903206"
     data-ad-slot="3172437737"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

  </div>

  <div class="clear"></div>

    <div class="w_bot">          

  <div class="w_bot1">

      <a href="{:U('wap/aboutus/index', array('id'=>2))}" title="关于我们">关于我们</a>

      <a href="<?php echo U('wap/aboutus/index', array('id'=>3));?>" title="联系我们">联系我们</a>

      <a href="<?php echo U('wap/aboutus/index', array('id'=>4));?>" title="客服专区">客服专区</a>

      <a href="<?php echo U('wap/aboutus/index', array('id'=>8));?>" title="网站地图">网站地图</a>

<script src=" http://hm.baidu.com/h.js?49113e6b733eb50457f8170c967ff321" type="text/javascript"></script>
  </div>

  版权所有&copy;白菜哦-高性价比海淘购物推荐 所有资讯均受著作湘ICP备13002285号

</div>
<script>

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
  <script>
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https'){
   bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
  }
  else{
  bp.src = 'http://push.zhanzhang.baidu.com/push.js';
  }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>

<script src="/static/js/wap/pl.js"></script>

<script>

$(function(){

	//商品点赞

	$(".z_submit").click(function(){

		$.get("/index.php?g=wap&m=ajax&a=zan&t=item",{id:$(this).attr("data")},function(result){

			if(result.status==1){

				$("#zan").html(result.data);

				weui.Loading.success("点赞成功");

			}else{

				weui.Loading.error(result.msg);

			}

		},'json')

	});

	//详细页收藏商品

	$(".J_fav").click(function(){

		if(PINER.uid==""){

			window.location="<?php echo U('wap/user/login');?>";

			return false;

		}

		var obj=$(this);

		$.post("/index.php?g=wap&m=ajax&a=setlikes",{id:obj.attr("data-id"),xid:obj.attr("data-xid")},function(result){

			if(result.status==1){

				weui.Loading.success(result.msg);

			}else{

				weui.Loading.error(result.msg);

			}

		},'json');

	});

})

</script>

</div>

</body>

</html>
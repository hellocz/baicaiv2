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

<div  class="w_h1_c_r">

     <div class="t_c_order">

         <a href="<?php echo U('wap/book/gny',array('tp'=>$tp,'isnice'=>1));?>" title="编辑推荐" <?php if($tab == 'isnice'): ?>class="current"<?php endif; ?>>编辑推荐</a>

         <a href="<?php echo U('wap/book/gny',array('tp'=>$tp,'isbao'=>1));?>" title="网友爆料" <?php if($tab == 'isbao'): ?>class="current1"<?php endif; ?>>网友爆料</a>

     </div>

   </div>

<a href="javascript:history.go(-1);" title="返回" class="w_h2_l"><img src="/static/images/wap/w_t_lef.png" title="返回" alt="国内商品优惠劵"/></a>

<h2><?php if($tp == 0): ?>国内<?php else: ?>海淘<?php endif; ?></h2>

</nav>

<div class="w_center">

  <div class="w_sd">

    <ul>

      <li>

        <a href="<?php echo U('wap/book/index');?>" title="商品分类" alt="国内商品优惠劵">

         <img src="/static/images/wap/3d_1.png"/><br/>商品分类

        </a>

      </li>

      <li><a href="javascript:;" title="每日签到" id="J_sign">

          <img src="/static/images/wap/3d_2.png"/><br/>每日签到

          </a>

      </li>

      <li><a href="<?php echo U('wap/user/index');?>" title="我的白菜" alt="国内商品优惠劵">

          <img src="/static/images/wap/3d_3.png"/><br/>我的白菜

          </a>

      </li>

    </ul>

  </div>

  <div class="clear"></div>

 <div class="w_glzl">

  <div id="m_search" class="p_lr">

     <form action="<?php echo U('wap/book/gny');?>" method="get" class="clearfix">

       <input type="text fl" class="text" name="keywords" placeholder="快速搜索你想要的商品" value="">

       <input type="hidden" name="tp" value="<?php echo ($tp); ?>" />

       <input type="hidden" name="<?php echo ($tab); ?>" value="1" />

       <button class="btn fr" type="submit"></button>

     </form>

  </div>

  

  <ul class="list list_preferential" id="post_list_preferential">

    <?php if(is_array($item_list)): $i = 0; $__LIST__ = $item_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li> <a href="<?php echo U('wap/item/index',array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); echo ($r["price"]); ?>">

  <div class="image_wrap">

  <div class="image"><img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: echo attach($r['img'],'item'); endif; ?>" title="<?php echo ($r["title"]); echo ($r["price"]); ?>" alt="<?php echo ($r["title"]); echo ($r["price"]); ?>"/></div>

  </div>

  <h2><?php echo ($r["title"]); ?></h2>

  <div class="price" ><?php echo ($r["price"]); ?></div>

  <address><?php echo ($r['orig_name']); ?>｜<?php echo (fdate($r['add_time'])); ?>
<span><i class="icons icon_like"></i><?php echo ($r["likes"]); ?></span><span><i class="icons icon_comment"></i><?php echo ($r["comments"]); ?></span><span><i class="icons icon_zan"></i><?php echo ($r["zan"]); ?></span>
  </address>

  </a> </li><?php endforeach; endif; else: echo "" ;endif; ?>

    <?php if(is_array($item_list)): $i = 0; $__LIST__ = $item_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li> 

      <a href="<?php echo U('wap/item/index',array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); ?>">

      <div class="image_wrap">

        <div class="image"><img src="<?php echo attach($r['img'],'item');?>" alt="<?php echo ($r["title"]); ?>" title="<?php echo ($r["title"]); ?>"/></div>

      </div>

      <address>

      <span><?php echo (fdate($r["add_time"])); ?></span><?php echo getly($r['orig_id']);?>

      </address>

      <h2><?php echo ($r["title"]); ?></h2>

      <div class="tips"><span><i class="icons icon_comment"></i><?php echo ($r["comments"]); ?></span></div>

      </a>

    </li><?php endforeach; endif; else: echo "" ;endif; ?>

  </ul>

  <?php if($pagesize < $count): ?><div class="clear"></div>

  <div id="more" class="btn_getmore" ><a href="javascript:;" title="加载更多" alt="国内商品优惠劵">加载更多</a></div><?php endif; ?>

  <div id="Loading" style="display: none;text-align:center">加载中...</div>

  <input type="hidden" id="page" value="2"/>

</div>

   <div class="clear"></div>

    <div class="w_bot">          

  <div class="w_bot1">

      <a href="<?php echo U('wap/aboutus/index', array('id'=>2));?>" title="关于我们">关于我们</a>

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

   

   <script src="/static/js/wap/weui.min.js"></script>

   <link href="/static/js/wap/weui.css" type="text/css" rel="stylesheet"/>

   <script>

//加载更多

$(document).ready(function(){

  $("#more").click(function(){

    var more_id=$("#page").val(),l=$("#Loading"),g=$("#more");

    l.show();g.hide();

    $.ajax({

       type:"GET",

       url: "/wap-book-gny-tp-<?php echo ($tp); ?>-<?php echo ($tab); ?>-1",

       data: "keywords=<?php echo ($keywords); ?>&more=more&p="+more_id,

       success: function(msg){

         if(msg){

           $("#page").val(parseInt(more_id)+1);

           $("#post_list_preferential").append(msg);

           g.show();l.hide();

         }else{

           weui.Loading.error("已经到最后一页了");

           $(".btn_getmore").hide();l.hide();

         }

       }

    });

  })

});

//签到

$("#J_sign").click(function(){

  if(PINER.uid==""){

    window.location="<?php echo U('wap/user/login');?>";

    return false;

  }

  $.get(PINER.root+'/?g=wap&m=user&a=sign',function(result){

    if(result.status==0){

      weui.Loading.error(result.msg);

    }else{

      weui.Loading.success(result.msg);

    }

  },'json');

});

</script>

</div>

</body>

</html>
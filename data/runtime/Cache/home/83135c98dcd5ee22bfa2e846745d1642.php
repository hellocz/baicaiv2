<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo ($page_seo["title"]); ?></title>

<meta name="keywords" content="<?php echo ($page_seo["keywords"]); ?>" />

<meta name="description" content="<?php echo ($page_seo["description"]); ?>" />

<link href="/css/bc_css.css?v=2017120101" type="text/css" rel="stylesheet"/>

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
                <input id="s" name="q" type="search" class="text_search" value="<?php if($strpos1): echo ($strpos1); else: ?>黑五<?php endif; ?>" onblur="if(this.value==&#39;&#39;) {this.value=&#39;黑五&#39;;this.style.color=&#39;#999&#39;;}" onfocus="if(this.value==&#39;黑五&#39;) {this.value=&#39;&#39;;this.style.color=&#39;#333&#39;;}" style="color: rgb(153, 153, 153);" _hover-ignore="1">
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


<div class="w_center">

  <div class="w_cen_lef">

    <div class="w_zh_dq">

	  <a href="/" title="首页">首页</a>><a href="<?php echo U('exchange/index');?>" title="积分兑换">积分兑换</a>><a href="<?php echo U('tick/index');?>" title="优惠劵" class="w_zh_dq_1">优惠劵</a>

	</div>

    <div class="w_yhj1">

     <ul>

	 <?php if(is_array($orig_list)): $i = 0; $__LIST__ = $orig_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li>

         <a href="<?php echo U('tick/orig',array('id'=>$item['id']));?>" title="<?php echo ($item['name']); ?>">

           <img src="<?php if($item['img_url']): echo attach($item['img_url'],item_orig); else: ?>/images/nopic.jpg<?php endif; ?>" title="<?php echo ($item['name']); ?>" alt="<?php echo ($item['name']); ?>"/><br/>

           <?php echo ($item['name']); ?>

         </a>

       </li><?php endforeach; endif; else: echo "" ;endif; ?>

     </ul>

    </div>

	<div class="w_azm">按字母检索：

	<a href="<?php echo U('tick/index');?>" title="全部" <?php if($tp == ''): ?>class="w_rqb"<?php endif; ?>>全部</a>

	   <?php $plist = M("cosler")->select();?>

	   <?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><a href="<?php echo U('tick/index',array('tp'=>$r['fPY']));?>" title="<?php echo ($r['fPY']); ?>" <?php if($tp == $r['fPY']): ?>class="w_rqb"<?php endif; ?>><?php echo ($r['fPY']); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>

	   </div>

	<div  class="w_yhj2">

     <ul>

	 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li <?php if($i%2 == 1): ?>class="no_left"<?php endif; ?>>

         <a class="tick_img" href="<?php echo U('tick/show',array('id'=>$r['id']));?>" title=""><img src="<?php echo attach($r['img'],'item_orig');?>" title="<?php echo ($r["name"]); ?>" alt="<?php echo ($r["name"]); ?>"/></a>

         <div class="quan_des">
          <h2><a href="<?php echo U('tick/show',array('id'=>$r['id']));?>" title="<?php echo ($r["name"]); ?>"><?php echo ($r["name"]); ?></a></h2>

         <p>还剩：<?php echo ($r["days"]); ?>天, 已领：<?php echo ($r["yl"]); ?>张, <br/>剩余：<?php echo ($r["sy"]); ?>张</p>
         <div><a class="quan_get" href="<?php echo U('tick/show',array('id'=>$r['id']));?>" title="立即领取">立即领取</a></div>
        </div>


       </li><?php endforeach; endif; else: echo "" ;endif; ?>

     </ul>

    </div>


    <div class="w_pag"><?php echo ($pagebar); ?></div>


  </div>

  <div class="w_cen_rig ">

    <style type="text/css">
    .quan_you{
        height: 80px;
        width: 80px;
        display: table-cell;
        line-height: 80px;
    }
</style>
<div class="w_r5">

     <h2>热门优惠劵</h2>

     <ul>

	 <?php
 $hot_tick = M("tick")->where("start_time < NOW() and end_time > NOW()")->order("yl desc,id desc")->limit(3)->select(); $count=count($hot_tick); for($i=0;$i<$count;$i++){ $new_time[$i]['time']=strtotime($hot_tick[$i]['end_time']); if($new_time[$i]['time']> time()){ $hot_tickA[$i]['id']=$hot_tick[$i]['id']; $hot_tickA[$i]['name']=$hot_tick[$i]['name']; $hot_tickA[$i]['orig_id']=$hot_tick[$i]['orig_id']; $hot_tickA[$i]['start_time']=$hot_tick[$i]['start_time']; $hot_tickA[$i]['end_time']=$hot_tick[$i]['end_time']; $hot_tickA[$i]['new_time']=strtotime($hot_tick[$i]['end_time']); $hot_tickA[$i]['time']=time(); $hot_tickA[$i]['intro']=$hot_tick[$i]['intro']; $hot_tickA[$i]['status']=$hot_tick[$i]['status']; $hot_tickA[$i]['yl']=$hot_tick[$i]['yl']; $hot_tickA[$i]['sy']=$hot_tick[$i]['sy']; $v[$i]['je']=$hot_tick[$i]['je']; $hot_tickA[$i]['dhjf']=$hot_tick[$i]['dhjf']; $hot_tickA[$i]['ordid']=$hot_tick[$i]['ordid']; $hot_tickA[$i]['ljdz']=$hot_tick[$i]['ljdz']; $hot_tickA[$i]['xl']=$hot_tick[$i]['xl']; }else{ continue; } } ?>

	  <?php if(is_array($hot_tickA)): $i = 0; $__LIST__ = $hot_tickA;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li>

         <a class="quan_you" href="<?php echo U('tick/show',array('id'=>$r['id']));?>" title="<?php echo ($r['name']); ?>">

         <img src="<?php echo orig_img($r['orig_id']);?>" title="<?php echo ($r['name']); ?>" alt="<?php echo ($r['name']); ?>"/>

        

         </a>

         <div class="quan_des">

          <p><?php echo ($r['name']); ?></p>

           <span>已领：<?php echo ($r['yl']); ?>件<a href="<?php echo U('tick/show',array('id'=>$r['id']));?>" title="领取">领取</a></span>
        </div>
         <div></div>

       </li><?php endforeach; endif; else: echo "" ;endif; ?>

     </ul>
     <a href="<?php echo U('tick/index');?>">查看更多>></a>
     </div>

	 

	   <!--
<div class="w_r6">

     <h2>专题</h2>

     <div class="w_bd_3">

      advert 11;

    </div>
    </div>
      -->
    
    <div class="w_r7">

    

    

        <!--

        <h3>热门资讯</h3>

        -->



        <?php echo R('advert/index', array(15), 'Widget');?>



       </div>

  

  <div style=" clear:both;"></div>

  

  <!--

  <script type="text/javascript" src="/js/jquery.SuperSlide2.js"></script>

     

       <div style="width:300px;margin:40px auto 0 auto">

      

          <h2>&nbsp;&nbsp;您可能还喜欢</h2>

          

          <div class="mr_frbox" >

              <img class="mr_frBtnL prev" src="/images/w_le1.png" width="28" height="46" />

              <div class="mr_frUl">

                  <ul>

                      <?php $art_list =M("item")->where("status=1")->order('ishot desc,id desc')->limit(8)->select();?>

                      <?php if(is_array($art_list)): $i = 0; $__LIST__ = $art_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if($i%2): ?><li>

                              <a href="<?php echo U('item/index', array('id'=>$r['id']));?>" target="_blank"><img src="<?php echo attach($r['img'],'item');?>" width="115" height="95" alt="<?php echo ($r["title"]); ?>" /><p><?php echo (msubstr($r["title"],0,8,"")); ?></p></a>

                          <?php else: ?>

                              <a href="<?php echo U('item/index', array('id'=>$r['id']));?>" target="_blank"><img src="<?php echo attach($r['img'],'item');?>" width="115" height="95" alt="<?php echo ($r["title"]); ?>" /><p><?php echo (msubstr($r["title"],0,8,"")); ?></p></a>

                          </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

                  </ul>

              </div>

              <img class="mr_frBtnR next" src="/images/w_rig1.png" width="28" height="46" />

          </div>

      

       </div>

      

      

      <script type="text/javascript">

      $(".mr_frbox").slide({

          titCell:"",

          mainCell:".mr_frUl ul",

          autoPage:true,

          effect:"leftLoop",

          autoPlay:true,

          vis:4

      });

      </script>

    --> 


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


</body>

</html>
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

<script type="text/javascript" src="/js/jquery.flexslider-min.js"></script>



<link rel="stylesheet" type="text/css" href="/static/css/default/style.css" />

<link rel="stylesheet" type="text/css" href="/static/css/default/base.css" />

<link rel="stylesheet" type="text/css" href="/static/css/default/exchange.css" />
<style type="text/css">
#con_wt_1 table td{
border: 2px solid;
margin: 1px;
padding: 2px;
}
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


<div class="w_center">

  <div class="w_cen_lef">

    <div class="w_zh_dq">

	  <a href="/" title="首页">首页</a>><a href="<?php echo U('exchange/index');?>" title="礼品兑换">礼品兑换</a>><a  class="w_zh_dq_1">兑换详情</a>

	</div>

	 <div class="w_zrxx">

       <h1><?php echo ($item["title"]); ?></h1>

       <div class="w_zrxx_1">

      <div class="w_zrxx_1_l">

       <img src="<?php echo attach(str_replace('_s.'.array_pop(explode('.', $item['img'])), '_b.'.array_pop(explode('.', $item['img'])), $item['img']), 'score_item');?>" title="<?php echo ($item["title"]); ?>" alt="<?php echo ($item["title"]); ?>"/>

      </div>

      <div class="w_zrxx_1_r">

       <div class="w_zrxx_1_r2" style="margin-top:0px">

       <span><?php echo L('surplus_stock');?>：<em><?php echo ($item["stock"]); ?></em></span><br/>

       <span><?php echo L('buy_num');?>：<em><?php echo ($item["buy_num"]); ?></em></span><br/>

       <span><?php echo L('user_num');?>：<em><?php echo ($item["user_num"]); ?></em></span><br/>

 	<span>所需积分：<em><?php echo ($item["score"]); ?></em></span><br/>

	   <span>所需金币：<em><?php echo ($item["coin"]); ?></em></span><br/>

	   <span><?php echo L('ec_number');?>：<input type="text" id="J_num_<?php echo ($item["id"]); ?>" class="input_text_number" value="1" size="4"></span><br/>

       </div>

       <div class="w_zrxx_1_r3">

       <a href="javascript:;" id="J_ec_btn" title="立即兑换" data-id="<?php echo ($item["id"]); ?>" data-num="#J_num_<?php echo ($item["id"]); ?>" class="w_dha">立即兑换</a><a style="left:20px;position: relative;" href="<?php echo U('user/phone_bind');?>"  title="绑定手机号"  class="w_dha">绑定手机号</a>
       </div>
       <div class="w_zrxx_1_r3">
       

       </div>

      </div>

     </div>

      <div class="w_xq1">

      <div class="w_had">

      <span class="w_had_dq" id="wt1" onclick="setTab('wt',1,2,'w_had_dq')">兑换须知</span>

      <span id="wt2" onclick="setTab('wt',2,2,'w_had_dq')">兑换记录</span>             

    </div>



      <div class="w_xq1_d_l" id="con_wt_1" style="display: block;">

        <?php echo ($item["desc"]); ?>

      </div>

    <div class="w_xq1_d_l" id="con_wt_2" style="display: none;">

       <table cellpadding="0" cellspacing="0" class="w_dtxq_tb">

	    <tr>

		  <td class="w_dtxq_tb_1">兑换用户 </td>

		  <td class="w_dtxq_tb_2">兑换时间</td>

		  <td class="w_dtxq_tb_3">状态</td>

		</tr>

		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><tr>

		  <td class="w_dtxq_tb_1"><?php echo ($r["uname"]); ?></td>

		  <td class="w_dtxq_tb_2"><?php echo (fdate($r["add_time"])); ?></td>

		  <td class="w_dtxq_tb_3"><?php if($r['status'] == 0): ?>处理中<?php else: ?>已完成<?php endif; ?></td>

		</tr><?php endforeach; endif; else: echo "" ;endif; ?>

	  </table>

	   <div class="w_pag"><?php echo ($pagebar); ?></div>

    </div>

     </div>

   </div> 

  </div>

  <div class="w_cen_rig ">

    <div class="w_r5">
     <h2>热门优惠劵</h2>
     <ul>
	 <?php $hot_tick = M("tick")->where("start_time < NOW()")->order("yl desc,id desc")->limit(6)->select(); $count=count($hot_tick); for($i=0;$i<$count;$i++){ $new_time[$i]['time']=strtotime($hot_tick[$i]['end_time']); if($new_time[$i]['time']> time()){ $hot_tickA[$i]['id']=$hot_tick[$i]['id']; $hot_tickA[$i]['name']=$hot_tick[$i]['name']; $hot_tickA[$i]['orig_id']=$hot_tick[$i]['orig_id']; $hot_tickA[$i]['start_time']=$hot_tick[$i]['start_time']; $hot_tickA[$i]['end_time']=$hot_tick[$i]['end_time']; $hot_tickA[$i]['new_time']=strtotime($hot_tick[$i]['end_time']); $hot_tickA[$i]['time']=time(); $hot_tickA[$i]['intro']=$hot_tick[$i]['intro']; $hot_tickA[$i]['status']=$hot_tick[$i]['status']; $hot_tickA[$i]['yl']=$hot_tick[$i]['yl']; $hot_tickA[$i]['sy']=$hot_tick[$i]['sy']; $v[$i]['je']=$hot_tick[$i]['je']; $hot_tickA[$i]['dhjf']=$hot_tick[$i]['dhjf']; $hot_tickA[$i]['ordid']=$hot_tick[$i]['ordid']; $hot_tickA[$i]['ljdz']=$hot_tick[$i]['ljdz']; $hot_tickA[$i]['xl']=$hot_tick[$i]['xl']; }else{ continue; } } ?>
	  <?php if(is_array($hot_tickA)): $i = 0; $__LIST__ = $hot_tickA;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li>
         <a href="<?php echo U('tick/show',array('id'=>$r['id']));?>" title="<?php echo ($r['name']); ?>">
         <img src="<?php echo orig_img($r['orig_id']);?>" title="<?php echo ($r['name']); ?>" alt="<?php echo ($r['name']); ?>"/>
         <p><?php echo ($r['name']); ?></p>
         </a>
           <span>已领：<?php echo ($r['yl']); ?>件</span>
         <div><a href="<?php echo U('tick/show',array('id'=>$r['id']));?>" title="领取">领取</a></div>
       </li><?php endforeach; endif; else: echo "" ;endif; ?>
     </ul>
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
/*
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
*/
$('.sxs .gb').click(function(){
    $('.sxs').hide();
})
</script>


<script src="/static/js/lhg/lhgdialog.min.js?self=true&skin=idialog" type="text/javascript"></script>

<script src="/js/jquery.form.js" type="text/javascript"></script>

<script src="/js/function.js" type="text/javascript"></script>

<script>

$("#J_ec_btn").on('click', function(){

	if(!confirm('兑换该物品需<?php echo ($item["coin"]); ?>金币，请确定？')){

		return false;

	}

	if("" == PINER.uid){

		$.get("index.php?m=user&a=login",function(res){opdg(res.data,524,262,'用户登录');},'json');

		return false;

	}

	var id = $(this).attr('data-id'),

	num_input = $(this).attr('data-num'),

	num = $(num_input).val();

	$.get(PINER.root + '/?m=exchange&a=ec', {id:id, num:num}, function(result){

		if(result.status == 1){

			$(".tip-c").html(result.msg);

			$('.tipbox').show().addClass("tip-success");

			setTimeout("$('.tipbox').hide();", 2000); 

		}else if(result.status == 2){

			opdg(result.data,450,253,"填写收货地址");

			$('#J_daddress_form').ajaxForm(

				 function(result){

					result = eval("("+result+")");

					if(result.status == 1){

						$(".tip-c").html(result.msg);

						$('.tipbox').show().addClass("tip-success");

						window.location.reload();

					} else {

						$(".tip-c").html(result.msg);

						$('.tipbox').show().addClass("tip-error");

						setTimeout("$('.tipbox').hide();", 2000);

					}	

				}

			); 

		}else{

			$(".tip-c").html(result.msg);

			$('.tipbox').show().addClass("tip-error");

			setTimeout("$('.tipbox').hide();", 2000);

		}

	},'json');

});

</script>

</body>

</html>
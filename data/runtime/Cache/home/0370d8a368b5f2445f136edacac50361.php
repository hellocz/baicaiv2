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


<link rel="stylesheet" href="/static/css/default/main.css" type="text/css">
<script type="text/javascript"> var zhiyou_open = 1; </script>
<script type="text/javascript" src="/js/userbase.1.0.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<style type="text/css">
  .w_r_tab{
    margin-top: 30px;
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
	  <a href="/" title="首页">首页</a>><a href="<?php echo U('bao/index',array('type'=>isbao,'dss'=>'cc'));?>" target="_blank"><span id="sy2">网友爆料</span></a>
	</div>
    <div class="w_spxx_bd">
    <div class="w_spxx_1">
      <h2><?php echo ($item["title"]); ?><em style="color:red;margin-left:15px"><?php echo ($item["price"]); ?></em><br/></h2>
	  <div class="w_xgxq">
	    <div class="w_xgxq_1">
		  <i><a href="javascript:;" class="J_jb " data-id="<?php echo ($item["id"]); ?>" data-xid='1' title="无货举报">无货举报</a></i>
		  <span>标签：</span>
		  <?php if(is_array($item['tag_list'])): $i = 0; $__LIST__ = $item['tag_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><a href="<?php echo U('book/index', array('tag'=>urlencode($tag)));?>" target="_blank"><?php echo ($tag); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
		  <br/><span>时间：</span><a><?php echo (fdate($item["add_time"])); ?></a><span style="margin-left:15px;">商城：</span><a href="<?php echo U('orig/show',array('id'=>$item['orig_id']));?>" title="<?php echo getly($item['orig_id']);?>" style="margin-left:10px;"><?php echo getly($item['orig_id']);?></a>
		</div>
		<div class="w_zj">
        <div class="w_zdlj">
		 <?php if(is_array($item['go_link'])): $i = 0; $__LIST__ = $item['go_link'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if($i==1): ?><a   <?php if($item['orig_id'] == 3): ?>isconvert="1" href="<?php echo ($r['link']); ?>"<?php else: ?> href="__ROOT__/?m=item&a=tgo&to=<?php echo shortUrl($r['link']);?>"<?php endif; ?> rel="nofollow" target="_blank"  title="<?php echo ($item["title"]); ?>" class="w_zdlj_a" style="background:#3dc399;"><i class="w_down"></i><?php echo ($r["name"]); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>		 
          <?php if(count($item['go_link']) > 1): ?><ul style="display: none;">
		   <?php if(is_array($item['go_link'])): $i = 0; $__LIST__ = $item['go_link'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li>  <a   <?php if($item['orig_id'] == 3): ?>isconvert="1" href="<?php echo ($r['link']); ?>"<?php else: ?> href="__ROOT__/?m=item&a=tgo&to=<?php echo shortUrl($r['link']);?>"<?php endif; ?> target="_blank" rel="nofollow"  title="<?php echo ($item["title"]); ?>"><?php echo ($r["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul><?php endif; ?>
        </div>
      </div>
	   <div class="w_xxgg">
	     <a href="javascript:;"  data-id="<?php echo ($item["id"]); ?>" title="分享+" class="T_share w_xxgg_1">分享</a>
		 <a href="javascript:;" data="<?php echo ($item["id"]); ?>" title="点赞" class="z_submit w_xxgg_2">点赞</a>
		 <a href="javascript:;" data-id="<?php echo ($item["id"]); ?>" data-xid="1" title="收藏" class="J_fav w_xxgg_3">收藏</a>
		 <a href="#pl" title="评论" class="w_xxgg_4">评论</a>
	   </div>	   
	  <div class="clear"></div>
	  </div>
        <?php if(!empty($item['remark'])): ?><div class="pyss">
            小编评语：<?php echo ($item["remark"]); ?>
        </div><?php endif; ?>
	  <div class="content">
		<?php echo ($item["content"]); ?>
		</div>
      <div class="w_spxx_3">
       <em>注意：</em>优惠信息有时效性和地域性，如果看到价格变化或者已经无货请点击 : <a href="javascript:;" class="J_jb " data-id="<?php echo ($item["id"]); ?>" data-xid='1'>无货举报</a><br>希望大家发扬网络共享精神，如果发现了优质商品特价，欢迎<a href="<?php echo U('item/share_item');?>" title="爆料">点此爆料</a>，以便及时分享给广大菜油，谢绝商家广告。
      </div>
      <div class="w_spxx_4">
       <div class="w_spxx_4_l">
         <p>上一篇：<?php if($pre): ?><a href="<?php echo U('bitem/index',array('id'=>$pre['id'],'isbao'=>1));?>" title="<?php echo ($pre['title']); ?>"><?php echo ($pre['title']); ?></a><?php else: ?>无<?php endif; ?></p>
         <p>下一篇：<?php if($next): ?><a href="<?php echo U('bitem/index',array('id'=>$next['id'],'isbao'=>1));?>" title="<?php echo ($next['title']); ?>"><?php echo ($next['title']); ?></a><?php else: ?>无<?php endif; ?></p>
       </div>
       
      </div>
      <div class="w_spxx_5">
      <?php echo R('advert/index', array(13), 'Widget');?>
      </div>

	  <a name="pl"></a>
      <?php if($item['uid'] != 0): else: ?> ﻿      <link rel="stylesheet" type="text/css" href="/css/jquery.sinaEmotion.css" />


	  <script type="text/javascript" src="/js/jquery.sinaEmotion.js"></script>

	  <a name="comments"></a>

	  <div class="w_spxx_7">

        <textarea readonly id="J_cmt_content" name="content"  class="emotion"></textarea>

         <span id="J_login">需要您<a href="javascript:;" id="J_lo_btn">登录</a>后才可以发起讨论</span>

         <i id="face" style="line-height: 25px;  height: 25px;  display: block;  width: 100px; cursor:pointer"><img src="http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif" style="vertical-align: middle;"/>表情</i><input type="button" id="J_cmt_submit" data-id="<?php echo ($item["id"]); ?>" value="发表评论" class="w_fbpl"/>

		 <input type="hidden" name="itemid" id="itemid" value="<?php echo ($itemid); ?>"/><input type="hidden" name="xid" id="xid" value="<?php echo ($xid); ?>"/>

      </div>

	  <?php
 $comment_mod = M('comment'); $pagesize = 5; $map = array('itemid' => $itemid,'xid'=>$xid,'status'=>1,'pid'=>0); $count = $comment_mod->where($map)->count('id'); $pager = new Page($count, $pagesize); $pager->path = "ajax/comment_list"; $pager->parameter ="itemid=$itemid&xid=$xid"; $pager_bar = $pager->jshow(); $pager_hot = new Page($count, $pagesize); $pager_hot->path = "ajax/comment_list"; $pager_hot->parameter ="itemid=$itemid&xid=$xid&order=zan"; $pager_bar_hot = $pager_hot->jshow(); $hot_list=M()->query("select * from try_comment where itemid=$itemid and xid=$xid and status=1  order by zan desc,id desc limit $pager_hot->firstRow , $pager_hot->listRows "); foreach($hot_list as $key=>$v){ $hot_list[$key]['list1']=M()->query("select count(*) from try_comment where status=1 and pid='".$v['id']."' order by id asc"); $hot_list[$key]['list']=M()->query("select * from try_comment where status=1 and pid='".$v['id']."' order by id asc"); } $sql = "select * from try_comment where itemid=$itemid and xid=$xid and status=1 and pid=0 order by id desc  limit $pager->firstRow , $pager->listRows "; $cmt_list = M()->query($sql); foreach($cmt_list as $key=>$v){ $cmt_list[$key]['list']=M()->query("select * from try_comment where status=1 and pid='".$v['id']."' order by id asc"); $cmt_list[$key]['list1']=M()->query("select count(*) from try_comment where status=1 and pid='".$v['id']."' order by id asc"); } ?>



<div style=" clear:both;"></div>



      <style>

          a{ text-decoration:none;}

          .ly_ba{ width:100%; margin-top:20px; padding-bottom:5px; height:auto; display:inline-table; border-bottom:1px dashed #CCC;}

          .ly_tx_a{ width:15%; height:auto;  float:left; text-align:left; background:#fff; }

          .ly_tx_a img{ border-radius:24px;}

          .ly_tx_a p{ font-size:12px;}



          .lr_ra{ width:85%; float: left; height:auto;  }



          .ly_ba_lr{ width:100%; float: left;  height:auto;  padding:0;}

          .lr_ra p{     line-height: 26px;

              font-size: 14px;

              margin-top: 0px;}

          .lr_ra em{ width:250px; height:26px; line-height:26px; text-align:right; padding-right:10px; display:block; float:right; font-style:normal; font-size:12px;    color: #999999;}



          .yl_ba_hf{ width:100%; float:left; }

          .yl_ba_hf ul{ float:right; /*width:320px; */height:30px; background:#fff; border:none;}

          .yl_ba_hf ul li{ float:left; text-align: center; width:70px; height:30px; line-height:30px; display: block; padding:0; border:none;}

          .yl_ba_hf ul li img{ width:16px; height:16px;}

          .yl_ba_hf ul li a{ text-decoration:none; font-size:12px; background:#fff; color:#F00; }



          .gly_pl{clear: both;

              line-height: 26px;

              font-size: 14px;

              color: #666;}

          .gly_pl span{    line-height: 2em;

              padding: 10px;

              background: #e7fdf9;

              border: 1px solid #999;

              display: block;}

          .gly_pl input{  }





          .hflr_a{ width:100%; float:left; background:#fcfcfc; display:block; margin-top:8px; padding-top:10px;}

          .hflr_b{ width:100%; float:left; background:#fcfcfc; display:block; margin-top:8px; padding-top:10px;}

          .lh_a1{ width:100%; float:left;}

          .lh_a1 .hf_zr{ float:left; }

          .lh_a1  p{ float:left;  font-size:14px; padding-left:30px;}

          .lh_a1 .hf_zr img{ width:24px; height:24px; border-radius:12px; float:left; margin-left:10px;}

          .lh_a1 .hf_zr span{ margin-top:0px; float:left;}

          .lh_a1 .lrhf{ padding-right:13px;}

          .lh_a1 .lrhf div{ float:right; font-size:12px;}

          .lh_a1 .lrhf div span{ margin-right:10px;}



          .hfzk_b{ display:none;}



          .black_overlay{  display: none;  position: absolute; top:200%;     left: 0%;  width: 100%;  height: 100%;

              z-index:1001;  -moz-opacity: 0.8;  opacity:.80;  filter: alpha(opacity=80);  }

          .white_content {  display: none;  position:fixed; top: 50%; margin-top: -140px;    left: 50%;  width: 400px; margin-left: -300px;  padding: 16px;

              border:1px #CCCCCC solid;    background-color: white;  z-index:1002;  overflow: auto;  }





          .black_overlay_a{  display: none;  position: absolute;  top:200%;  left: 0%;  width: 100%;  height: 100%;

              z-index:1001;  -moz-opacity: 0.8;  opacity:.80;  filter: alpha(opacity=80);  }

          .white_content_a {  display: none;  position:fixed; top: 50%; margin-top: -140px;   left: 50%;  width: 400px; margin-left: -300px;  padding: 16px;   border:1px #CCCCCC solid;

              background-color: white;  z-index:1002;  overflow: auto;  }



          .black_overlay_b{  display: none;  position: absolute;  top:200%;  left: 0%;  width: 100%;  height: 100%;

              z-index:1001;  -moz-opacity: 0.8;  opacity:.80;  filter: alpha(opacity=80);  }

          .white_content_b {  display: none;  position:fixed; top: 50%; margin-top: -140px;    left: 50%;  width: 400px; margin-left: -300px;  padding: 16px;   border:1px #CCCCCC solid;

              background-color: white;  z-index:1002;  overflow: auto;  }





          .black_overlay_c{  display: none;  position: absolute;  top:200%;  left: 0%;  width: 100%;  height: 100%;

              z-index:1001;  -moz-opacity: 0.8;  opacity:.80;  filter: alpha(opacity=80);  }

          .white_content_c {  display: none;  position: fixed ; top: 50%; margin-top: -140px; left: 50%;  width: 400px; margin-left: -300px;  padding: 16px;   border:1px #CCCCCC solid;

              background-color: white;  z-index:1002;  overflow: auto;  }



          .white_content a{ float:right; margin-bottom:20px;}

          .white_content_a a{ float:right; margin-bottom:20px;}

          .white_content_b a{ float:right; margin-bottom:20px;}

          .white_content_c a{ float:right; margin-bottom:20px;}



          .jf_qd input{ background:#3dc399; border:none; color:#fff; line-height:26px; padding: 0 10px;}

          hr{clear: both;}





          .white_content tr{height: 40px;}

          .white_content tr td:first-child{text-align: center;}

          .white_content tr td input{border:1px solid #ddd;height: 30px;

              padding-left: 10px;

              padding-right: 10px;}





          /*7-30新增*/

          .J_pl_nav a{

              margin-right: 10px;

              cursor: pointer;

          }



          .J_pl_nav a.active{

              color: #fe2f27;

          }

          .J_pl_list1{

              display: none;

          }





          /*7-30新增 END*/

      </style>

      <div class="w_spxx_8">

          <h3 class="J_pl_nav"><a class="" title="最热评论">最热评论</a><a title="最新评论" class="active">最新评论</a></h3>

          <script>

              $(".J_pl_nav a").click(function(){

                  $(this).addClass('active').siblings('a').removeClass('active');

                  var n = $(this).index();
                  $('.J_pl_list').hide();

                  $(".J_pl_list"+n).show();

              });

          </script>



          <div class="J_pl_list0 J_pl_list" style="display: none;">

              <div id="J_cmt_list_hot">

              <?php if(is_array($hot_list)): $i = 0; $__LIST__ = $hot_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="ly_ba">

                      <div class="ly_tx_a">

                          <img src="<?php echo avatar($val['uid'], 48);?>" height="48" width="48" />

                          <em></em>

                      </div>

                      <div class="lr_ra">

                          <p class="ssb"><?php echo ($val["uname"]); ?><span>LV.<?php echo grade($val['uid']);?></span><em><?php echo (fdate($val["add_time"])); ?></em></p>

                          <div class="ly_ba_lr"><p class="J_pl_i"><?php echo ($val["info"]); ?></p></div>

                          <div class="hflr_a hflr<?php echo ($val["id"]); ?>" id="hflr_a<?php echo ($val["id"]); ?>">

                              <?php if(is_array($val['list'])): $i = 0; $__LIST__ = $val['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><div class="lh_a1">

                                      <div class="hf_zr"> <img src="<?php echo avatar($r['uid'], 48);?>" /><span><?php echo ($r["uname"]); ?></span></div> <p class="J_pl_i"><?php echo ($r["info"]); ?></p>


                                      <div class="lrhf"><div><span><?php echo (fdate($r["add_time"])); ?></span><a href="javascript:;" class="J_hf" data-id="<?php echo ($r["id"]); ?>" psid="<?php echo ($val["id"]); ?>" title="回复">回复</a></div></div>

                                  </div><?php endforeach; endif; else: echo "" ;endif; ?>

                          </div>

                          <div class="yl_ba_hf">

                              <div class="gly_pl">

                                  <?php if($val['pingyu']): ?><span><strong>管理员评论：</strong><?php echo ($val['pingyu']); ?></span><?php endif; ?>  &nbsp; &nbsp; &nbsp; &nbsp;

                              </div>

                              <ul>

                                  <?php if($visitor['is_bj'] == 1): ?><li><a href="javascript:if (confirm('您确定删除此评论')) location.href='<?php echo U('ajax/sc_comment',array('id'=>$val['id'],'uid'=>$val['uid']));?>'; " title="删除">删除</a></li><?php endif; ?>

                                  <?php if($visitor['is_bj'] == 1): ?><li>

                                      <a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';document.getElementById('id').value='<?php echo ($val["id"]); ?>';document.getElementById('uid').value='<?php echo ($val["uid"]); ?>';">管理</a>



                                  </li><?php endif; ?>

                                  <?php if($val['jf']): ?><li><img src="/images/jf1_pic.png" alt="积分" />积分<a href="" >+<?php echo ($val['jf']); ?></a></li><?php endif; ?>

                                  <li><a href="javascript:;" class="w_dred J_zan" data-id="<?php echo ($val["id"]); ?>">顶（<i><?php echo ($val["zan"]); ?></i>）</a></li>

                                  <li class="J_hf1" data-id="<?php echo ($val["id"]); ?>" psid="<?php echo ($val["id"]); ?>">回复</li>

                              </ul>

                          </div>



                      </div>

                  </div><?php endforeach; endif; else: echo "" ;endif; ?>

                  </div>

              <div class="w_pag" id="J_cmt_page_hot" style="margin-bottom:20px"><?php echo ($pager_bar_hot); ?></div>

          </div>





          <div style=" clear:both;"></div><br> <br>



          <div  class="J_pl_list1 J_pl_list" style="display: block;">

              <div id="J_cmt_list">

              <?php if(is_array($cmt_list)): $i = 0; $__LIST__ = $cmt_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="ly_ba">

                      <div class="ly_tx_a">

                          <img src="<?php echo avatar($val['uid'], 48);?>" height="48" width="48" />

                          <em ><?php echo ($val["lc"]); ?>楼</em>

                      </div>



                      <div class="lr_ra">

                          <p class="ssb"><?php echo ($val["uname"]); ?><span>LV.<?php echo grade($val['uid']);?></span><em><?php echo (fdate($val["add_time"])); ?></em></p>

                          <div class="ly_ba_lr"><p class="J_pl_i"><?php echo ($val["info"]); ?></p></div>

                          <div class="hflr_b hflr<?php echo ($val["id"]); ?>" id="hflr_b<?php echo ($val["id"]); ?>">

                              <?php if(is_array($val['list'])): $i = 0; $__LIST__ = $val['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><div class="lh_a1">

                                      <div class="hf_zr"> <img src="<?php echo avatar($r['uid'], 48);?>" /><span><?php echo ($r["uname"]); ?></span></div> <p class="J_pl_i"><?php echo ($r["info"]); ?></p>

                                      <div class="lrhf"><div><span><?php echo (fdate($r["add_time"])); ?></span><a href="javascript:;" class="J_hf" data-id="<?php echo ($r["id"]); ?>" psid="<?php echo ($val["id"]); ?>" title="回复">回复</a></div></div>

                                  </div><?php endforeach; endif; else: echo "" ;endif; ?>

                          </div>

                          <div class="yl_ba_hf">

                              <div class="gly_pl">

                                  <?php if($val['pingyu']): ?><span><strong>管理员评论：</strong><?php echo ($val['pingyu']); ?></span><?php endif; ?>&nbsp; &nbsp; &nbsp; &nbsp;



                              </div>

                              <ul>

                                  <?php if($visitor['is_bj'] == 1): ?><li><a href="javascript:if (confirm('您确定删除此评论')) location.href='<?php echo U('ajax/sc_comment',array('id'=>$val['id'],'uid'=>$val['uid']));?>'; " title="删除">删除</a></li><?php endif; ?>

                                  <?php if($val['jf']): ?><li><img src="/images/jf1_pic.png" alt="积分" />积分<a href="" >+<?php echo ($val['jf']); ?></a></li><?php endif; ?>

                                  <?php if($visitor['is_bj'] == 1): ?><li>

                                      <a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';document.getElementById('id').value='<?php echo ($val["id"]); ?>';document.getElementById('uid').value='<?php echo ($val["uid"]); ?>';">管理</a>

                                  </li><?php endif; ?>



                                  <li><a href="javascript:;" class="w_dred J_zan" data-id="<?php echo ($val["id"]); ?>">顶（<i><?php echo ($val["zan"]); ?></i>）</a></li>

                                  <li class="J_hf1" data-id="<?php echo ($val["id"]); ?>" psid="<?php echo ($val["id"]); ?>">回复</li>

                              </ul>

                          </div>





                      </div>



                  </div><?php endforeach; endif; else: echo "" ;endif; ?>

              </div>

              <div class="w_pag" id="J_cmt_page" style="margin-bottom:20px"><?php echo ($pager_bar); ?></div>

          </div>



          <div class="clear"></div>





      </div>

      </div>

      <div id="light" class="white_content">

          <a href="javascript:void(0)" onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">

              关闭</a>

          <br /><br />

          <form action="<?php echo U('ajax/bj_comment');?>" method="post" style="width:300px;margin:0 auto;">

              <table width="96%" border="0">

                  <tr>

                      <td width="20%">积分</td>

                      <td width="80%"><input style=" width:90%;" name="jf" type="text" /></td>

                  </tr>

                  <tr>

                      <td width="20%">财富</td>

                      <td width="80%"><input style=" width:90%;" name="cf" type="text" /></td>

                  </tr>

                  <tr>

                      <td width="20%">贡献</td>

                      <td width="80%"><input style=" width:90%;" name="gx" type="text" /></td>

                  </tr>

                  <tr>

                      <td width="20%">评语</td>

                      <td width="80%"><input style=" width:90%;" name="pingyu" type="text" value="感谢您的精彩回复！"/></td>

                  </tr>

                  <input type="hidden" id="id" name="id" value="">

                  <input type="hidden" id="uid" name="uid" value="">

				  <input type="hidden"  name="title" value="<?php echo ($item["title"]); ?>">

				  <input type="hidden"  name="g_id" value="<?php echo ($item["id"]); ?>">

                  <tr>

                      <td colspan="2" style="text-align:left; padding-left:20%; padding-top:20px;" class="jf_qd">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" 确 定 " />&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value=" 重 填 " /></td>

                  </tr>

              </table>

          </form>

      </div>

      <div id="fade" class="black_overlay">

      <script type="text/javascript">

          $(window).load(function(){

              // 绑定表情

              $('#face').SinaEmotion($('.emotion'));

              // 测试本地解析

              $(".J_pl_i").each(function(){

                  $(this).html(AnalyticEmotion($(this).html()));

              });

          });

          $(".gly_pl>a").click(function(){

              var top = $(this).offset().top;

              var height = $('.white_content').height();

              $('.white_content').css('top',top-height/2);

          })

      </script>

      <style>.w_pag a{cursor:pointer}</style><?php endif; ?>
      
    </div>
  </div>
  </div>
  <div class="w_cen_rig ">
	  <?php if($item['uid'] != 0): ?><div class="w_rr1">
      <div class="w_bjrr"><img src="<?php echo avatar($item['uid'], 48);?>"/><span>爆料人：<a href="<?php echo U('space/index', array('uid'=>$item['uid']));?>" class="J_card n" data-uid="<?php echo ($item["uid"]); ?>" target="_blank"><?php echo ($item["uname"]); ?></a></span></div>
	 	<!--<div class="w_wybj"><a href="<?php echo U("item/share_item");?>" title="我要爆料" class="w_zdlj_a">我要爆料</a></div>-->
      </div><?php endif; ?>
    <div class="w_r_tab">
        <h2>热门白菜榜</h2>


              <div class="rightPanel beyondHide">

                <ul class="tab_nav" id="tabNav2">
                    <li class="tab_faxian_li current_item"><h3>小时榜</h3></li>
                    <li class="tab_faxian_li"><h3>24小时榜</h3></li>
                    <!--
                    <li class="more"><a href="" target="_blank">更多 &gt;</a></li>
                    -->
                </ul>

                <div class="tab_info_con" style="display: block;">
                    <ul class="ninePicBox">
                        <?php if(is_array($hour_list)): $i = 0; $__LIST__ = $hour_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li class="re_pic" <?php if(!($i%3)): ?>class="gogo"<?php endif; ?>>
                            <?php if($i < 4): ?><img class="re_tt" src="/images/tz_<?php echo ($i); ?>.png" /><?php endif; ?>
                            <a href="<?php echo U('item/index',array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); ?>" target="_blank">
                                <img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: echo attach($r['img'],'item');?>!thumb94<?php endif; ?>" alt="<?php echo ($r["title"]); ?>" style="width:94px; height:94px;">
                                <div class="tabCon" style="z-index:999999;">
                                    <p><?php echo (msubstr($r["title"],0,16,"")); ?></p>
                                    <span><?php echo ($r["price"]); ?></span>
                                </div>
                            </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                 </div>

                <div class="tab_info_con" style="display: none;">
                    <ul class="ninePicBox">
                        <?php if(is_array($day_list)): $i = 0; $__LIST__ = $day_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li class="re_pic" <?php if(!($i%3)): ?>class="gogo"<?php endif; ?>>
                            <?php if($i < 4): ?><img class="re_tt" src="/images/tz_<?php echo ($i); ?>.png" /><?php endif; ?>
                            <a href="<?php echo U('item/index',array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); ?>" target="_blank">
                                <img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: echo attach($r['img'],'item');?>!thumb94<?php endif; ?>" alt="<?php echo ($r["title"]); ?>" style="width:94px; height:94px;">
                                <div class="tabCon" style="z-index:999999;">
                                    <p><?php echo (msubstr($r["title"],0,16,"")); ?></p>
                                    <span><?php echo ($r["price"]); ?></span>
                                </div>
                            </a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>

              </div>
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

  <!--   <div class="w_r5">
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
	  -->
	 

    
  <div style=" clear:both;"></div>
  <style>
			.widget{ background-color:#fff; width: 280px; margin:30px 0 20px 0;padding:10px;
-moz-box-shadow:rgba(0, 0, 0, 0.0980392) 2px 2px 5px;-webkit-box-shadow:rgba(0, 0, 0, 0.0980392) 2px 2px 5px;box-shadow:rgba(0, 0, 0, 0.0980392) 2px 2px 5px;}
.widget-title{font-size:1.2em;color:#AC643D;margin-bottom:10px;padding-bottom:5px;border-bottom:#dedede dotted 1px;}
.widget li{padding:5px;background:#F6F6F6;margin:10px 0;font-size:12px;}
.widget a{color:#333;}
.widget li a{font-weight:bold;color:#333333;}
.widget li a:hover{color:#AC643D;text-decoration:none;}
.widget li img{max-width: 100%;}
.widget_tag_cloud a{background:#F2F2F2;color:#AC643D;
-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}
.recommendd-posts-list a img {
    border: #dedede solid 1px;
    padding: 1px;
}
.widget ul.recommendd-posts-list li a {
    color: #0066DD;
    font-size: 1.1em;
}
.widget ul.recommendd-posts-list li a{
	color:#0066DD;font-size:1.1em;}
.widget ul.recommendd-posts-list li a:hover{
	text-decoration:underline;
	}
.recommendd-posts-list a span{color:red;}
.recommendd-posts-list a img{border:#dedede solid 1px;padding:1px;}
		</style>
	</head>
	<body>
		<div id="recommendpostswidget-2" class="widget recommend-posts"><div class="widget-title">热门推荐</div>
		
		<ul class="recommendd-posts-list">
		
		<?php if(is_array($is_hot)): $i = 0; $__LIST__ = $is_hot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li style="background:none;border-bottom:#ccc solid 1px;margin:0;padding:0;padding-bottom:10px;margin-bottom:10px;padding-left:80px;">
				<a href="<?php echo U('item/index', array('id'=>$val['id']));?>" title="" style="float:left;width:65px;margin-left:-80px;"><img src="<?php echo ($val["img"]); ?>" alt="<?php echo ($val["title"]); ?>"></a>
				<a href="<?php echo U('item/index', array('id'=>$val['id']));?>" title="" style="font-weight:normal;"><?php echo ($val["title"]); ?></a>
				<p style=" line-height:40px; color:#FF0000">
					价格：<?php echo ($val["price"]); ?>
				</p>
				<div class="clear"></div>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
			
			</ul>
		</div>
  
  <script type="text/javascript" src="/js/jquery.SuperSlide2.js"></script>
     
       <div style="width:300px;margin:40px auto 0 auto; background:#fff;">
      
          <h2 style=" color:#323232; font-size:16px; padding-left:16px; padding-top:20px; padding-bottom:20px;">&nbsp;&nbsp;您可能还喜欢</h2>
          
          <div class="mr_frbox" >
              <img class="mr_frBtnL prev" src="/images/knxh_l.png" width="28" height="46" />
              <div class="mr_frUl">
                  <ul>
					  <?php if(is_array($maylike_list)): $i = 0; $__LIST__ = $maylike_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mval): $mod = ($i % 2 );++$i; if(is_array($mval['list'])): $i = 0; $__LIST__ = $mval['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if($i%2): ?><li>
                              <a href="<?php echo U('item/index', array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); ?>" target="_blank"><img src="<?php echo attach($r['img'],'item');?>" width="115" height="95" alt="<?php echo ($r["title"]); ?>" /><p><?php echo (msubstr($r["title"],0,8,"")); ?></p></a>
                          <?php else: ?>
                              <a href="<?php echo U('item/index', array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); ?>" target="_blank"><img src="<?php echo attach($r['img'],'item');?>" width="115" height="95" alt="<?php echo ($r["title"]); ?>" /><p><?php echo (msubstr($r["title"],0,8,"")); ?></p></a>
                          </li><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                  </ul>
              </div>
              <img class="mr_frBtnR next" src="/images/knxh_r.png" width="28" height="46" />
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
<script>var t="item";</script>
<script src="/js/function.js"></script>
<script src="/static/js/lhg/lhgdialog.min.js?self=true&skin=idialog" type="text/javascript"></script>
<script>
$(document).ready(function() {
 $(".w_zdlj").hover(
	  function () {
		$(this).children(".w_zdlj ul").show();
	  },
	  function () {
		$(this).children(".w_zdlj ul").hide("");
	  }
	);
}) 
</script>
<div class="S_float w_clb_bd" style="display:none">
  <ul class="w_clb_1">
    <li>
	<a <?php if(is_array($item['go_link'])): $i = 0; $__LIST__ = $item['go_link'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if($i==1): ?>href="__ROOT__/?m=item&a=tgo&to=<?php echo shortUrl($r['link']);?>" rel="nofollow" target="_blank"  title="<?php echo ($item["title"]); ?>" class="w_zdlj_a" style="background:#3dc399;"<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	>
	 <i class="w_clb_i1"></i>
	 <em class="S_like" style="display:none"><?php echo ($item["likes"]); ?></em>
	</a>
	
	</li>
	<li>
	<a href="javascript:;"  data-id="<?php echo ($item["id"]); ?>" data-xid="1" title="收藏" class="J_fav">
	 <i class="w_clb_i2"></i>
	 <em></em>
	</a>
	</li>
	<li>
	<a href="javascript:;" data="<?php echo ($item["id"]); ?>" title="点赞" class="z_submit">
	 <i class="w_clb_i3"></i>
	 <em class="S_pl" style="display:none"><?php echo ($item["comments"]); ?></em>
	</a>
	</li>
	<li class="no_bott">
	<a href="javascript:;" class="T_share" data-id="<?php echo ($item["id"]); ?>" title="分享">
	 <i class="w_clb_i4"></i>
	 <em></em>
	</a>
	</li>
  </ul>
  <div class="w_sjsm">
   <a href="javascript:void(0);" title="" class="w_sjsm_a"></a>
   <div class="w_sjsm_d" style="display:none;">
      <div class="w_sjsm_d1">
	    <span id="qrcode"></span>
	    <span>扫一下，分享更方便，购买更轻松</span>
	  </div>
     <s></s>
   </div>
<script src="/js/qrcode.js"></script>
<script>
$(document).ready(function(e) {
 $(".w_sjsm").hover(
	  function () {
		$(this).children(".w_sjsm_d").show();		
	  },
	  function () {
		$(this).children(".w_sjsm_d").hide("");
	  }
	); 
	$(window).scroll(function (){
		if($(document).scrollTop()>200){
			$(".S_float").show();
		}else{
			$(".S_float").hide();
		}
	});
}) 
window.onload =function(){
	var qrcode = new QRCode(document.getElementById("qrcode"), {
		width : 200,//设置宽高
		height : 200
	});
	qrcode.makeCode("http://"+window.location.host+"<?php echo U('wap/item/index',array('id'=>$item['id']));?>");
}
</script>
</div>
</div>
</body>
</html>
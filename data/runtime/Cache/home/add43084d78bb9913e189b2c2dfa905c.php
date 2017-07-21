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

<link rel="stylesheet" href="/static/css/default/main.css" type="text/css">
<link rel="alternate" type="application/rss+xml" href="http://www.baicaio.com/rss" title="RSS" />
<script type="text/javascript"> var zhiyou_open = 1; </script>
 <script type="text/javascript" src="/js/userbase.1.0.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/jquery.SuperSlide.2.1.1.js"></script>

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




<div class="w_ks_bd">

  <div class="w_ks">

    <em>快速访问 ></em>

    <a href="<?php echo U('orig/index');?>" title="商城导航" class="w_ks_nav">商城导航</a>

	<?php echo getdh();?>                                                                                                    

  </div>

</div>

<div class="w_center">

  <div class="w_cen_lef">

    <div class="w_gn_f">

	<h2>热门置顶</h2>

     <div class="w_gn_f1">      

       <div onmouseup="StopUp_1()" class="LeftBotton1" onmousedown="GoUp_1()" onmouseout="StopUp_1()"></div>

      <div class="Cont1" id="Cont_1">

        <div class="ScrCont">

          <div id="List1_1">

            <!-- 图片列表 begin -->

			<?php if(is_array($hot_list)): $i = 0; $__LIST__ = $hot_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><div class="box3">

            <a href="<?php echo U('item/index',array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); ?>" target="_blank">

			  <img src="<?php echo attach($r['img'],'item');?>" title="<?php echo ($r["title"]); ?>" alt="<?php echo ($r["title"]); ?>"/><br/>

			  <?php echo ($r["title"]); ?><br/><?php echo ($r["intro"]); ?>

			  </a>

            </div><?php endforeach; endif; else: echo "" ;endif; ?>          

            <!-- 图片列表 end -->

          </div>

          <div id="List2_1"></div>

      </div>

      

    </div>

	<div onmouseup="ISL_StopDown_1()" class="RightBotton1" onmousedown="ISL_GoDown_1()" onmouseout="ISL_StopDown_1()"></div>

      <script type="text/javascript" src="/js/rollpic.js"></script>

	 </div>

	 </div>

     <div class="w_f2">

       <div class="w_sy_ha">

         <div class="w_sh_r"><a href="<?php echo ($cc_url); ?>" title="橱窗模式" <?php if($dss=='cc'): ?>class="w_sh_1i"<?php else: ?>class="w_sh_1"<?php endif; ?>><i></i></a><em>|</em><a href="<?php echo ($lb_url); ?>" title="列表模式" <?php if($dss=='lb'): ?>class="w_sh_2i"<?php else: ?>class="w_sh_2"<?php endif; ?>><i></i></a>		 

		 </div>

         <a href="<?php echo U('book/baicai',array('isnice'=>1,'dss'=>'lb'));?>"><span <?php if($tab == 'isnice'): ?>class="w_sy_s"<?php endif; ?> id="sy1" >编辑推荐<i></i></span></a>
         <!--<a href="<?php echo U('book/gny',array('tp'=>$tp,'isbao'=>1,'dss'=>'cc'));?>"><span <?php if($tab == 'isbao'): ?>class="w_sy_s"<?php endif; ?> id="sy2">网友爆料</span></a>-->

		 

       </div>

	   		<?php if($dss == lb): ?><div class="w_f2_nr1"   id="con_sy_1">

        <ul id="C_drc">

		<?php if(is_array($item_list)): $i = 0; $__LIST__ = $item_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li class="w_f2_nr1_1 hvr-glow">

          <a <?php if($tab == 'isbao'): ?>href="<?php echo U('item/index',array('id'=>$r['id'],'isbao'=>1));?>"<?php elseif($r['sc']): ?> href="<?php echo U('article/show',array('id'=>$r['id']));?>"<?php else: ?> href="<?php echo U('item/index',array('id'=>$r['id']));?>"<?php endif; ?> title="<?php echo ($r["title"]); ?>" target="_blank" class="zf_lista"><img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: if(preg_match('/img.baicaio.com/',$r['img'])): echo attach($r['img'],'item');?>!thumb208<?php else: echo attach($r['img'],'item'); endif; endif; ?>" title="<?php echo ($r["title"]); ?>" alt="<?php echo ($r["title"]); ?>"/></a>

          <div class="zf_listit">

              <h2><a <?php if($tab == 'isbao'): ?>href="<?php echo U('item/index',array('id'=>$r['id'],'isbao'=>1));?>"<?php elseif($r['sc']): ?> href="<?php echo U('article/show',array('id'=>$r['id']));?>"<?php else: ?> href="<?php echo U('item/index',array('id'=>$r['id']));?>"<?php endif; ?> title="<?php echo ($r["title"]); ?>" target="_blank"><?php echo ($r["title"]); ?><em style="color:red;"><?php echo ($r["price"]); ?></em></a>
              </h2>

              <!--<p class="w_p1"><?php if($tab == 'isbao'): if($r['uid'] != 0): ?><span><a href="<?php echo U('space/index', array('uid'=>$r['uid']));?>" title="<?php echo ($r["uname"]); ?>" data-uid="<?php echo ($r['uid']); ?>" class="J_card"> <img src="<?php echo avatar($r['uid'],'');?>" title="<?php echo ($r["username"]); ?>" alt="<?php echo ($r["username"]); ?>" class="ava"/> <?php echo ($r["uname"]); ?></a></span><?php endif; endif; ?><span><?php echo (mdate($r['add_time'])); ?></span></p>-->

              <p class="w_p1"><?php if($r['sc']): ?><a  class="w_dj1"><?php echo ($r["sc"]); ?></a><?php else: ?><a href="<?php echo U('orig/show',array('id'=>$r['orig_id']));?>" class="w_dj1"><?php echo getly($r['orig_id']);?></a><?php endif; if($tab == 'isbao'): if($r['uid'] != 0): ?><span style="float:right"><a href="<?php echo U('space/index', array('uid'=>$r['uid']));?>" title="<?php echo ($r["uname"]); ?>" data-uid="<?php echo ($r['uid']); ?>" class="J_card"> <img src="<?php echo avatar($r['uid'],'');?>" title="<?php echo ($r["username"]); ?>" alt="<?php echo ($r["username"]); ?>" class="ava"/> <?php echo ($r["uname"]); ?></a></span><?php endif; endif; ?><span><?php echo (mdate($r['add_time'])); ?></span></p>

              <p><?php if($r['intro']): echo ($r["intro"]); else: echo (msubstr(strip_tags($r["content"]),0,130)); endif; ?></p>

              <div class="w_f2nr1_b">

              <div class="w_f2nr1_le"><a href="javascript:void(0)" onclick="jz_submit_click(this)" title="赞" class="w_z_1 Jz_submit" data="<?php echo ($r["id"]); ?>"  data-t="item"><?php echo ($r["zan"]); ?></a><a href="javascript:;" title="<?php echo ($r["title"]); ?>"  class="w_z_2 Jl_likes" data-id="<?php echo ($r["id"]); ?>" data-xid="1"><?php echo ($r["likes"]); ?></a><a <?php if($tab == 'isbao'): ?>href="<?php echo U('item/index',array('id'=>$r['id'],'isbao'=>1));?>"<?php else: ?> href="<?php echo U('item/index',array('id'=>$r['id']));?>"<?php endif; ?> title="<?php echo ($r["title"]); ?>"  class="w_z_3" target="_blank"><?php echo ($r["comments"]); ?></a></div><div class="w_f2nr1_rig">

              <div class="w_zzj_1">

                    <?php $llink = unserialize($r['go_link']);$lc = count($llink);?>

                    <?php if(is_array($llink)): $i = 0; $__LIST__ = $llink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rm): $mod = ($i % 2 );++$i; if($i == 1): ?><a <?php if(($tab == 'isbao') AND ($r['orig_id'] == 3)): ?>isconvert="1" href="<?php echo ($rm['link']); ?>"<?php else: ?> href="__ROOT__/?m=item&a=tgo&to=<?php echo shortUrl($rm['link']);?>"<?php endif; ?> title="<?php echo ($rm["title"]); ?>" class="w_zdlj_a" target="_blank" ><i class="<?php if($lc > 1): ?>w_down<?php else: ?>w_right<?php endif; ?>"></i><?php echo ($rm["name"]); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>

                    <?php if($lc > 1): ?><ul>

                    <?php if(is_array($llink)): $i = 0; $__LIST__ = $llink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rm): $mod = ($i % 2 );++$i;?><li><a href="__ROOT__/?m=item&a=tgo&to=<?php echo shortUrl($rm['link']);?>" target="_blank" rel="nofollow"  title="<?php echo ($rm["title"]); ?>"><?php echo ($rm["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

                  </ul><?php endif; ?>

                </div>

            </div></div>

            </div>

         </li><?php endforeach; endif; else: echo "" ;endif; ?>

      </ul>

       </div>       

	   <?php else: ?>

       <div class="w_nr3">

         <ul id="C_drc">

		   <?php if(is_array($item_list)): $i = 0; $__LIST__ = $item_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li <?php if($i%3 == 1): ?>class="no_left"<?php endif; ?>>

             <a <?php if($tab == 'isbao'): ?>href="<?php echo U('item/index',array('id'=>$r['id'],'isbao'=>1));?>"<?php else: ?> href="<?php echo U('item/index',array('id'=>$r['id']));?>"<?php endif; ?> title="<?php echo ($r["title"]); ?>" target="_blank"><img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: ?> <?php if(preg_match('/img.baicaio.com/',$r['img'])): echo attach($r['img'],'item');?>!thumb208<?php else: echo attach($r['img'],'item'); endif; endif; ?>" title="<?php echo ($r["title"]); ?>" alt="<?php echo ($r["title"]); ?>"/></a>

             <h2> <a <?php if($tab == 'isbao'): ?>href="<?php echo U('item/index',array('id'=>$r['id'],'isbao'=>1));?>"<?php else: ?> href="<?php echo U('item/index',array('id'=>$r['id']));?>"<?php endif; ?> title="<?php echo ($r["title"]); ?>" target="_blank"><?php echo (msubstr($r["title"],0,30,'')); ?><em style="color:red;"><?php echo ($r["price"]); ?></em></a>
             <span style="height: 25px; position: absolute;top: 245px;right: 0;padding: 0 20px;background: rgba(255,255,255,0.7);"><a href="<?php echo U('orig/show',array('id'=>$r['orig_id']));?>" title="<?php echo getly($r['orig_id']);?>"><?php echo getly($r['orig_id']);?></a></span> </h2><div class="clear"></div>

			 

             <p class="w_p1"><?php if($tab == 'isbao'): if($r['uid'] != 0): ?><span><a href="<?php echo U('space/index', array('uid'=>$r['uid']));?>" title="<?php echo ($r["uname"]); ?>" data-uid="<?php echo ($r['uid']); ?>" class="J_card"> <img src="<?php echo avatar($r['uid'],'');?>" title="<?php echo ($r["username"]); ?>" alt="<?php echo ($r["username"]); ?>" class="ava"/> <?php echo ($r["uname"]); ?></a></span><?php endif; endif; ?></p>

			 

			 

             <p  style="height:24px"><?php echo (mdate($r['add_time'])); ?></p>

             <div class="w_nr3_div">

             <div class="w_zzj_1">

				<?php $llink = unserialize($r['go_link']);$lc = count($llink);?>

				<?php if(is_array($llink)): $j = 0; $__LIST__ = $llink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rm): $mod = ($j % 2 );++$j; if($j == 1): ?><a   <?php if(($tab == 'isbao') AND ($r['orig_id'] == 3)): ?>isconvert="1" href="<?php echo ($rm['link']); ?>"<?php else: ?> href="__ROOT__/?m=item&a=tgo&to=<?php echo shortUrl($rm['link']);?>"<?php endif; ?> title="<?php echo ($rm["title"]); ?>" class="w_zdlj_a" target="_blank" rel="nofollow" ><i class="<?php if($lc > 1): ?>w_down<?php else: ?>w_right<?php endif; ?>"></i><?php echo ($rm["name"]); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>

				<?php if($lc > 1): ?><ul>

				<?php if(is_array($llink)): $m = 0; $__LIST__ = $llink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rm): $mod = ($m % 2 );++$m;?><li><a href="__ROOT__/?m=item&a=tgo&to=<?php echo shortUrl($rm['link']);?>" target="_blank" rel="nofollow"  title="<?php echo ($rm["title"]); ?>" ><?php echo ($rm["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

              </ul><?php endif; ?>

			</div>

              <div class="w_f2nr1_le"><a href="javascript:void(0)" onclick="jz_submit_click(this)" title="赞" class="w_z_1 Jz_submit" data="<?php echo ($r["id"]); ?>"  data-t="item"><?php echo ($r["zan"]); ?></a><a href="javascript:;" title="<?php echo ($r["title"]); ?>"  class="w_z_2 Jl_likes" data-id="<?php echo ($r["id"]); ?>" data-xid="1"><?php echo ($r["likes"]); ?></a><a <?php if($tab == 'isbao'): ?>href="<?php echo U('item/index',array('id'=>$r['id'],'isbao'=>1));?>"<?php else: ?> href="<?php echo U('item/index',array('id'=>$r['id']));?>"<?php endif; ?> title="<?php echo ($r["title"]); ?>"  class="w_z_3" target="_blank"><?php echo ($r["comments"]); ?></a></div>

             </div>

           </li><?php endforeach; endif; else: echo "" ;endif; ?>

         </ul>

       </div><?php endif; ?>

	   <script>

	   $(document).ready(function(e) {

             $(".w_zzj_1").hover(

				  function () {

					$(this).children("ul").show();

					$(this).find("i").addClass("w_up").removeClass("w_down");

				  },

				  function () {

					$(this).children("ul").hide("");

					$(this).find("i").addClass("w_down").removeClass("w_up");

				  }

				); 

			 $(".w_p1 .w_dj1").each(function(){

				 if($(this).html()==""){

					 $(this).hide();

				 }

			 })

        }) 

	   </script>

       <div class="w_pag"><?php echo ($page_bar); ?></div>

     </div>

  </div>

  <div class="w_cen_rig">

    <div class="w_r1">

      <div class="w_w_r1_2">

        <h2>关注我们，获取最新动态</h2>

        <a href="http://weibo.com/baicaio" target="_blank" title="微博"><img src="/images/w_gz_1.png" title="微博" alt="微博"/></a>

        <a href="javascript:;" title="微信" class="l_wx_a">

		 <img src="/images/w_gz_2.png" title="微信" alt="微信"/>

		 <div class="l_wx">

		   <img src="/images/w_erm.jpg" title="白菜哦" alt="白菜哦"/>

		 </div>

		</a>

		<script>

		$(document).ready(function(e) {

             $(".l_wx_a").hover(

				  function () {

					$(this).children(".l_wx").show();

				  },

				  function () {

					$(this).children(".l_wx").hide("");

				  }

				); 

           }) 

		</script>

        <a href="/rss" title="订阅"><img src="/images/w_gz_3.png" title="订阅" alt="订阅"/></a>

        <a href="javascript:AddFavorite(window.location.href,document.title)" title="收藏"><img src="/images/w_gz_4.png" title="收藏" alt="收藏"/></a>
        <a href="/item/241815.html" title="插件"><img src="/images/w_gz_5.png" title="插件" alt="插件"/></a>
      </div>

    </div>

    

    <div class="w_r4"><?php echo R('advert/index', array(2), 'Widget');?></div>

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
                                 <img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: ?> <?php if(preg_match('/img.baicaio.com/',$r['img'])): echo attach($r['img'],'item');?>!thumb94<?php else: echo attach($r['img'],'item'); endif; endif; ?>" alt="<?php echo ($r["title"]); ?>" style="width:94px; height:94px;">
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
                                 <img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: ?> <?php if(preg_match('/img.baicaio.com/',$r['img'])): echo attach($r['img'],'item');?>!thumb94<?php else: echo attach($r['img'],'item'); endif; endif; ?>" style="width:94px; height:94px;">
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


  </div>

</div>
<script type="text/javascript" src="/js/scrollfix.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){

	$('.flexslider').flexslider({

		directionNav: true,

		pauseOnAction: false

	});

        $('.w_r_tab').scrollFix(60,"top");
        $('.w_r7').scrollFix(480,"top");

});

function show(obj){

	if($(this).attr('data')==0){

		obj.css('height','auto');

		$(this).attr('data','1');

	}else{

		obj.css('height','27px');

		$(this).attr('data','0');

	}

}

</script>

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


<script src="/js/function.js"></script>

<script src="/static/js/lhg/lhgdialog.min.js?self=true&skin=idialog" type="text/javascript"></script>

</body>

</html>
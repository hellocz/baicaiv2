<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo ($page_seo["title"]); ?></title>

<meta name="keywords" content="<?php echo ($page_seo["keywords"]); ?>" />

<meta name="description" content="<?php echo ($page_seo["description"]); ?>" />

<link href="/css/bc_css.css?v=2017112701" type="text/css" rel="stylesheet"/>

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


<link rel="stylesheet" type="text/css" href="/static/css/default/style.css" />
<link rel="stylesheet" type="text/css" href="/static/css/default/base.css" />
<script src="/js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>

<link rel="stylesheet" href="/static/css/default/main.css" type="text/css">
<link rel="alternate" type="application/rss+xml" href="http://www.baicaio.com/rss" title="RSS" />

<style>
  .w_dj1{margin-right: 10px;}
</style>

<script type="text/javascript" src="/js/jquery.SuperSlide.2.1.1.js"></script>

<!--//首页轮播-->
<script type="text/javascript">
  
</script>
<!--[if lt IE 9]>
<script src="http://www.smzdm.com/resources/public/js/html5.js?v=2016041103"></script>
<link rel="stylesheet" href="http://res.smzdm.com/resources/public/css/ieHack.css" type="text/css" />
<![endif]-->



<!--[if IE 7]>
<style type=”text/css”>
.blFormBox .wantItem{position: initial;}
</style>
<![endif]-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body style="background:#f5f5f5"><div class="w_head_bd">
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


<!--focus start-
<div id="slideBox" class="slideBox">
<?php  $adv_list = M("ad")->where('status=1 AND board_id=1')->select(); $advCount = M("ad")->where('status=1 AND board_id=1')->count(); ?>
  <div class="hd">
    <ul>
    <?php
 $html.=''; for($i=0;$i<$advCount;$i++){ $j=$i+1; $html.="<li>".$j."</li>"; } echo $html; ?>
    </ul>
  </div>
  <div class="bd">
    <ul>
    <?php
 $htmlA.=''; for($j=0;$j<=$advCount;$j++){ $htmlA.="<li><a href='".$adv_list[$j][url]."' target='_blank' alt='".$adv_list[$j][name]."'><img src='".$adv_list[$j][content]."' /></a></li>"; } echo $htmlA; ?>
    </ul>
  </div>
</div>
focus end-->  

<!--banner end-->
<div class="w_ks_bd">

  <div class="w_ks">

    <em>快速访问 ></em>

    <a href="<?php echo U('orig/index');?>" title="商城导航" class="w_ks_nav">商城导航</a>

	<?php echo getdh();?>                                                                                                    

  </div>

</div>
<div class="w_center">
  <div class="w_center">
      <div class="txtScroll-top">
            <div class="bd">
               <em>置顶</em>
                <form class="form_search" action="/bao-search" method="get">
                 <button type="submit" class="btn_search icon-search"><!--[if lt IE 8]>Go<![endif]--></button>
                <input id="s" name="q" class="text_search" value="爆料专搜" onblur="if(this.value=='') {this.value='爆料专搜';this.style.color='#999';}" onfocus="if(this.value=='爆料专搜') {this.value='';this.style.color='#333';}" style="color: rgb(153, 153, 153);" _hover-ignore="1" type="search">
            </form>
            </div>
        </div>
        <script id="jsID" type="text/javascript">
         var ary = location.href.split("&");
        jQuery(".txtScroll-top").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"top",autoPlay:true,vis:1});
        </script>
     <div class="w_f2">
        
<style type="text/css">
 .fpItem {
    position: relative;
}
 .itemImageAndName {
    cursor: pointer;
    font-family: "Open Sans Semibold","Open Sans",Arial,sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: 600;
    height: 218px;
    padding: 10px 10px 7px;
    position: relative;
}
 .fpGridBox {
    background-color: #fff;
    border-color: #c7c7c7;
    border-radius: 4px;
    border-style: solid;
    border-width: 1px 1px 3px;
     color: #999;
    float: left;
    margin-bottom: 10px;
    margin-right: 5px;
    overflow: hidden;
    width: 163px;
}
.itemImageAndName {
    cursor: pointer;
    font-family: "Open Sans Semibold","Open Sans",Arial,sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: 600;
    height: 218px;
    padding: 10px 10px 7px;
    position: relative;
}
.itemImageAndName {
    cursor: pointer;
    font-family: "Open Sans Semibold","Open Sans",Arial,sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: 600;
}
.imageContainer {
    display: table-cell;
    height: 133px;
    vertical-align: middle;
    width: 180px;
}
 .grid .fpItem .itemImageAndName img {
    border: medium none;
    display: block;
    margin: 0 auto;
    max-height: 125px;
    max-width: 125px;
}
.itemPrice {
    font-family: "Open Sans Bold", "Open Sans", Arial, sans-serif;
    font-style: normal;
    font-weight: 700;
    color: #76b14c;
    font-size: 15px;
    max-width: 100px;
    line-height: 18px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: inline-block;
}
 .avatarBox {
    position: absolute;
    right: 10px;
}
.fpItem .itemInfoLine {
    border-top: 1px solid #e5e5e5;
    color: #999;
    display: block;
    height: 25px;
    padding: 6px 10px 0 10px;
    position: relative;
}
 a.itemStore {
    font-family: arial,sans-serif;
    font-weight: 500;
    font-style: italic;
    color: #999;
    display: inline-block;
    font-size: 11px;
    padding: 0 2px 4px 0;
    max-width: 130px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
 .itemTitle {
    display: block;
    overflow: hidden;
    font-family: arial, sans-serif;
    font-weight: 400;
}
 .itemTitle {
    line-height: 15px;
    height: 60px;
    color: #0072bc;
}
 .itemBottomRow {
    background-color: #fcfcfc;
    color: #c7c7c7;
    border-radius: 0 0 4px 4px;
    border-top: 1px solid #d6d6d6;
    height: 37px;
}
.likes {
    border-right: 1px solid #d6d6d6;
    padding: 10px;
    position: relative;
    float: left;
}
.comments {
    border-right: 1px solid #d6d6d6;
    padding: 10px;
    overflow: hidden;
    text-align: center;
}
.w_zdlj_a{
    border-radius: 4px;
    color: #646464;
    float: right;
    padding-right: 10px;
    text-align: center;
}
.newtag{
    background-color: #3DC399;
    float: left;
    height: 20px;
    left: -30px;
    position: absolute;
    text-align: center;
    transform: rotate(-45deg);
    width: 100px;
}
.itemBottomRow .comments:hover{background: #3dc399;color: #fff;text-decoration: none !important;}

</style>
       <div class="w_nr3">

         <ul id="C_drc">
	<?php if(is_array($item_list)): $i = 0; $__LIST__ = $item_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><div class="fpGridBox grid">
            <div class="fpItem">
                  <div>
                     <div>
                        <div class="itemImageAndName">
                        <?php $time = time()-60*10;?>
                                <?php if($r['add_time'] > $time): ?><span class="newtag">NEW</span><?php endif; ?>
                                <div class="itemImageLink">
                                   <div class="imageContainer">
                                      <a href="<?php echo U('bitem/index',array('id'=>$r['id'],'isbao'=>1));?>" title="<?php echo ($r["title"]); ?>" target="_blank"><img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: echo attach($r['img'],'item');?>!newthumb<?php endif; ?>" title="<?php echo ($r["title"]); ?>" alt="<?php echo ($r["title"]); ?>"/></a>
                                  </div>
                                 <a class="itemStore"  href="<?php echo U('orig/show',array('id'=>$r['orig_id']));?>" title="<?php echo getly($r['orig_id']);?>"><?php echo getly($r['orig_id']);?></a>
                                 <a class="itemTitle" href="<?php echo U('bitem/index',array('id'=>$r['id'],'isbao'=>1));?>" title="<?php echo ($r["title"]); ?>" target="_blank"><?php echo ($r["title"]); ?><em style="color:red;"><?php echo ($r["price"]); ?></em></a>
                                </div>
                         </div>
	                 <div class="itemInfoLine">
                             <div class="avatarBox">
                                   <img src="<?php echo avatar($r['uid'],'');?>" title="<?php echo ($r["uname"]); ?>" alt="<?php echo ($r["uname"]); ?>" class="ava"/>
                             </div>
			       <div class="itemPrice  "><?php echo (mdate($r['add_time'])); ?></div>
                          </div>
                          <div class="itemBottomRow">
                                <div class="likes">
                                  <div class="w_f2nr1_le"><a href="javascript:void(0)" onclick="jz_submit_click(this)" title="赞" class="w_z_1 Jz_submit" data="<?php echo ($r["id"]); ?>"  data-t="item_diu"><?php echo ($r["zan"]); ?></a></div>
                                </div>
                               

        				<?php $llink = unserialize($r['go_link']);$lc = count($llink);?>

        				<?php if(is_array($llink)): $j = 0; $__LIST__ = $llink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rm): $mod = ($j % 2 );++$j; if($j == 1): ?><a   <?php if($r['orig_id'] == 3): ?>isconvert="1" href="<?php echo ($rm['link']); ?>"<?php else: ?> href="__ROOT__/?m=item&a=tgo&to=<?php echo shortUrl($rm['link']);?>"<?php endif; ?> title="<?php echo ($rm["title"]); ?>"  target="_blank" rel="nofollow" > <div class="comments"><?php echo ($rm["name"]); ?></div></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>

        				

                            </div>
                         </div>
                        </div>
                        </div>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>

         </ul>

       </div> 


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
         <div class="w_pag jiazai" style="display: none"><img src="/images/jiazai.gif"></div>
        <div class="w_pag" id="J_page"><?php echo ($pagebar); ?></div>
     </div>
  </div>

<script src="/static/js/wap/weui.min.js"></script>
<link rel='stylesheet' type='text/css' href='/static/js/wap/weui.css'>
<script type="text/javascript">
jQuery(".slideBox").slide({mainCell:".bd ul",autoPlay:true});
$(document).ready(function(){
    $('.flexslider').flexslider({
        directionNav: true,
        pauseOnAction: false
    });
});




var page=<?php echo ($p); ?>;
var para='isbao';
var pagesize=21;
var pageend=<?php echo ($p); ?>+3;
//右边滚动
$(window).scroll(function () {
    if ($(document).scrollTop() > 2297 ){  //判断滚动条是否滚动了***PX
        if($(document).scrollTop()<$(document).height()-$(window).height()-220){
            $(".w_r6").css({"position":"fixed",'top':"70px", "z-index":"800", "left":"50%", "margin-left":"300px","margin-top":0});
        }else{
            $(".w_r6").css({"position":"fixed", "z-index":"800", "left":"50%", "margin-left":"300px","margin-top":0,'top': '70px'});
        }
    }else
        $(".w_r6").css({"position":"static", "top":"0", "z-index":"800", "right":"0", "margin-left":"0",'margin-top':0});
});
function AddFavorite(sURL, sTitle) {
    sURL = encodeURI(sURL);
    try {
        window.external.addFavorite(sURL, sTitle);
    } catch (e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        } catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.");
        }
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
        <?php $tag_article_class = new articleTag;$about_nav = $tag_article_class->cate(array('type'=>'cate','cateid'=>'1','return'=>'about_nav','cache'=>'0',)); if(is_array($about_nav)): $i = 0; $__LIST__ = $about_nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; if($val['id'] != 14 and $val['id'] != 15): ?><a href="<?php echo U('aboutus/index', array('id'=>$val['id']));?>" title="<?php echo ($val["name"]); ?>"><?php echo ($val["name"]); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
       </div>
    --> 
   <div class="w_bot_2">  
   <em>友情链接<a class="sq_aa" href="/aboutus-index-id-14"  title="申请">（申请）</a>：</em>
   <?php $flink = M("flink")->where("cate_id=1 and status=1")->select();?>
   <?php if(is_array($flink)): $i = 0; $__LIST__ = $flink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="<?php echo ($val["url"]); ?>" target="_blank" title="<?php echo ($val["name"]); ?>"><?php echo ($val["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
   </div>  
   <div class="w_bot_3">
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
            pid: "mm_27883119_3410238_14718353",/*推广单元ID，用于区分不同的推广渠道*/
            appkey: "23232602",/*通过TOP平台申请的appkey，设置后引导成交会关联appkey*/
            unid: "mm_27883119_3410238_93410083",/*自定义统计字段*/
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
<div class="tipbox " style="z-index: 3001; left:40%; top: 323.126px; "><div class="tip-l"></div><div class="tip-c"></div><div class="tip-r"></div></div>
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
<script type="text/javascript" src="/js/function.js?v=170606"></script>

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
<script src="/static/js/lhg/lhgdialog.min.js?self=true&skin=idialog" type="text/javascript"></script>
<script src="/js/pbl.js"></script>
</body>
</html>
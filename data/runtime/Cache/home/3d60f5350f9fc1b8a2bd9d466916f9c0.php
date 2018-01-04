<?php if (!defined('THINK_PATH')) exit();?><!--banner-->
<!--focus start-->
<div class="focus" id="focus">
	<div id="focus_m" class="focus_m">
		<ul>
			<?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><a href="<?php echo U('advert/tgo', array('id'=>$ad['id']));?>" hidefocus="true">
			<li style="background:url(<?php if($ad['is_url']==1): echo ($ad["content"]); else: ?>__UPLOAD__/advert/<?php echo ($ad["content"]); endif; ?>) center 0 no-repeat #288cc0;"></li>
            </a><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>	
</div>
<!--focus end-->
<script type="text/javascript" src="/js/script.js"></script>
<!--banner end-->
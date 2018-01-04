<?php if (!defined('THINK_PATH')) exit();?><!--矩形广告位-->

<div id="slide">

<?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><div><?php echo ($ad["html"]); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>

<p id="slide_p">

<?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><span <?php if($i == 1): ?>class='cur'<?php endif; ?>></span><?php endforeach; endif; else: echo "" ;endif; ?>

</p>

</div>
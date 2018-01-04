<?php if (!defined('THINK_PATH')) exit(); if(is_array($item_list)): $i = 0; $__LIST__ = $item_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li> <a href="<?php echo U('wap/item/index',array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); ?>">

	<div class="image_wrap">

	<div class="image"><img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: echo attach($r['img'],'item'); endif; ?>" title="<?php echo ($r["title"]); ?>" alt="<?php echo ($r["title"]); ?>"/></div>

	</div>

	<address>

	<span><?php echo (fdate($r['add_time'])); ?></span><?php echo ($r['orig_name']); ?>

	</address>

	<h2><?php echo ($r["title"]); ?></h2>

	<div class="tips"><span><i class="icons icon_zan"></i><?php echo ($r["zan"]); ?></span></div>

	<div style="color:#FF0000; "><?php echo ($r["price"]); ?></div>

	</a> </li><?php endforeach; endif; else: echo "" ;endif; ?>
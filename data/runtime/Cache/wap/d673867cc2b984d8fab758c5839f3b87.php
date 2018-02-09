<?php if (!defined('THINK_PATH')) exit(); if(is_array($item_list)): $i = 0; $__LIST__ = $item_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li> <a href="<?php echo U('wap/item/index',array('id'=>$r['id']));?>" title="<?php echo ($r["title"]); echo ($r["price"]); ?>">

	<div class="image_wrap">

	<div class="image"><img src="<?php if($r['img']==''): ?>/images/nopic.jpg<?php else: echo attach($r['img'],'item'); endif; ?>" title="<?php echo ($r["title"]); echo ($r["price"]); ?>" alt="<?php echo ($r["title"]); echo ($r["price"]); ?>"/></div>

	</div>

	<h2><?php echo ($r["title"]); ?></h2>

	<div class="price" ><?php echo ($r["price"]); ?></div>

	<address><?php echo ($r['orig_name']); ?>｜<?php echo (fdate($r['add_time'])); ?>
<span><i class="icons icon_like"></i><?php echo ($r["likes"]); ?></span><span><i class="icons icon_comment"></i><?php echo ($r["comments"]); ?></span><span><i class="icons icon_zan"></i><?php echo ($r["zan"]); ?></span>
	</address>

	</a> </li><?php endforeach; endif; else: echo "" ;endif; ?>
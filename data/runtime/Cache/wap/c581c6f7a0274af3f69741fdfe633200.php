<?php if (!defined('THINK_PATH')) exit();?><!--slider-->

  <div id="slider" class="owl-carousel">

  <?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><div > <a href="<?php echo U('wap/advert/tgo', array('id'=>$ad['id']));?>"  class="openapp_banner" ><img src="<?php echo ($ad["content"]); ?>" alt="<?php echo ($ad["name"]); ?>" title="<?php echo ($ad["name"]); ?>" /></a> </div><?php endforeach; endif; else: echo "" ;endif; ?>

  </div>

  <script>

    $(function() {

		$("#slider").owlCarousel({

			singleItem:true,

			autoPlay:true

		});

	});

  </script>

  <!--slider end-->
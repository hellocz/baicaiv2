<?php if (!defined('THINK_PATH')) exit(); if(is_array($left_menu)): $i = 0; $__LIST__ = $left_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><h3 class="f14"><span class="J_switchs cu on" title="<?php echo L('expand_or_contract');?>"></span><?php echo ($val["name"]); ?></h3>
<ul>
	<?php if(is_array($val['sub'])): $i = 0; $__LIST__ = $val['sub'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sval): $mod = ($i % 2 );++$i;?><li class="sub_menu"><a href="javascript:;" data-uri="<?php echo U($sval['module_name'].'/'.$sval['action_name'], array('menuid'=>$sval['id'])); echo ($sval["data"]); ?>" data-id="<?php echo ($sval["id"]); ?>" hidefocus="true"><?php echo ($sval["name"]); if($sval['id'] == 203 ): ?>(<em id="sum"></em>)<?php endif; ?> <?php if($sval['id'] == 301 ): ?>(<em id="sum1"></em>)<?php endif; ?></a></li>
		<?php if($sval['id'] == 203 ): ?><script>
				var t = null;
				$.getJSON("/?g=admin&m=item&a=check1",function (data) {
					if(data.status ==1){
						$('#sum').html(data.msg);
					}else{
						$('#sum').html(0);
					}

				});
/*
				t = setInterval(function(){
					$.getJSON("/?g=admin&m=item&a=check1",function (data) {
						if(data.status ==1){
							$('#sum').html(data.msg);
						}else{
							$('#sum').html(0);
						}


					});
					$.getJSON("/?g=admin&m=article&a=check",function (data) {
						if(data.status ==1){
							$('#sum1').html(data.msg);
						}else{
							$('#sum1').html(0);
						}

					});

				},10000);
*/
				$.getJSON("/?g=admin&m=article&a=check",function (data) {
					if(data.status ==1){
						$('#sum1').html(data.msg);
					}else{
						$('#sum1').html(0);
					}

				});
			</script><?php endif; endforeach; endif; else: echo "" ;endif; ?>
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
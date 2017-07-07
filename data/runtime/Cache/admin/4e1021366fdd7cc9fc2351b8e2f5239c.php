<?php if (!defined('THINK_PATH')) exit();?><!--添加商品来源分类-->
<div class="dialog_content">
	<form id="info_form" name="info_form" action="<?php echo u('article/check_done');?>" method="post">
	<table width="100%" cellpadding="2" cellspacing="1" class="table_form">
		<input type="hidden" name="id" value="<?php echo ($id); ?>">
		<tr>
			<th>积分 :</th>
			<td>
               <input type="text" name="score" class="input-text fl mr10" size="20" value="<?php echo ($min_score); ?>">
			</td>
		</tr>
		<tr>
			<th>金币 :</th>
			<td>
               <input type="text" name="coin" class="input-text fl mr10" size="20"  value="<?php echo ($min_score); ?>">
			</td>
		</tr>
		<tr>
			<th>贡献 :</th>
			<td>
               <input type="text" name="offer" class="input-text fl mr10" size="20"  value="<?php echo ($min_score); ?>">
			</td>
		</tr>
		<tr>
			<th>经验 :</th>
			<td>
               <input type="text" name="exp" class="input-text fl mr10" size="20"  value="<?php echo ($min_score); ?>">
			</td>
		</tr>
	</table>
	</form>
</div>
<script>
$(function(){
	$('#info_form').ajaxForm({success:complate,dataType:'json'});
	function complate(result){
		if(result.status == 1){
			$.dialog.get(result.dialog).close();
			$.pinphp.tip({content:result.msg});
			window.location.reload();
		} else {
			$.pinphp.tip({content:result.msg, icon:'alert'});
		}
	}
	
});
</script>
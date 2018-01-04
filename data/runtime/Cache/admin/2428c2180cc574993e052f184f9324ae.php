<?php if (!defined('THINK_PATH')) exit();?><div class="dialog_content">
<form id="info_form" action="<?php echo u('tick/edit');?>" method="post">
<div class="common-form">
	<table width="100%" cellpadding="2" cellspacing="1" class="table_form">
        <tr>
			<th width="100">优惠券名称 :</th>
			<td><input type="text" name="name" id="name" class="input-text" size="30" value="<?php echo ($info["name"]); ?>"></td>
		</tr>
		<tr>
			<th>金额 :</th>
			<td>
			<input type="text" name="je" id="je" class="input-text" size="30" value="<?php echo ($info["je"]); ?>">
			</td>
		</tr>
		<tr>
			<th>兑换积分 :</th>
			<td>
			<input type="text" name="dhjf" id="dhjf" class="input-text" size="30" value="<?php echo ($info["dhjf"]); ?>">
			</td>
		</tr>
		<tr>
			<th>商城 :</th>
			<td>
            	<select style="width:50%"  name="orig_id">
                <?php $orig_list = M()->query('SELECT *,fristPinyin(name) as t FROM `try_item_orig` WHERE 1 order by t');?>
				<?php if(is_array($orig_list)): $i = 0; $__LIST__ = $orig_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><option value="<?php echo ($r["id"]); ?>" <?php if($r['id'] == $info['orig_id']): ?>selected<?php endif; ?>><?php echo ($r["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>链接地址 :</th>
			<td>
				<input type="text" name="ljdz" class="input-text" size="30" value="<?php echo ($info["ljdz"]); ?>">
			</td>
		</tr>
		<tr>
			<th>限领 :</th>
			<td>
				<input type="text" name="xl"  class="input-text" size="15" value="<?php echo ($info["xl"]); ?>">*0不做限制
			</td>
		</tr>
		<tr>
			<th>描述 :</th>
			<td>
               <textarea name="intro" id="intro" style="width:80%;height:50px;"><?php echo ($info["intro"]); ?></textarea>
			</td>
		</tr>
		<tr>
			<th>开始时间 :</th>
			<td>
             
              <input type="text" name="start_time" id="start_time" size="25" class="input-text fl mr10" value="<?php echo ($info["start_time"]); ?>">
			</td>
		</tr>
		<tr>
			<th>结束时间 :</th>
			<td>
                <input type="text" name="end_time" id="end_time" size="25" class="input-text fl mr10" value="<?php echo ($info["end_time"]); ?>">
               
			</td>
		</tr>
	</table>
    <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />
</div>
</form>
</div>
<link rel="stylesheet" type="text/css" href="__STATIC__/js/calendar/calendar-blue.css"/>
<script src="__STATIC__/js/calendar/calendar.js"></script>
<script>
Calendar.setup({
	inputField : "start_time",
	ifFormat   : "%Y-%m-%d %H:%M",
	showsTime  : true,
	timeFormat : "24"
});

Calendar.setup({
	inputField : "end_time",
	ifFormat   : "%Y-%m-%d %H:%M",
	showsTime  : true,
	timeFormat : "24"
});





</script>
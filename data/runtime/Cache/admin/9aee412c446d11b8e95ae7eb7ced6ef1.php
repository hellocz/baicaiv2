<?php if (!defined('THINK_PATH')) exit();?><!--添加广告位-->
<div class="dialog_content">
<form id="info_form" action="<?php echo u('adboard/add');?>" method="post">
<table width="100%" cellpadding="2" cellspacing="1" class="table_form">
	<tr> 
		<th width="80">广告位名称 :</th>
		<td><input type="text" name="name" id="name" class="input-text" size="30"></td>
	</tr>
	<tr> 
		<th width="80">广告位类型 :</th>
		<td>
        <select name="tpl">
        	<?php if(is_array($tpl_list)): $key = 0; $__LIST__ = $tpl_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($key % 2 );++$key;?><option value="<?php echo ($val["alias"]); ?>"><?php echo ($val["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select> 
		</td>
	</tr>
	<tr> 
		<th>广告位尺寸 :</th>
		<td>宽 : <input type="text" name="width" id="width" class="input-text" size="6" value="300"> px&nbsp;&nbsp;&nbsp;&nbsp;高 : <input type="text" name="height" id="height" class="input-text" size="6" value="300"> px</td>
		</tr>
	<tr> 
		<th>广告位说明 :</th>
		<td><textarea rows="4" cols="45" class="input-textarea" id="description" name="description"></textarea></td>
	</tr>
	<tr>
		<th><?php echo L('enabled');?> :</th>
		<td>
			<label><input type="radio" name="status" value="1" checked> <?php echo L('yes');?></label>&nbsp;&nbsp;
			<label><input type="radio" name="status" value="0"> <?php echo L('no');?></label>
		</td>
	</tr>
</table>
</form>
</div>
<script type="text/javascript">
var check_name_url = "<?php echo U('adboard/ajax_check_name');?>";
$(function(){
	$.formValidator.initConfig({formid:"info_form",autotip:true});
	$("#name").formValidator({onshow:lang.please_input+lang.adboard_name,onfocus:lang.please_input+lang.adboard_name}).inputValidator({min:1,onerror:lang.please_input+lang.adboard_name}).ajaxValidator({
	    type : "get",
		url : check_name_url,
		datatype : "json",
		async:'false',
		success : function(result){	
            if(result.status == 0){
                return false;
			}else{
                return true;
			}
		},
		buttons: $("#dosubmit"),
		onerror : lang.adboard_already_exists,
		onwait : lang.connecting_please_wait
	});
	
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
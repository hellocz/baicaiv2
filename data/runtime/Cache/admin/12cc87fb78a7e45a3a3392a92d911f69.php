<?php if (!defined('THINK_PATH')) exit();?><div class="dialog_content">

<form id="info_form" action="<?php echo u('item_orig/edit');?>" method="post">

<div class="common-form">

	<table width="100%" cellpadding="2" cellspacing="1" class="table_form">

        <tr>

			<th width="100">链接名称 :</th>

			<td><input type="text" name="name" id="name" class="input-text" size="30" value="<?php echo ($info["name"]); ?>"></td>

		</tr>

        <tr>

			<th width="100">链接地址 :</th>

			<td><input type="text" name="url" id="url" class="input-text" size="30" value="<?php echo ($info["url"]); ?>"></td>

		</tr>

		<tr>

			<th>图片 :</th>

			<td>

            	<input type="text" name="img" id="J_img" class="input-text fl mr10" size="30" value="<?php echo ($info["img_url"]); ?>">

            	<div id="J_upload_img" class="upload_btn"><span><?php echo L('upload');?></span></div>

				<?php if(!empty($info['img'])): ?><img src="<?php echo attach($info['img'], 'item_orig');?>" class="ml10" /><?php endif; ?>

			</td>

		</tr>

		<tr>

			<th width="100">国内（外） :</th>

			<td>

			<select name="ismy" id="ismy">

			<option value="0" <?php if($info['ismy'] == 0): ?>selected<?php endif; ?>>国内</option>

			<option value="1" <?php if($info['ismy'] == 1): ?>selected<?php endif; ?>>海淘</option>

			</select></td>

		</tr>

		<tr>

			<th>热门</th>

			<td>

               <label><input type="radio" name="is_hot" value="1" <?php if($info['is_hot'] == 1): ?>checked<?php endif; ?>> 是</label> <label><input type="radio" name="is_hot" value="0" <?php if($info['is_hot'] == 0): ?>checked<?php endif; ?>> 否</label>

			</td>

		</tr>

		<tr>

			<th>描述 :</th>

			<td>

               <textarea name="intro" cols="50" rows="4"><?php echo ($info["intro"]); ?></textarea>

			</td>

		</tr>

		<!-- <tr>

			<th>商场运费 :</th>

			<td>

               <input type="text" name="shipping" class="input-text fl mr10" size="30" value="<?php echo ($info["shipping"]); ?>" placeholder="">

			</td>

		</tr> -->

		<tr>

			<th>口碑指数 :</th>

			<td>

               <input type="text" name="kb" class="input-text fl mr10" size="30" value="<?php echo ($info["kb"]); ?>">

			</td>

		</tr>

		<tr>

			<th>商品质量 :</th>

			<td>

               <input type="text" name="fwzl" class="input-text fl mr10" size="30" value="<?php echo ($info["fwzl"]); ?>"  placeholder="5星">

			</td>

		</tr>

		<tr>

			<th>服务配送 :</th>

			<td>

               <input type="text" name="fwps" class="input-text fl mr10" size="30" value="<?php echo ($info["fwps"]); ?>" placeholder="5星">

			</td>

		</tr>

		<tr>

			<th>客户服务 :</th>

			<td>

               <input type="text" name="khfw" class="input-text fl mr10" size="30" value="<?php echo ($info["khfw"]); ?>" placeholder="5星">

			</td>

		</tr>

		<tr>

			<th><?php echo L('seo_title');?> :</th>

			<td><input type="text" name="seo_title" class="input-text" value="<?php echo ($info["seo_title"]); ?>" style="width:300px;"></td>

		</tr>

		<tr>

			<th><?php echo L('seo_keys');?> :</th>

			<td><input type="text" name="seo_keys" class="input-text" value="<?php echo ($info["seo_keys"]); ?>" style="width:300px;"></td>

		</tr>

		<tr>

			<th><?php echo L('seo_desc');?> :</th>

			<td><textarea name="seo_desc" style="width:295px; height:50px;"><?php echo ($info["seo_desc"]); ?></textarea></td>

		</tr>

	</table>

    <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />

</div>

</form>

</div>

<script src="__STATIC__/js/fileuploader.js"></script>

<script type="text/javascript">

var check_name_url = "<?php echo U('item_orig/ajax_check_name',array('id'=>$info['id']));?>";

$(function(){

	$.formValidator.initConfig({formid:"info_form",autotip:true});

	$("#name").formValidator({onshow:"请填写链接名称",onfocus:"请填写链接名称"}).inputValidator({min:1,onerror:"请填写链接名称"}).ajaxValidator({

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

		onerror : "链接名称已经存在",

		onwait : "正在验证"

	}).defaultPassed();

	$("#url").formValidator({onshow:"请填写链接地址",onfocus:"请填写链接地址"}).inputValidator({min:1,onerror:"请填写链接地址"}).defaultPassed();

	

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

	

	//上传图片

    var uploader = new qq.FileUploaderBasic({

    	allowedExtensions: ['jpg','gif','jpeg','png','bmp','pdg'],

        button: document.getElementById('J_upload_img'),

        multiple: false,

        action: "<?php echo U('item_orig/ajax_upload_img');?>",

        inputName: 'img',

        forceMultipart: true, //用$_FILES

        messages: {

        	typeError: lang.upload_type_error,

        	sizeError: lang.upload_size_error,

        	minSizeError: lang.upload_minsize_error,

        	emptyError: lang.upload_empty_error,

        	noFilesError: lang.upload_nofile_error,

        	onLeave: lang.upload_onLeave

        },

        showMessage: function(message){

        	$.pinphp.tip({content:message, icon:'error'});

        },

        onSubmit: function(id, fileName){

        	$('#J_upload_img').addClass('btn_disabled').find('span').text(lang.uploading);

        },

        onComplete: function(id, fileName, result){

        	$('#J_upload_img').removeClass('btn_disabled').find('span').text(lang.upload);

            if(result.status == '1'){

        		$('#J_img').val(result.data);

        	} else {

        		$.pinphp.tip({content:result.msg, icon:'error'});

        	}

        }

    });

});

</script>
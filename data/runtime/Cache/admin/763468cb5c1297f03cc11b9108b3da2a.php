<?php if (!defined('THINK_PATH')) exit();?><!doctype html>

<html>

<head>

	<meta charset="utf-8" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<link href="__STATIC__/css/admin/style.css" rel="stylesheet"/>

	<title><?php echo L('website_manage');?></title>

	<script>

	var URL = '__URL__';

	var SELF = '__SELF__';

	var ROOT_PATH = '__ROOT__';

	var APP	 =	 '__APP__';

	//语言项目

	var lang = new Object();

	<?php $_result=L('js_lang');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>lang.<?php echo ($key); ?> = "<?php echo ($val); ?>";<?php endforeach; endif; else: echo "" ;endif; ?>

	</script>

</head>



<body>

<div id="J_ajax_loading" class="ajax_loading"><?php echo L('ajax_loading');?></div>

<?php if(($sub_menu != '') OR ($big_menu != '')): ?><div class="subnav">

    <div class="content_menu ib_a blue line_x">

    	<?php if(!empty($big_menu)): ?><a class="add fb J_showdialog" href="javascript:void(0);" data-uri="<?php echo ($big_menu["iframe"]); ?>" data-title="<?php echo ($big_menu["title"]); ?>" data-id="<?php echo ($big_menu["id"]); ?>" data-width="<?php echo ($big_menu["width"]); ?>" data-height="<?php echo ($big_menu["height"]); ?>"><em><?php echo ($big_menu["title"]); ?></em></a>　<?php endif; ?>

        <?php if(!empty($sub_menu)): if(is_array($sub_menu)): $key = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($key % 2 );++$key; if($key != 1): ?><span>|</span><?php endif; ?>

        <a href="<?php echo U($val['module_name'].'/'.$val['action_name'],array('menuid'=>$menuid)); echo ($val["data"]); ?>" class="<?php echo ($val["class"]); ?>"><em><?php echo L($val['name']);?></em></a><?php endforeach; endif; else: echo "" ;endif; endif; ?>

    </div>

</div><?php endif; ?>

<form id="info_form" action="<?php echo u('score_item/edit');?>" method="post" enctype="multipart/form-data">

<div class="pad_lr_10">

	<div class="col_tab">

		<ul class="J_tabs tab_but cu_li">

			<li class="current">基本资料</li>

            <li class="current">商品描述</li>

		</ul>

		<div class="J_panes">

			<div class="content_list pad_10">

				<table width="100%" cellspacing="0" class="table_form">

					<tr>

						<th width="120"><?php echo L('article_cateid');?> :</th>

						<td>

						<select name="cate_id" id="cate_id">

            			<option value="">--请选择分类--</option>

            			<?php if(is_array($cate_list)): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>" <?php if($info['cate_id'] == $val['id']): ?>selected="selected"<?php endif; ?>><?php echo ($val["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

            			</select>

						</td>

					</tr>

		            <tr>

						<th>商品名称 :</th>

						<td>

		                    <input type="text" name="title" id="J_title"class="input-text iColorPicker" size="60" value="<?php echo ($info["title"]); ?>">

		                </td>

					</tr>

		            <tr>

						<th><?php echo L('article_img');?> :</th>

						<td>

                        <?php if(!empty($info["img"])): ?><span class="attachment_icon J_attachment_icon" file-type="image" file-rel="<?php echo attach($info['img'], 'score_item');?>">

                        <img src="<?php echo attach($info['img'], 'score_item');?>" style="width:100px; height:100px;" /></span><?php endif; ?><br />

                        <input type="file" name="img" class="input-text"  style="width:200px;" />

                        </td>

		 			</tr>

					<!--<tr>

						<th>所需积分 :</th>

						<td><input type="text" name="score" id="score" class="input-text" value="<?php echo ($info["score"]); ?>" size="10" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')"></td>

					</tr>-->
					<tr>

						<th>所需积分 :</th>

						<td><input type="text" name="score" id="score" class="input-text" value="<?php echo ($info["score"]); ?>" size="10" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')"></td>

					</tr>
					<tr>

						<th>所需金币 :</th>

						<td><input type="text" name="coin" id="coin" class="input-text" value="<?php echo ($info["coin"]); ?>" size="10" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')"></td>

					</tr>

					<tr>

						<th>库存 :</th>

						<td><input type="text" name="stock" id="stock" class="input-text" value="<?php echo ($info["stock"]); ?>" size="10" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')"></td>

					</tr>     

					<tr>

						<th>每人限兑换数 :</th>

						<td><input type="text" name="user_num" id="user_num" value="<?php echo ($info["user_num"]); ?>" class="input-text" size="10" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')"></td>

					</tr> 

					<tr>

						<th>排序值 :</th>

						<td><input type="text" name="ordid" value="<?php echo ($info["ordid"]); ?>" id="ordid" class="input-text" size="10" onkeyup="this.value=this.value.replace(/[^0-9.]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9.]/g,'')"></td>

					</tr>

				</table>

			</div>

            <div class="content_list pad_10 hidden">

				<table width="100%" cellspacing="0" class="table_form">

                	<tr>

						<th>商品描述 :</th>

		                <td><textarea name="desc" id="desc" style="width:68%;height:400px;visibility:hidden;resize:none;"><?php echo ($info["desc"]); ?></textarea></td>

					</tr>

				</table>

			</div>

        </div>

		<div class="mt10"><input type="submit" value="<?php echo L('submit');?>" id="dosubmit" name="dosubmit" class="btn btn_submit" style="margin:0 0 10px 100px;"><br /><br /><br /></div>

	</div>

</div>

<input type="hidden" name="menuid"  value="<?php echo ($menuid); ?>"/>

<input type="hidden" name="id" id="id" value="<?php echo ($info["id"]); ?>" />

</form>

<script src="__STATIC__/js/jquery/jquery.js"></script>

<script src="__STATIC__/js/jquery/plugins/jquery.tools.min.js"></script>

<script src="__STATIC__/js/jquery/plugins/formvalidator.js"></script>

<script src="__STATIC__/js/pinphp.js"></script>

<script src="__STATIC__/js/admin.js"></script>

<script>

//初始化弹窗

(function (d) {

    d['okValue'] = lang.dialog_ok;

    d['cancelValue'] = lang.dialog_cancel;

    d['title'] = lang.dialog_title;

})($.dialog.defaults);

</script>



<?php if(isset($list_table)): ?><script src="__STATIC__/js/jquery/plugins/listTable.js"></script>

<script>

$(function(){

	$('.J_tablelist').listTable();

});

</script><?php endif; ?>

<script src="__STATIC__/js/kindeditor/kindeditor.js"></script>

<script type="text/javascript">

$('.J_cate_select').cate_select('请选择');

$(function() {

	KindEditor.create('#desc', {

		uploadJson : '<?php echo U("attachment/editer_upload");?>',

		fileManagerJson : '<?php echo U("attachment/editer_manager");?>',

		allowFileManager : true

	});

	$('ul.J_tabs').tabs('div.J_panes > div');

});

</script>

</body>

</html>
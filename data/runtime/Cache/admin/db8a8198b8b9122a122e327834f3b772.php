<?php if (!defined('THINK_PATH')) exit();?><!doctype html>

<html>

<head>

	<meta charset="utf-8" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<link href="__STATIC__/css/admin/style.css?v=20180123" rel="stylesheet"/>

	<link href="__STATIC__/css/card.min.css" rel="stylesheet"/>

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

<!--编辑商品-->

<form id="info_form" action="<?php echo u('item/edit');?>" method="post" enctype="multipart/form-data">

<div class="pad_lr_10">

	<div class="col_tab">

		<ul class="J_tabs tab_but cu_li">

			<li class="current">基本信息</li>

            <li>展示图片</li>

			<li>SEO设置</li>

            <li>附加属性</li>

		</ul>

		<div class="J_panes">

        <div class="content_list pad_10">

		<table width="100%" cellpadding="2" cellspacing="1" class="table_form">

			<tr>

				<th width="120">所属分类 :</th>

                <td><select class="J_cate_select mr10" data-pid="0" data-uri="<?php echo U('item_cate/ajax_getchilds', array('type'=>0));?>" data-selected="<?php echo ($selected_ids); ?>"></select>

                <input type="hidden" name="cate_id" id="J_cate_id" value="<?php echo ($info["cate_id"]); ?>" />

                &nbsp;<input class="input-text" type="text" name="search_cate" id ="search_cate" value="" placeholder="搜索分类" /> </td>

			</tr>

            <tr>

				<th>商品名称 :</th>

				<td><input type="text" name="title" id="J_title" class="input-text" size="60" value="<?php echo ($info["title"]); ?>"></td>

			</tr>

			<tr>

				<th>副标题 :</th>

				<td><input type="text" name="otitle" id="J_otitle" class="input-text" size="60" value="<?php echo ($info["otitle"]); ?>"></td>

			</tr>
<!--
			<tr>

                <th>商品简介 :</th>

                <td><textarea name="intro" id="intro" cols="80" rows="2"><?php echo ($info["intro"]); ?></textarea></td>

            </tr>
-->
            <tr>

				<th>商品图片 :</th>

				<td>
				<div class="w_tpk">
				<img id="spimg" src="<?php if($info['img'] != '' && $info['img']!='http:' ): echo ($info['img']); else: ?>/images/jia_pic.png<?php endif; ?>"/>

		  </div>
		   <div style="margin-top:90px">    <p style="color:#999999;">支持小于300k格式为jpg、jpeg、png的图片，截图请注意商品显示完全</p></div>
		   <div class="w_cczx">

            			<em>上传照片</em>
  		<input type="hidden" name="img" value="<?php echo ($item['img']); ?>" id="img"/>

		  <input type="file" name="J_img" id="J_img" class="w_bl_in2" />
				<input type="file" name="img"  id="img" class="w_bl_in2" style="display: none" />
 			</div>
 			<input style="top:15px;left: 15px;"  type="button" name="J_img_d" class="btn" id="J_img_d"   value="选取第一张" />
			<input type="text" style="top:15px;left: 15px;position:relative" size="80" name="img_usb"   placeholder="远程图片地址" class="input-text" value="">
 			</td>
 			</tr>

			<tr>

				<th>链接地址 : </th>

				<td id="Link_form">

				<?php $go_link = unserialize($info['go_link']);?>

				<?php if($go_link !='' ): if(is_array($go_link)): $i = 0; $__LIST__ = $go_link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><span><input type="text" name="link_type[]" placeholder="链接类型" class="input-text" value="<?php echo ($r["name"]); ?>"> ：<input type="text" id="J_link" style="width:1000px;" name="link_url[]" placeholder="链接地址" class="input-text" value="<?php echo ($r["link"]); ?>"/> &nbsp;<input type="button"  value=" + " id="J_add_link">
				 <input type="button" value="<?php echo L('auto_convert');?>" id="J_convert" name="tags_btn" class="btn">
				  <input type="button" value="强制直营" id="J_smid" name="tags_btn" class="btn">
				 <br><br></span><?php endforeach; endif; else: echo "" ;endif; ?>

				<?php else: ?>

					<span><input type="text" name="link_type[]" placeholder="链接类型" value="直达链接" class="input-text" value=""> ：<input id="J_link" type="text" style="width:1000px;" name="link_url[]" placeholder="链接地址" class="input-text"/> &nbsp;<input type="button" value=" + " id="J_add_link"></span>
				 <input type="button" value="<?php echo L('auto_convert');?>" id="J_convert" name="tags_btn" class="btn">
				 <input type="button" value="强制直营" id="J_smid" name="tags_btn" class="btn"><?php endif; ?>

				

				</td>

			</tr>			

            <tr>

				<th>商品标签 :</th>

				<td>

                	<input type="text" name="tags" id="J_tags" class="input-text" size="50" value="<?php echo ($info["tags"]); ?>">
		<span style="color:red;"><分隔符支持中文的顿号、或者英文的逗号,></span>
                    <input type="button" value="<?php echo L('auto_get');?>" id="J_gettags" name="tags_btn" class="btn">

                </td>

			</tr>

            <tr>

				<th>商品价格 :</th>

				<td><input type="text" name="price" id="price" size="50" class="input-text" value="<?php echo ($info["price"]); ?>"> </td>

			</tr>

			<!--<tr>

				<th>邮费 :</th>

				<td><input type="text" name="express" id="express" class="input-text" size="10" value="<?php echo ($info["express"]); ?>"> 元 <label><input type="checkbox" value="1" name="ispost" id="ispost"  <?php if($info['ispost'] == 1): ?>checked<?php endif; ?>>可直邮</label></td>

			</tr>-->

			<tr>

				<th width="120">商品来源 :</th>

				<!--<td><input type="text" name="orig_id" id="orig_id" size="30" class="input-text" value="<?php echo ($orig_name); ?>"> </td>-->

                <td>

				<select name="orig_id" id="orig_id">

            	<?php if(is_array($orig_list)): $i = 0; $__LIST__ = $orig_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>" <?php if($info['orig_id'] == $val['id']): ?>selected="selected"<?php endif; ?>><?php echo ($val["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

            	</select></td>

			</tr>

			<tr>

				<th>商品属性 :</th>

				<td>

				<script language="javascript" src="../../js/jquery-1.9.1.min.js"></script>

				<script>

					$(function(){;

						$("input[type='checkbox']").click(function(){

							if($(this).is(':checked')){

								$(this).val(1);

							}else{

								$("this").val(0);

							}	

						});

	

					});

				</script>

				<label><input type="checkbox" value="<?php echo ($info['isbest']); ?>" name="isbest" id="isbest" <?php if($info['isbest'] == 1): ?>checked<?php endif; ?>>精品</label> &nbsp;&nbsp;

				<label><input type="checkbox" value="<?php echo ($info['ishot']); ?>"  name="ishot" id="ishot" <?php if($info['ishot'] == 1): ?>checked<?php endif; ?>>热门</label> &nbsp;&nbsp;

				<label><input type="checkbox" value="<?php echo ($info['istop']); ?>" name="istop" id="istop"  <?php if($info['istop'] == 1): ?>checked<?php endif; ?>>置顶</label> &nbsp;&nbsp;

				<label><input type="checkbox" value="<?php echo ($info['isbao']); ?>" name="isbao" id="isbao" disabled <?php if($info['isbao'] == 1): ?>checked<?php endif; ?>>
					<input type="hidden" name="isbao" value="<?php echo ($info['isbao']); ?>"/>网友爆料</label>

				&nbsp;&nbsp;

				<label><input type="checkbox" value="<?php if(($info['isnice'] == 1) OR ($info['isbao'] == 0)): ?>1<?php else: ?>0<?php endif; ?>" name="isnice" id="isnice"  <?php if(($info['isnice'] == 1) OR ($info['isbao'] == 0)): ?>checked<?php endif; ?>>推荐</label>

					<label><input type="checkbox" value="<?php echo ($info['ispost']); ?>" name="ispost" id="ispost"  <?php if($info['ispost'] == 1): ?>checked<?php endif; ?>>可直邮</label>

					<label><input type="checkbox" value="<?php echo ($info['isoriginal']); ?>" name="isoriginal" id="isoriginal" <?php if($info['isoriginal'] == 1): ?>checked<?php endif; ?>>原创</label> &nbsp;&nbsp;

					<label><input type="checkbox" value="<?php echo ($info['isfront']); ?>" name="isfront" id="isfront" <?php if($info['isfront'] == 1): ?>checked<?php endif; ?>>文章置顶</label> &nbsp;&nbsp;

					<label>&nbsp;&nbsp;<input type="text" value="<?php echo ($info["express"]); ?>"  disabled="disabled" style="width:50px;"></label>

					<input type="hidden" value="<?php echo ($info["source"]); ?>" name="source">

				</td>

			</tr>

			<tr>

				<th>商品详情 :</th>

				<td>

					<script id="content" name="content" type="text/plain" style="width:80%;height:300px;z-index:100;"><?php echo ($info["content"]); ?></script>

					<!--<textarea name="content" id="content" style="width:68%;height:400px;visibility:hidden;resize:none;"><?php echo ($info["content"]); ?></textarea>--></td>

			</tr>

			<tr>

            	<th>发布人 :</th>

                <td><?php echo ($info["uname"]); ?></td>

           </tr>

			<tr>

				<th>
			<input type="button" value="<?php echo L('ds_publish');?>" id="J_ds_publish" name="tags_btn" class="btn">
			<input type="button" style="display: none" value="<?php echo L('rm_ds_publish');?>" id="J_rm_publish" name="tags_btn" class="btn"></th>
				<td>
				<input type="text"  style="display: none"  name="add_time" id="add_time" size="25" class="input-text" value="<?php if($info['add_time'] != 0 ): echo (date('Y-m-d H:i:s',$info["add_time"])); endif; ?>"/>

				<input type="text" name="hide_time" id="hide_time" style="display: none" size="25" class="input-text" value="<?php echo date('Y-m-d H:i:s',time());?>">
				</td>


			</tr>

		

			<tr>

				<th>评语 / 退回理由 :</th>

				<td>

					<input type="text" name="remark" id="remark" size="75" class="input-text" value="<?php echo ($info["remark"]); ?>"></td>

			</tr>

			<tr>

				<th>状态 :</th>

				<td>

					<select name="status">

						<option value="0" <?php if($info['status'] == 0): ?>selected="selected"<?php endif; ?>>未审</option>

						<option value="1" <?php if($info['status'] == 1): ?>selected="selected"<?php endif; ?>>通过</option>

						<option value="2" <?php if($info['status'] == 2): ?>selected="selected"<?php endif; ?>>草稿</option>

						<option value="3" <?php if($info['status'] == 3): ?>selected="selected"<?php endif; ?>>退回</option>

					</select>

				</td>

			</tr>

			<tr>

				<th>操作：</th> 

				<td>

					<?php if($info['status'] == 0): ?><a href="javascript:;" class="J_showdialog " data-uri="/?g=admin&m=item&a=set_score&id=<?php echo ($info["id"]); ?>" data-title="设置积分信息" data-id="edit" data-acttype="ajax" data-width="300" data-height="140" title="审核">审核</a> |<?php endif; ?>

					<a href="javascript:void(0);" class="J_confirmurl" data-uri="<?php echo u('item/delete', array('id'=>$info['id']));?>" data-msg="<?php echo sprintf(L('confirm_delete_one'),$info['title']);?>"><?php echo L('delete');?></a>

				</td>

			</tr>
			<tr>

				<th>投票文章列表:</th>

				<td>

					<input type="text" name="article_list" id="article_list" size="200" class="input-text" value="<?php echo ($article_list); ?>"><br>
					<p style="color:#999999;">文章id列表，要求以英文的逗号分开，例如 60,53</p>
					</td>

			</tr>

		</table>

		</div>

        <div class="content_list pad_10 hidden">

        	<style>

				.addpic {}

				.addpic li { float:left; text-align:center; margin:0 0 10px 20px;}

				.addpic a { display:block;}

            </style>

            <ul class="addpic">

            <?php if(is_array($img_list)): $i = 0; $__LIST__ = $img_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="album_<?php echo ($val['id']); ?>">

            <a href="javascript:void(0)" onclick="del_album(<?php echo ($val['id']); ?>);"><img src="__STATIC__/css/admin/bgimg/tv-collapsable.gif" /></a>

            <a><img src="<?php echo attach($val['url'],'item');?>" style="width:80px;height:60px; border:solid 1px #000; "/></a>

            </li><?php endforeach; endif; else: echo "" ;endif; ?>

            </ul>

            <div class="cb"></div>

            <table width="100%" cellpadding="2" cellspacing="1" class="table_form" id="first_upload_file">

                <tbody class="uplode_file">

                <tr>

                    <th width="100" align="left"><a href="javascript:void(0);" class="blue" onclick="add_file();"><img src="__STATIC__/css/admin/bgimg/tv-expandable.gif" /></a>上传文件 :</th>

                    <td><input type="file" name="imgs[]"><!--<input type="text" size="40" name="img_usbs[]" placeholder="远程图片地址" class="input-text" value="">--></td>

                </tr>

                </tbody>

            </table>

        </div>

		<div class="content_list pad_10 hidden">

		<table width="100%" cellpadding="2" cellspacing="1" class="table_form">

			<tr>

				<th width="120"><?php echo L('seo_title');?> :</th>

 				<td><input type="text" name="seo_title" id="seo_title" class="input-text" size="60" value="<?php echo ($info["seo_title"]); ?>"></td>

			</tr>

			<tr>

				<th><?php echo L('seo_keys');?> :</th>

				<td><input type="text" name="seo_keys" id="seo_keys" class="input-text" size="60" value="<?php echo ($info["seo_keys"]); ?>"></td>

			</tr>

			<tr>

				<th><?php echo L('seo_desc');?> :</th>

				<td><textarea name="seo_desc" id="seo_desc" cols="80" rows="8"><?php echo ($info["seo_desc"]); ?></textarea></td>

			</tr>

		</table>

		</div>

        <div class="content_list pad_10 hidden">

		<table width="100%" cellpadding="2" cellspacing="1" class="table_form" id="item_attr">

			<?php if(is_array($attr_list)): $i = 0; $__LIST__ = $attr_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>

                <td width="200">

                <a href="javascript:void(0);" class="blue" onclick="del_attr(<?php echo ($val["id"]); ?>,this);"><img src="__STATIC__/css/admin/bgimg/tv-collapsable.gif" /></a>属性名 :<?php echo ($val["attr_name"]); ?>

                </td>

                <td width="">属性值 :<?php echo ($val["attr_value"]); ?></td>

            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

            

            <tbody class="add_item_attr">

            <tr>

                <th width="200">

                <a href="javascript:void(0);" class="blue" onclick="add_attr();"><img src="__STATIC__/css/admin/bgimg/tv-expandable.gif" /></a>属性名 :<input type="text" name="attr[name][]" class="input-text" size="20">

                </th>

                <td>属性值 :<input type="text" name="attr[value][]" class="input-text" size="30"></td>

            </tr>

            </tbody>

		</table>

		</div>

        </div>

		

	<!--	<div class="mt10"><input type="submit" value="<?php echo L('submit');?>" id="dosubmit" name="dosubmit" class="btn btn_submit" style="margin:0 0 10px 100px;"></div>-->

		<input  type="hidden" value="4"  name="statusA" id="statusA"/>

		<div class="mt10">

			<!--<input type="button"  class="btn btn_submit" id="bccg" name="dosubmit"  style="margin:0 0 10px 100px;"  value="保存草稿" class="btn">-->

			<input type="submit" class="btn btn_submit"  id="dosubmit" name="dosubmit"  style="margin:0 0 10px 100px;"   value="提交保存">&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  class="btn btn_submit" id="zzfb" name="dosubmit"  style="margin:0 0 10px 10px;"   value="直接发布" class="btn">&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  class="btn btn_submit" id="preview" name="dosubmit"  style="margin:0 0 10px 10px;"   value="预览" class="btn">
			

		</div>

	</div>

</div>

<input type="hidden" name="menuid"  value="<?php echo ($menuid); ?>"/>

<input type="hidden" name="id" id="id" value="<?php echo ($info["id"]); ?>" />

<!--<input type="hidden" name="status" id="status" value="<?php echo ($info["status"]); ?>" />-->

</form>
<style>

	#clipArea {

		margin: 20px;

		height: 300px;}

	#car{

		display: block;

		left: 50%;

		top: 50%;

		width: 600px;

		height: 300px;

		position: fixed;

		margin-left: -300px;

		margin-top: -150px;

		display: none;

            z-index: 999;

	}
	a.cates {
    margin-left: 4px;
}

</style>

<div id="car">

	<div id="clipArea"></div>

	<button id="clipBtn">裁剪</button>

	<button id="J_img_close">关闭</button>

	<p class="clipArea_tips"><span>*</span>滑动鼠标滑轮，可进行裁剪区域缩放。</p>

</div>

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

<script src="/js/ajaxfileupload.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>

<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.js?v=20171214"> </script>

<script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

<script>

	$(function(){

		$("#bccg").click(function(){

			$("#statusA").val('2');	
			$("#info_form").attr("target","_self");

			$("#info_form").submit();

		});

		$("#zzfb").click(function(){

			$imgsrc=$("#spimg")[0].src;

			if($('#J_cate_id').val()== 0){

			  alert("请选择所属分类！");

			}else if($('#img').val()=='' && !$imgsrc){

			  alert("请上传商品图片！");

			}else{

				$("#statusA").val('1');	
				$("#info_form").attr("target","_self");
				$("#info_form").submit();

			}

		});
		$("#preview").click(function(){

			$imgsrc=$("#spimg")[0].src;

			if($('#J_cate_id').val()== 0){

			  alert("请选择所属分类！");

			}else if($('#img').val()=='' && !$imgsrc){

			  alert("请上传商品图片！");

			}else{

				$("#statusA").val('5');	
				$("#info_form").attr("target","_blank");
				$("#info_form").submit();

			}

		});


		$("#dosubmit").click(function(){

			$imgsrc=$("#spimg")[0].src;

			if($('#J_cate_id').val()== 0){

			  alert("请选择所属分类！");

			}else if($('#img').val()=='' && !$imgsrc){

			  alert("请上传商品图片！");

			}else{

			  $("#statusA").val('4');	
			  $("#info_form").attr("target","_self");
			  $("#info_form").submit();

			}

		});

	});





</script>

<script type="text/javascript">

	var ue = UE.getEditor('content');



$('.J_cate_select').cate_select('请选择');



$(function() {

	if($("#add_time").val() !=""){
		$('#J_ds_publish').hide()
		$("#add_time").show()
		$('#J_rm_publish').show();
	}



	$('#save_msg').click(function(){

		$('#add_time').val('');

	});

	$('#send_msg').click(function(){

		

	});

	$('ul.J_tabs').tabs('div.J_panes > div');

	//自动获取标签

	$('#J_gettags').live('click', function() {

		var title = $.trim($('#J_title').val());

		if(title == ''){

			$.pinphp.tip({content:lang.article_title_isempty, icon:'alert'});

			return false;

		}

		$.getJSON('<?php echo U("item/ajax_gettags");?>', {title:title}, function(result){

			if(result.status == 1){

				$('#J_tags').val(result.data);

			}else{

				$.pinphp.tip({content:result.msg});

			}

		});

	});

	$('#J_smid').live('click', function() {

		var url = $.trim($('#J_link').val());

		if(url == ''){

			$.pinphp.tip({content:lang.article_title_isempty, icon:'alert'});

			return false;

		}

		$.getJSON('<?php echo U("item/ajax_smid");?>', {url:url}, function(result){

			if(result.status == 1){
				if(result.data.id!=-1){
				$('#J_link').val(result.data.convert_url);
				}

			}else{

				$.pinphp.tip({content:result.msg});

			}

		});

	});

	$('#J_ds_publish').live('click', function() {
		$('#J_ds_publish').hide()
		$("#add_time").show()
		$('#J_rm_publish').show();
		$("#add_time").val($("#hide_time").val());

	});
	$('#J_rm_publish').live('click', function() {
		$('#J_rm_publish').hide();
		$("#add_time").hide()
		$('#J_ds_publish').show()
		$("#add_time").val("");

	});
	
	$('#J_convert').live('click', function() {

		var url = $.trim($('#J_link').val());

		if(url == ''){

			$.pinphp.tip({content:lang.article_title_isempty, icon:'alert'});

			return false;

		}

		$.getJSON('<?php echo U("item/ajax_converturl");?>', {url:url}, function(result){

			if(result.status == 1){

				$('#J_link').val(result.data.convert_url);
				if(result.data.id!=-1)
				 $("#orig_id").val(result.data.id);

			}else{

				$.pinphp.tip({content:result.msg});

			}

		});

	});

	$.formValidator.initConfig({formid:"info_form",autotip:true});

	$("#J_title").formValidator({onshow:'请填写商品名称',onfocus:'请填写商品名称'}).inputValidator({min:1,onerror:'请填写商品名称'}).defaultPassed();

});

function get_child_cates(obj,to_id)

{

	var parent_id = $(obj).val();

	if( parent_id ){

		$.get('?m=item&a=get_child_cates&g=admin&parent_id='+parent_id,function(data){

				var obj = eval("("+data+")");

				$('#'+to_id).html( obj.content );

	    });

    }

}



function add_file()

{

    $("#next_upload_file .uplode_file").clone().insertAfter($("#first_upload_file .uplode_file:last"));

}

function del_file_box(obj)

{

	$(obj).parent().parent().remove();

}

function del_album(id)

{

	var url = "<?php echo U('item/delete_album');?>";

    $.get(url+"&album_id="+id, function(data){

		if(data==1){

		    $('.album_'+id).remove();

		};

    });

}

function add_attr()

{

    $("#hidden_attr .add_item_attr").clone().insertAfter($("#item_attr .add_item_attr:last"));

}

function del_attrs(obj)

{

	$(obj).parent().parent().remove();

}

function del_attr(id,obj)

{

	var url = "<?php echo U('item/delete_attr');?>";

    $.get(url+"&attr_id="+id, function(data){

		if(data==1){

		    $(obj).parent().parent().remove();

		};

    });

}

$("#J_add_link").live('click',function(){

	$("#Link_form").append('<span><input name="link_type[]"  class="input-text" value="直达链接" > ：<input type="text" name="link_url[]"  value="" class="input-text"/>&nbsp;&nbsp;<input type="button" value=" - " id="J_del_link"/><br><br></span>');

});

$("#J_del_link").live('click',function(){

	$(this).parent().remove();

});



</script>

<table id="next_upload_file" style="display:none;">

<tbody class="uplode_file">

   <tr>

      <th width="100"><a href="javascript:void(0);" onclick="del_file_box(this);" class="blue"><img src="__STATIC__/css/admin/bgimg/tv-collapsable.gif" /></a>上传文件 :</th>

      <td><input type="file" name="imgs[]"><!--<input type="text" size="40" name="img_usbs" placeholder="远程图片地址" class="input-text" value="">--></td>

   </tr>

</tbody>

</table>

<table id="hidden_attr" style="display:none;">

<tbody class="add_item_attr">

<tr>

    <th width="200">

    <a href="javascript:void(0);" class="blue" onclick="del_attrs(this);"><img src="__STATIC__/css/admin/bgimg/tv-collapsable.gif" /></a>属性名 :<input type="text" name="attr[name][]" class="input-text" size="20">

    </th>

    <td>属性值 :<input type="text" name="attr[value][]" class="input-text" size="30"></td>

</tr>

</tbody>

</table>

<script src="__STATIC__/js/kindeditor/kindeditor.js"></script>

<script>

/*var editor;

KindEditor.ready(function(K) {

	editor = K.create('#content', {

		uploadJson : '<?php echo U("attachment/editer_upload");?>',

		fileManagerJson : '<?php echo U("attachment/editer_manager");?>',

		allowFileManager : true

	});

	K('#info_form').bind('submit', function() {

		editor.sync();

	});

});*/

</script>

<link rel="stylesheet" href="__STATIC__/js/calendar/calendar-blue.css"/>

<script src="__STATIC__/js/calendar/calendar.js"></script>

<script src="/js/car1.6/iscroll-zoom.js"></script>

<script src="/js/car1.6/hammer.js"></script>

<script src="/js/car1.6/lrz.all.bundle.js"></script>

<script src="/js/car1.6/PhotoClip.js"></script>

<script>

	var pc = new PhotoClip('#clipArea', {
		size: [200, 200],
		outputSize: [600, 600],
		//adaptive: ['60%', '80%'],
		file: '#file',
		view: '#view',
		ok: '#clipBtn',
		//img: 'img/mm.jpg',
		loadStart: function() {
			console.log('开始读取照片');
		},
		loadComplete: function() {
			console.log('照片读取完成');
		},
		done: function(dataURL) {
			$('#clipBtn').html('保存中....');

			$.post('/index.php?m=item&a=uploadimg1',{data:dataURL},function(result){

				if(result.status ==1){

					$('#clipBtn').html('裁剪');

					$('#spimg').attr('src',result.data);

					$('#img').val(result.data);

					$('#car').hide();

				}

			},'json');
		},
		fail: function(msg) {
			alert(msg);
		}
	});
	$('#J_img_d').click('change',function () {
		var content = ue.getContent(); 
		var pattern =/<img(.*?)src=\"(.*?)\"/;
		var imgs=pattern.exec(content);
		if(imgs !=null && imgs[2].substring(0,13)== "/ueditor/php/"){
		pc.load(imgs[2]);
		$('#car').show();
		}
		else{
			$.get('/ueditor/php/controller.php?action=catchimage&transfer=1&source[]='+imgs[2],{},function(result){

				if(result.state =="SUCCESS"){
					img=result.list[0].url;
					pc.load(img);
					$('#car').show();

				}
				else{
					alert("找不到图片");
					$('#car').hide();
				}

			},'json');
		
		}
		

	});

	$("#spimg").click(function(){

	$("#J_img").trigger("click");

});
	$('#J_img_close').click('change',function () {

		$('#car').hide();

	});

	$('#J_img').live('change',function () {

		$('#car').show();

	});

	$("#J_img").live('change',function () {

	ajaxFileUpload();

});

var PINER = {
    root: "__ROOT__",
    uid: "<?php echo $visitor['id'];?>", 
    async_sendmail: "<?php echo $async_sendmail;?>",
    config: {
        wall_distance: "<?php echo C('pin_wall_distance');?>",
        wall_spage_max: "<?php echo C('pin_wall_spage_max');?>"
    },
    //URL
    url: {}
};

$("#search_cate").change(function(){
		//alert($(this).val());
		if($(this).val() !=""){
			$.post('<?php echo U("item/ajax_getcates");?>', {cate:$(this).val()}, function(result){

			if(result.status == 1){
				$(".cates").remove();
				for(var i=0;i<result.data.length;i++){
				$("#search_cate").after("<a class='cates' spid=" + result.data[i].spid + ">"+result.data[i].name + "</a>");
			}

			}else{
				$.pinphp.tip({content:result.msg});

			}

		},'json');
		}
	});
	$(".cates").live("click",function(){
		var spid = $(this).attr("spid");
		$('.J_cate_select').attr("data-selected",0);
		$(".J_cate_select").cate_select();
		$('.J_cate_select').attr("data-selected",spid);
		$(".J_cate_select").cate_select();
	});

function ajaxFileUpload() {


	$.ajaxFileUpload

	(

		{

			url: PINER.root + '/?m=item&a=uploadimg', //用于文件上传的服务器端请求地址

			secureuri: false, //是否需要安全协议，一般设置为false

			fileElementId: 'J_img', //文件上传域的ID

			dataType: 'json', //返回值类型 一般设置为json

			success: function (result, status)  //服务器成功响应处理函数

			{

				if(result.status =='1'){
					pc.load(result.data);

					

				}

			},

			error: function (data, status, e)//服务器响应失败处理函数

			{

				tips(e,0);

			}

		}

	)

	return false;

}

/*Calendar.setup({

	inputField : "add_time",

	ifFormat   : "%Y-%m-%d %H:%M",

	showsTime  : true,

	timeFormat : "24"

});*/

$(document).ready(function(){

$("#edui1").css("z-index","100")

})

</script>

<script src="/js/function_item_aedt.js"></script>

</body>

</html>
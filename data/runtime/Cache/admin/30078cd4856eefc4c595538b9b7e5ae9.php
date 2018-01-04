<?php if (!defined('THINK_PATH')) exit();?><!doctype html>

<html>

<head>

	<meta charset="utf-8" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<link href="__STATIC__/css/admin/style.css" rel="stylesheet"/>

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
<div class="pad_lr_10" >
    <div class="J_tablelist table_list" data-acturi="<?php echo U('tick/ajax_edit');?>">
	<table width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width="25"><input type="checkbox" id="checkall_t" class="J_checkall"></th>
                <th width="40"><span tdtype="order_by" fieldname="tk_id">ID</span></th>
				<th align="center" >优惠券码</th>
				<th align="center" >密码</th>
                <th align="center">用户</th>                
				<th align="center">领取时间</th>
				<th align="center">状态</span></th>
            </tr>
        </thead>
    	<tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                <td align="center">
                <input type="checkbox" class="J_checkitem" value="<?php echo ($val["tk_id"]); ?>"></td>
                <td align="center"><?php echo ($val["tk_id"]); ?></td>
				<td align="center"><?php echo ($val["tk_code"]); ?></td>
				<td align="center"><?php echo ($val["tk_psw"]); ?></td>
                <td align="center"><?php echo get_uname($val['uid']);?></td>
                <td align="center"><?php echo ($val["lq_time"]); ?></td>
				<td align="center"><?php if($val['status'] == 1): ?>已领<?php else: ?>未领<?php endif; ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    	</tbody>
    </table>
    </div>

    <div class="btn_wrap_fixed">
    	<label><input type="checkbox" name="checkall" class="J_checkall"><?php echo L('select_all');?>/<?php echo L('cancel');?></label>
    	<input type="button" class="btn" data-tdtype="batch_action" data-acttype="ajax" data-uri="<?php echo U('tick/delete_tk');?>" data-name="id" data-msg="<?php echo L('confirm_delete');?>" value="<?php echo L('delete');?>" />
    	<div id="pages"><?php echo ($page); ?></div>
    </div>
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
<script src="/static/js/jquery/plugins/listTable.js"></script>
<script>
    $(function(){
        $('.J_tablelist').listTable();
    });
</script>
</body>
</html>
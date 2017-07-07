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
<!--会员列表-->
<div class="pad_lr_10" >
    <form name="searchform" method="get" >
    <table width="100%" cellspacing="0" class="search_form">
        <tbody>
            <tr>
                <td>
                <div class="explain_col">
                    <input type="hidden" name="g" value="admin" />
                    <input type="hidden" name="m" value="score_log" />
                    <input type="hidden" name="a" value="index" />
                    <input type="hidden" name="menuid" value="<?php echo ($menuid); ?>" />
                    &nbsp;会员名 :
                    <input name="keyword" type="text" class="input-text" size="25" value="<?php echo ($keyword["keyword"]); ?>" />
                    <input type="submit" name="search" class="btn" value="搜索" />
                </div>
                </td>
            </tr>
        </tbody>
    </table>
    </form>

    <div class="J_tablelist table_list" data-acturi="<?php echo U('score_log/ajax_edit');?>">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
                <th><span data-tdtype="order_by" data-field="uid">会员名</span></th>
				<th>操作</th>
                <th width="180">积分</th>
				<th width="180">操作时间</th>
            </tr>
        </thead>
    	<tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                <td align="center"><?php echo ($val["uname"]); ?></td>
				<td align="center"><?php echo ($val["action"]); ?></td>
                <td align="center"><?php if($val['score'] > 0): ?><label class="green">+<?php echo ($val["score"]); ?></label><?php else: ?><label class="red"><?php echo ($val["score"]); ?></label><?php endif; ?></td>
                <td align="center"><?php echo (date("Y-m-d H:i:s",$val["add_time"])); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    	</tbody>
    </table>
    <div class="btn_wrap_fixed">
        <div id="pages"><?php echo ($page); ?></div>
    </div>

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
</body>
</html>
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

<!--商品列表-->

<div class="pad_lr_10" >

    <form name="searchform" method="get" >

    <table width="100%" cellspacing="0" class="search_form">

        <tbody>

            <tr>

                <td>

                <div class="explain_col">

                    <input type="hidden" name="g" value="admin" />

                    <input type="hidden" name="m" value="item" />

                    <input type="hidden" name="a" value="count" />

                    <input type="hidden" name="menuid" value="<?php echo ($menuid); ?>" />

					<?php if($sm != ''): ?><input type="hidden" name="sm" value="<?php echo ($sm); ?>" /><?php endif; ?>

                    发表时间 :

                    <input type="text" name="time_start" id="J_time_start" class="date" size="12" value="<?php echo ($search["time_start"]); ?>">

                    -

                    <input type="text" name="time_end" id="J_time_end" class="date" size="12" value="<?php echo ($search["time_end"]); ?>">
                    &nbsp;&nbsp;&nbsp;&nbsp;

                    <input type="radio" <?php if($search["type"] == '0'): ?>checked<?php endif; ?> name="type" value="0">原创

                    <input type="radio" <?php if($search["type"] == '1'): ?>checked<?php endif; ?> name="type" value="1">非原创

                    <input type="radio" <?php if($search["type"] == '2'): ?>checked<?php endif; ?> name="type" value="2">点击量

                    &nbsp;&nbsp;分类 :

					<select name="status">

					<option value="0" <?php if($search["status"] == '0'): ?>selected="selected"<?php endif; ?>>全部</option>

					<option value="1" <?php if($search["status"] == '1'): ?>selected="selected"<?php endif; ?>>国内</option>

                    <option value="2" <?php if($search["status"] == '2'): ?>selected="selected"<?php endif; ?>>海淘</option>

                    <option value="3" <?php if($search["status"] == '3'): ?>selected="selected"<?php endif; ?>>淘宝系</option>


					</select>

                    <input type="submit" name="search" class="btn" value="确定" />

					

                </div>

                </td>

            </tr>

        </tbody>

    </table>

    </form>

    <div class="J_tablelist table_list" data-acturi="<?php echo U('item/ajax_edit');?>">

    <table width="100%" cellspacing="0">

        <thead>

            <tr>


                <th width=140><span data-tdtype="order_by" data-field="id">商城名称</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozc</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozb</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozyt</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozyt</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozyt</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozyt</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozyt</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozyt</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozyt</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price">baicaiozyt</span></th>

                <th width="70"><span data-tdtype="order_by" data-field="price"><strong>汇总:</strong></span></th>

            </tr>

        </thead>

    	<tbody>


            <tr>

                <td>亚马逊海外购</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>

            </tr>

            <tr>

                <td ><strong>汇总:</strong></td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>
                <td align="center">12</td>

            </tr>


    	</tbody>

    	<tfoot>
    		
    	</tfoot>

    </table>

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

<link rel="stylesheet" href="__STATIC__/js/calendar/calendar-blue.css"/>

<script src="__STATIC__/js/calendar/calendar.js"></script>

<script>

Calendar.setup({

	inputField : "J_time_start",

	ifFormat   : "%Y-%m-%d",

	showsTime  : false,

	timeFormat : "24"

});

Calendar.setup({

	inputField : "J_time_end",

	ifFormat   : "%Y-%m-%d",

	showsTime  : false,

	timeFormat : "24"

});

$('.J_preview').preview(); //查看大图

$('.J_cate_select').cate_select({top_option:lang.all}); //分类联动

$('.J_tooltip[title]').tooltip({offset:[10, 2], effect:'slide'}).dynamic({bottom:{direction:'down', bounce:true}});

</script>

</body>

</html>
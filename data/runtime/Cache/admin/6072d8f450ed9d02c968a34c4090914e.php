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

                    <!-- <?php if($sm != ''): ?><input type="hidden" name="sm" value="<?php echo ($sm); ?>" /><?php endif; ?> -->

                    发表时间 :

                    <input type="text" name="time_start" id="J_time_start" class="date" size="12" value="<?php echo ($search["time_start"]); ?>">

                    -

                    <input type="text" name="time_end" id="J_time_end" class="date" size="12" value="<?php echo ($search["time_end"]); ?>">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- 注：限时间范围在90天以内
                    <div class="bk8"></div> -->


                    <input type="radio" <?php if($search["original"] == ''): ?>checked<?php endif; ?> name="original" value="">全部

                    <input type="radio" <?php if($search["original"] == '1'): ?>checked<?php endif; ?> name="original" value="1">原创

                    <input type="radio" <?php if($search["original"] == '0'): ?>checked<?php endif; ?> name="original" value="0">非原创

                    

                    &nbsp;&nbsp;&nbsp;&nbsp;分类 :

                    <select name="my">

                    <option value="" <?php if($search["my"] == ''): ?>selected="selected"<?php endif; ?>>全部</option>

                    <option value="0" <?php if($search["my"] == '0'): ?>selected="selected"<?php endif; ?>>国内</option>

                    <option value="1" <?php if($search["my"] == '1'): ?>selected="selected"<?php endif; ?>>海淘</option>

                    <option value="2" <?php if($search["my"] == '2'): ?>selected="selected"<?php endif; ?>>淘宝系</option>


                    </select>

                    &nbsp;&nbsp;&nbsp;&nbsp;统计类型 :
                    <select name="type">

                    <option value="0" <?php if($search["type"] == '0'): ?>selected="selected"<?php endif; ?>>发贴数</option>

                    <option value="1" <?php if($search["type"] == '1'): ?>selected="selected"<?php endif; ?>>点击量</option>


                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" name="search" class="btn" onclick="count_check()" value="确定" />

                    

                </div>

                </td>

            </tr>

        </tbody>

    </table>

    </form>

<div id='errorinfo'><?php if($errorinfo): echo ($errorinfo); endif; ?></div>

<?php if($list): ?><div id="datainfo" class="J_tablelist table_list" data-acturi="<?php echo U('item/ajax_edit');?>">

    <table width="100%" cellspacing="0">

        <thead>

            <tr>


                <th width=140><span data-tdtype="order_by" data-field="id">商城名称</span></th>

                <?php if(is_array($admin_list)): $i = 0; $__LIST__ = $admin_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><th width="70"><span data-tdtype="order_by" data-field="price"><?php echo ($val["username"]); ?></span></th><?php endforeach; endif; else: echo "" ;endif; ?>
                <th width="70"><span data-tdtype="order_by" data-field="price">汇总</span></th>

            </tr>

        </thead>

        <tbody>
             <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                <td><?php echo ($val["orig_name"]); ?></td>
                <?php if(is_array($admin_list)): $i = 0; $__LIST__ = $admin_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$admin): $mod = ($i % 2 );++$i;?><td align="center"><?php echo ($val['count'][$admin['id']]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                <td align="center"><?php echo ($val['count']['sum']); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>


        </tbody>

        <tfoot>
            
        </tfoot>

    </table>

    </div><?php endif; ?>


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

// $('.J_preview').preview(); //查看大图

// $('.J_cate_select').cate_select({top_option:lang.all}); //分类联动

// $('.J_tooltip[title]').tooltip({offset:[10, 2], effect:'slide'}).dynamic({bottom:{direction:'down', bounce:true}});

function count_check() {
    if($('#J_time_start').val() == '' || $('#J_time_end').val() == ''){
        $('#datainfo') && $('#datainfo').hide();
        $('#errorinfo').html('请选择发表时间范围!');
    }else{
        $('#errorinfo').html('');
        $('form[name="searchform"]').submit();
    }
}

</script>

</body>

</html>
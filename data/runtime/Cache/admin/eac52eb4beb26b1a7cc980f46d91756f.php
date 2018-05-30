<?php if (!defined('THINK_PATH')) exit();?><!doctype html>

<html class="off">

<head>

    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="__STATIC__/css/admin/style.css" />

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

<body scroll="no">

<div id="header">

	<div class="logo"><a href="__APP__" title="<?php echo L('website_manage');?>"></a></div>

    <div class="fr">

    	<div class="cut_line admin_info tr">

        	<a href="./" target="_blank"><?php echo L('site_home');?></a>

        	<span class="cut">|</span>

        	<?php echo ($my_admin["rolename"]); ?>：<span class="mr10"><?php echo ($my_admin["username"]); ?></span>
            [
        	<a href="<?php echo u('index/logout');?>"><?php echo L('logout');?> | </a>
            <a href="javascript:;" class="J_showdialog" data-uri="<?php echo U('user/binding', array('id'=>$_SESSION['admin']['id']));?>" data-title="绑定前端账号" data-id="binding" data-acttype="ajax" data-width="500" data-height="140">绑定</a>
            ]

        </div>

    </div>

    <ul class="nav white" id="J_tmenu">

        <li class="top_menu"><a href="javascript:;" data-id="0" hidefocus="true" style="outline:none;">控制台</a></li>

    	<?php if(is_array($top_menus)): $i = 0; $__LIST__ = $top_menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="top_menu"><a href="javascript:;" data-id="<?php echo ($val["id"]); ?>" hidefocus="true" style="outline:none;"><?php echo L($val['name']);?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

    </ul>

</div>

<div id="content">

	<div class="left_menu fl">

    	<div id="J_lmenu" class="J_lmenu" data-uri="<?php echo U('index/left');?>"></div>

        <a href="javascript:;" id="J_lmoc" style="outline-style: none; outline-color: invert; outline-width: medium;" hidefocus="true" class="open" title="<?php echo L('expand_or_contract');?>"></a>

    </div>

    <div class="right_main">

    	<div class="crumbs">

        	<div class="options">

				<a href="javascript:;" title="<?php echo L('refresh_page');?>" id="J_refresh" class="refresh" hidefocus="true"><?php echo L('refresh_page');?></a>

            	<a href="javascript:;" title="<?php echo L('full_screen');?>" id="J_full_screen" class="admin_full" hidefocus="true"><?php echo L('full_screen');?></a>

                <a href="javascript:;" title="<?php echo L('flush_cache');?>" id="J_flush_cache" class="flush_cache" data-uri="<?php echo U('cache/qclear');?>" hidefocus="true"><?php echo L('flush_cache');?></a>

            	<a href="javascript:;" title="<?php echo L('background_map');?>" id="J_admin_map" class="admin_map" data-uri="<?php echo U('index/map');?>" hidefocus="true"><?php echo L('background_map');?></a>

			</div>

    		<div id="J_mtab" class="mtab">

            	<a href="javascript:;" id="J_prev" class="mtab_pre fl" title="上一页">上一页</a>

                <a href="javascript:;" id="J_next" class="mtab_next fr" title="下一页">下一页</a>

                <div class="mtab_p">

                    <div class="mtab_b">

                        <ul id="J_mtab_h" class="mtab_h"><li class="current" data-id="0"><span><a>后台首页</a></span></li></ul>

                    </div>

                </div>

            </div>

        </div>

    	<div id="J_rframe" class="rframe_b">

        	<iframe id="rframe_0" src="<?php echo U('index/panel');?>" frameborder="0" scrolling="auto" style="height:100%;width:100%;"></iframe>

        </div>

    </div>

</div>

<script src="__STATIC__/js/jquery/jquery.js"></script>

<script src="__STATIC__/js/pinphp.js"></script>

<script>

    //弹窗表单
    $('.J_showdialog').live('click', function(){
        var self = $(this),
            dtitle = self.attr('data-title'),
            did = self.attr('data-id'),
            duri = self.attr('data-uri'),
            dwidth = parseInt(self.attr('data-width')),
            dheight = parseInt(self.attr('data-height')),
            dpadding = (self.attr('data-padding') != undefined) ? self.attr('data-padding') : '',
            dcallback = self.attr('data-callback');
                if($('#add_time').val()!==null && $('#add_time').val()!==''){
                    duri+='&add_time='+$('#add_time').val();
        }
        $.dialog({id:did}).close();
        $.dialog({
            id:did,
            title:dtitle,
            width:dwidth ? dwidth : 'auto',
            height:dheight ? dheight : 'auto',
            padding:dpadding,
            lock:true,
            ok:function(){
                var info_form = this.dom.content.find('#info_form');
                if(info_form[0] != undefined){
                    info_form.submit();
                    if(dcallback != undefined){
                        eval(dcallback+'()');
                    }
                    return false;
                }
                if(dcallback != undefined){
                    eval(dcallback+'()');
                }
            },
            cancel:function(){}
        });
        $.getJSON(duri, function(result){
            if(result.status == 1){
                $.dialog.get(did).content(result.data);
            }
        });
        return false;
    });

//初始化弹窗

(function (d) {

    d['okValue'] = lang.dialog_ok;

    d['cancelValue'] = lang.dialog_cancel;

    d['title'] = lang.dialog_title;

})($.dialog.defaults);
$(window).bind('beforeunload', function(){ 
    return '您可能有数据没有保存'; 
})
</script>

<script src="__TMPL__public/js/index.js"></script>

</body>

</html>
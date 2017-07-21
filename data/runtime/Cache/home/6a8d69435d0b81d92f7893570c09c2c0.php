<?php if (!defined('THINK_PATH')) exit();?><div class="dialog_address clearfix">

	<form id="J_daddress_form" action="<?php echo U('exchange/address');?>" method="post" onsubmit="return check();">

    <ul class="address_list">

        <?php if(is_array($address_list)): $i = 0; $__LIST__ = $address_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><label><input type="radio" class="fl" name="address_id" value="<?php echo ($val["id"]); ?>"><?php echo ($val["consignee"]); ?>(<?php echo ($val["mobile"]); ?>) - <?php echo ($val["address"]); ?> <?php echo ($val["zip"]); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>

        <li><label><input type="radio" checked class="fl" name="address_id" value="0"><?php echo L('new_address');?></label></li>

    </ul>

    <table width="100%">

        <tr>

            <th width="70"><?php echo L('consignee');?>：</th>

            <td><input type="text" id="J_consignee" class="input_text" name="consignee"></td>

        </tr>

        <tr>

            <th><?php echo L('address');?>：</th>

            <td><input type="text" id="J_address" class="input_text" name="address" size="30"></td>

        </tr>

        <tr>

            <th><?php echo L('zip');?>：</th>

            <td><input type="text" class="input_text" name="zip" size="8"></td>

        </tr>

        <tr>

            <th><?php echo L('mobile');?>：</th>

            <td><input type="text" id="J_mobile" class="input_text" name="mobile" onblur="javascript:checkmobile(this.value);"></td>

        </tr>

        <tr>

            <th></th>

            <td><input type="submit" class="btn" value="<?php echo L('ok');?>"></td>

        </tr>

    </table>

    <input type="hidden" name="order_id" value="<?php echo ($order_id); ?>">

    </form>

</div>

<script>

function checkmobile(mobile){

	var reg = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|14[57]{1}[0-9]{8}$|17[0678][0-9]{8}$|18[0-9][0-9]{8}$/;

	if (!reg.test(mobile)){

		alert("请输入正确的手机号码");return false;

	}

}

function check(){

	if($("input:checked").val()=='0'){

		if(document.getElementById("J_consignee").value==""){

			alert("请输入联系人姓名！");return false;

		}

		if(document.getElementById("J_address").value==""){

			alert("请输入收货地址！");return false;

		}

		if(document.getElementById("J_mobile").value==""){

			alert("请输入正确的手机号码！");return false;

		}

		checkmobile(document.getElementById("J_mobile").value);

	}

}

</script>
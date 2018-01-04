<?php if (!defined('THINK_PATH')) exit();?><div class="lh_a1">
    <div class="hf_zr"> <img src="<?php echo avatar($data['uid'], 48);?>" /><span><?php echo ($data["uname"]); ?></span></div> <p class="J_pl_i"><?php echo ($data["info"]); ?></p>
    <div class="lrhf"><div><span><?php echo (fdate($data["add_time"])); ?></span><a href="javascript:;" class="J_hf" data-id="<?php echo ($data["id"]); ?>" title="»Ø¸´">»Ø¸´</a></div></div>
</div>
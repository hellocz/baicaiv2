<?php if (!defined('THINK_PATH')) exit(); if(is_array($cmt_list)): $i = 0; $__LIST__ = $cmt_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="ly_ba">



		<div class="ly_tx_a">

			<img src="<?php echo avatar($val['uid'], 48);?>" height="48" width="48" />

			<em><?php echo ($val["lc"]); ?>楼</em>

		</div>



		<div class="lr_ra">

			<p class="ssb"><?php echo ($val["uname"]); ?><span>LV.<?php echo grade($val['uid']);?></span><em><?php echo (fdate($val["add_time"])); ?></em></p>

			<?php $infos=explode("|",$val['info']); ?>
                         <div class="ly_ba_lr"><p class="J_pl_i"><?php if(stripos($val['info'],'|android') !== false ): echo ($infos[0]); ?></p></div><div class="ly_ba_lr"><p class="J_pl_i">来自<a href="<?php echo U('item/index',array('id'=>'275535'));?>"  target="_blank"> android </a>客户端</p></div><?php elseif(stripos($val['info'],'|iphone') !== false ): ?> <?php echo ($infos[0]); ?></p></div><div class="ly_ba_lr"><p class="J_pl_i">来自<a href="<?php echo U('item/index',array('id'=>'275535'));?>"  target="_blank"> iphone </a>客户端</p></div><?php else: echo ($val["info"]); ?></p></div><?php endif; ?>



            
			<div class="hflr_b hflr<?php echo ($val["id"]); ?>" id="hflr_b<?php echo ($val["id"]); ?>">

				<?php if(is_array($val['list'])): $i = 0; $__LIST__ = $val['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><div class="lh_a1">
					  <?php $infos=explode("|",$r['info']); ?>
            <div class="hf_zr"> <img src="<?php echo avatar($r['uid'], 48);?>" /><span><?php echo ($r["uname"]); ?></span></div> <p class="J_pl_i"><?php if(stripos($r['info'],'|android') !== false ): echo ($infos[0]); ?></p><p class="J_pl_i">来自<a href="<?php echo U('item/index',array('id'=>'275535'));?>"  target="_blank"> android </a>客户端</p><?php elseif(stripos($r['info'],'|iphone') !== false ): ?> <?php echo ($infos[0]); ?></p><p class="J_pl_i">来自<a href="<?php echo U('item/index',array('id'=>'275535'));?>"  target="_blank"> iphone </a>客户端</p><?php else: echo ($r["info"]); ?></p><?php endif; ?>

						<div class="lrhf"><div><span><?php echo (fdate($r["add_time"])); ?></span><a href="javascript:;" class="J_hf" data-id="<?php echo ($r["id"]); ?>" psid="<?php echo ($val["id"]); ?>" title="回复">回复</a></div></div>

					</div><?php endforeach; endif; else: echo "" ;endif; ?>

			</div>




			<div class="yl_ba_hf">

				<div class="gly_pl">

					<?php if($val['pingyu']): ?><span><strong>管理员评论：</strong><?php echo ($val['pingyu']); ?></span><?php endif; ?>&nbsp; &nbsp; &nbsp; &nbsp;

					<!-- <?php if($visitor['is_bj'] == 1): ?><a style="  background:#f90; text-align:center; color:#fff; padding:2px 5px; " href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';document.getElementById('id').value='<?php echo ($val["id"]); ?>';document.getElementById('uid').value='<?php echo ($val["uid"]); ?>';">+</a> -->

					<!--   <div id="light_a" class="white_content_a">

                        设置积分

                        <a href="javascript:void(0)" onclick="document.getElementById('light_a').style.display='none';document.getElementById('fade_a').style.display='none'">

                        关闭</a>

                         <br /><br />

                      <hr />

                      <br />

                      <form action="<?php echo U('ajax/bj_comment');?>" method="post">

                          <table width="96%" border="0">

                              <tr>

                                  <td width="20%">积分</td>

                                  <td width="80%"><input style=" width:90%;" name="jf" type="text" /></td>

                              </tr>

                              <tr>

                                  <td width="20%">财富</td>

                                  <td width="80%"><input style=" width:90%;" name="cf" type="text" /></td>

                              </tr>

                              <tr>

                                  <td width="20%">贡献</td>

                                  <td width="80%"><input style=" width:90%;" name="gx" type="text" /></td>

                              </tr>

                              <tr>

                                  <td width="20%">评语</td>

                                  <td width="80%"><input style=" width:90%;" name="pingyu" type="text" value="感谢您的精彩回复！"/></td>

                              </tr>

                              <input type="hidden" id="id" name="id" value="">

                              <input type="hidden" id="uid" name="uid" value="">

                              <tr>

                                  <td colspan="2" style="text-align:left; padding-left:20%; padding-top:20px;" class="jf_qd">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" 确 定 " />&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value=" 重 填 " /></td>

                              </tr>

                          </table>

                      </form>

                       </div>

                        <div id="fade_a" class="black_overlay_a">

                        </div>-->

					<!--  &nbsp;<?php endif; ?> -->

				</div>

				<ul>

					<?php if($visitor['is_bj'] == 1): ?><li><a href="javascript:if (confirm('您确定删除此评论')) location.href='<?php echo U('ajax/sc_comment',array('id'=>$val['id'],'uid'=>$val['uid']));?>'; " title="删除">删除</a></li><?php endif; ?>

					<?php if($val['jf']): ?><li><img src="/images/jf1_pic.png" alt="积分" />积分<a href="" >+<?php echo ($val['jf']); ?></a></li><?php endif; ?>

					<?php if($visitor['is_bj'] == 1): ?><li>

						<a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';document.getElementById('id').value='<?php echo ($val["id"]); ?>';document.getElementById('uid').value='<?php echo ($val["uid"]); ?>';">管理</a>

					</li><?php endif; ?>

					<!-- <li class="hfzk_b" id="hfzk_b<?php echo ($val["id"]); ?>">收起</li>

                    <li class="hfzk_b1" id="hfzk_b1<?php echo ($val["id"]); ?>" style="display:none;">展开</li> -->

					<li><a href="javascript:;" class="w_dred J_zan" data-id="<?php echo ($val["id"]); ?>">顶（<i><?php echo ($val["zan"]); ?></i>）</a></li>

					<li class="J_hf1" data-id="<?php echo ($val["id"]); ?>" psid="<?php echo ($val["id"]); ?>">回复</li>

				</ul>

			</div>





		</div>



	</div>

	<script type="text/javascript">

		$(document).ready(function(){

			$("#hfzk_b<?php echo ($val["id"]); ?>").click(function(){

				$("#hfzk_b<?php echo ($val["id"]); ?> ").css('display','none');

				$("#hfzk_b1<?php echo ($val["id"]); ?>").css('display','block');

				$("#hflr_b<?php echo ($val["id"]); ?>").toggle(200);

			});

			$("#hfzk_b1<?php echo ($val["id"]); ?>").click(function(){

				$("#hfzk_b1<?php echo ($val["id"]); ?>").css('display','none');

				$("#hfzk_b<?php echo ($val["id"]); ?>").css('display','block');

				$("#hflr_b<?php echo ($val["id"]); ?>").toggle(200);

			});


		});

	</script><?php endforeach; endif; else: echo "" ;endif; ?>
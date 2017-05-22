<?php

class scoreAction extends userbaseAction {

    /**
     * 积分订单
     */
    public function index() {
        $map = array();
        $map['uid'] = $this->visitor->info['id'];
		$more = $this->_get('more','trim');
		$p=$this->_get('p','intval') ? $this->_get('p','intval') : 1;
        $score_order_mod = M('score_order');
        $pagesize = 8;
		$start=($p-1)*$pagesize;
        $count = $score_order_mod->where($map)->count('id');
        $order_list = $score_order_mod->field('id,order_sn,item_id,item_name,order_score,order_coin,status,add_time')->where($map)->limit($start.','.$pagesize)->order('id DESC')->select();
        if($more == 'more'){
			$more_arr="";
			foreach($order_list as $key=>$r){
				$df=$r['status']==1 ? L('order_status_1') : L('order_status_0');
				$more_arr.="<li><a href='".U('wap/exchange/detail', array('id'=>$r['item_id']))."' title='".$r['item_name']."'>";
				$more_arr.="<img src='".score_item_img($r['item_id'])."' title='$r[item_name]' alt='$r[item_name]' />";
				$more_arr.="<h2><span>".fdate($r['add_time'])."</span>".$r['item_name']."</h2><p>".$df;
				$more_arr.="</p><p>".$val['order_coin']."金币</p></a></li>";
			}
			echo $more_arr;
			exit;
		}
		$this->assign('order_list', $order_list);
		$this->assign('count', $count);
		$this->assign('pagesize', $pagesize);
		$this->assign('title_h2', '兑换记录');
        $this->_curr_menu('order');
        $this->_config_seo();
        $this->display();
    }

    public function logs() {
        $map = array();
        $map['uid'] = $this->visitor->info['id'];
        //当前积分
        $score_total = $this->visitor->get('score');
        $score_log_mod = M('score_log');
        $pagesize = 20;
        $count = $score_log_mod->where($map)->count('id');
        $pager = $this->_pager($count, $pagesize);
        $logs_list = $score_log_mod->field('id,action,score,add_time')->where($map)->limit($pager->firstRow.','.$pager->listRows)->order('id DESC')->select();
        $this->assign('logs_list', $logs_list);
        $this->assign('page_bar', $pager->fshow());
        $this->assign('score_total', $score_total);
        $this->_config_seo();
        $this->display();
    }
}
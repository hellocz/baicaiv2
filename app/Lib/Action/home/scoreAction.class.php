<?php

class scoreAction extends userbaseAction {

    /**
     * 积分订单
     */
    public function index() {
        $map = array();
        $map['uid'] = $this->visitor->info['id'];
        $score_order_mod = M('score_order');
        $pagesize = 4;
        $count = $score_order_mod->where($map)->count('id');
        $pager = $this->_pager($count, $pagesize);
        $order_list = $score_order_mod->field('id,order_sn,item_id,item_name,order_score,order_coin,status,add_time,remark,luckdraw_num')->where($map)->limit($pager->firstRow.','.$pager->listRows)->order('id DESC')->select();
        $this->assign('order_list', $order_list);
        $this->assign('page_bar', $pager->fshow());
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
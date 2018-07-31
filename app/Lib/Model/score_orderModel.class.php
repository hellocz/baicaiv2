<?php

class score_orderModel extends Model
{
    protected $_auto = array (
        array('add_time','time',1,'function'),
        array('order_sn','get_sn',1,'callback'),
    );

    public function get_sn() {
        return date('YmdHis').rand(1000, 9999);
    }

    /**
     * 幸运中奖order
     */
    public function get_lucky_score_order($item_id = '', $luckdraw_num = '') {
        if(!$item_id || !$luckdraw_num) return false;

        $where = array('item_id'=>$item_id,'luckdraw_num'=>$luckdraw_num);
        $lucky_score_order = $this->where($where)->find();

        return $lucky_score_order;
    }

    /**
     * 查询抽奖列表
     * $limit 分页用
     * $order 排序
     */
    public function score_order_list($where = '', $limit = '', $order = 'id DESC') {
        
        $score_order_list = $this->where($where)->order($order)->limit($limit)->select();

        return $score_order_list;
    }
}
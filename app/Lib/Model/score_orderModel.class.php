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
     * 抽奖/兑换 - 某个item的订单数
     */
    public function order_counts($item_id = 0) {
        if(!$item_id) return false;
        
        $where = "item_id=$item_id";
        $count = $this->where($where)->count();

        return $count;
    }

    /**
     * 抽奖/兑换 - 某个item的订单记录
     */
    public function order_list($item_id = 0, $limit = '', $order = 'id DESC') {
        if(!$item_id) return false;
        
        $where = "item_id=$item_id";
        $list = $this->where($where)->order($order)->limit($limit)->select();

        return $list;
    }

    /**
     * 抽奖 - 中奖订单记录
     */
    public function get_lucky_order($item_id = 0, $luckdraw_num = '') {
        if(!$item_id || !$luckdraw_num) return false;

        $where = array('item_id'=>$item_id,'luckdraw_num'=>$luckdraw_num);
        $list = $this->where($where)->find();

        return $list;
    }

    /**
     * 抽奖/兑换 - 用户订单数
     */
    public function user_order_counts($t = 'exchange', $uid = 0) {
        if(!$uid) return false;

        switch ($t) {
            case 'lucky': //抽奖记录
                $where = "uid={$uid} and t.cate_id=8";
                break;
            case 'win': //中奖记录
                $where = "uid={$uid} and t.cate_id=8 and t.win<>'' and luckdraw_num=t.win";
                break;
            default: //兑换记录
                $where = "uid={$uid} and t.cate_id<>8";
                break;
        }

        $db_pre = C('DB_PREFIX');
        $table = "{$db_pre}score_order";
        $table_t = "{$db_pre}score_item";

        $count = $this->join("join {$table_t} t on {$table}.item_id=t.id")->where($where)->count();

        return $count;
    }

    /**
     * 抽奖/兑换 - 用户订单记录
     */
    public function user_order_list($t = 'exchange', $uid = 0, $limit = '', $order = 'id DESC') {
        if(!$uid) return false;

        switch ($t) {
            case 'lucky': //抽奖记录
                $where = "uid={$uid} and t.cate_id=8";
                break;
            case 'win': //中奖记录
                $where = "uid={$uid} and t.cate_id=8 and t.win<>'' and luckdraw_num=t.win";
                break;
            default: //兑换记录
                $where = "uid={$uid} and t.cate_id<>8";
                break;
        }

        $db_pre = C('DB_PREFIX');
        $table = "{$db_pre}score_order";
        $table_t = "{$db_pre}score_item";

        $list = $this->field("{$table}.*, t.title, t.img, t.sign_date, t.win")->join("join {$table_t} t on {$table}.item_id=t.id")->where($where)->order($order)->limit($limit)->select();

        return $list;
    }

}
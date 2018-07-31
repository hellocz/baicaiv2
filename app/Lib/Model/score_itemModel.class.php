<?php

class score_itemModel extends Model{

    public function get_info($id) {
        if(!$id) return false;
        $item = $this->where(array('id' => $id))->find();
        return $item;
    }

    /**
     * 查询积分兑换、积分抽奖列表
     * $t 积分兑换exchange，积分抽奖lucky，往期开奖lucky_expired
     * $limit 分页用
     * $order 排序
     */
    public function score_item_list($t = 'exchange', $limit = '10', $order = 'sign_date DESC,id DESC') {
        switch ($t) {
            case 'lucky':
                $where = array('status'=>'1', 'cate_id' => 8, 'win' => '');
                break;
            case 'lucky_expired':
                $where = array('status'=>'1', 'cate_id' => 8, 'win' => array('NEQ',''));
                break;
            default:
                $where = array('status'=>'1', 'cate_id' => array('NEQ','8'));
                break;
        }
        $item_list = $this->where($where)->order($order)->limit($limit)->select();

        return $item_list;
    }

}
<?php

class score_itemModel extends Model{

    public function get_info($id) {
        if(!$id) return false;
        $item = $this->where(array('id' => $id))->find();
        return $item;
    }


    /**
     * 查询积分兑换、积分抽奖列表数量
     */
    public function item_counts($t = 'exchange') {
        switch ($t) {
            case 'lucky':
                $where = array('cate_id' => 8, 'win' => '');
                break;
            case 'lucky_expired':
                $where = array('cate_id' => 8, 'win' => array('NEQ',''));
                break;
            default:
                $where = array('cate_id' => array('NEQ','8'));
                break;
        }
        $count = $this->where($where)->count();

        return $count;
    }

    /**
     * 查询积分兑换、积分抽奖列表
     * $t 积分兑换exchange，积分抽奖lucky，往期开奖lucky_expired
     * $limit 分页用
     * $order 排序
     */
    public function item_list($t = 'exchange', $limit = '10', $order = 'sign_date DESC,id DESC') {
        switch ($t) {
            case 'lucky':
                $where = array('cate_id' => 8, 'win' => '');
                break;
            case 'lucky_expired':
                $where = array('cate_id' => 8, 'win' => array('NEQ',''));
                break;
            default:
                $where = array('cate_id' => array('NEQ','8'));
                break;
        }
        if($t == 'lucky_expired'){
            //取中奖用户ID
            $db_pre = C('DB_PREFIX');
            $table = "{$db_pre}score_item";
            $table_t = "{$db_pre}score_order";
            $list = $this->field("{$table}.*, t.uid, t.status, t.remark")->join("left join {$table_t} t on {$table}.id=t.item_id and {$table}.win=t.luckdraw_num")->where($where)->order($order)->limit($limit)->select();
        }else{
            $list = $this->where($where)->order($order)->limit($limit)->select();
        }
        
        return $list;
    }


}
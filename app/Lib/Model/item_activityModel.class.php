<?php
class item_activityModel extends Model
{
    protected $where_valid = "status=1 and DATEDIFF(now() ,start_time)>-1 and DATEDIFF(end_time,now())>0 ";

    /**
    * 获得商品活动列表
    */
    public function item_activity_list($t = 'valid', $where = '', $field = '', $limit = '', $order = ''){
        
        $db_pre = C('DB_PREFIX');
        
        $map = array();
        if($t == 'valid'){ //有效
            $map['_string'] = $this->where_valid;
        }
        if($where){
            $map['_complex'] = $where;
        }
        if(!$field){
            $field = "item_id, activity_id, a.*";
        }
        if(!$order){
            $order = 'start_time desc';
        }
        
        $list = $this->field($field)->where($map)->join("JOIN {$db_pre}activity a on {$db_pre}item_activity.activity_id=a.id")->order($order)->limit($limit)->select();
        return $list;
    }

}
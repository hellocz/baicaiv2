<?php
class activityModel extends Model
{
    protected $where_valid = "status=1 and DATEDIFF(now() ,start_time)>-1 and DATEDIFF(end_time,now())>0 ";

    /**
     * item信息, 通过ID获取
     */
    public function get_info($id = '', $field = '') {
        if(!$id) return false;        
        $info = $this->field($field)->where(array('id' => $id))->find();
        return $info;
    }

    /**
    * 获得活动列表
    */
    public function activity_list($t = 'valid', $where = '', $limit = '0,10', $order = 'start_time desc'){
        $map = array();
        if($t == 'valid'){ //有效
            $map['_string'] = $this->where_valid;
        }
        if($where){
            $map['_complex'] = $where;
        }
        if(!$order){
            $order = 'start_time desc';
        }
        $list = $this->where($map)->order($order)->limit($limit)->select();
        return $list;
    }

    /**
    * 获得活动列表SQL
    */
    public function activity_sql($t = 'valid', $where = '', $field = '', $limit = '', $order = ''){
        $map = array();
        if($t == 'valid'){ //有效
            $map['_string'] = $this->where_valid;
        }
        if($where){
            $map['_complex'] = $where;
        }
        $sql = $this->field($field)->where($map)->order($order)->limit($limit)->buildSql();
        return $sql;
    }

    /**
    * 获得有活动的商城IDs
    */
    public function get_orig_ids($t = 'valid', $where = ''){
        $map = array();
        if($t == 'valid'){ //有效
            $map['_string'] = $this->where_valid;
        }
        if($where){
            $map['_complex'] = $where;
        }
        $list = $this->field('distinct orig_id')->where($map)->select();
        $ids = array();
        if(count($list) > 0){
            foreach ($list as $key => $val) {
                $ids[] = $val['orig_id'];
            }
        }
        return $ids;
    }

}
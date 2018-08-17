<?php
class tickModel extends Model
{

    /**
     * item信息, 通过ID获取
     */
    public function get_info($id = '', $field = '') {
        if(!$id) return false;        
        $info = $this->field($field)->where(array('id' => $id))->find();
        return $info;
    }

    /**
    * 获得券列表
    */
    public function tick_list($where = '', $limit = '0,10', $order = 'start_time desc'){
        if(!$order){
            $order = 'start_time desc';
        }
        $list = $this->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

}
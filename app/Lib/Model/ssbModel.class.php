<?php
class ssbModel extends Model
{

    /**
    * 获得删除的消息IDs
    */
    public function get_mids($uid = 0){
        if(!$uid) return false;

        $list = $this->where("uid=$uid and type=1")->select();

        $ids = array();
        if(count($list) > 0){
            foreach($list as $key=>$val){
                $ids[$val['mid']] = $val['mid'];
            }
        }
        return $ids;
    }

}
<?php

class score_logModel extends Model
{
    protected $_auto = array (array('add_time','time',1,'function'));

    /**
    * 用户积分变动总数
    */
    public function user_score_log_count($t = '', $uid = 0){
        if(!$uid) return false;
        
        $where = "uid='$uid' "; 
        if($t == 'illegal'){
        	$where .= "and action like 'un%'"; 
        }
        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 用户积分列表
    */
    public function user_score_log_list($t = '', $uid = 0, $limit = '0,10', $order = 'add_time desc'){
        if(!$uid) return false;
        
        $where = "uid='$uid' "; 
        if($t == 'illegal'){
        	$where .= "and action like 'un%'"; 
        }
        $list = $this->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

}
<?php
class tkModel extends Model
{

    /**
    * 清理六个月之前的卡券
    */
    public function clear($uid){
        if(!$uid) return false;

        $list = D('tick')->tick_list('DATE_SUB( CURDATE( ) , INTERVAL 6 MONTH ) > DATE( end_time )', '', '');
        if($list){
            foreach($list as $v){
                $arr[]=$v['id'];
            }
            $this->where(array('tick_id'=>array('in',$arr),'uid'=>$uid))->delete();
        }
    }

    /**
    * 获得卡券总数
    */
    public function counts($where = ''){
        if(!$where) return false;

        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 用户卡券总数
    */
    public function user_tick_count($t = 'all', $uid = 0){
        if(!$uid) return false;
        
        $where = "uid=$uid "; 

        if($t == 'valid'){ //有效
            $where .="and t.end_time>NOW()";
            $count = $this->where($where)->join("try_tick t ON t.id = try_tk.tick_id")->count();
        }else{ //所有
            $count = $this->where($where)->count();
        }

        return $count;
    }

    /**
    * 用户卡券列表
    */
    public function user_tick_list($t = 'all', $uid = 0, $limit = '1,10', $order = 'get_time desc, tk_id desc'){
        if(!$uid) return false;
        
        $where = "uid=$uid "; 

        if($t == 'valid'){ //有效
            $where .="and t.end_time>NOW()";            
        }

        $list = $this->where($where)->join("try_tick t ON t.id = try_tk.tick_id")->order($order)->limit($limit)->select();
        foreach($list as $k=>$v){
            $list[$k]['start_time'] = strtotime($list[$k]['start_time']);
            $list[$k]['end_time'] = strtotime($list[$k]['end_time']);
            if($list[$k]['end_time']>time()){
                $list[$k]['valid']=1;
            }
        }

        return $list;
    }

}
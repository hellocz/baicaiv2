<?php
class user_followModel extends Model
{
    //自动完成
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

    /**
    * 该用户关注用户数
    */
    public function user_follow_count($uid = 0){
        if(!$uid) return false;
        $count = $this->where("uid=$uid")->count();
        return $count;
    }

    /**
    * 用户关注列表
    */
    public function user_follow_list($uid = 0, $order = 'add_time desc', $limit = '1,10'){
        if(!$uid) return false;
        if(!$order){
            $order = 'add_time desc';
        }
        $list = $this->where("uid=$uid")->join("try_user u ON u.id=try_user_follow.follow_uid")->order($order)->limit($limit)->select();
        if(count($list) > 0){
            foreach($list as $key=>$val){
                //加入多少天
                $list[$key]['join_days']=intval((time() - $val['reg_time']) / 86400);
            }
        }
        return $list;
    }

    /**
    * 该用户的粉丝数
    */
    public function user_fans_count($uid = 0){
        if(!$uid) return false;
        $count = $this->where("follow_uid=$uid")->count();
        return $count;
    }

    /**
    * 用户粉丝列表
    */
    public function user_fans_list($uid = 0, $order = 'add_time desc', $limit = '1,10'){
        if(!$uid) return false;
        if(!$order){
            $order = 'add_time desc';
        }
        $list = $this->where("follow_uid=$uid")->join("try_user u ON u.id=try_user_follow.uid")->order($order)->limit($limit)->select();//
        return $list;
    }

    /**
    * 用户是否已关注
    */
    public function is_follow($uid = 0, $follow_uid = 0){
        if(!$uid || !$follow_uid) return false;

        $count = $this->where("uid=$uid and follow_uid=$follow_uid")->count();
        return $count;
    }
}
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
    public function user_follow_list($uid = 0, $limit = '', $order = 'add_time desc'){
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
    public function user_fans_list($uid = 0, $limit = '', $order = 'add_time desc'){
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

        $list = $this->where("uid=$uid and follow_uid=$follow_uid")->find();
        if(!$list){
            return false;
        }

        return true;
    }

    /**
    * 关注
    */
    public function follow($uid = 0, $follow_uid = 0){
        if(!$uid || !$follow_uid) return false;

        //关注动作
        $return = 1;

        //他是否已经关注我
        $map = array('uid'=>$follow_uid, 'follow_uid'=>$uid);
        $is_mutually = $this->is_follow($follow_uid, $uid);
        $data = array('uid'=>$uid, 'follow_uid'=>$follow_uid, 'add_time'=>time());
        if ($is_mutually) {
            $data['mutually'] = 1; //互相关注
            $this->where($map)->setField('mutually', 1); //更新他关注我的记录为互相关注
            $return = 2;
        }

        $result = $this->add($data);
        if(!$result){
            return false;
        }

        //增加我的关注人数
        D('user')->where(array('id'=>$uid))->setInc('follows');

        //增加Ta的粉丝人数
        D('user')->where(array('id'=>$follow_uid))->setInc('fans');

        //提醒被关注的人
        D('user_msgtip')->add_tip($follow_uid, 1);

        //把他的微薄推送给我
        //TODO...是否有必要？

        return $return;
    }

    /**
    * 取消关注
    */
    public function unfollow($uid = 0, $follow_uid = 0){
        if(!$uid || !$follow_uid) return false;

        $result = $this->where(array('uid'=>$uid, 'follow_uid'=>$follow_uid))->delete();

        if ($result) {
            //他是否已经关注我
            $map = array('uid'=>$follow_uid, 'follow_uid'=>$uid);
            $is_mutually = $this->where($map)->count();
            if ($is_mutually) {
                $this->where($map)->setField('mutually', 0); //更新他关注我的记录为互相关注
            }
            
            //减少我的关注人数
            D('user')->where(array('id'=>$uid))->setDec('follows');

            //减少Ta的粉丝人数
            D('user')->where(array('id'=>$follow_uid))->setDec('fans');

            //删除我微薄中Ta的内容
           // M('topic_index')->where(array('author_id'=>$follow_uid, 'uid'=>$uid))->delete();

            return true;
        } else {
            return false;
        }
    }

    /**
    * 用户关注的用户IDs
    */
    public function user_follow_ids($uid = 0){
        if(!$uid) return false;

        $list = $this->where("uid=$uid")->select();

        $ids = array();
        if(count($list) > 0){
            foreach($list as $key=>$val){
                $ids[$val['follow_uid']] = 1;
            }
        }
        return $ids;
    }

}
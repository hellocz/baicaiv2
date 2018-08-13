<?php
class notify_tagModel extends Model
{
    /**
    * 获得TAG总数
    */
    public function counts($where = ''){
        if(!$where) return false;

        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 获得TAG列表
    */
    public function follow_list($where = '', $limit = '1,10', $order = 'id desc'){
        if(!$order){
            $order = 'id desc';
        }
        $list = $this->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

    /**
    * 用户TAG总数
    */
    public function user_follow_count($userid = 0){
        if(!$userid) return false;
        
        $where = "userid=$userid and f_sign=1"; 
        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 用户TAG列表
    */
    public function user_follow_list($userid = 0, $limit = '1,10', $order = 'id desc'){
        if(!$userid) return false;
        
        $where = "userid=$userid and f_sign=1"; 
        $list = $this->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

    /**
    * 用户是否已关注该TAG
    */
    public function is_follow($userid = 0, $tag = ''){
        if(!$userid || !$tag) return false;

        $list = $this->where("userid=$userid and tag='{$tag}'")->find();
        if(!$list){
            return false;
        }

        return true;
    }

    /**
    * 用户是否已关注该TAG
    */
    public function get_follow_tag($userid = 0, $tag = ''){
        if(!$userid || !$tag) return false;

        $list = $this->where("userid=$userid and tag='{$tag}'")->find();
        return $list;
    }

    /**
    * 关注TAG 
    * 参数：userid, tag
    * 参数：notify true 推送|false 关注
    */
    public function follow($userid = 0, $tag = '', $notify = false){
        if(!$userid || !$tag) return false;

        $list = $this->get_follow_tag($userid, $tag);

        if($list){  //关注tag
            $list['f_sign'] = 1;
            if($notify) $list['p_sign'] = 1;
            $this->save($list);
            $result = true;
        }else{ // 推送
            $list['userid'] = $userid;
            $list['tag'] = $tag;
            $list['f_sign'] = 1;
            if($notify) $list['p_sign'] = 1; 
            $result = $this->add($list);
        }

        return $result;
    }

    /**
    * 取消关注TAG
    * 参数：userid, id
    * 参数：notify true 取消推送|false 取消关注
    */
    public function unfollow($userid = 0, $tag = '', $notify = false){
        if(!$userid || !$tag) return false;
        
        $list = $this->get_follow_tag($userid, $tag);

        if(!$list) return false;

        if($notify){  //取消推送
            $list['p_sign'] = 0;
            $this->save($list);
            $result = true;
        }else{  //取消关注
            $result = $this->delete($list['id']);
        }

        return $result;
    }

    /**
    * 获得top TAG列表
    */
    public function top_follow_list($where = '', $limit = '1,100'){
        $list = $this->field("TRIM(tag) as tag, count(*) as count")->where($where)->group("TRIM(tag)")->order("count(*) desc")->limit($limit)->select();
        return $list;
    }

    /**
    * 用户关注的用户IDs
    */
    public function user_follow_tags($userid = 0){
        if(!$userid) return false;

        $list = $this->where("userid=$userid and f_sign=1")->select();

        $tags = array();
        if(count($list) > 0){
            foreach($list as $key=>$val){
                $tags[$val['tag']] = $val['tag'];
            }
        }
        return $tags;
    }

}
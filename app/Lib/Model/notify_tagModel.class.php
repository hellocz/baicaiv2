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
    public function follow_list($where = '', $order = 'id desc', $limit = '1,10'){
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
        
        $where = "userid='$userid'"; 
        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 用户TAG列表
    */
    public function user_follow_list($userid = 0, $order = 'id desc', $limit = '1,10'){
        if(!$userid) return false;
        
        $where = "userid='$userid'"; 
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
    public function create_follow_tag($data = array(), $notify = false){
        if(!$data || !$data['userid'] || !$data['tag']) return false;

        $list = $this->get_follow_tag($data['userid'], $data['tag']);

        if($list){  //关注tag
            $list['f_sign'] = 1;
            if($notify) $list['p_sign'] = 1;            
            $this->save($list);
            $result = true;
        }else{ // 推送
            $data['f_sign'] = 1;
            if($notify) $data['p_sign'] = 1; 
            $result = $this->add($data);
        }

        return $result;
    }

    /**
    * 取消关注TAG
    * 参数：userid, id
    * 参数：notify true 取消推送|false 取消关注
    */
    public function del_follow_tag($data = array(), $notify = false){
        if(!$data || !$data['userid'] || !$data['id']) return false;

        if($notify){  //取消推送
            $data['p_sign'] = 0;
            $this->save($data);
            $result = true;
        }else{  //取消关注
            $result = $this->where($data)->delete();
        }

        return $result;
    }

    /**
    * 获得top TAG列表
    */
    public function top_follow_list($where = '', $limit = '1,100'){
        $list = $this->field("tag, count(*) as count")->where($where)->group("tag")->order("count(*) desc")->limit($limit)->select();
        return $list;
    }

}
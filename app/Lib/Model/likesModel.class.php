<?php
class likesModel extends Model
{
    //自动完成
    protected $_auto = array(
        array('addtime', 'time', 1, 'function'),
    );

    /**
    * 获得收藏总数
    */
    public function likes_count($where = ''){
        if(!$where) return false;

        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 获得收藏列表
    */
    public function likes_list($where = '', $order = 'addtime desc', $limit = '1,10'){
        if(!$order){
            $order = 'addtime desc';
        }
        $list = $this->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

    /**
    * 用户收藏总数
    */
    public function user_likes_count($uid = 0){
        if(!$uid) return false;
        
        $where = "uid='$uid'"; 
        $count = $this->likes_count($where);
        return $count;
    }

    /**
    * 用户收藏列表
    */
    public function user_likes_list($uid = 0, $order = 'addtime desc', $limit = '1,10'){
        if(!$uid) return false;
        
        $where = "uid='$uid'"; 
        $list = $this->likes_list($where, $order, $limit);
        return $list;
    }
}
<?php
class commentModel extends Model
{
    //自动完成
    protected $_auto = array(
        array('add_time', 'time', 1, 'function'),
    );

    /**
    * 获得文章总数
    */
    public function counts($where = ''){
        if(!$where) return false;

        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 获得文章列表
    */
    public function comment_list($where = '', $limit = '1,10', $order = 'add_time desc'){
        if(!$order){
            $order = 'add_time desc';
        }
        $list = $this->where($where)->order($order)->limit($limit)->select();
        return $list;
    }

    /**
    * 用户评论总数
    */
    public function user_comment_count($uid = 0){
        if(!$uid) return false;
        
        $where = "uid='$uid' and status=1"; 
        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 用户评论列表
    */
    public function user_comment_list($uid = 0, $limit = '1,10', $order = 'add_time desc'){
        if(!$uid) return false;
        
        $where = "uid='$uid' and status=1"; 
        $list = $this->where($where)->order($order)->limit($limit)->select();
        if(count($list) > 0){
            foreach($list as $key=>$val){
                $arr=array();
                switch($val['xid']){
                    case "1":$mod=D('item');$path="item";$url=U('item/index',array('id'=>$val['itemid']));break;
                    case "2":$mod=D("zr");$path="zr";$url=U('zr/show',array('id'=>$val['itemid']));break;
                    case "3":$mod=D("article");$path="article";$url=U('article/show',array('id'=>$val['itemid']));break;
                }
                $arr = $mod->get_info($val['itemid'], "title,img,content,intro,zan,comments");
                $list[$key]['title']=$arr['title'];
                $list[$key]['img']=attach($arr['img'],$path);
                $list[$key]['url']=$url;
                $list[$key]['content']=$arr['content'];
                $list[$key]['intro']=$arr['intro'];
                $list[$key]['zan']=$arr['zan'];
                $list[$key]['comments']=$arr['comments'];
            }
        }
        return $list;
    }
}
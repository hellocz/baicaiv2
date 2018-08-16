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
    public function comment_list($where = '', $limit = '0,10', $order = 'add_time desc'){
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
    public function user_comment_list($uid = 0, $limit = '0,10', $order = 'add_time desc'){
        if(!$uid) return false;
        
        $where = "uid='$uid' and status=1"; 
        $list = $this->where($where)->order($order)->limit($limit)->select();
        if(count($list) > 0){
            foreach($list as $key=>$val){
                $arr=array();
                switch($val['xid']){
                    case "1":
                        $mod=D('item');$type="item";$url=U('item/index',array('id'=>$val['itemid']));
                        $field="title,img,content,intro,zan,comments";
                        break;
                    case "2":
                        $mod=D("zr");$type="zr";$url=U('zr/show',array('id'=>$val['itemid']));
                        $field="title,img,content,intro,zan,comments";
                        break;
                    case "3":
                        $mod=D("article");$type="article";$url=U('article/show',array('id'=>$val['itemid']));
                        $field="title,img,info content,intro,zan,comments";
                        break;
                }
                $arr = $mod->get_info($val['itemid'], "title,img,content,intro,zan,comments");
                $list[$key][$type]=1;
                $list[$key]['id']=$val['itemid'];
                if(count($arr) == 0) {
                    $list[$key]['title']="该信息不存在或已删除";
                    $list[$key]['img']="";
                    $list[$key]['url']="";
                    $list[$key]['content']="";
                    $list[$key]['intro']="";
                    $list[$key]['zan']=0;
                    $list[$key]['comments']=0;
                }
                else
                {
                    $list[$key]['title']=$arr['title'];
                    $list[$key]['img']=$arr['img'];
                    $list[$key]['url']=$url;
                    $list[$key]['content']=$arr['content'];
                    $list[$key]['intro']=$arr['intro'];
                    $list[$key]['zan']=$arr['zan'];
                    $list[$key]['comments']=$arr['comments'];
                }
            }
        }
        return $list;
    }
}
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
    public function counts($where = ''){
        if(!$where) return false;

        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 获得收藏列表
    */
    public function likes_list($where = '', $limit = '0,10', $order = 'addtime desc'){
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
        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 用户收藏列表
    */
    public function user_likes_list($uid = 0, $limit = '0,10', $order = 'addtime desc'){
        if(!$uid) return false;
        
        $where = "uid='$uid'"; 
        $list = $this->where($where)->order($order)->limit($limit)->select();
        if(count($list) > 0){
            foreach($list as $key=>$val){
                $arr=array();
                switch($val['xid']){
                    case "1":
                        $mod=D('item');$type="item";$url=U('item/index',array('id'=>$val['itemid']));
                        $field="title,img,content,intro,zan,comments,add_time,uid,uname";
                        break;
                    case "2":
                        $mod=D("zr");$type="zr";$url=U('zr/show',array('id'=>$val['itemid']));
                        $field="title,img,content,intro,zan,comments,add_time,uid,uname";
                        break;
                    case "3":
                        $mod=D("article");$type="article";$url=U('article/show',array('id'=>$val['itemid']));
                        $field="title,img,info as content,intro,zan,comments,add_time,uid,uname";
                        break;
                }
                $arr = $mod->get_info($val['itemid'], $field);
                $list[$key][$type]=1;
                $list[$key]['id']=$val['itemid'];
                if(count($arr) == 0) {
                    $list[$key]['title']="该信息不存在或已删除";
                    $list[$key]['img']="";
                    $list[$key]['url']="";
                    $list[$key]['content']="";
                    // $list[$key]['intro']="";
                    $list[$key]['zan']=0;
                    $list[$key]['comments']=0;
                    $list[$key]['add_time']="";
                    $list[$key]['item_uid']="";
                    $list[$key]['uname']="";
                }
                else
                {
                    $list[$key]['title']=$arr['title'];
                    $list[$key]['img']=$arr['img'];
                    $list[$key]['url']=$url;
                    $list[$key]['content']=$arr['content'];
                    // $list[$key]['intro']=$arr['intro'];
                    $list[$key]['zan']=$arr['zan'];
                    $list[$key]['comments']=$arr['comments'];
                    $list[$key]['add_time']=$arr['add_time'];
                    $list[$key]['item_uid']=$arr['uid'];
                    $list[$key]['uname']=$arr['uname'];
                }
            }
        }
        return $list;
    }

    /**
    * 用户是否已收藏
    */
    public function is_likes($uid = 0, $xid = 0, $itemid = 0){
        if(!$uid || !$xid || !$itemid) return false;

        $result = $this->where("uid=$uid and xid=$xid and itemid=$itemid")->find();
        if(!$result){
            return false;
        }

        return true;
    }

    /**
    * 删除收藏
    */
    public function delete_likes($uid = 0, $xid = 0, $itemid = 0){
        if(!$uid || !$xid || !$itemid) return false;

        $result = $this->where("uid=$uid and xid=$xid and itemid=$itemid")->delete();
        if(!$result){
            return false;
        }

        return true;
    }
}
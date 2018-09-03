<?php
class item_voteModel extends Model
{

    public function vote($userid,$xid, $itemid,$type)
    {
        $isvote=$this->where("uid=$userid and xid=$xid and itemid=$itemid")->find();
        if($isvote){
            $status['code'] = 0;
            $status['error'] = "不能重复投票";
        }
        else{
            $i_mod = get_mod($xid);
            if($type==1){
                $i_mod->where("id=$itemid")->setInc("zan");
            }
            else{
                $i_mod->where("id=$itemid")->setInc("cai");
            }
            $this->add(array('itemid'=>$itemid,'xid'=>$xid,'add_time'=>time(),'uid'=>$userid,'type'=>$type));
            $status['code'] = 1;
        }
        return $status;
    }


    /**
    * 用户投票总数
    */
    public function user_vote_count($uid = 0){
        if(!$uid) return false;
        
        $where = "uid='$uid'"; 
        $count = $this->where($where)->count();
        return $count;
    }

    /**
    * 用户投票列表
    */
    public function user_vote_list($uid = 0, $limit = '0,10', $order = 'add_time desc'){
        if(!$uid) return false;
        
        $where = "uid='$uid'"; 
        $list = $this->where($where)->order($order)->limit($limit)->select();
        if(count($list) > 0){
            foreach($list as $key=>$val){
                $arr=array();
                switch($val['xid']){
                    case "1":
                        $mod=D('item');$type="item";$url=U('item/index',array('id'=>$val['itemid']));
                        $field="title,img,content,intro,zan,cai,comments";
                        break;
                    // case "2":
                    //     $mod=D("zr");$type="zr";$url=U('zr/show',array('id'=>$val['itemid']));
                    //     $field="title,img,content,intro,zan,comments";
                    //     break;
                    case "3":
                        $mod=D("article");$type="article";$url=U('article/show',array('id'=>$val['itemid']));
                        $field="title,img,info content,intro,zan,cai,comments";
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
                    $list[$key]['intro']="";
                    $list[$key]['zan']=0;
                    $list[$key]['cai']=0;
                    $list[$key]['comments']=0;
                }
                else
                {
                    $list[$key]['title']=$arr['title'];
                    $list[$key]['img']=$arr['img'];
                    $list[$key]['url']=$url;
                    $list[$key]['content']=$arr['content'];
                    $list[$key]['intro']=$arr['intro'];
                    $list[$key]['zan']=intval($arr['zan']);
                    $list[$key]['cai']=intval($arr['cai']);
                    $list[$key]['comments']=$arr['comments'];
                }
            }
        }
        return $list;
    }
   
}
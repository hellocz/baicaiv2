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

    /**
    * 商品评论总数
    */
    public function item_comment_count($itemid = 0){
        if(!$itemid) return false;
        
        $where = array('itemid' => $itemid,'xid'=>1,'status'=>1,'pid'=>0);
        $count = $this->where($where)->count('id');
        return $count;
    }

    /**
    * 商品评论列表
    * 历史数据的楼层lc需要计算
    */
    public function item_comment_list($itemid = 0, $limit = '0,10', $order = 'id desc'){
        if(!$itemid) return false;
        
        //取出所有数据，计算楼层
        $where = array('itemid' => $itemid,'xid'=>1,'status'=>1,'pid'=>0);
        // $list = $this->where($where)->order($order)->limit($limit)->select();
        $list = $this->where($where)->order("id asc")->select();   
        $i = 1;
        $arr_id=array();
        $arr_zan=array();
        if(count($list) > 0){
          foreach($list as $key=>$v){
            $list[$key]['lc'] = $i;
            $i++;

            $where1 = "status=1 and pid='".$v['id']."'";
            $list[$key]['list']=$this->where($where1)->order("id asc")->select();   
            $j=1;
            foreach($list[$key]['list'] as $key2=>$v2){
              $list[$key]['list'][$key2]['lc'] = $j;
              $j++;
            }

            //数组排序用
            $arr_id[$key] = $v['id'];
            $arr_zan[$key] = $v['zan'];            
          }
        }
        
        // echo "<pre>";
        // echo "list: ";print_r($list);echo "<br><br>";

        //取分页数据
        $arr_order = explode(" ", strtolower(trim($order)));
        if(strpos(',', $limit) === 0){
            $limit = '0,'.trim($limit);
        }
        $arr_limit = explode(",", trim($limit));    
        $volumn = ${'arr_'.$arr_order[0]} ? ${'arr_'.$arr_order[0]} : ''; 
        $sort = $arr_order[1] && $arr_order[1] == 'desc' ? SORT_DESC : SORT_ASC;
        if($volumn){
            array_multisort($volumn, $sort, $arr_id, SORT_DESC, $list);
        }
        $list = array_slice ($list, intval($arr_limit[0]), intval($arr_limit[1]));

        // echo "arr_order: ";print_r($arr_order);echo "<br><br>";
        // echo "arr_limit: ";print_r($arr_limit);echo "<br><br>";
        // echo "volumn: ";print_r($volumn);echo "<br><br>";
        // echo "sort: ";print_r($sort);echo "<br><br>";
        // echo "list: ";print_r($list);echo "<br><br>";
        // echo "</pre>";exit;

        return $list;
    }
}
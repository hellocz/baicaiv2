<?php
/*
* 商品类
* Created by PhpStorm.
* Author: 初心 [jialin507@foxmail.com]
* Date: 2017/4/12
*/
class shopAction extends userbaseAction
{
    public function _initialize() {
        parent::_initialize();
    }

    public function init() {
        if(IS_POST){
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data)) {
                return '';
            }
            $this->$data['reqBody']['api']($data['reqBody']);
        }
    }

    /**
     * 商品列表
     * @param $data
     */
    public function shoplist($data){
        $tp = $data['tp'];
        $page = $data['page'] * 10;
        empty($data['pagesize']) && $data['pagesize'] = 10;
        $time=time();
        $db_pre = C('DB_PREFIX');
        $item_orig = M("item_orig");
        $where = $db_pre."item_orig.ismy=".$tp;
        if($tp == 2){
//            $where = $db_pre."item_orig.ismy = 0 or ".$db_pre."item_orig.ismy = 1";//重置搜索条件
            $where = '1=1';
        }
        if(!empty($data['cid'])){
            $where .= ' and cate_id = '.$data['cid'];
        }else{
            $where .= ' and cate_id != 342';
        }

        if(!empty($data['orig_id'])){
            $where .= ' and orig_id = '.$data['orig_id'];
        }

        if(!empty($data['key'])){
            $where .= " and title like '%".$data['key']."%'";
        }
        if(!empty($data['isbao'])){
            $where .= " and isbao = 1";
        }
//        $field = 'i.id,i.uid,i.uname,i.title,i.intro,i.img,i.price,i.likes,i.intro,i.content,i.comments,i.comments_cache,i.add_time,i.orig_id,i.url,i.go_link,i.zan';
        $field = 'name,i.id,i.title,i.img,i.price,i.comments,i.likes,i.add_time,i.zan,i.go_link';
        $item_list = $item_orig
            ->where($where." and i.status=1 and i.add_time<$time ")
            ->join($db_pre . 'item i ON i.orig_id = ' . $db_pre . 'item_orig.id')
            ->field($field)
            ->order("i.add_time desc, i.id desc")
            ->limit($page-10, $data['pagesize'])
            ->select();

        foreach ($item_list as $key => &$val) {
            if(!isset($val['shopid'])){
                $val['shopid'] = $val['id'];
                unset($val['id']);
            }
            $val['go_link'] = array_shift(unserialize($val['go_link']));
        }
        $code = 10001;
        if(count($item_list) < 1){
            $code = 10002;
        }
        echo get_result($code,$item_list);return ;

    }

    //获取置顶商品
    public function shoplisttop($data)
    {
        $db_pre = C('DB_PREFIX');
        $item_orig = M("item_orig");
        $where = 'istop = 1';
        $time = time();
        $field = 'name,i.id,i.title,i.img,i.price,i.comments,i.likes,i.add_time,i.zan,i.go_link';
        $item_list = $item_orig
            ->where($where." and i.status=1 and i.add_time<$time ")
            ->join($db_pre . 'item i ON i.orig_id = ' . $db_pre . 'item_orig.id')
            ->field($field)
            ->order("i.add_time desc, i.id desc")
            ->select();

        foreach ($item_list as $key => &$val) {
            if(!isset($val['shopid'])){
                $val['shopid'] = $val['id'];
                unset($val['id']);
            }
            $val['go_link'] = array_shift(unserialize($val['go_link']));
        }
        $code = 10001;
        if(count($item_list) < 1){
            $code = 10002;
        }
        echo get_result($code,$item_list);return ;
    }


    public function getorig($data)
    {
        $item_mod = M('item_orig');
        $item = $item_mod->field('id,img,name,url')->select();
        $code = 10001;
        if(count($item) < 1){
            $code = 10002;
        }
        echo get_result($code,$item);return ;
    }

    /**
     * 标签搜索
     * @param $data
     */
    public function tagsearch($data) {
        $time=time();
        $page = $data['page'] * 10;
        $where = array();
        $where['add_time']=array('lt',$time);
        $where['tag_cache'] = array('like', '%' . $data['tag'] . '%');
        $db_pre = C('DB_PREFIX');
        if(!empty($data['cid'])){
            $where['cate_id'] = $data['cid'];
        }else{
            $where['cate_id'] = array('neq','342');
        }

        if(!empty($data['key'])){
            $where['title'] = array('like', '%' . $data['key'] . '%');
        }
        $item_mod = M('item');
        //查询字段
        $field = $db_pre . 'item.id,cate_id,title,'.$db_pre . 'item.img,price,likes,add_time,zan,go_link,'.$db_pre.'item_orig.name';
        $item_list = $item_mod->join($db_pre . 'item_orig ON ' . $db_pre . 'item.orig_id = '.$db_pre . 'item_orig.id')
                            ->field($field)
                            ->where($where)
                            ->order('id DESC')
                            ->limit($page-10, 10)
                            ->select();

        foreach ($item_list as $key => &$val) {
            if(!isset($val['shopid'])){
                $val['shopid'] = $val['id'];
                unset($val['id']);
            }
            $val['go_link'] = array_shift(unserialize($val['go_link']));
        }
        $code = 10001;
        if(count($item_list) < 1){
            $code = 10002;
        }
        echo get_result($code,$item_list);return ;


    }

    /**
     * 商品详细页
     */
    public function shopitem($data) {
        $id = $data['shopid'];
        $item_mod = M('item');
        $item = $item_mod->field('tag_cache,orig_id,title,img,intro,price,zan,likes,comments,add_time,content,status,go_link')->where(array('id' => $id))->find();
        if(!$item){
            echo get_result(20001,[], "商品不存在");return ;
        }

        if($item['status']==0){
            echo get_result(20001,[], "该信息未通过审核");return ;
        }
        if($item['add_time']>time()){
            echo get_result(20001,[], "该信息暂未发布");return ;
        }

        //来源
        $orig = M('item_orig')->field('id,name,img')->find($item['orig_id']);
        $like = M('likes')->where(['uid'=>$data['userid'],'itemid'=>$id])->field('itemid')->find();
        $item['mylike'] = 0;

        if($like){
            $item['mylike'] = 1;
        }
        $go_link = unserialize($item['go_link']);
        $item['fenxiang'] = 'http://www.baicaio.com/item/'.$id.'.html';
        $item['go_link'] = array_shift($go_link);
        $tag_caches = unserialize($item['tag_cache']);
        $item['tag_cache'] = '';
        foreach ($tag_caches as $tag_cache){
            $item['tag_cache'] .= $tag_cache.' ';
        }
        $item['orig'] = $orig;
        unset($item['orig_id']);
        echo get_result(10001,$item);
    }
    
    /**
     * 商品评论
     */
    public function commentitem($data) {

        $item_comment_mod = M('comment');
        $page = $data['page'] * 10;
        $pagesize = 10;
        $map = array('itemid' => $data['shopid']);

        $cmt_list = $item_comment_mod->where($map)->field('id,uid,uname,info,add_time,zan,lc')->order('id DESC')->limit($page - 10, $pagesize)->select();

        $code = 10001;
        if(count($cmt_list) < 1){
            $code = 10002;
        }
        echo get_result($code,$cmt_list);return ;


    }

    //1小时和24小时榜 0 为一天 1为 一小时
    public function hourday($data) {


        $time = time();
       // $time = 1495596278;
        $time_hour = $time - 3600;
        $time_day = $time - 86400;

        if($data['type'] == 1){
            $list=M()->query("SELECT id,title,img,price,go_link,comments,likes,add_time,zan from try_item  WHERE add_time between $time_hour and $time ORDER BY hits desc,add_time desc LIMIT 9");
        }else{
            $list=M()->query("SELECT id,title,img,price,go_link,comments,likes,add_time,zan from try_item  WHERE add_time between $time_day and $time ORDER BY hits desc,add_time desc LIMIT 9");
        }

        foreach ($list as $key => &$val) {
            if(!isset($val['shopid'])){
                $val['shopid'] = $val['id'];
                unset($val['id']);
            }
            $val['go_link'] = array_shift(unserialize($val['go_link']));
        }
        $code = 10001;
        if(count($list) < 1){
            $code = 10002;
        }
        echo get_result($code,$list);return ;

    }


    public function ad($data) {
        $ad_id = $data['adid'] ? $data['adid'] : 0;
        $result = M('ad')->where(['board_id'=>$ad_id,'status'=>1])->field('content,url')->select();
        $code = 10001;
        if(count($result) < 1){
            $code = 10002;
        }
        echo get_result($code,$result);return ;
    }

    //获取商品信息
    public function fetch_item($data) {
        $url = $data['url'];
       //获取商品信息
        $itemcollect = new itemcollect();
        $info = $itemcollect->url_parse($url);
        if(!empty($info)){
            $info['url'] = $url;
        }

        $encode = mb_detect_encoding($info['title'], array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        if($encode != 'UTF-8'){
            $info['title'] = mb_convert_encoding($info['title'], 'UTF-8', $encode);
        }
        $info['item_cate']=M("item_cate")->where("pid=0")->select();

        echo get_result(10001,$info);return ;
    }

    //发布商品
    public function publish_item($data) {
        $user = M("user")->where("id=".$data['userid'])->find();
        if($user['exp'] < 51){
            echo get_result(10001,"您的等级还不够，需要升到 2 级才能发布信息！");return ;
        }
        $item_mod = D('item');
        //过滤字符
        $kill_word = C("pin_kill_word");
        $kill_word = explode(",",$kill_word);
        if(in_array($data['content'],$kill_word)||in_array($data['title'],$kill_word)){
            echo get_result(10001,"您发表的内容有非法字符！");return ;
        }
        $item = $item_mod->create();
        $item['title'] = $data['title'];
        $item['info'] = Input::deleteHtmlTags($data['content']);
        $item['uid'] = $data['userid'];
        $item['price'] = $data['price'];
        $item['uname'] = get_uname($data['userid']);
        $item['isbao'] = '1';
        $item['source'] = '1';
//        $status = $data['status'];
//        if($status!=2){$status=0;}
        $item['status'] = 0;

        //添加凑单品，活动入口链接
        $arr[] = array('name'=>'直达链接','link'=>$data['url']);
        if(empty($data["link_type"])){
            $link_type=$data["link_type"];
            $link_url =$data["link_url"];
            foreach($link_type as $key=>$val){
                $arr[]=array('name'=>$val,'link'=>$link_url[$key]);
            }
        }

        $item['go_link']=serialize($arr);
        foreach($data['imgs'] as $key=>$val){
            $item['imgs'][$key]['url']=$val;
        }
//        if($data['ispost'] == 1){
            $item['ispost'] =1;
//        }
        //添加商品
        $result = $item_mod->publish($item);
        if ($result) {
            //发布商品钩子
            $tag_arg = array('uid' => $item['uid'], 'uname' => $item['uname'], 'action' => 'pubitem');
            tag('pubitem_end', $tag_arg);
            if($status == 2){
                echo get_result(10001,"保存草稿成功！");return ;
            }else{
                echo get_result(10001,"感谢您的爆料，我们会尽快审核，请关注短消息通知！");return ;
            }

        } else {
            echo get_result(10001,$item_mod->getError());return ;
        }
    }



}

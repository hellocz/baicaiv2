<?php
/*
* 文章类
* Created by PhpStorm.
* Author: 初心 [jialin507@foxmail.com]
* Date: 2017/4/13
*/
class articleAction extends userbaseAction
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

    /*
     * 文章列表
     */
    public function article($data){

        if($data['isbest'] == 1){
            $where['isbest']=1;
        }

        $cate_id = $data['cate_id'];

        $page = $data['page'] * 10;

        $time=time();
        $where['status']="1";
        if(!empty($data['key'])){
            $where['title'] = array('like', '%' . $data['key'] . '%');
        }
        $where['add_time']=array('lt',$time);
        if($cate_id != 0){
            $where['_string']=" cate_id=$cate_id or cate_id in(select id from try_article_cate where pid=$cate_id) ";
        }

        $field = 'id,uid,title,author,img,intro,likes,add_time,comments,zan';
        $article_list = M("article")->where($where)
                                    ->field($field)
                                    ->order("isbest desc,id desc")
                                    ->limit($page-10, 10)
                                    ->select();

        foreach ($article_list as $key => &$val) {
            if(!isset($val['articleid'])){
                $val['articleid'] = $val['id'];
                unset($val['id']);
            }
        }
        $code = 10001;
        if(count($article_list) < 1){
            $code = 10002;
        }
        echo get_result($code,$article_list);return ;
    }
    /*
     * 文章详情
     */
    public function articleitem($data) {
        if(empty($data['articleid'])){
           echo get_result(20001,[], "错误的请求");return ;
        }
        $id=$data['articleid'];

        $model = M("article");
        $field = 'tags,title,uid,author,img,intro,info,likes,zan,comments,add_time';
        $item = $model->where("id=$id and status=1")->field($field)->find();
        if(!$item){
            echo get_result(20001,[], "文章内容不存在或未通过审核");return ;
        }
        $like = M('likes')->where(['uid'=>$data['userid'],'itemid'=>$id])->field('itemid')->find();
        $item['mylike'] = 0;
        if($like){
            $item['mylike'] = 1;
        }
        $item['fenxiang'] = 'http://www.baicaio.com/item/'.$id.'.html';

        echo get_result(10001,$item);
    }

    //TODO:未完成！
    //发布晒单、攻略
    public function publish($data){
        $user = M("user")->where("id=".$data['userid'])->find();
        if($user['exp'] < 51){
            echo get_result(10001,"您的等级还不够，需要升到 2 级才能发布信息！");return ;
        }
        $mod = D("article");
        $t=$data['t'];
        //过滤字符
        $kill_word = C("pin_kill_word");
        $kill_word = explode(",",$kill_word);
        if(in_array($_POST['info'],$kill_word)||in_array($_POST['title'],$kill_word)){
            $this->error('您发表的内容有非法字符');
        }
        if (false === $data = $mod->create()) {
            IS_AJAX && $this->ajaxReturn(0, $mod->getError());
            $this->error($mod->getError());
        }
        $user = $this->visitor->get();
        !$user && $this->redirect('user/login');
        ($user['exp'] < 51) && $this->error('您的等级还不够，需要升到 2 级才能发布信息！');
        $data['uid']=$user['id'];
        $data['uname']=$user['username'];
        $data['author']=$user['username'];
        $data['intro']=msubstr(strip_tags($data['info']),0,250);
        if($data['status']!=2){$data['status']=0;}
        if($data['tags']==""){
            $data['tags'] = D('tag')->get_tags_by_title($data['title']);
            $data['tags'] = implode(' ', $data['tags']);
        }

        if( $mod->add($data) ){
            if( method_exists($this, '_after_insert')){
                $id = $mod->getLastInsID();
                $this->_after_insert($id);
            }
            IS_AJAX && $this->ajaxReturn(1, L('operation_success'), '', 'add');
            if($t=='sd'){
                $jumpUrl=U('user/publish',array('t'=>'sd'));
            }else{
                $jumpUrl=U('user/publish',array('t'=>'gl'));
            }
            $this->success(L('operation_success'),$jumpUrl);
        } else {
            IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
            $this->error(L('operation_failure'));
        }

    }
    //上传图片
    public function uploadimg(){
        //上传图片
        if (!empty($_FILES['J_img']['name'])) {
            $art_add_time = date('ym/d');
            $result = $this->_upload($_FILES['J_img'], 'article/' . $art_add_time);
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $data['J_img'] = get_rout_img($art_add_time .'/'. str_replace('.' . $ext, '.' . $ext, $result['info'][0]['savename']),'article');
            }
        }
        $this->ajaxReturn(1, L('operation_success'), $data['J_img']);
    }
    public function uploadimg1(){
        //上传图片
        $data=$this->_post('data');
        $data = substr(strstr($data,','),1);
        $img=base64_decode($data);
        $str = uniqid(mt_rand(),1);

        $file = 'upload/'.md5($str).'.jpg';
        $art_add_time = date('ym/d');
        $upload_path = '/'.C('pin_attach_path') . 'article/'. $art_add_time.'/'.md5($str).'.jpg';
        file_put_contents($file, $img);
        $art_add_time = date('ym/d');
        $upyun = new UpYun2('baicaiopic', '528', 'lzw123456');
        $fh = fopen($file, 'rb');
        $rsp = $upyun->writeFile($upload_path, $fh, True);   // 上传图片，自动创建目录
        fclose($fh);
        @unlink ($file);
        $data = IMG_ROOT_PATH.'/data/upload/article/'. $art_add_time.'/'.md5($str).'.jpg';
        $this->ajaxReturn(1, L('operation_success'),$data);
    }
}
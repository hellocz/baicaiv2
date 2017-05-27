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

        $field = 'id,title,author,img,intro,likes,add_time,zan';
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
        $field = 'title,author,img,intro,info,likes,zan,comments,add_time';
        $item = $model->where("id=$id and status=1")->field($field)->find();
        if(!$item){
            echo get_result(20001,[], "文章内容不存在或未通过审核");return ;
        }
        echo get_result(10001,$item);
    }

}
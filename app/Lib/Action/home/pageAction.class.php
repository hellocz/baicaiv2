<?php
class pageAction extends frontendAction {
    
    public function index() {
		$id = $this->_get('id','intval');
		!$id&&$this->_404();
		$info = M("article_page")->where("cate_id=$id")->find();
		$this->assign('info',$info);
        $this->display();
    }
}
<?php
class expressAction extends frontendAction {

    public function index() {
        $this->display();
    }

    public function show() {
        $id = $this->_get("id","intval");
		!$id && $this->_404();
		$model = M("express");
		$orig_info = $model->where("id=$id")->find();
		$this->assign('info',$orig_info);
        $this->_config_seo();
    	$this->display();
    }
}
<?php

class hdAction extends backendAction{

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('hd');
		$this->mod = D('hd');
    }

    public function index() {
        $list = M('hd')->order('order_s asc,id desc')->select();
        $this->assign('list', $list);
		$this->display();
    }
	public function add(){
		if (IS_POST) {
            $r=M("hd")->data($_POST)->add();
            $this->success(L('operation_success'));
        }else{
            $this->display();
        }
	}
	
	public function edit() {
        if (IS_POST) {
           // print_r($_POST);
            if(empty($_POST['is_color'])){
                $_POST['is_color'] = 0;
            }
            $r=M("hd")->where("id=$_POST[id]")->save($_POST);
           $this->success(L('operation_success'));
        } else {
            $id = $this->_get('id','intval');
            $item = M("hd")->where(array('id'=>$id))->find();
            $this->assign('info', $item);
            $this->display();
        }
    }
	
	function delete_attr() {
        $attr_mod = M('zr_attr');
        $attr_id = $this->_get('attr_id','intval');
        $attr_mod->delete($attr_id);
        echo '1';
        exit;
    }
}
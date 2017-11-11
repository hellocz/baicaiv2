<?php

class commentAction extends backendAction{

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('comment');
    }

    public function index() {
        //默认排序
        $this->sort = 'id';
        $this->order = 'desc';
        $map = $this->_search();
		$id = $this->_get("id","intval");
		$id && $map['id']=$id;
		//排序
		$model = $this->_mod;
        $mod_pk = $model->getPk();
        if ($this->_request("sort", 'trim')) {
            $sort = $this->_request("sort", 'trim');
        } else if (!empty($sort_by)) {
            $sort = $sort_by;
        } else if ($this->sort) {
            $sort = $this->sort;
        } else {
            $sort = $mod_pk;
        }
        if ($this->_request("order", 'trim')) {
            $order = $this->_request("order", 'trim');
        } else if (!empty($order_by)) {
            $order = $order_by;
        } else if ($this->order) {
            $order = $this->order;
        } else {
            $order = 'DESC';
        }
		$pagesize = 20;
        //如果需要分页
        if ($pagesize) {
            $count = $model->where($map)->count($mod_pk);
            $pager = new Page($count, $pagesize);
        }
        $select = $model->order($sort . ' ' . $order)->where($map);
        $this->list_relation && $select->relation(true);
        if ($pagesize) {
            $select->limit($pager->firstRow.','.$pager->listRows);
            $page = $pager->show();
            $this->assign("page", $page);
        }
        $list = $model->select();
        $this->assign('list', $list);
        $this->assign('list_table', true);
		$this->display();
    }
	//无效评论
	public function sets(){
		$status = $this->_get("status","intval");
		$id = $this->_get("id","intval");
		M("comment")->where("id=$id")->setField(array("status"=>$status));
		$uinfo = M("comment")->field("u.id,u.username,score,exp,offer,coin")->join("try_user as u ON u.id=try_comment.uid")->where("try_comment.id=$id")->find();
		set_score($uinfo,-10,"","",'');
		//积分日志			
		set_score_log($uinfo,"uncomments",-10,"","",'');
		$this->ajaxReturn(1);
	}

   protected function _search() {
        $map = array();
        ($uname = $this->_request('uname', 'trim')) && $map['uname'] = array('like', '%'.$uname.'%');
        $this->assign('search', array(
            'uname' => $uname,
        ));
        return $map;
    }
}
<?php

class zrAction extends backendAction{

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('zr');
		$this->_cate_mod = D('item_cate');
    }

    public function index() {
        //默认排序
        $this->sort = 'ordid';
        $this->order = 'ASC';
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
        $select = $model->order($sort . ' ' . $order);
        $this->list_relation && $select->relation(true);
        if ($pagesize) {
            $select->limit($pager->firstRow.','.$pager->listRows);
            $page = $pager->show();
            $this->assign("page", $page);
        }
        $list = $model->select();
		//栏目
		$arr = M('item_cate')->where("pid=0")->select();
		$cate = array();
		foreach($arr as $key=>$val){
			$cate[$val['id']]=$val['name'];
		}
		foreach($list as $key=>$val){
			$list[$key]['catename']=$cate[$val['cate_id']];
		}
        $this->assign('list', $list);
        $this->assign('list_table', true);
		$this->display();
    }
	public function add(){
		if (IS_POST) {
            //获取数据
            if (false === $data = $this->_mod->create()) {
                $this->error($this->_mod->getError());
            }
            if( !$data['cate_id']||!trim($data['cate_id']) ){
                $this->error('请选择商品分类');
            }
            //必须上传图片
            if (empty($_FILES['img']['name'])) {
                $this->error('请上传商品图片');
            }
            $data['uid'] = 0;
            $data['uname'] = $_SESSION['admin']['username'];
			//上传图片
            $date_dir = date('ym/d/'); //上传目录
            $result = $this->_upload($_FILES['img'], 'zr/'.$date_dir);
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $data['img'] = get_rout_img($date_dir . $result['info'][0]['savename'],'zr');
            }			
            $zr_id = $this->_mod->publish($data);
            !$zr_id && $this->error(L('operation_failure'));

            //附加属性
            $attr = $this->_post('attr', ',');
            if( $attr ){
                foreach( $attr['name'] as $key=>$val ){
                    if( $val&&$attr['value'][$key] ){
                        $atr['zr_id'] = $zr_id;
                        $atr['attr_name'] = $val;
                        $atr['attr_value'] = $attr['value'][$key];
                        M('zr_attr')->add($atr);
                    }
                }
            }
            $this->success(L('operation_success'));
        } else {
            $this->display();
        }
	}
	
	public function edit() {
        if (IS_POST) {
            //获取数据
            if (false === $data = $this->_mod->create()) {
                $this->error($this->_mod->getError());
            }
            if( !$data['cate_id']||!trim($data['cate_id']) ){
                $this->error('请选择商品分类');
            }
            $zr_id = $data['id'];
            $date_dir = date('ym/d/'); //上传目录           
            //修改图片
            if (!empty($_FILES['img']['name'])) {
                $result = $this->_upload($_FILES['img'], 'zr/'.$date_dir);
                if ($result['error']) {
                    $this->error($result['info']);
                } else {
                    $data['img'] = get_rout_img($date_dir . $result['info'][0]['savename'],'zr');                   
                }
            }
            //更新商品
            $this->_mod->where(array('id'=>$zr_id))->save($data);

            //附加属性
            $attr = $this->_post('attr', ',');
            if( $attr ){
                foreach( $attr['name'] as $key=>$val ){
                    if( $val&&$attr['value'][$key] ){
                        $atr['zr_id'] = $zr_id;
                        $atr['attr_name'] = $val;
                        $atr['attr_value'] = $attr['value'][$key];
                        M('zr_attr')->add($atr);
                    }
                }
            }
            $this->success(L('operation_success'));
        } else {
            $id = $this->_get('id','intval');
            $item = $this->_mod->where(array('id'=>$id))->find();
            //分类
            $spid = $this->_cate_mod->where(array('id'=>$item['cate_id']))->getField('spid');
            if( $spid==0 ){
                $spid = $item['cate_id'];
            }else{
                $spid .= $item['cate_id'];
            }
            $this->assign('selected_ids',$spid); //分类选中
            $tag_cache = unserialize($item['tag_cache']);
            $item['tags'] = implode(' ', $tag_cache);
			$item['imgs'] = unserialize($item['imgs']);
            $this->assign('info', $item);
            
            //属性
            $attr_list = M('zr_attr')->where(array('zr_id'=>$id))->select();
            $this->assign('attr_list', $attr_list);
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
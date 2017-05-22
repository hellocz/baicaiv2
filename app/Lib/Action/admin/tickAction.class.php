<?php

class tickAction extends backendAction{

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('tick');
    }

    public function index() {
        $big_menu = array(
            'title' => L('添加优惠券'),
            'iframe' => U('tick/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '140'
        );
        $this->assign('big_menu', $big_menu);
        //默认排序
        $this->sort = 'id';
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
        $this->assign('list', $list);
        $this->assign('list_table', true);
		$this->display();
    }
	public function tk(){
		$id = $this->_get('id','intval');
		$big_menu = array(
            'title' => L('导入优惠券'),
            'iframe' => U('tick/dao',array('id'=>$id)),
            'id' => 'add',
            'width' => '500',
            'height' => '140'
        );
        $this->assign('big_menu', $big_menu);
		$model=M('tk');
		$id>0&&$map['tick_id']=$id;
		$pagesize = 20;
		$count = $model->where($map)->count();
		$pager = new Page($count,$pagesize);
		$list = $model->where($map)->order("get_time desc")->limit($pager->firstRow.','.$pager->listRows)->select();
		$page = $pager->show();
		
		for($i=0;$i < $count; $i++){
			if($list[$i]['get_time']){
				$list[$i]["lq_time"]=date('Y:m:d H:i:s',$list[$i]["get_time"]);
			}else{
				$list[$i]["lq_time"]='尚未领取';
			}
			
		}
		/*echo "<pre>";
		var_dump($list);*/
		$this->assign('page',$page);
		$this->assign('list',$list);
		$this->display();
	}
	public function dao(){		
		if (IS_POST) {
			$id = $this->_get('id','intval');
			if (!empty($_FILES['file']['name'])) {
				/*if($_FILES['file']['type']!='application/vnd.ms-excel'){
					 $this->error('上传文件格式不正确！');
				}*/
				$result = $this->_upload($_FILES['file'], 'xls');
				if ($result['error']) {
					$this->error($result['info']);
				} else {
					$ext = array_pop(explode('.', $result['info'][0]['savename']));
					$da['fileurl']=$result['info'][0]['savename'];
					//$this->ajaxReturn(1, L('operation_success'), $da['fileurl']);
					//首先导入PHPExcel
					require_once 'api/excel_reader2.php';
					$data = new Spreadsheet_Excel_Reader();
					//设置文本输出编码 
					$data->setOutputEncoding('UTF-8'); 
					//读取Excel文件 					
					$data->read('data/upload/xls/'.$da['fileurl']); 
					//$data->sheets[0]['numRows']为Excel行数 
					for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
					//显示每个单元格内容 
						$da = array();
						$da['tk_code'] =  $data->sheets[0]['cells'][$i][1]; 
						$da['tk_psw'] = $data->sheets[0]['cells'][$i][2]; 
						$da['tick_id'] = $id; 
						if(!empty($da['tk_code'])){
							M('tk')->add($da);
						}
					}
					//统计优惠券数量
					$num=M("tk")->where("tick_id='$id'")->count();
					$val['id']=$id;
					$val['sy']=$num;
					M("tick")->save($val);
					$this->success(L('operation_success'));
				}
			} else {
				$this->error(L('illegal_parameters'));
			}
		}else{
			$this->assign('open_validator', true);
			$this->assign('id',$this->_get('id','intval'));
            if (IS_AJAX) {
                $response = $this->fetch();
                $this->ajaxReturn(1, '', $response);
            } else {
                $this->display();
            }
		}
	}
}
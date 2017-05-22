<?php

class exchangeAction extends frontendAction {

    public function _initialize() {
        parent::_initialize();
        $this->assign('nav_curr', 'exchange');
    }

    /**
     * 积分兑换首页
     */
    public function index() {
        $cid = $this->_get('cid', 'intval');
        $sort = $this->_get('sort', 'trim', 'hot');
		$more = $this->_get('more','trim');
		$p=$this->_get('p','intval') ? $this->_get('p','intval') : 1;
        //排序：最热(hot)，最新(new)
        switch ($sort) {
            case 'hot':
                $sort_order = 'buy_num DESC,id DESC';
                break;
            case 'new':
                $sort_order = 'id DESC';
                break;
        }
        $cname = D('score_item_cate')->get_name($cid);
        $where = array('status'=>'1');
        $cid && $where['cate_id'] = $cid;

        $pagesize=8;
		$start=($p-1)*$pagesize;
		$score_item = M('score_item');
        $count = $score_item->where($where)->count('id');
        $item_list = $score_item->where($where)->order($sort_order)->limit($start.','.$pagesize)->select();
		if($more == 'more'){
			$more_arr="";
			foreach($item_list as $key=>$r){
				$more_arr.="<li><a href='".U('wap/exchange/detail',array('id'=>$r['id']))."' title='".$r['title']."'>";
				$more_arr.="<img src='".attach($r['img'],'score_item')."' title='".$r['title']."' alt='".$r['title']."'/>";
				$more_arr.=$r['title']."<br/>金币 ".$r['coin']."<br/>剩余 ".$r['stock']." 件</a></li>";
			}
			echo $more_arr;
			exit;
		}
        $this->assign('item_list', $item_list);
        $this->assign('cid', $cid);
        $this->assign('sort', $sort);
        $this->assign('cname', $cname);
		$this->assign('count', $count);
		$this->assign('pagesize', $pagesize);
        $this->assign('page_seo',set_seo("礼品兑换"));
        $this->display();
    }

    /**
     * 积分商品详细页
     */
    public function detail() {
        $id = $this->_get('id', 'intval');
        !$id && $this->_404();
        $item_mod = M('score_item');
        $item = $item_mod->field('id,title,img,score,coin,stock,user_num,buy_num,desc')->find($id);
        $exchange_desc = M('article_page')->where(array('cate_id'=>'7'))->getField('info');
        $this->assign('exchange_desc', $exchange_desc);
        $this->assign('item', $item);
		//兑换记录(首页不做分页)
		$list = M("score_order")->where("item_id=$id")->order('add_time desc,id desc')->limit(20)->select();
		foreach($list as $key=>$val){
			$list[$key]['uname']=get_uname($val['uid']);
		}
		$this->assign('list',$list);
		$this->assign('title_h2','积分兑换');
        $this->_config_seo();
        $this->display();
    }

    /**
     * 兑换
     */
    public function ec() {
        !$this->visitor->is_login && $this->ajaxReturn(0, L('login_please'));
        $id = $this->_get('id', 'intval');
        $num = $this->_get('num', 'intval', 1);
        if (!$id || !$num) $this->ajaxReturn(0, L('invalid_item'));
        $item_mod = M('score_item');
        $user_mod = M('user');
        $order_mod = D('score_order');
        $uid = $this->visitor->info['id'];
        $uname = $this->visitor->info['username'];
        $item = $item_mod->find($id);
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        !$item['stock'] && $this->ajaxReturn(0, L('no_stock'));
        //金币够不
        $user_coin = $user_mod->where(array('id'=>$uid))->getField('coin');
        $user_coin < $item['coin'] && $this->ajaxReturn(0, '没有足够的金币');
        //限额
        $eced_num = $order_mod->where(array('uid'=>$uid, 'item_id'=>$item['id']))->sum('item_num');
        if ($item['user_num'] && $eced_num + $num > $item['user_num']) {
            $this->ajaxReturn(0, sprintf(L('ec_user_maxnum'), $item['user_num']));
        }
        $order_coin = $num * $item['coin'];
        $data = array(
            'uid' => $uid,
            'uname' => $uname,
            'item_id' => $item['id'],
            'item_name' => $item['title'],
            'item_num' => $num,
            'order_coin' => $order_coin,
        );
        if (false === $order_mod->create($data)) {
            $this->ajaxReturn(0, L('ec_failed'));
        }
        $order_id = $order_mod->add();
        //扣除用户积分并记录日志
        $user_mod->where(array('id'=>$uid))->setDec('coin', $order_coin);
        $score_log_mod = D('score_log');
        $score_log_mod->create(array(
            'uid' => $uid,
            'uname' => $uname,
            'action' => 'exchange',
            'coin' => $order_coin*-1,
        ));
        $score_log_mod->add();

        //减少库存和增加兑换数量
        $item_mod->save(array(
            'id' => $item['id'],
            'stock' => $item['stock'] - $num,
            'buy_num' => $item['buy_num'] + $num,
        ));
        //返回
        if ($item['type'] == '1') {
            //如果是虚拟商品直接提示
            $this->ajaxReturn(1, L('ec_success'));
        } else {
            //如果是实物则弹窗询问收货地址
            $address_list = M('user_address')->field('id,consignee,address,zip,mobile')->where(array('uid'=>$uid))->select();
            $this->assign('address_list', $address_list);
            $this->assign('order_id', $order_id);
            $resp = $this->fetch('dialog:address');
            $this->ajaxReturn(2, L('please_input_address'), $resp);
        }
    }

    /**
     * 收货地址
     */
    public function address() {
        !$this->visitor->is_login && $this->ajaxReturn(0, L('login_please'));
        $order_id = $this->_post('order_id', 'intval');
        $address_id = $this->_post('address_id', 'intval');
        $consignee = $this->_post('consignee', 'trim');
        $address = $this->_post('address', 'trim');
        $zip = $this->_post('zip', 'trim');
        $mobile = $this->_post('mobile', 'trim');
        if (!$address_id && (!$order_id || !$consignee || !$address || !$mobile)) {
            $this->ajaxReturn(0, L('please_input_address_info'));
        }
        $order_mod = M('score_order');
        if (!$order_mod->where(array('uid'=>$this->visitor->info['id'], 'id'=>$order_id))->count('id')) {
            $this->ajaxReturn(0, L('order_not_foryou'));
        }
        $user_address_mod = M('user_address');
        if ($address_id) {
            $address = $user_address_mod->field('consignee,address,zip,mobile')->find($address_id);
        } else {
            $address = array(
                'uid' => $this->visitor->info['id'],
                'consignee' => $consignee,
                'address' => $address,
                'zip' => $zip,
                'mobile' => $mobile,
            );
            //添加收货地址
            $user_address_mod->add($address);
        }
        $result = $order_mod->save(array(
            'id' => $order_id,
            'consignee' => $address['consignee'],
            'address' => $address['address'],
            'zip' => $address['zip'],
            'mobile' => $address['mobile'],
        ));
        $this->ajaxReturn(1, L('ec_success'));
    }

    /**
     * 积分规则
     */
    public function rule() {
        $info = M('article_page')->find(6);
        $this->assign('info', $info);
        $this->_config_seo();
        $this->display();
    }
}
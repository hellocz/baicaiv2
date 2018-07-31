<?php

class exchangeAction extends frontendAction {

    private $_user = null;

    public function _initialize() {
        parent::_initialize();
        $this->assign('nav_curr', 'exchange');
        if ($this->visitor->is_login) {
            $user = M('user')->find($this->visitor->info['id']);
        }
        $this->_user = $user;
        $this->assign('user', $this->_user);

        $this->item_mod = D('score_item');
        $this->order_mod = D('score_order');
        $this->user_mod = D('user');
    }

    /**
     * 积分兑换首页
     */
    public function index() {    
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}

        $where = array('status'=>'1', 'cate_id' => array('NEQ','8'));
        // $sort_order = 'id DESC';
        $page = array();
        $page['p'] = $p;
        $page['size'] = 2;
        $page['count'] = $this->item_mod->where($where)->count('id');        
        // $pager = $this->_pager($count, $pagesize);
        // $item_list = $this->item_mod->where($where)->order($sort_order)->limit($pager->firstRow.','.$pager->listRows)->select();
        // $this->assign('item_list', $item_list);
        $this->get_score_item_list('exchange', $page['p'], $page['size']);

        // $this->assign('page_bar', $pager->fshow());
        $this->assign('page', $page);
        $this->assign('page_seo',set_seo("礼品兑换"));
        $this->display();
    }

    /**
     * 抽奖页面
     */
    public function lucky() {
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}

        $where = array('status'=>'1');
        $where['cate_id'] = 8;
        $where['win'] = ''; 

        // $pager = $this->_pager($count, 20);
        // $item_list = $this->item_mod->where($where)->order($sort_order)->limit($pager->firstRow.','.$pager->listRows)->select();
        $this->get_score_item_list('lucky', $p, 100);

        $where['win'] = array('NEQ','');
        $page = array();
        $page['p'] = $p;
        $page['size'] = 8;
        $page['count'] = $this->item_mod->where($where)->count('id');
        // $expired_item_list = $this->item_mod->where($where)->order($sort_order)->limit(5)->select();
        $this->get_score_item_list('lucky_expired', $page['p'], $page['size']);

        //右边最新中奖名单
        $this->right_lucky_item();

        // $this->assign('page_bar', $pager->fshow());
        $this->assign('page', $page);
        $this->assign('page_seo',set_seo("礼品兑换"));
        $this->display();
    }


    /**
     * 积分商品详细页
     */
    public function detail() {
        $id = $this->_get('id', 'intval');
        !$id && $this->_404();

        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}

        $item = $this->item_mod->get_info($id);
        !$item && $this->error('该信息不存在或已删除');
        // 中奖用户ID 
        if($item['win'] != ""){
            $order = $this->order_mod->get_lucky_score_order($item['id'], $item['win']);
            $item['uid'] = $order['uid'];
        }
        $this->assign('item', $item);        

        //兑换记录(首页不做分页)
        $page = array();
        $page['count'] = $this->order_mod->where("item_id=$id")->count('id');
        $page['size'] = 20;
        $page['p'] = $p;
        $this->get_score_order_list($id, $page['p'], $page['size']);

        $expire = 0; //未开奖
        if($item['win'] != ""){ //已开奖
            $expire = 2;
        }else if($item['sign_date'] < time()){ //等待开奖
            $expire = 1;
        }

        //右边最新中奖名单
        $this->right_lucky_item();

        $this->assign('expire',$expire);
        $this->assign('page', $page);
        $this->_config_seo();
        $this->display();
    }

    /**
     * 积分兑换&抽奖列表，ajax分页请求
     */
    public function get_score_item_list($t = 'exchange', $p = 1, $pagesize = 8) {
        if (IS_AJAX) {
            $t = $this->_get('t', 'trim');
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 8);
        }
        if($p<1){$p=1;}
        if($pagesize<1){$pagesize=8;}

        $order = 'sign_date DESC,id DESC';
        $limit = $pagesize*($p-1) . ',' . $pagesize;
        $item_list = $this->item_mod->score_item_list($t, $limit, $order);

        // 中奖用户ID 
        if($t == 'lucky_expired' && count($item_list)>0){
            foreach ($item_list as $key => $val) {
                $order = $this->order_mod->get_lucky_score_order($val['id'], $val['win']);
                $item_list[$key]['uid'] = $order['uid'];
            }
        }

        $this->assign("{$t}_item_list", $item_list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("{$t}_item_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    /**
     * 积分兑换/抽奖详情页：兑换/抽奖记录，ajax分页请求
     */
    public function get_score_order_list($id = '', $p = 1, $pagesize = 20) {
        if (IS_AJAX) {
            $id = $this->_get('id', 'trim');
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 20);
        }
        if($p<1){$p=1;}
        if($pagesize<1){$pagesize=20;}
        !$id && IS_AJAX && $this->ajaxReturn(0, '信息不存在或已删除');
        !$id && $this->_404();

        $item = $this->item_mod->get_info($id);
        !$item && IS_AJAX && $this->ajaxReturn(0, '信息不存在或已删除');
        !$item && $this->error('该信息不存在或已删除');

        //抽奖/兑换记录
        $where = "item_id=$id";
        $order = 'add_time desc,id desc';
        $limit = $pagesize*($p-1) . ',' . $pagesize;
        $list = $this->order_mod->score_order_list($where, $limit, $order);
        foreach($list as $key=>$val){
            $list[$key]['uname']=get_uname($val['uid']);
            if($item['cate_id'] == 8 ){
                if( $item['sign_date'] !=""){
                    if($item['sign_date'] >time()){
                        $list[$key]['zero_info'] = "未开奖";
                    }
                    else{
                        if($item['win'] !="" && $list[$key]['luckdraw_num'] == $item['win']){
                            $list[$key]['zero_info'] = "中奖";
                        }
                        else{
                            $list[$key]['zero_info'] = "未中奖";
                        }

                    }
                }
            }
        }

        $this->assign('order_list',$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $this->assign('item', $item);    
            $data = array(
                'list' => $this->fetch("order_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    /**
     * 页面右边-最新中奖名单（积分抽奖、积分抽奖详情页）
     */
    public function right_lucky_item(){
        $limit = 10;
        $sort_order = 'sign_date DESC,id DESC';
        $item_list = $this->item_mod->score_item_list('lucky_expired');

        $this->assign('right_lucky_item_list', $item_list);
    }

    /**
     * 兑换
     */
    public function ec() {
        !$this->visitor->is_login && $this->ajaxReturn(0, L('login_please'));
        $id = $this->_get('id', 'intval');
        $num = $this->_get('num', 'intval', 1);
        if (!$id || !$num) $this->ajaxReturn(0, L('invalid_item'));
        $uid = $this->visitor->info['id'];
        $uname = $this->visitor->info['username'];
        $mobile = $this->user_mod->field('mobile')->find($uid);
        if($mobile['mobile'] ==""){
            $this->ajaxReturn(0, '没有绑定手机号，<a href="'. U("user/phone_bind") .'" target="_blank" class=fc-green>绑定我的手机号</a>');
        }
       
        $item = $this->item_mod->get_info($id);
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        $item['sign_date']<time() && $this->ajaxReturn(0,"抽奖已过期,不能再兑换,请关注其他抽奖商品");
        !$item['stock'] && $this->ajaxReturn(0, L('no_stock'));
        //金币够不
        $order_coin = $num * $item['coin'];
        $order_score = $num * $item['score'];

        $user_cf = $this->user_mod->where(array('id'=>$uid))->field('coin,score')->find();
        $user_cf['coin'] < $order_coin && $this->ajaxReturn(0, '没有足够的金币' );
        $user_cf['score'] < $order_score && $this->ajaxReturn(0, '没有足够的积分' );
        //限额
        $eced_num = $this->order_mod->where(array('uid'=>$uid, 'item_id'=>$item['id']))->sum('item_num');

        $luck_num = $this->order_mod->where(array('item_id'=>$item['id']))->sum('item_num');
        if ($item['user_num'] && $eced_num + $num > $item['user_num']) {
            $this->ajaxReturn(0, sprintf(L('ec_user_maxnum'), $item['user_num']));
        }

        $data = array(
            'uid' => $uid,
            'uname' => $uname,
            'item_id' => $item['id'],
            'item_name' => $item['title'],
            'item_num' => $num,
            'order_coin' => $order_coin,
            'order_score' => $order_score,
        );
        if($item['cate_id'] == 8){
            $data['order_coin'] = $item['coin'];
            $data['order_score'] = $item['score'];
            $data['item_num'] = 1;
            for ($x=1; $x<=$num; $x++) {
                 $data['luckdraw_num'] = ++$luck_num;
                if (false === $this->order_mod->create($data)) {
                    $this->ajaxReturn(0, L('ec_failed'));
                }
                $order_id = $this->order_mod->add();
            } 
            // $this->ajaxReturn(0, '进入抽奖兑换');
        }
        else{
            if (false === $this->order_mod->create($data)) {
                $this->ajaxReturn(0, L('ec_failed'));
            }
            $order_id = $this->order_mod->add();
        }
        //扣除用户积分并记录日志
        $this->user_mod->where(array('id'=>$uid))->setDec('coin', $order_coin);
        $this->user_mod->where(array('id'=>$uid))->setDec('score', $order_score);
        $score_log_mod = D('score_log');
        $score_log_mod->create(array(
            'uid' => $uid,
            'uname' => $uname,
            'action' => 'exchange',
            'coin' => $order_coin*-1,
            'score' => $order_score*-1,
        ));
        $score_log_mod->add();

        //减少库存和增加兑换数量
        $this->item_mod->save(array(
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
        if (!$this->order_mod->where(array('uid'=>$this->visitor->info['id'], 'id'=>$order_id))->count('id')) {
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
        $result = $this->order_mod->save(array(
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

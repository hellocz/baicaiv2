<?php
class luckyAction extends userbaseAction
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

    /**
     * 我的抽奖
     */
    public function myluckys() {
        $userid = $data['userid'];
        empty($data['pagesize']) && $data['pagesize'] = 10;
        $page = $data['page'] * $data['pagesize'];
        $map['uid'] = $userid;
        $score_order_mod = M('score_order');
        $map['luckdraw_num'] = array('NEQ','');
        $order_list = $score_order_mod->field('id,order_sn,item_id,item_name,order_score,order_coin,status,add_time,remark,luckdraw_num')->where($map)->limit($page-$data['pagesize'], $data['pagesize'])->order('id DESC')->select();
         $code = 10001;
         if(count($order_list) < 1){
            $code = 10002;
        }
        echo get_result($code,$order_list);return ;
    }

    /**
     * 抽奖详情页
     */
    public function lucky_list() {
        $where['cate_id'] = 8;
        $where['win'] = '';
        empty($data['pagesize']) && $data['pagesize'] = 10;
       
        $sort_order = 'sign_date DESC';
        $score_item = M('score_item');->where($where)->order($sort_order)->limit($page-$data['pagesize'], $data['pagesize'])->select();
         $code = 10001;
         if(count($score_item) < 1){
            $code = 10002;
        }
        echo get_result($code,$score_item);return ;
    }

    /**
     * 积分商品详细页
     */
    public function exchange_detail() {
        $id = $data['id'];
        $item_mod = M('score_item');
        $item = $item_mod->field('id,title,img,score,coin,stock,user_num,buy_num,desc,cate_id,win,sign_date')->find($id);

        $list = M("score_order")->where("item_id=$id")->order('add_time desc')->select();
        $item['list'] = $list;
        $code = 10001;
        echo get_result($code,$item);return ;

    }
    /**
     * 往期抽奖详情页
     */
    public function lucky_list_past() {
        $where['cate_id'] = 8;
        $where['win'] = array('NEQ','');
        empty($data['pagesize']) && $data['pagesize'] = 10;
        $page = $data['page'] * $data['pagesize'];
        $sort_order = 'sign_date DESC';
        $score_item = M('score_item');->where($where)->order($sort_order)->limit($page-$data['pagesize'], $data['pagesize'])->select();
        $code = 10001;
        if(count($score_item) < 1){
            $code = 10002;
        }
        echo get_result($code,$score_item);return ;
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
        $mobile = M("user")->field('mobile')->find($uid);
        if($mobile['mobile'] ==""){
            $this->ajaxReturn(0, '没有绑定手机号' . $mobile['mobile'] );
        }
       
        $item = $item_mod->find($id);
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        $item['sign_date']<time() && $this->ajaxReturn(0,"抽奖已过期,不能再兑换,请关注其他抽奖商品");
        !$item['stock'] && $this->ajaxReturn(0, L('no_stock'));
        //金币够不
        $order_coin = $num * $item['coin'];
        $order_score = $num * $item['score'];

        $user_cf = $user_mod->where(array('id'=>$uid))->field('coin,score')->find();
        $user_cf['coin'] < $order_coin && $this->ajaxReturn(0, '没有足够的金币' );
        $user_cf['score'] < $order_score && $this->ajaxReturn(0, '没有足够的积分' );
        //限额
        $eced_num = $order_mod->where(array('uid'=>$uid, 'item_id'=>$item['id']))->sum('item_num');

        $luck_num = $order_mod->where(array('item_id'=>$item['id']))->sum('item_num');
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
                if (false === $order_mod->create($data)) {
                    $this->ajaxReturn(0, L('ec_failed'));
                }
                $order_id = $order_mod->add();
            } 
        //    $this->ajaxReturn(0, '进入抽奖兑换');
        }
        else{
        if (false === $order_mod->create($data)) {
            $this->ajaxReturn(0, L('ec_failed'));
        }
        $order_id = $order_mod->add();
        }
        //扣除用户积分并记录日志
        $user_mod->where(array('id'=>$uid))->setDec('coin', $order_coin);
         $user_mod->where(array('id'=>$uid))->setDec('score', $order_score);
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


}

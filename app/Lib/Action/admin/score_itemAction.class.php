<?php

class score_itemAction extends backendAction
{

    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('score_item');
        $this->_cate_mod =D('score_item_cate');
    }

    public function _before_index() {
        //默认排序
        $this->sort = 'sign_date';
        $this->order = 'desc';

        $res = $this->_cate_mod->field('id,name')->select();
        $cate_list = array();
        foreach ($res as $val) {
            $cate_list[$val['id']] = $val['name'];
        }
        $this->assign('cate_list', $cate_list);
    }

    protected function _search() {
        $map = array();
        ($cate_id = $this->_request('cate_id', 'trim')) && $map['cate_id'] = array('eq', $cate_id);
        ($keyword = $this->_request('keyword', 'trim')) && $map['title'] = array('like', '%'.$keyword.'%');
        $this->assign('search', array(
            'keyword' => $keyword,
            'cate_id' => $cate_id,
        ));
        return $map;
    }

    public function _before_add() {
        $cate_list = $this->_cate_mod->field('id,name')->select();
        $this->assign('cate_list',$cate_list);
    }

    public function _before_edit() {
        $this->_before_add();
    }

    protected function _before_insert($data) {
        $data['sign_date']=strtotime($_POST['sign_date']);
        //上传图片
        if (!empty($_FILES['img']['name'])) {
            $time_dir = date('ym/d/');
            $result = $this->_upload($_FILES['img'], 'score_item/' . $time_dir, array(
                'width' => C('pin_score_item_img.swidth').','.C('pin_score_item_img.bwidth'),
                'height' => C('pin_score_item_img.sheight').','.C('pin_score_item_img.bheight'),
                'suffix' => '_s,_b',
                'remove_origin' => true
            ));
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                //$data['img'] = $time_dir .'/'. str_replace('.' . $ext, '_s.' . $ext, $result['info'][0]['savename']);
				$data['img'] = get_rout_img($time_dir .$result['info'][0]['savename'],'score_item');
            }
        }
        return $data;
    }

    protected function _before_update($data) {
        $data['sign_date']=strtotime($_POST['sign_date']);
        if (!empty($_FILES['img']['name'])) {
            $time_dir = date('ym/d/');
            //删除原图
            $old_img = $this->_mod->where(array('id'=>$data['id']))->getField('img');
            $old_img = 'score_item/' . $time_dir . $old_img;
            is_file($old_img) && @unlink($old_img);
            //上传新图
            $result = $this->_upload($_FILES['img'], 'score_item/' . $time_dir, array(
                'width' => C('pin_score_item_img.swidth').','.C('pin_score_item_img.bwidth'),
                'height' => C('pin_score_item_img.sheight').','.C('pin_score_item_img.bheight'),
                'suffix' => '_s,_b',
                'remove_origin' => true
            ));
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                //$data['img'] = $time_dir .'/'. str_replace('.' . $ext, '_s.' . $ext, $result['info'][0]['savename']);
				$data['img'] = get_rout_img($time_dir .$result['info'][0]['savename'],'score_item');
            }
        } else {
            unset($data['img']);
        }

        return $data;
    }

    public function get_latest_lottery(){
     $filename = "http://f.apiplus.net/pl5-1.json";
     $json_string = file_get_contents($filename);
     $data = json_decode($json_string, true);
     $lottery = $data['data'][0]['opencode'];
     $lottery = str_replace(",","",$lottery);
     $this->ajaxReturn(1,"最新福彩开奖号码",$lottery);        //打印文件的内容
     
    }

    public function computer_lucky_num(){
        $id = $this->_get('id');
        $lottery = $this->_get('lottery', 'intavl');
        $buy_num = $this->_get('buy_num', 'intavl');
        if ($lottery == "" || $buy_num =="")
           { $this->ajaxReturn(0, L('operation_failure'));}
        $win = $lottery%$buy_num +1;

        $order = M("score_order")->where(array('item_id'=>$id,'luckdraw_num'=>$win))->find();

        $order['win'] = $win;

        if($order['mobile'] == null){
            $where['item_id'] = $id;
            $where['uname'] = $order['uname'];
            $where['mobile'] = array("NEQ",'');
            $order_addtion = M("score_order")->where($where)->find();
            $order['consignee'] = $order_addtion['consignee'];
            $order['address'] = $order_addtion['address'];
            $order['zip'] = $order_addtion['zip'];
            $order['mobile'] = $order_addtion['mobile'];
        }

        $this->ajaxReturn(1,"中奖相关信息",$order); 

    }
}
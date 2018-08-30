<?php

class messageAction extends userbaseAction {

    /**
     * 网友消息（私信）
     */
    public function index() {
        $uid = $this->visitor->info['id'];
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}
        $pagesize = 10;

        //以人为单位 查找与我对话的人
        $count = D('message')->talk_count($uid);

        //用户对话列表
        if($count > 0){
            $this->get_talk_list($uid, $p, $pagesize);

            //清除私信新消息提示
            D('user_msgtip')->clear_tip($uid, 3);
        }

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count, 
            'url'=>'/index.php?m=message&a=get_talk_list&uid='.$uid,
        );
        $this->assign('page', json_encode($page));
        $this->assign('page_seo',set_seo('网友消息'));
        $this->display();

    }

    /**
     * 系统消息列表 - AJAX翻页请求
     */
    public function get_talk_list($uid = 0, $p = 1, $pagesize = 10) {
        if (IS_AJAX) {
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');          
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 10);
        }
        if($p<1){$p=1;}

        $limit = $pagesize*($p-1) . ',' . $pagesize;        
        $list=D("message")->talk_list($uid, $limit);
        $this->assign("talk_list",$list);

        //关注
        $follows = D("user_follow")->user_follow_ids($uid);
        $this->assign("follows",$follows);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("talk_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    /**
     * 系统通知
     */
    public function system() {
        $uid = $this->visitor->info['id'];
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}
        $pagesize = 10;

        //用户系统消息数
        $count = D("message")->system_count($uid);

        //用户系统消息列表
        if($count > 0){
            $this->get_system_list($uid, $p, $pagesize);

            //清除系统新消息提示
            D('user_msgtip')->clear_tip($uid, 4);
            //更新系统消息查看状态为已查看
            D('message')->set_system_ck_status($uid, 1);
            //更新用户未读消息数
            D('message')->set_unread_message_num($uid);
        }

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count, 
            'url'=>'/index.php?m=message&a=get_system_list&uid='.$uid,
        );
        $this->assign('page', json_encode($page));
        $this->assign('page_seo',set_seo('系统消息'));
        $this->display();
    }

    /**
     * 系统消息列表 - AJAX翻页请求
     */
    public function get_system_list($uid = 0, $p = 1, $pagesize = 10) {
        if (IS_AJAX) {
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');          
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 10);
        }
        if($p<1){$p=1;}

        $limit = $pagesize*($p-1) . ',' . $pagesize;        
        $list=D("message")->system_list($uid, $limit);
        $this->assign("system_list",$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("system_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    /**
     * 订阅消息 - TODU
     */
    public function subscription() {
        $this->display();
    }

    /**
     * 消息详细
     */
    public function talk() {
        $ftid = $this->_get('ftid');
        $uid = $this->visitor->info['id'];

        // //更新状态
        // $map = "ftid='".$ftid."' AND ((from_id = '".$uid."' AND status<>2) OR (to_id = '".$uid."' AND status<>3))";
        // $message_mod->where($map)->setField('status', 0);

        //显示列表
        $message_list = D('message')->message_list($ftid, $uid, ''); 
        $ta_id = $ftid - $uid; 
        ($ta_id <= 0 || $ta_id == $uid) && $this->_404();
        $ta_name = D('user')->get_field($ta_id, 'username'); 
        !$ta_name && $this->_404();

        //更新对话接收者的消息查看状态为已查看
        D('message')->set_message_ck_status($ftid, $uid, 1);
        //更新用户未读消息数
        D('message')->set_unread_message_num($uid);

        $this->assign('message_list', $message_list);
        $this->assign('ta_id', $ta_id);
        $this->assign('ta_name', $ta_name);
        $this->assign('ftid', $ftid);
        $this->assign('page_seo',set_seo("网友消息"));
        $this->display();
    }

    /**
     * 发布消息
     */
    public function publish() {
        $uid= $this->visitor->info['id'];
        $to_id = $this->_post('to_id', 'intval');
        $content = $this->_post('content', 'trim');
        $to_name = D('user')->get_field($to_id, 'username');
        $ftid = $uid + $to_id;
        $data = array(
            'ftid' => $ftid,
            'from_id' => $uid,
            'from_name' => $this->visitor->info['username'],
            'to_id' => $to_id,
            'to_name' => $to_name,
            'info' => $content,
            'add_time' => time(),
        );

        //发布消息
        $message_mod = D('message');
        $info = $message_mod->publish($data);
        if ($info) {
            $this->assign('message_list', array($info));
            $resp = $this->fetch('message_list');
            $this->ajaxReturn(1, '', $resp);
        } else {
            $this->ajaxReturn(0, $message_mod->getError());
        }
    }

    /**
     * 选择发送目标
     */
    public function target() {
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}
        $pagesize=20;   
        $uid = $this->visitor->info['id'];

        $count = array();
        $count['contacts'] = D("message")->user_contact_count($uid);//最近联系人 
        $count['follows'] = D("user_follow")->user_follow_count($uid);//关注的用户 
        $count['fans'] = D("user_follow")->user_fans_count($uid);//粉丝 

        //列表
        $target_contact_list = $this->get_target_list('contacts', $uid, $p, $pagesize);
        $target_follow_list = $this->get_target_list('follows', $uid, $p, $pagesize);
        $target_fans_list = $this->get_target_list('fans', $uid, $p, $pagesize);
        // print_r($target_follow_list);exit;
        $this->assign('target_contact_list', $target_contact_list);
        $this->assign('target_follow_list', $target_follow_list);
        $this->assign('target_fans_list', $target_fans_list);
        
        $page = array();
        $page['contacts'] = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count['contacts'], 
            'url'=>"/index.php?m=message&a=get_target_list&t=contacts&uid={$uid}",
        );
        $page['follows'] = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count['follows'], 
            'url'=>"/index.php?m=message&a=get_target_list&t=follows&uid={$uid}",
        );
        $page['fans'] = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count['fans'], 
            'url'=>"/index.php?m=message&a=get_target_list&t=fans&uid={$uid}",
        );
        $this->assign('count', $count);
        $this->assign('t', $t);
        $this->assign('page_contacts', json_encode($page['contacts']));
        $this->assign('page_follows', json_encode($page['follows']));
        $this->assign('page_fans', json_encode($page['fans']));
        $this->_config_seo();
        $this->display();
    }

    /**
     * 我关注的用户 - AJAX翻页请求
     */
    public function get_target_list($t = 'fans', $uid = 0, $p = 1, $pagesize = 10) {
        if (IS_AJAX) {
            $t = $this->_get('t',"trim");
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');          
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 10);
        }
        if($p<1){$p=1;}

        $limit = $pagesize*($p-1) . ',' . $pagesize;
        switch ($t) {
            case 'contacts':
                $list=D('message')->user_contact_list($uid, $limit);
                break;  
            case 'follows':
                $list=D("user_follow")->user_follow_list($uid, $limit);
                break;
            case 'fans':            
                $list=D("user_follow")->user_fans_list($uid, $limit);                
                break;
            default:
                $list = array();
                break;
        }

        //AJAX分页请求
        if (IS_AJAX) {
            $this->assign("target_list",$list);
            $data = array(
                'list' => $this->fetch("target_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }else{
            return $list;
        }
    }

    /**
     * 搜索用户
     */
    public function search_target() {
        $search_uname = $this->_post('search_uname', 'trim');
        !$search_uname && $this->ajaxReturn(0, '');
        $uid = $this->visitor->info['id'];

        $where = array('username'=>array('like', '%'.$search_uname.'%'));
        $user_list = D('user')->user_list($where, 'id,username,img_url', '0,10');
        if(count($user_list) > 0){
            foreach ($user_list as $key => $val) {
                $user_list[$key]['ftid'] = $val['id'] + $uid;
                $user_list[$key]['img_url'] = avatar_img($val['img_url'],64);
            }
        };
        $resp = $user_list;
        $this->ajaxReturn(1, '', $resp);
    }

    // /**
    //  * 写信
    //  */
    // public function write() {
    //     $ta_id = $this->_get('to_id', 'intval');
    //     !$ta_id && $this->_404();
    //     $ta_name = M('user')->where(array('id'=>$ta_id))->getField('username');
    //     $this->assign('ta_id', $ta_id);
    //     $this->assign('ta_name', $ta_name);
    //     $this->_config_seo();
    //     $this->display();
    // }

    /**
     * 发布
     */
    public function report_bug() {
        $uid= $this->visitor->info['id'];
        foreach ($_POST as $key=>$val) {
            $_POST[$key] = Input::deleteHtmlTags($val);
        }
        $to_id = $this->_post('to_id', 'intval');
        $content = $this->_post('content', 'trim');
        if (!$content) {
            $this->ajaxReturn(0, L('message_content_empty'));
        }
        $to_name = M('user')->where(array('id'=>$to_id))->getField('username');
        $ftid = $this->visitor->info['id'] + $to_id;
        $data = array(
            'ftid' => $ftid,
            'from_id' => $this->visitor->info['id'],
            'from_name' => $this->visitor->info['username'],
            'to_id' => $to_id,
            'to_name' => $to_name,
            'info' => $content,
        );
        $message_mod = D('message');
        $info = $message_mod->create($data);
        $info['id'] = $message_mod->add();
        if ($info['id']) {
            //提示接收者
            D('user_msgtip')->add_tip($to_id, 3);
            M("user")->where("id=$uid")->setInc("score",1);
            //积分日志
            set_score_log(array('id'=>$uid,'username'=>$this->visitor->info['username']),'report_bug',1,'','','');
            $this->assign('info', $info);
            $resp = $this->fetch('list_unit');
            $this->ajaxReturn(1, L('send_message_success'), $resp);
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }

    // /**
    //  * 删除短信
    //  */
    // public function del() {
    //     $data=array();
    //     $data['mid'] = $this->_get('mid', 'intval');
    //     $message_mod = D('ssb');
    //     $data['uid'] = $this->visitor->info['id'];
    //     $data['type'] = 1;
    //     $r = $message_mod->add($data);
    //     if ($r) {
    //         $this->ajaxReturn(1, L('delete_message_success'));
    //     } else {
    //         $this->ajaxReturn(0, L('delete_message_failed'));
    //     }
    // }

    /**
     * 删除整个对话
     */
    public function del_talk() {
        $ftid = $this->_get('ftid', 'intval');
        !$ftid && $this->ajaxReturn(0, L('delete_message_failed'));
        $message_mod = D('message');
        $mid_arr = $message_mod->get_message_ids($ftid, $this->visitor->info['id']);
        $result = $message_mod->user_delete($mid_arr, $this->visitor->info['id']);
        //更新用户未读消息数
        D('message')->set_unread_message_num($uid);
        $this->ajaxReturn(1, L('delete_message_success'));
    }

    /**
     * 删除所有对话
     */
    public function del_all() {
        $uid= $this->visitor->info['id'];
        $message_mod = D('message');
        $mid_arr = $message_mod->get_message_ids(0, $uid);
        $message_mod->user_delete($mid_arr, $uid);
        //更新用户未读消息数
        D('message')->set_unread_message_num($uid);
        $this->ajaxReturn(1, L('delete_message_success'));
    }

    /**
     * 全部标记为已读
     */
    public function read_all() {
        $uid= $this->visitor->info['id'];
        //更新对话接收者的消息查看状态为已读
        D('message')->set_message_ck_status(0, $uid, 1);
        //更新用户未读消息数
        D('message')->set_unread_message_num($uid);
        $this->ajaxReturn(1, '');
    }

}
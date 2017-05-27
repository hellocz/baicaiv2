<?php

/*
* 用户类
* Created by PhpStorm.
* Author: 初心 [jialin507@foxmail.com]
* Date: 2017/4/11
*/

/**
 * mobile 18569555555
 * uid 192795
 * password 123456
 * Class userAction
 */
class userAction extends userbaseAction
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
     * 用户注册
     * @param $data
     */
    public function register($data) {
            //封IP start
            $kill_ip=C('pin_kill_ip');
            $kill_ip = explode("\n",$kill_ip);
            $myip = get_client_ip();
            if(in_array($myip,$kill_ip)){
                echo get_result(20001,[], '您的IP已被禁用');return ;
            }
            //封IP end
            $data['username'] = $data['mobile'];
            $data['email'] = '0@0.c';
            $data['gender'] = 0;
            $smscode = M('smscode')->where(['mobile'=>$data['mobile']])->find();
            if($smscode){
                if($smscode['out_time'] < time()){
                    echo get_result(20001,[], "验证码超时");return ;
                }
                if($data['captcha'] != $smscode['code']){
                    echo get_result(20001,[], "验证码错误");return ;
                }
            }else{
                echo get_result(20001,[], "未请求验证码");return ;
            }

            //方式
//            $type = $this->_post('type', 'trim', 'reg');
//            if ($type == 'reg') {
//                //验证
//                $agreement = $this->_post('agreement');
//                !$agreement && $this->error(L('agreement_failed'));
//
//                $captcha = $this->_post('captcha', 'trim');

//            }

//            if ($data['password'] != $data['repassword']) {
//                echo get_result(20001,[], "两次输入的密码不一致");return ;
//            }

//            //用户禁止
//            $ipban_mod = D('ipban');
//            $ipban_mod->clear(); //清除过期数据
//            $is_ban = $ipban_mod->where("(type='name' AND name='".$data['username']."') OR (type='email' AND name='".$data['email']."')")->count();
//            if($is_ban){
//                echo get_result(20001,[], '您的帐号或邮箱被禁止注册');return ;
//            }
            //连接用户中心
            $passport = $this->_user_server();


            //注册
            $uid = $passport->register($data['username'], $data['password'], $data['email'], $data['gender']);
            if(!$uid){
                echo get_result(20001,[],get_user_lang(strtolower($passport->get_error())));return ;
            }
            M('smscode')->where(['mobile'=>$data['mobile']])->delete();
            echo get_result();
//        $data['mobile']

//            //是否通过朋友分享注册的
//            if(trim($_SESSION['tg'])!=''){
//                $suid = M("user")->field('try_user.*')->join("try_share as s on s.uid=try_user.id")->where("s.dm='$_SESSION[tg]'")->find();
//                //查找一天是否超过5次
//                $time=time();
//                $start=strtotime(date('Y-m-d',$time));
//                $end = strtotime(date('Y-m-d',$time))+24*3600;
//                $count = M("score_log")->where("add_time>$start and $end>add_time and uid=$suid[id] and action='share_register'")->count();
//                if($count<5){
//                    //给用户加积分
//                    M("user")->where("id=$suid[id]")->setField(array("coin"=>$suid['coin']+5,"offer"=>$suid['offer']+5,'score'=>$suid['score']+5,'exp'=>$suid['exp']+5));
//                    //积分日志
//                    set_score_log(array('id'=>$suid['id'],'username'=>$suid['username']),'share_register',5,5,5,5);
//                }
//            }
            //第三方帐号绑定
//            if (cookie('user_bind_info')) {
//                $user_bind_info = object_to_array(cookie('user_bind_info'));
//                $oauth = new oauth($user_bind_info['type']);
//                $bind_info = array(
//                    'pin_uid' => $uid,
//                    'keyid' => $user_bind_info['keyid'],
//                    'bind_info' => $user_bind_info['bind_info'],
//                );
//                $oauth->bindByData($bind_info);
//                //临时头像转换
//                $this->_save_avatar($uid, $user_bind_info['temp_avatar']);
//                //清理绑定COOKIE
//                cookie('user_bind_info', NULL);
//            }
//            //注册完成钩子
//            $tag_arg = array('uid'=>$uid, 'uname'=>$data['username'], 'action'=>'register');
//            tag('register_end', $tag_arg);
//            //登陆
//            $this->visitor->login($uid);
//            //登陆完成钩子
//            $tag_arg = array('uid'=>$uid, 'uname'=>$data['username'], 'action'=>'login');
//            tag('login_end', $tag_arg);
//            //同步登陆
//            $synlogin = $passport->synlogin($uid);
//            $this->success(L('register_successe').$synlogin, U('user/index'));


    }

    /**
     * 获取手机验证码
     */
    public function smscode($data) {
        $code = '123456';

        $smscode = M('smscode')->where(['mobile'=>$data['mobile']])->find();
        if($smscode){
            $res = M('smscode')->where(['mobile'=>$data['mobile']])->save(['code'=>$code,'out_time'=>time()+600]);
        }else{
            $res = M('smscode')->add(['mobile'=>$data['mobile'],'code'=>$code,'out_time'=>time()+600]);
        }
        if($res){
            echo get_result(10001,['code'=>$code]);
        }else{
            echo get_result(20001, [], "未知错误");
        }
    }

    /**
     * 用户登陆
     */
    public function login($data) {
        //封IP start
        $kill_ip=C('pin_kill_ip');
        $kill_ip = explode("\n",$kill_ip);
        $myip = get_client_ip();
        if(in_array($myip,$kill_ip)){
            echo get_result(20001,[], '您的账户已被禁用');return ;
        }
        //封IP end
        if (empty($data['mobile'])) {
            echo get_result(20001,[], '用户名不能为空');return ;
        }
        if (empty($data['password'])) {
            echo get_result(20001,[], '密码不能为空');return ;
        }
        //连接用户中心
        $passport = $this->_user_server();
        $uid = $passport->auth($data['mobile'], $data['password']);
        if (!$uid) {
            echo get_result(20001,[], '账号或密码错误');return ;
        }
        $userinfo = $passport->get($uid);
        $info = [
            'userid'    =>  $userinfo['id'],
            'username'    =>  $userinfo['username'],
            'gender'    =>  $userinfo['gender'],
            'score'    =>  $userinfo['score'],
        ];

        //登陆
//        $this->visitor->login($uid, $remember);
        echo get_result(10001,$info);
    }

    /**
     * 重置密码
     */
    public function resetpassword($data) {
        $passlen = strlen($data['password']);
        if ($passlen < 6 || $passlen > 20) {
            echo get_result(20001,[], '密码长度不能小于6或大于20');return ;
        }

        $user = M('user')->field('id')->where(array('username'=>$data['mobile']))->find();
        if(!$user){
            echo get_result(20001,[], "手机号码未注册");return ;
        }

        $smscode = M('smscode')->where(['mobile'=>$data['mobile']])->find();

        if($smscode){
            if($smscode['out_time'] < time()){
                echo get_result(20001,[], "验证码超时");return ;
            }
            if($data['captcha'] != $smscode['code']){
                echo get_result(20001,[], "验证码错误");return ;
            }
        }else{
            echo get_result(20001,[], "未请求验证码");return ;
        }

        $wp_hasher = new PasswordHash(8, TRUE); //验证加密
        if (isset($data['password'])) {
            $sigPassword = $wp_hasher->HashPassword($data['password']);
            $data['password'] = $sigPassword;
        }
        $result = M('user')->field('id')->where(array('username'=>$data['mobile']))->save(['password'=>$data['password']]);
        if (!$result) {
            echo get_result(20001,[], '未知错误');return ;
        }
        M('smscode')->where(['mobile'=>$data['mobile']])->delete();
        echo get_result();
    }

    /**
     * 获取用户头像
     */
    public function getimg($data) {
        $img = avatar($data['userid'],'32');
        echo get_result(10001,$img);
    }

    //改变收货地址
    public function setaddress($data) {
        $user_address_mod = M('user_address');
        $userid = $data['userid'];
        $id = $data['addressid']; //编辑地址id
        $type = $data['type']; //新增修改删除

        if ($type == 'del') {
            $user_address_mod->where(array('id'=>$id, 'uid'=>$userid))->delete();
            echo get_result(10001,'删除成功!');
            return ;
        }


        $consignee = $data['consignee'];
        $address = $data['address'];
        $zip = $data['zip'];
        $mobile = $data['mobile'];

        if ($type == 'edit') {
            $result = $user_address_mod->where(array('id'=>$id, 'uid'=>$userid))->save(array(
                'consignee' => $consignee,
                'address' => $address,
                'zip' => $zip,
                'mobile' => $mobile,
            ));
            if ($result) {
                echo get_result(10001,'修改成功!');
            } else {
                echo get_result(10001,'修改失败!');
            }
        }

        if ($type == 'add') {
            $result = $user_address_mod->add(array(
                'uid' => $userid,
                'consignee' => $consignee,
                'address' => $address,
                'zip' => $zip,
                'mobile' => $mobile,
            ));
            if ($result) {
                echo get_result(10001, '新增成功!');
            } else {
                echo get_result(10001, '新增失败!');
            }

        }
    }

    //查询收货地址
    public function getaddress($data)
    {
        $user_address_mod = M('user_address');
        $userid = $data['userid'];
        $address_list = $user_address_mod->where(array('uid'=>$userid))->field(['id','consignee','zip','mobile','address'])->select();

        echo get_result(10001,$address_list);
    }


    //用户等级
    public function grade($data){
        $page = $data['page'] * 10;
        $t='score';
        $pagesize=10;
        //经验值、等级
        $user = M("user")->field('id,score,exp')->where(['id'=>$data['userid']])->find();
        $grade_mod = M("grade");
        $log_mod = M("score_log");
        $user['grade'] = $grade_mod->where("min<=$user[exp] and max>=$user[exp]")->getField("grade");
        if($t=='score'){
            //积分变更

            $jf_list = $log_mod->where("uid=$user[id] and score<>0")
                ->field('action,score,add_time')
                ->order("add_time desc")
                ->limit($page-10, $pagesize)
                ->select();

            $code = 10001;
            if(count($jf_list) < 1){
                $code = 10002;
            }
            echo get_result($code,['grade'=>$user['grade'],'score'=>$user['score'],'jf_list'=>$jf_list]);return ;

        }
    }


    //签到
    public function sign($data){
        $mod = M("user");
        //查询是否已签到
        $user = $mod->where("id=".$data['userid'])->find();
        $time = time();
        $signtime=$user['sign_date'];
        $ds=intval(($time-$signtime)/86400); //60s*60min*24h
        $data['id']=$user['id'];
        $data['sign_date']=$time;
        if($ds>1){//如果大于1，则签到清零+1,积分+5
            $data['score']=$user['score']+5;
            $data['exp']=$user['exp']+5;
            $data['sign_num']=1;
            $data['all_sign']=$user['all_sign']+1;
            $mod->save($data);
            //积分日志
            set_score_log($user,'sign',5,'','',5);
            echo get_result(10001,'您已连续签到1天，成功获取5个积分！');
        }elseif($ds==0){//当天以签到
            echo get_result(10001,'您今天已签到');
        }else{//否则在原基础上+1
            $max_score = $user['sign_num']+5;
            $data['sign_num']=$user['sign_num']+1;
            $data['all_sign']=$user['all_sign']+1;
            if($max_score>15){$max_score=15;}
            $data['score']=$user['score']+$max_score;
            $data['exp']=$user['exp']+$max_score;
            $mod->save($data);
            //积分日志
            set_score_log($user,'sign',$max_score,'','',$max_score);
            echo get_result(10001,'您已连续签到'.$user['sign_num'].'天，成功获取'.$max_score.'个积分！');
        }


    }


    //我的优惠券
    public function tick($data){
        $page = $data['page'] * 10;
        $pagesize=10;

        $mod_tick = M('tk');
        $where ="uid=".$data['userid']." ";
        $gq = $data['gq'];
        $mod_xs= M('tick')->where(' DATE_SUB( CURDATE( ) , INTERVAL 1 MONTH ) > DATE( end_time )')->field('id')->select();
        if($mod_xs){
            foreach($mod_xs as $v){
                $arr[]=$v['id'];
            }
            $mod_tick->where(array('tick_id'=>array('in',$arr),'uid'=>$data['userid']))->delete();
        }


        if($gq==1){$where .=" and t.end_time<NOW() ";$tab=1;}



        $join = " try_tick t ON t.id = try_tk.tick_id ";
        //$field= "t.orig_id,t.name,t.start_time,t.end_time,t.id，*";
        $list = $mod_tick->where($where)
            ->join($join)->field('name,end_time,tk_code,tk_psw,ljdz')
            ->order("get_time desc, tk_id desc")
            ->limit($page-10, $pagesize)
            ->select();

        foreach($list as $k=>$v){
            if(strtotime($list[$k]['end_time'])<time()){
                $list[$k]['sssss']=1;
            }
        }
        $code = 10001;
        if(count($list) < 1){
            $code = 10002;
        }
        echo get_result($code,$list);return ;

    }

    //积分兑换
    public function scorelist($data) {

        $cid = $data['cid'];
        $sort_order = 'id DESC';
        $page = $data['page'] * 10;
        $pagesize = 10;
        $where = array('status'=>'1');
        $cid && $where['cate_id'] = $cid;
        $score_item = M('score_item');
        $item_list = $score_item->where($where)->field('title,score,img,id')->order($sort_order)->limit($page-10, $pagesize)->select();
        $code = 10001;
        if(count($item_list) < 1){
            $code = 10002;
        }
        echo get_result($code,$item_list);return ;
    }

    //积分详情
    public function scoredetails($data) {

        $id = $data['scoreid'];
        $item_mod = M('score_item');
        $item = $item_mod->field('id,title,img,score,desc')->find($id);
        echo get_result(10001,$item);return ;
    }

    //我的文章
    public function publish($data){
        $pagesize=10;
        $page= $data['page'] * 10;
        $user['id'] = $data['userid'];
        $t = $data['type'];
        !$t&&$t='gn';
        $item_mod=M('item');
        $article_mod = M('article');
        $zr_mod=M("zr");
        switch($t){
            case "gn":
                $list = $item_mod->where("o.ismy=0 and try_item.uid='$user[id]' and try_item.status=1")->join("try_item_orig o ON o.id=try_item.orig_id")->field("try_item.zan,try_item.comments,try_item.id,try_item.title,try_item.img,try_item.intro,try_item.price")->order('try_item.add_time desc,try_item.id desc')->limit($page-10, $pagesize)->select();
                break;
            case "ht":
                $list = $item_mod->where("o.ismy=1 and try_item.uid='$user[id]' and try_item.status=1")->join("try_item_orig o ON o.id=try_item.orig_id")->field("try_item.zan,try_item.comments,try_item.id,try_item.title,try_item.img,try_item.intro,try_item.price")->order('try_item.add_time desc,try_item.id desc')->limit($page-10, $pagesize)->select();
                break;
            case "best":
                $list = $item_mod->where("isbest=1 and uid='$user[id]' and try_item.status=1")->field("try_item.zan,try_item.comments,try_item.id,try_item.title,try_item.img,try_item.intro,try_item.price")->order('try_item.add_time desc,try_item.id desc')->limit($page-10, $pagesize)->select();
                break;
            case "zr":
                $list = $zr_mod->where("uid='$user[id]' and (status=1 or status=4)")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "sd":
                $list=$article_mod->where("uid=$user[id] and cate_id=10 and status=1")->field("id,title,comments,zan,intro,img")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "gl":
                $list=$article_mod->where("uid=$user[id] and cate_id in(select id from try_article_cate where pid=9 or id=9) and status=1")->field("id,title,comments,zan,intro,img")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "icg"://草稿
                $list=$item_mod->where("status=2 and uid='$user[id]'")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "ids"://待审商品
                $list=$item_mod->where("status=0 and uid='$user[id]'")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "ith"://退回商品
                $list=$item_mod->where("status=3 and uid='$user[id]'")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "zcg"://转让草稿
                $list=$zr_mod->where("status=2 and uid='$user[id]'")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "zds"://待审转让
                $list=$zr_mod->where("status=0 and uid='$user[id]'")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "zth"://退回转让
                $list=$zr_mod->where("status=3 and uid='$user[id]'")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "scg"://晒单草稿
                $list=$article_mod->where("status=2 and uid=$user[id] and cate_id=10")->field("id,title,comments,zan,intro,img")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "sds"://晒单待审
                $list=$article_mod->where("status=0 and uid=$user[id] and cate_id=10")->field("id,title,comments,zan,intro,img")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "sth"://晒单退回
                $list=$article_mod->where("status=3 and uid=$user[id] and cate_id=10")->field("id,title,comments,zan,intro,img")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "gcg"://攻略草稿
                $list=$article_mod->where("uid=$user[id] and cate_id in(select id from try_article_cate where pid=9 or id=9) and status=2")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "gds"://攻略待审
                $list=$article_mod->where("uid=$user[id] and cate_id in(select id from try_article_cate where pid=9 or id=9) and status=0")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
            case "gth"://攻略退回
                $list=$article_mod->where("uid=$user[id] and cate_id in(select id from try_article_cate where pid=9 or id=9) and status=3")->order('add_time desc,id desc')->limit($page-10, $pagesize)->select();
                break;
        }

        $code = 10001;
        if(count($list) < 1){
            $code = 10002;
        }
        echo get_result($code,$list);return ;
    }

    //我的分享
//    public function share($data){
//        $pagesize=10;
//        $page= $data['page'] * 10;
//        $user['id'] = $data['userid'];
//        $t = $data['type'];
//        !$t&&$t='gn';
//        $mod=M("share");
//
//        switch($t){
//            case "gn":
//                $list = $mod->field("i.*,try_share.dm")->where("o.ismy=0 and try_share.uid='$user[id]' and try_share.xid=1")->join(array("try_item i ON i.id=try_share.item_id ","try_item_orig o ON o.id=i.orig_id"))->limit($page-10, $pagesize)->order("i.id desc")->select();
//                break;
//            case "ht":
//                $list = $mod->field("i.*,try_share.dm")->where("o.ismy=1 and try_share.uid='$user[id]' and try_share.xid=1")->join(array("try_item i ON i.id=try_share.item_id ","try_item_orig o ON o.id=i.orig_id"))->limit($page-10, $pagesize)->order("i.id desc")->select();
//                break;
//            case "best":
//                $list = $mod->field("i.*,try_share.dm")->where(" i.isbest=1 and try_share.uid='$user[id]' and try_share.xid=1")->join("try_item i ON i.id=try_share.item_id")->limit($page-10, $pagesize)->order("i.id desc")->select();
//                break;
//            case "zr":
//                $list = $mod->field("z.*,try_share.dm")->where("try_share.uid=$user[id] and try_share.xid=2")->join("try_zr z ON z.id=try_share.item_id")->limit($page-10, $pagesize)->order("z.id desc")->select();
//                break;
//            case "sd":
//                $list=$mod->field("a.*,try_share.dm")->where("try_share.uid=$user[id] and try_share.xid=3 and a.cate_id=10")->join("try_article a ON a.id=try_share.item_id")->limit($page-10, $pagesize)->order("a.id desc")->select();
//                break;
//            case "gl":
//                $list=$mod->field("a.*,try_share.dm")->where("try_share.uid=$user[id] and try_share.xid=3 and a.cate_id in(select id from try_article_cate where pid=9 or id=9)")->join("try_article a ON a.id=try_share.item_id")->limit($page-10, $pagesize)->order("a.id desc")->select();
//                break;
//        }
//        $code = 10001;
//        if(count($list) < 1){
//            $code = 10002;
//        }
//        echo get_result($code,$list);return ;
//    }

    //我的收藏
    public function likes($data){
        $pagesize=10;
        $page= $data['page'] * 10;
        $user['id'] = $data['userid'];
        $t = $data['type'];
        !$t&&$t='gn';
        $mod = M("likes");
        switch($t){
            case "gn":
                $list = $mod->where("try_likes.xid=1 and o.ismy=0")->join("try_item i on i.id=try_likes.itemid and i.uid='$user[id]'")->join("try_item_orig o on o.id=i.orig_id")->field("i.id,i.title,i.img,i.comments,i.intro")->limit($page-10, $pagesize)->select();
                break;
            case "ht":
                $list = $mod->where("try_likes.xid=1 and o.ismy=1")->join("try_item i on i.id=try_likes.itemid and i.uid='$user[id]'")->join("try_item_orig o on o.id=i.orig_id")->field("i.id,i.title,i.img,i.comments,i.intro")->limit($page-10, $pagesize)->select();
                break;
            case "best":
                $list = $mod->where("try_likes.xid=1 and i.isbest=1")->join("try_item i on i.id=try_likes.itemid and i.uid='$user[id]'")->field("i.id,i.title,i.img,i.comments,i.intro")->limit($page-10, $pagesize)->select();
                break;
            case "sd":
                $list = $mod->where("try_likes.xid=3 and a.cate_id=10")->join("try_article a on a.id=try_likes.itemid and i.uid='$user[id]'")->field("a.id,a.title,a.img,a.comments,a.intro")->limit($page-10, $pagesize)->select();
                break;
            case "gl":
                $list = $mod->where("try_likes.xid=3 and a.cate_id in(select id from try_article_cate where pid=9 or id=9)")->join("try_article a on a.id=try_likes.itemid and i.uid='$user[id]'")->field("a.id,a.title,a.img,a.comments,a.intro")->limit($page-10, $pagesize)->select();
                break;
            case "zr":
                $list = $mod->where("try_likes.xid=2")->join("try_zr z on z.id=try_likes.itemid")->field("z.id,z.title,z.img,z.comments,z.intro and i.uid='$user[id]'")->limit($page-10, $pagesize)->select();
                break;

        }
        $code = 10001;
        if(count($list) < 1){
            $code = 10002;
        }
        echo get_result($code,$list);return ;
    }

    //系统消息
    public function getmsg($data) {
        $uid = $data['userid'];
        $page = $data['page'] * 10;
        $message_mod = M('message');
        $pagesize = 10;
        $map = array();
        $map['from_id'] = '0';
        $map['to_id'] = array('in', '0,'.$uid);
        $xx = $message_mod->where($map)->limit($page-10, $pagesize)->field('add_time,info')->order("add_time desc")->select();

        $code = 10001;
        if(count($xx) < 1){
            $code = 10002;
        }
        echo get_result($code,$xx);return ;
    }

    //我的评论
    public function comments($data){
        $page = $data['page'] *10;
        $userid = $data['userid'];
        $t = $data['t'] ? 'r' : '';
        $mod_comment = M("comment");
        $time = time()-24*3600*10;
        $pagesize = 5;
        $where =" 1=1 and uid=$userid ";
        if($t=="r"){$where .=" and add_time>$time ";}


        $list = $mod_comment->where($where)->order("add_time desc,id desc")->field('id,xid,itemid,info,add_time')->limit($page - 10,$pagesize)->select();
        foreach($list as $key=>$val){
            $arr=array();
            switch($val['xid']){
                case "1":$mod=M('item');$path="item";break;
                case "2":$mod=M("zr");$path="zr";break;
                case "3":$mod=M("article");$path="article";break;
            }
            $arr = $mod->where("id=$val[itemid]")->field("title,img")->find();
            $list[$key]['title']=$arr['title'];
            if($val['xid']=='1'){$list[$key]['img']=attach($arr['img'],$path);}else{$list[$key]['img']=attach($arr['img'],$path);}
            unset($list[$key]['xid']);
            $list[$key]['shopid'] = $list[$key]['itemid'];
            $list[$key]['commentid'] = $list[$key]['id'];
            unset($list[$key]['itemid']);
            unset($list[$key]['id']);
        }

        $code = 10001;
        if(count($list) < 1){
            $code = 10002;
        }
        echo get_result($code,$list);return ;
    }
    //删除评论
    public function del_comment($data){
        $id = $data['commentid'];
        $item = M("comment")->where("id=$id")->field('xid,itemid')->find();
        $r=M("comment")->where("id=$id")->delete();
        //减少对应项目的评论数量
        if($r){
            switch($item['xid']){
                case "1":$mod = M("item");break;
                case "2":$mod = M("zr");break;
                case "3":$mod = M("article");break;
            }
            $mod->where("id=$item[itemid]")->setDec("comments");
            echo get_result(10001,'删除成功');return ;
        }else{
            echo get_result(10001,'删除失败');return ;
        }

    }

    //对商品点赞
    public function zan($data) {
        $id = $data['id'];
        $mod = 'item';
        switch ($data['type']){
            case 1:$mod = 'item';break;
            case 2:$mod = 'article';break;
        }

        if(M($mod)->where("id=$id")->setInc('zan')){
            echo get_result(10001,'点赞成功');return ;
        }else{
            echo get_result(10001,'点赞失败');return ;
        }
    }

    //收藏商品
    public function setlikes($data){
        $userid = $data['userid'];
        $id = $data['id'];
        $xid = $data['xid'];
        $i_mod = get_mod($xid);
        //验证对象
        $item = $i_mod->where("id=$id")->find();
        if(!$item){
            echo get_result(10001,'收藏错误');return ;
        }
        $mod = D("likes");
        //查找是否已收藏
        $islike=$mod->where("uid=$userid and xid=$xid and itemid=$id")->find();
        if($islike){//如果已经收藏则取消收藏
            $r=$mod->where("uid=$userid and xid=$xid and itemid=$id")->delete();
            if($r){
                $i_mod->where("id=$id")->setDec("likes");
                $res['likes']=intval($item['likes'])-1;
                $res['t']='qx';
                echo get_result(10001,'您已成功取消收藏');return ;
            }else{
                echo get_result(10001,'操作失败');return ;
            }
        }else{
            $r=$mod->add(array('itemid'=>$id,'xid'=>$xid,'addtime'=>time(),'uid'=>$userid));
            if($r){
                $i_mod->where("id=$id")->setInc("likes");
                $res['likes']=intval($item['likes'])+1;
                $res['t']='sc';
                echo get_result(10001,'收藏成功');return ;
            }else{
                echo get_result(10001,'操作失败');return ;
            }
        }
    }

    //评论
    public function comment($data){
        $st = strtotime("today");
        $ed = strtotime(date('Y-m-d',strtotime('+1 day')));
        //查询当天评论次数
        $num = M("comment")->where("uid=".$data['userid']." and add_time>$st and add_time<$ed ")->count();
        if($num>49){
            echo get_result(10001,'您今天评论的次数已达上限');return ;
        }
        $data['info'] = Input::deleteHtmlTags($data['info']);
        //过滤字符
        $kill_word = C("pin_kill_word");
        $kill_word = explode(",",$kill_word);
        if(in_array($data['info'],$kill_word)){
            echo get_result(10001,'您发表的内容有非法字符');return ;
        }

        //敏感词处理
        $check_result = D('badword')->check($data['info']);
        switch ($check_result['code']) {
            case 1: //禁用。直接返回
                echo get_result(10001,'您发表的内容有敏感字符');return ;
                break;
            case 3: //需要审核
                $data['status'] = 0;
                break;
        }
        $data['info'] = $check_result['content'];
        $data['uid'] = $data['userid'];
        $data['uname'] = D('user')->where(['id'=>$data['userid']])->getField('username');

        $data['add_time'] = time();
        //验证评论对象
        switch($data['xid']){
            case "1":$item_mod=M("item");break;
            case "2":$item_mod=M("zr");break;
            case "3":$item_mod=M("article");break;
        }
        $itemid = $data['id'];
        unset($data['id']);
        $item = $item_mod->where(array('id' => $itemid, 'status' => '1'))->find();

        if(!$item){
            echo get_result(10001,'错误的id');return ;
        }
        $data['lc']=intval($item['comments'])+1;
        //写入评论
        $comment_mod = D('comment');
        $data['itemid'] = $itemid;
        if (false === $comment_mod->create($data)) {
            echo get_result(10001,$comment_mod->getError());return ;
        }
        $comment_id = $comment_mod->add();
        if ($comment_id) {
            $item_mod->where(array('id'=>$itemid))->setInc('comments');//评论数量加1
            M("user")->where("id=$data[uid]")->setInc("score");
            //积分日志
            set_score_log(array('id'=>$data['uid'],'username'=>$data['uname']),'comment',1,'','',1);

            echo get_result(10001,'评论成功');return ;
        } else {
            echo get_result(10001,'评论失败');return ;
        }
    }



    /**
     * 基本信息修改
     */
    public function profile() {
        $data['gender'] = $this->_post('gender', 'intval');
        $data['province'] = $this->_post('province', 'trim');
        $data['city'] = $this->_post('city', 'trim');
        $data['tags'] = $this->_post('tags', 'trim');
        $data['intro'] = $this->_post('intro', 'trim');
        $birthday = $this->_post('birthday', 'trim');
        $birthday = explode('-', $birthday);
        $data['byear'] = $birthday[0];
        $data['bmonth'] = $birthday[1];
        $data['bday'] = $birthday[2];
        $data['realname']=$this->_post('realname','trim');
        $data['zipcode']=$this->_post('zipcode','trim');
        $data['mobile']=$this->_post('mobile','trim');
        $data['address']=$this->_post('address','trim');
        if (false !== M('user')->where(array('id'=>$this->visitor->info['id']))->save($data)) {
            $msg = array('status'=>1, 'info'=>L('edit_success'));
        }else{
            $msg = array('status'=>0, 'info'=>L('edit_failed'));
        }

    }

}
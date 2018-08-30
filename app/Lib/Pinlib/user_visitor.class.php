<?php
/**
 * 访问者
 *
 * @author andery
 */
class user_visitor {

    public $is_login = false; //登陆状态
    public $info = null;

    public function __construct() {
        if (session('?user_info')) {
            //已经登陆
            $this->info = session('user_info');
            $this->is_login = true;
        } elseif ($user_info = (array)cookie('user_info')) {
            $user_info = M('user')->field('id,username,is_bj,password')->where(array('id'=>$user_info['id'], 'password'=>$user_info['password']))->find();
            if ($user_info) {
                //记住登陆状态
                $this->assign_info($user_info);
                //未读消息
                D('message')->set_unread_message_num($user_info['id']);
                $this->is_login = true;
            }
        } else {
            $this->is_login = false;
        }
    }

    /**
     * 登陆会话
     */
    public function assign_info($user_info) {
        session('user_info', $user_info);
         $time = 3600 * 24 * 42; //两周
         cookie('user_info', array('id'=>$user_info['id'], 'password'=>$user_info['password']), $time);
        $this->info = $user_info;
    }

    /**
     * 记住密码
     */
    public function remember($user_info, $remember = null) {
        if ($remember) {
            $time = 3600 * 24 * 14; //两周
            cookie('user_info', array('id'=>$user_info['id'], 'password'=>$user_info['password']), $time);
        }
    }

    /**
     * 获取用户信息
     */
    public function get($key = null) {
        $info = null;
        if (is_null($key) && $this->info['id']) {
            $info = D('user')->get_info($this->info['id']);
        } else {
            if (isset($this->info[$key])) {
                return $this->info[$key];
            } else {
                //获取用户表字段
                $fields = M('user')->getDbFields();
                if (!is_null(array_search($key, $fields))) {
                    $info = D('user')->get_field($this->info['id'], $key);
                }
            }
        }
        return $info;
    }

    /**
     * 登陆
     */
    public function login($uid, $remember = null) {
        $user_mod = M('user');
        //更新用户信息
        $user_mod->where(array('id' => $uid))->save(array('last_time' => time(), 'last_ip' => get_client_ip()));
        $user_info = $user_mod->field('id,username,password,is_bj')->find($uid);        
        //保持状态
        $this->assign_info($user_info);
        $this->remember($user_info, $remember);
        //未读消息
        D('message')->set_unread_message_num($user_info['id']);
    }

    /**
     * 退出
     */
    public function logout() {
        session('user_info', null);
        cookie('user_info', null);
    }

}
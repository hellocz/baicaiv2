<?php
/**
 * 内置用户中心连接接口
 * author: andery@foxmail.com
 */
class default_passport
{

    private $_error = 0;

    public function __construct() {
        $this->_user_mod = D('user');
    }

    public function get_info() {
        return array(
            'code' => 'default', //插件代码必须和文件名保持一致
            'name' => 'PinPHP', //整合插件名称
            'desc' => 'PinPHP 默认会员系统',
            'version' => '1.0', //整合插件的版本
            'author' => 'PinPHP TEAM', //开发者
        );
    }

    /**
     * 注册新用户
     */
    public function register($username, $password, $email, $gender, $mobile) {
        if (!$this->check_username($username)) {
            $this->_error = L('username_exists');
            return false;
        }
        // if (!$this->check_email($email)) {
        //     $this->_error = L('email_exists');
        //     return false;
        // }
        if (!$this->check_mobile($mobile)) {
            $this->_error = L('该手机号已被注册');
            return false;
        }
        return array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'gender' => $gender,
            'mobile' => $mobile
        );
    }

    /**
     * 修改用户资料
     */
    public function edit($uid, $old_password, $data, $force = false) {
		$wp_hasher = new PasswordHash(8, TRUE); //验证加密
        if (!$force) {
            //先验证
            $info = $this->get($uid);
            if (!$wp_hasher->CheckPassword($old_password,$info['password'])) {
                $this->_error = L('auth_failed');
                return false;
            }
        }
        if (isset($data['password'])) {
			$sigPassword = $wp_hasher->HashPassword($data['password']); 
            $data['password'] = $sigPassword;
        }
        return $data;
    }

    /**
     * 删除用户
     */
    public function delete() {
        return true;
    }

    public function get($flag, $is_name = false) {
        if ($is_name) {
            $map = array('username' => $flag);
        } else {
            $map = array('id' => intval($flag));
        }
        return M('user')->where($map)->find();
    }

    /**
     * 登陆验证
     */
    public function auth($username, $password) {
        //$uid = M('user')->where(array('username'=>$username, 'password'=>md5($password)))->getField('id');
		$user = M('user')->where(array('username'=>$username,'email'=>$username,'_logic'=>'OR'))->field('id,password')->find();//查找用户
		$wp_hasher = new PasswordHash(8, TRUE); //验证加密
		$sok = $wp_hasher->CheckPassword($password,$user['password']);
        if ($user['id']&&$sok){
            return $user['id'];
        } else {
            $this->_error = L('auth_failed');
            return false;
        }
    }

    /**
     * 同步登陆
     */
    public function synlogin() {}

    /**
     * 同步退出
     */
    public function synlogout() {}

    /**
     * 检测用户邮箱唯一
     */
    public function check_email($email) {
        if ($this->_user_mod->where(array('email'=>$email))->count('id')) {
            return false;
        }
        return true;
    }

    /**
     * 检测用户名唯一
     */
    public function check_username($username) {
        if ($this->_user_mod->where(array('username'=>$username))->count('id')) {
            return false;
        }
        return true;
    }

    /**
     * 检测手机号唯一
     */
    public function check_mobile($mobile) {
        if ($this->_user_mod->where(array('mobile'=>$mobile))->count('id')) {
            return false;
        }
        return true;
    }

    public function get_error() {
        return $this->_error;
    }
}
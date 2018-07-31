<?php

class userModel extends Model
{
    protected $_validate = array(
        array('username', 'require', '{%username_require}'), //不能为空
        array('repassword', 'password', '{%inconsistent_password}', 0, 'confirm'), //确认密码
        array('email', 'email', '{%email_error}'), //邮箱格式
        array('username', '1,20', '{%username_length_error}', 0, 'length', 1), //用户名长度
        array('password', '6,20', '{%password_length_error}', 0, 'length', 1), //密码长度
        array('username', '', '{%username_exists}', 0, 'unique', 1), //新增的时候检测重复
    );

    protected $_auto = array(
        //array('password','md5',1,'function'), //密码加密
        array('reg_time','time',1,'function'), //注册时间
        array('reg_ip','get_client_ip',1,'function'), //注册IP
    );

    /**
     * 修改用户名
     */
    public function rename($map, $newname) {
        if ($this->where(array('username'=>$newname))->count('id')) {
            return false;
        }
        $this->where($map)->save(array('username'=>$newname));
        $uid = $this->where(array('username'=>$newname))->getField('id');
        //修改商品表中的用户名
        M('item')->where(array('uid'=>$uid))->save(array('uname'=>$newname));
        //修改专辑表中的用户名
        M('album')->where(array('uid'=>$uid))->save(array('uname'=>$newname));
        //评论和微薄暂时不修改。
        return true;
    }

    public function name_exists($name, $id = 0) {
        $where = "username='" . $name . "' AND id<>'" . $id . "'";
        $result = $this->where($where)->count('id');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function email_exists($email, $id = 0) {
        $where = "email='" . $email . "' AND id<>'" . $id . "'";
        $result = $this->where($where)->count('id');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function mobile_exists($mobile, $id = 0) {
        $where = "mobile='" . $mobile . "' AND id<>'" . $id . "'";
        $result = $this->where($where)->count('id');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 用户信息, where条件须唯一确定一条记录，如email, username, mobile, id
     */
    public function get_user_by_uid($uid, $field = '') {
        if(!$uid) return false;        
        $user = $this->field($field)->where("id=".$uid)->find();
        return $user;
    }

    public function get_user_by_email($email, $field = '') {
        if(!$email) return false;        
        $user = $this->field($field)->where("email='".$email."'")->find();
        return $user;
    }

    public function get_user_by_username($username, $field = '') {
        if(!$username) return false;        
        $user = $this->field($field)->where("username='".$username."'")->find();
        return $user;
    }

    public function get_user_by_mobile($mobile, $field = '') {
        if(!$mobile) return false;        
        $user = $this->field($field)->where("mobile='".$mobile."'")->find();
        return $user;
    }

    /**
     * 用户信息, 通过ID取用户信息
     */
    public function get_info($id = '', $field = '') {
        if(!$id) return false;        
        $user = $this->field($field)->where(array('id' => $id))->find();
        return $user;
    }

    public function user_list($where, $field = '') {
        if(!$where) return false;        
        $user_list = $this->where($where)->field($field)->select();
        return $user_list;
    }
}
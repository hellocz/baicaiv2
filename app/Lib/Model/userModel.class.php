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
    public function get_user_by_id($id, $field = '') {
        if(!$id) return false;        
        $user = $this->field($field)->where("id=".$id)->find();
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

    /**
     * 用户字段, 通过ID取用户信息
     */
    public function get_field($id = '', $field = '') {
        if(!$id) return false;
        if(!$field) return false;        
        $info = $this->where(array('id' => $id))->getField($field);
        return $info;
    }

    public function user_list($where, $field = '', $limit = '', $order = 'username asc') {
        if(!$where) return false;        
        $user_list = $this->where($where)->field($field)->order($order)->limit($limit)->select();
        return $user_list;
    }

    /**
     * 用户排行列表
     */
    public function top_user_list($t = '', $period = '', $limit = '0,10', $order = 'counts DESC,u.id asc') {
        if(!$t) return false;

        $db_pre = C('DB_PREFIX');
        $field = "u.id, max(u.username) username, max(u.intro) intro, max(u.exp) exp, count(1) counts";
        $table = $db_pre.'user u';

       //今日，本周，本月，全部
        $where = '';
        $time = strtotime(date("2018-07-23 01:01:59"));
        switch ($period) {
            case 'd':
                $time_start = strtotime(date("Y-m-d", $time));
                $where = "and a.add_time between {$time_start} and {$time} ";
                break;
            case 'w':
                $w = (date('w', $time) == 0 ? 7 : date('w', $time)) - 1;
                $time_start = strtotime(date('Y-m-d', strtotime("-$w days", $time)));
                $where = "and a.add_time between {$time_start} and {$time} ";
                break;
            case 'm':
                $time_start = strtotime(date("Y-m-01", $time));
                $where = "and a.add_time between {$time_start} and {$time} ";
                break;
            case 'all':
                $where = "and a.add_time <= {$time} ";
                break;
            default:
                //无时间条件
                $where = '';
                break;
        }

        switch ($t) {
            case 'sign': 
                //连续签到排行 
                // $list = $this->field($field)->table($table)->join("join {$db_pre}score_log a ON u.id=a.uid")->where("a.action='sign' ".$where)->group("u.id")->order($order)->limit($limit)->select();
                $field = "id, username, intro, exp, sign_num, sign_num as counts";
                $list = $this->field($field)->table($table)->order($order)->limit($limit)->select();
                break;

            case 'bao':
                //爆料
                $list = $this->field($field)->table($table)->join("join {$db_pre}item a ON u.id=a.uid")->where("a.status=1 and a.isbao=1 ".$where)->group("u.id")->order($order)->limit($total_limit)->select();
                break;

            case 'article':
                //原创：攻畋+晒单
                $list = $this->field($field)->table($table)->join("join {$db_pre}article a ON u.id=a.uid")->where("a.status=1 ".$where)->group("u.id")->order($order)->limit($limit)->select();
                break;

            case 'comm':
                //评论
                $list = $this->field($field)->table($table)->join("join {$db_pre}comment a ON u.id=a.uid")->where("a.status=1 ".$where)->group("u.id")->order($order)->limit($limit)->select();
                break;

            case 'vote':
                //投票：点选、点踩
                $list = array();
                break;

            case 'exp':
                //等级
                $field = "id, username, intro, exp, exp as counts";
                $list = $this->field($field)->table($table)->order($order)->limit($limit)->select();
                break;

            case 'offer':
                //贡献
                $field = "id, username, intro, exp, offer, offer as counts";
                $list = $this->field($field)->table($table)->order($order)->limit($limit)->select();
                break;

            case 'shares':
                //爆料
                $field = "id, username, intro, exp, shares, shares as counts";
                $list = $this->field($field)->table($table)->order($order)->limit($limit)->select();
                break;

            default: 
                $list = array();
                break;
        }

        return $list;
    }

    /**
     * 签到
     */
    public function sign($id) {
        $user = $this->get_user_by_id($id);

        if(!$user) return false;

        //查询是否已签到
        $time = time();
        $date = strtotime(date('Ymd'));
        $signtime=$user['sign_date'];
        $ds=intval(($time-$signtime)/86400); //60s*60min*24h
        $data['id']=$user['id'];
        $data['sign_date']=$time;
        if($ds>1){ 
            //如果大于1，则签到清零+1,积分+5
            $data['score']=$user['score']+5;
            $data['exp']=$user['exp']+5;
            $data['sign_num']=1;
            $data['all_sign']=$user['all_sign']+1;
            $this->save($data);
            //积分日志
            set_score_log($user,'sign',5,'','',5);

            return array('status' => 1, 'sign_num' => 1, 'score' => 5);
        }
        elseif($signtime >= $date){ 
            //当天以签到
            return array('status' => 0);
        }
        else{ 
            //否则在原基础上+1
            $max_score = $user['sign_num']+5;
            $data['sign_num']=$user['sign_num']+1;
            $data['all_sign']=$user['all_sign']+1;
            if($max_score>10){$max_score=10;}
            $data['score']=$user['score']+$max_score;
            $data['exp']=$user['exp']+$max_score;
            $this->save($data);
            //积分日志
            set_score_log($user,'sign',$max_score,'','',$max_score);

            return array('status' => 1, 'sign_num' => $data['sign_num'], 'score' => $max_score);
        }
    }

}
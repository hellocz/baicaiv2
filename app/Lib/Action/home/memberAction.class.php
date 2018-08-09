<?php

class memberAction extends frontendAction {

    private $_user = null;

    /**
     * 用户主页
     */
    public function index() {
        $t = $this->_get('t',"trim");
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}
        $pagesize=12;

        //用户信息
        $uid = $this->_get('uid', 'intval');
        if ($uid) {
            $user = D('user')->get_info($uid);
            $this->_user = $user;
        } elseif (!$uid && $this->visitor->is_login) {
            $this->_user = $this->visitor->get();
        } else {
            $this->_404();
        }
        $uid=$this->_user['id'];
        //用户相关
        $this->_user['join_days'] = intval((time() - $this->_user['reg_time']) / 86400);
        //是否关注
        if(!$this->visitor->is_login){
            $this->_user['follow']=false;
        }else{
            $myuser = $this->visitor->get();
            $this->_user['follow']= D("user_follow")->is_follow($myuser['id'], $uid);
        }
        //发表的爆料、原创文章的总被点赞数
        $sum_article = D('article')->user_article_sum($uid);
        $sum_item = D("item")->user_bao_sum($uid);
        $this->_user['zan'] = isset($sum_article['zan']) ? $sum_article['zan'] : 0;//原创：攻畋+晒单        
        $this->_user['zan'] += isset($sum_item['zan']) ? $sum_item['zan'] : 0;//爆料
        //粉丝
        $fans = D("user_follow")->user_fans_count($uid);
        $this->_user['fans'] = intval($fans);

        $count = array();        
        $count['article'] = isset($sum_article['count']) ? $sum_article['count'] : 0;//原创：攻畋+晒单        
        $count['bao'] = isset($sum_item['count']) ? $sum_item['count'] : 0;//爆料        
        $count['vote'] = 0; //投票：点选、点踩        
        $count['comm'] = D('comment')->user_comment_count($uid); //评论        
        $count['likes'] = D("likes")->user_likes_count($uid);//收藏        
        $count['follows'] = D("user_follow")->user_follow_count($uid);//关注

        $typeArr = array('article', 'bao', 'vote', 'comm', 'likes', 'follows');
        if(!in_array($t, $typeArr)){
            $t="news";
            foreach ($typeArr as $val) {
                $this->get_list($val, $uid, 1, 3);
            }
        }else{
            $this->get_list($t, $uid, $p, $pagesize);
        }

        $this->assign("count",$count);
        if($t != 'news'){
            $page = array(
                'p'=>$p, 
                'size'=>$pagesize, 
                'count'=>isset($count[$t]) ? $count[$t] : 0,
                'url'=> "/index.php?m=member&a=get_list&t={$t}&uid={$uid}",
            );
            $this->assign('page', json_encode($page));
        }
        $this->_config_seo(array(
            'title' => $this->_user['username'] . L('space_home_title') . '-' . C('pin_site_name'),
        ));
        $this->assign("t",$t);
        $this->assign('user',$this->_user);
        $this->display();
    }


    /**
     * 用户动态，原创、爆料、评论、投票、收藏、关注等列表
     */
    public function get_list($t = 'article', $uid = 0, $p = 1, $pagesize = 8) {
        if (IS_AJAX) {
            $t = $this->_get('t', 'trim');
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 8);
        }
        if($p<1){$p=1;}

        $status = 1;
        $field = "";
        $order = "add_time desc";
        $limit = $pagesize*($p-1) . ',' . $pagesize;
        switch ($t) {
            case 'article': //原创：攻畋+晒单
                $list=D('article')->user_article_list($uid, $status, $field, $order, $limit);
                break;
            case 'bao': //爆料
                $list = D("item")->user_bao_list($uid, $status, $field, $order, $limit);
                break;
            case 'vote': //投票：点选、点踩
                # code...
                break;
            case 'comm': //评论
                $list=D('comment')->user_comment_list($uid, $order, $limit);
                break;
            case 'likes': //收藏
                $order = "addtime desc";
                $list=D("likes")->user_likes_list($uid, $order, $limit);
                break;
            case 'follows': //关注
                $list=D("user_follow")->user_follow_list($uid, $order, $limit);
                break;
            
            default:
                IS_AJAX && $this->ajaxReturn(0, '信息不存在');
                break;
        }
        $this->assign("user_{$t}_list",$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("user_{$t}_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }


    /**
     * 用户积分规则
     */
    public function rule() {

        //用户信息
        if ($this->visitor->is_login) {
            $user = $this->visitor->get();

            //等级
            $exp=$user['exp'];
            $grade_list = D("grade")->grade_cache();
            $grade = grade($exp);
            $grade_min = 0;
            $grade_max = 50;
            // //查找下一等级
            // $user['next_grade'] = $grade_mod->where("grade=$user[grade]+1")->find();
            // $user['w']=($user['exp']*100)/$user['next_grade']['min'];
            // $user['lft']=$user['next_grade']['min']-$user['exp'];

            $user['grade']= $grade_list[$grade];
            $user['next_grade'] = $grade_list[$grade+1];
            $user['grade_percent'] = round($exp/$user['next_grade']['min'], 2);
            $user['grade_left'] = $user['next_grade']['min'] - $exp;

            $level = 1;
            if($user['grade']['grade'] >= 1 and $user['grade']['grade']<=4){
                $level = 1;
            }else if($user['grade']['grade'] >= 5 and $user['grade']['grade']<=9){
                $level = 2;
            }else if($user['grade']['grade'] >= 10 and $user['grade']['grade']<=14){
                $level = 3;
            }else if($user['grade']['grade'] >= 15 and $user['grade']['grade']<=19){
                $level = 4;
            }else{
                $level = 5;
            }
            $user['level'] = $level;
        }
        // print_r($user);exit;

        $this->assign('user',$user);
        $this->_config_seo(array('title'=>'积分规则'));
        $this->display();
    }


    /**
     * 用户排名
     */
    public function ranking() {
        $t = $this->_get('t',"trim");
        $period = $this->_get('period',"trim");

        //等级
        $grade_list = D("grade")->grade_cache();

        //用户信息
        $follows = array();
        if ($this->visitor->is_login) {

            $user = $this->visitor->get();

            //等级
            $grade = '1';
            foreach ($grade_list as $i => $v) {
                if($user['exp'] >= $grade_list[$i]['min'] && $user['exp'] <= $grade_list[$i]['max']){
                    $grade = $grade_list[$i]['grade'];
                    break;
                }
            }
            $user['grade'] = $grade;

            //关注
            $follow_list = M("user_follow")->where("uid=$user[id]")->select();
            if(count($follow_list) > 0){
                foreach($follow_list as $fk=>$fv){
                    $follows[$fv['follow_uid']] = 1;
                }
            }
        }

         //用户排名
        $db_pre = C('DB_PREFIX');
        $mod = M('');

        $total_limit = 10;
        $limit = 100;

        $field = "u.id, count(1) cnt,max(u.username) username,max(u.intro) intro,max(u.exp) exp";
        //今日，本周，本月，全部
        $time = strtotime(date("2018-07-23 01:01:59"));
        if($period=='d'){
            $time_start = strtotime(date("Y-m-d", $time));
            $where = "a.add_time between {$time_start} and {$time} ";
        }else if($period=='w'){
            $w = (date('w', $time) == 0 ? 7 : date('w', $time)) - 1;
            $time_start = strtotime(date('Y-m-d', strtotime("-$w days", $time)));
            $where = "a.add_time between {$time_start} and {$time} ";
        }else if($period=='m'){
            $time_start = strtotime(date("Y-m-01", $time));
            $where = "a.add_time between {$time_start} and {$time} ";
        }else{
            $period = '';
            $where = "a.add_time <= {$time} ";
        }

        if($t == 'sign'){
            //签到排行 
            $list = $mod->field($field)->table($db_pre.'score_log a')->join("join try_user u ON u.id=a.uid")->where("a.action='sign' and ".$where)->group("u.id")->order("cnt desc")->limit($total_limit)->select();
        }else if($t == 'bao'){
            //爆料
            $list = $mod->field($field)->table($db_pre.'item a')->join("join try_user u ON u.id=a.uid")->where("a.status=1 and a.isbao=1 and ".$where)->group("u.id")->order("cnt desc")->limit($total_limit)->select();
        }else if($t == 'article'){
            //原创：攻畋+晒单
            $list = $mod->field($field)->table($db_pre.'article a')->join("join try_user u ON u.id=a.uid")->where("a.cate_id in(9,10) and a.status=1 and ".$where)->group("u.id")->order("cnt desc")->limit($total_limit)->select();
        }else if($t == 'comm'){
            //评论
            $list = $mod->field($field)->table($db_pre.'comment a')->join("join try_user u ON u.id=a.uid")->where("a.status=1 and ".$where)->group("u.id")->order("cnt desc")->limit($total_limit)->select();
        }else if($t == 'vote'){
            //投票：点选、点踩
            $list = array();
        }else{
            $t = 'exp';
            //等级
            $list = M("user")->field("id,username,exp")->order("exp desc,id asc")->limit($total_limit)->select();
        }

        //本人的默认排名信息
        if($user){
            $me_list = array(
                'id' => $user['id'],
                'cnt' => 0,
                'username' => $user['username'],
                'intro' => $user['intro'],
                'exp' => $user['exp'],
                'grade' => $user['grade'],
                'rank' => "1000+",
            );
        }
        $user_list= array();
        if(count($list) > 0){
            $i = 1;
            foreach ($list as $k => $v) {
                //取前100名用户
                if($i <= $limit){
                    $user_list[$k] = $v;
                    $user_list[$k]['rank'] = $i;

                    //用户是否被关注
                    $user_list[$k]['follow'] = 0;
                    if(isset($follows[$v['id']])){
                        $user_list[$k]['follow'] = 1;
                    }

                    //用户等级
                    $user_list[$k]['grade'] = '1';
                    foreach ($grade_list as $gk => $gv) {
                        if($v['exp'] >= $grade_list[$gk]['min'] && $v['exp'] <= $grade_list[$gk]['max']){
                            $user_list[$k]['grade'] = $grade_list[$gk]['grade'];
                            break;
                        }
                    }
                }

                //本人的排名，超过1000显示1000+
                if($user && $user['id']==$v['id']){
                    $me_list['cnt'] = $user_list[$k]['cnt'];
                    $me_list['rank'] = $user_list[$k]['rank'];
                }

                $i++;
            }
        }
        // print_r($user_list); print_r($me_list); exit;

        $this->assign('user_list',$user_list);
        if($user){
            $this->assign('me_list',$me_list);
        }
        $this->assign("t",$t);
        $this->assign("period",$period);
        $this->_config_seo(array('title'=>'用户排名'));
        $this->display();
    }

}
<?php

class memberAction extends frontendAction {

    private $_user = null;

    /**
     * 用户主页
     */
    public function index() {
        $t = $this->_get('t',"trim");
        !$t&&$t="news";
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}

        //用户信息
        $uid = $this->_get('uid', 'intval');
        if ($uid) {
            $user = M('user')->find($uid);
            $this->_user = $user;
        } elseif (!$uid && $this->visitor->is_login) {
            $this->_user = $this->visitor->get();
        } else {
            $this->_404();
        }
        $this->assign('user', $this->_user);

         //用户的分享
        $pagesize=12;
        $uid=$this->_user['id'];
        $time=time();
        $mod=M("item");
        $amod=M('article');
        $cmod=M('comment');
        $lmod = M("likes");
        $fmod = M("user_follow");
        $count = array();

        //原创：攻畋+晒单
        $count['original'] = $amod->where("uid='".$uid."' and cate_id in(9,10) and status=1 and add_time<$time")->count();
        //爆料
        $count['bao'] = $mod->where("uid='$uid' and status=1 and isbao=1")->count();
        //投票：点选、点踩
        $count['vote'] = 0; 
        //评论
        $count['comm'] = $cmod->where("uid='$uid' and status=1")->count();
        //收藏
        $count['likes'] = $lmod->where("uid='$uid'")->count();
        //关注
        $count['follows'] = $fmod->where("uid='$uid'")->count();
        //所有动态
        $count['news'] = array_sum($count);


        $pager = $this->_pager($count[$t], $pagesize);
        $item_list = array();

        if($count[$t] > 0){
            if($t=="news" || $t == "original"){ //原创：攻畋+晒单
                $list=$amod->where("status=1 and add_time<$time and uid='".$uid."' and cate_id in(9,10)")->order("add_time desc")->limit($pager->firstRow . ',' . $pager->listRows)->select();

                if(count($list) > 0){
                    foreach($list as $key=>$val){
                        $list[$key]['t'] = "original";
                        $item_list[] = $list[$key];
                    }
                }
            }

            if($t=="news" || $t == "bao"){ //爆料
                $field = 'id,uid,uname,title,intro,img,price,likes,content,comments,comments_cache,add_time,orig_id,url,go_link,zan,hits';
                $list = $mod->where("status=1 and isbao=1 and add_time<$time and uid='$uid'")->field($field)->order("add_time desc")->limit($pager->firstRow . ',' . $pager->listRows)->select();

                if(count($list) > 0){
                    foreach($list as $key=>$val){
                        $list[$key]['t'] = "bao";
                        $item_list[] = $list[$key];
                    }
                }
            }

            if($t=="news" || $t == "vote"){ //投票：点选、点踩

            }

            if($t=="news" || $t == "comm"){ //评论
                $list=$cmod->where("uid='$uid' and status=1")->order("add_time desc")->limit($pager->firstRow . ',' . $pager->listRows)->select();

                if(count($list) > 0){
                    foreach($list as $key=>$val){
                        $arr=array();
                        switch($val['xid']){
                            case "1":$mod=M('item');$path="item";$url=U('item/index',array('id'=>$val['itemid']));break;
                            case "2":$mod=M("zr");$path="zr";$url=U('zr/show',array('id'=>$val['itemid']));break;
                            case "3":$mod=M("article");$path="article";$url=U('article/show',array('id'=>$val['itemid']));break;
                        }
                        $arr = $mod->where("id=".$val['itemid'])->field("title,img,content,intro,zan,comments")->find();
                        $list[$key]['title']=$arr['title'];
                        $list[$key]['img']=attach($arr['img'],$path);
                        $list[$key]['url']=$url;
                        $list[$key]['content']=$arr['content'];
                        $list[$key]['intro']=$arr['intro'];
                        $list[$key]['zan']=$arr['zan'];
                        $list[$key]['comments']=$arr['comments'];

                        $list[$key]['t'] = "comm";
                        $item_list[] = $list[$key];
                    }
                }
            }

            if($t=="news" || $t == "likes"){ //收藏
                $list=$lmod->where("uid='$uid'")->order("addtime desc")->limit($pager->firstRow . ',' . $pager->listRows)->select();
                if(count($list) > 0){
                    foreach($list as $key=>$val){
                        $list[$key]['add_time']=$val['addtime'];
                        $arr=array();
                        switch($val['xid']){
                            case "1":$mod=M('item');$path="item";$url=U('item/index',array('id'=>$val['itemid']));break;
                            case "2":$mod=M("zr");$path="zr";$url=U('zr/show',array('id'=>$val['itemid']));break;
                            case "3":$mod=M("article");$path="article";$url=U('article/show',array('id'=>$val['itemid']));break;
                        }
                        $arr = $mod->where("id=".$val['itemid'])->field("title,img,content,intro,zan,comments")->find();
                        $list[$key]['title']=$arr['title'];
                        $list[$key]['img']=attach($arr['img'],$path);
                        $list[$key]['url']=$url;                        
                        $list[$key]['content']=$arr['content'];
                        $list[$key]['intro']=$arr['intro'];
                        $list[$key]['zan']=$arr['zan'];
                        $list[$key]['comments']=$arr['comments'];

                        $list[$key]['t'] = "likes";
                        $item_list[] = $list[$key];
                    }
                }
            }

            if($t=="news" || $t == "follows"){ //关注
                // $follow = $mod_fo->where("uid=$uid")->join("try_user u ON u.id=try_user_follow.follow_uid")->order("add_time desc")->limit(6)->select();//他关注的
                // $fans = $mod_fo->where("follow_uid=$uid")->join("try_user u ON u.id=try_user_follow.uid")->order("add_time desc")->limit(6)->select();//他的粉丝
                $list=$fmod->where("uid=$uid")->join("try_user u ON u.id=try_user_follow.follow_uid")->order("add_time desc")->limit($pager->firstRow . ',' . $pager->listRows)->select();

                //是否关注
                if(!$this->visitor->is_login){
                    foreach($list as $key=>$val){
                        $list[$key]['follow']=0;
                    }
                }else{
                    $myuser = $this->visitor->get();
                    $follow_list = M("user_follow")->where("uid=$myuser[id]")->select();
                    foreach($follow_list as $k=>$v){
                        foreach($list as $mk=>$mv){                
                            if($mv['uid']==$v['follow_uid']){
                                $list[$mk]['follow']=1;
                            }
                        }
                    }
                }

                if(count($list) > 0){
                    foreach($list as $key=>$val){
                        $list[$key]['t'] = "follows";
                        $item_list[] = $list[$key];
                    }
                }
            }


            //动态tab，对不同数据按时间排序
            $volume = array();
            foreach($item_list as $key=>$val){
                $volume[$key]=$val['add_time'];
            }
            array_multisort($volume, SORT_DESC, SORT_NUMERIC, $item_list);
        }
        // echo "<pre>";print_r($count);print_r($item_list);echo "</pre>";exit;

        //等级
        $exp=$this->_user['exp'];
        // $this->_user['grade'] = M("grade")->where("min<=$exp and max>=$exp")->getField("grade");
        $grade_list = M("grade")->field("grade,min,max")->order("min asc,id asc")->select();
        $grade = '1';
        foreach ($grade_list as $i => $v) {
            if($exp >= $grade_list[$i]['min'] && $exp <= $grade_list[$i]['max']){
                $grade = $grade_list[$i]['grade'];
                break;
            }
        }
        $this->_user['grade'] = $grade;

        //是否关注
        if(!$this->visitor->is_login){
        	$this->_user['follow']=0;
        }else{
        	$myuser = $this->visitor->get();
        	$this->_user['follow']= M("user_follow")->where("uid=$myuser[id] and follow_uid=$uid")->count();
        }

        //发表的爆料、原创文章的总被点赞数
        $count['zan'] = 0;
        //原创：攻畋+晒单
        $arr = $amod->field("sum(zan) as zan")->where("uid='".$uid."' and cate_id in(9,10) and status=1 and add_time<$time")->select();
        $count['zan'] += isset($arr[0]) ? $arr[0]['zan'] : 0;
        //爆料
        $arr = $mod->field("sum(zan) as zan")->where("uid='$uid' and status=1 and isbao=1")->select();
        $count['zan'] += isset($arr[0]) ? $arr[0]['zan'] : 0;

        //粉丝
        $count['fans'] = $fmod->where("follow_uid='$uid'")->count();

        // //勋章
        // $xz['share_num'] = M("share")->where("uid=$uid")->count();//分享达人
        // $xz['bao_num'] = M("item")->where("uid=$uid and status=1")->count();//爆料达人
        // $xz['sign_num'] = $this->_user['all_sign'];//签到
        // $xz['gl_num'] = M("article")->where("uid=$uid and status=1 and cate_id in(select id from try_article_cate where pid=9 or id=9)")->count();//攻略
        // $xz['sd_num'] = M("article")->where("uid=$uid and status=1 and cate_id=10")->count();//晒单
        // $xz['cm_num'] = M("comment")->where("uid=$uid and status=1")->count();
        // $this->assign('xz',$xz);

        $this->assign("count",$count);
        $this->assign('item_list',$item_list);
        $this->assign('p',$p);
        $this->assign('pagebar', ($count[$t] > $pagesize) ? $pager->newfshow() : '');
        $this->_config_seo(array(
            'title' => $this->_user['username'] . L('space_home_title') . '-' . C('pin_site_name'),
        ));
        $this->assign("t",$t);
        $this->assign('user',$this->_user);
        $this->display();
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
            // $user['grade'] = M("grade")->where("min<=$exp and max>=$exp")->getField("grade");
            $grades = M("grade")->field("grade,min,max")->order("min asc,id asc")->select();
            $grade = '1';
            $grade_min = 0;
            $grade_max = 50;
            $grade_list = array();
            foreach ($grades as $i => $v) {
                $grade_list[$v['grade']]=$v;
                if($exp >= $grades[$i]['min'] && $exp <= $grades[$i]['max']){
                    $grade = $v['grade'];
                }
            }
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
        $grade_list = M("grade")->field("grade,min,max")->order("min asc,id asc")->select();

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
        $uid=$user['id'];
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
        }else if($t == 'original'){
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
        $this->assign('me_list',$me_list);
        $this->assign("t",$t);
        $this->assign("period",$period);
        $this->_config_seo(array('title'=>'用户排名'));
        $this->display();
    }

}
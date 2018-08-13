<?php

class userAction extends userbaseAction {

    public function _initialize(){
        parent::_initialize();
        $this->_mod = D('user');
    }


    /**
     * 个人资料
     */
    public function index(){
        // !$this->visitor->is_login && $this->redirect('index/index');
        $t = $this->_get('t',"trim");
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}
        $pagesize=10;        
        $uid=$this->_user['id'];

        $count = array();
        $sum_article = D('article')->user_article_sum($uid);
        $sum_item = D("item")->user_bao_sum($uid);
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

        // //勋章
        // $xz['share_num'] = M("share")->where("uid=$uid")->count();//分享达人
        // $xz['bao_num'] = M("item")->where("uid=$uid and status=1")->count();//爆料达人
        // $xz['sign_num'] = $this->_user['all_sign'];//签到
        // $xz['gl_num'] = M("article")->where("uid=$uid and status=1 and cate_id in(select id from try_article_cate where pid=9 or id=9)")->count();//攻略
        // $xz['sd_num'] = M("article")->where("uid=$uid and status=1 and cate_id=10")->count();//晒单
        // $xz['cm_num'] = M("comment")->where("uid=$uid and status=1")->count();
        // $this->assign('xz',$xz);

        // //勋章
        // $xz['share_num'] = M("score_log")->where("action='share' and uid=$user[id]")->count();//分享
        // $xz['bao_num'] = M("item")->where("uid=$user[id] and status=1")->count();//爆料达人
        // $xz['sign_num'] = M("score_log")->where("action='sign' and uid=$user[id]")->count();//签到
        // $xz['gl_num'] = M("article")->where("uid=$user[id] and status=1 and cate_id in(select id from try_article_cate where pid=9 or id=9)")->count();//攻略
        // $xz['sd_num'] = M("article")->where("uid=$user[id] and status=1 and cate_id=10")->count();//晒单
        // $xz['cm_num'] = M("comment")->where("uid=$user[id] and status=1")->count();
        // $this->assign('xz',$xz);

        $this->assign("count",$count);
        if($t != 'news'){
            $page = array(
                'p'=>$p, 
                'size'=>$pagesize, 
                'count'=>isset($count[$t]) ? $count[$t] : 0,
                'url'=> "/index.php?m=user&a=get_list&t={$t}&uid={$uid}",
            );
            $this->assign('page', json_encode($page));
        }
        $this->assign("t",$t);
        $this->assign("page_seo",set_seo('个人中心'));
        $this->display();
    }

    /**
     * 个人资料 - 动态，原创、爆料、评论、投票、收藏、关注等列表, AJAX翻页请求
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

        $field = "";
        $status = 1;
        $limit = $pagesize*($p-1) . ',' . $pagesize;
        switch ($t) {
            case 'article': //原创：攻畋+晒单
                $list=D('article')->user_article_list($uid, $status, $field, $limit);
                break;
            case 'bao': //爆料
                $list = D("item")->user_bao_list($uid, $status, $field, $limit);
                break;
            case 'vote': //投票：点选、点踩
                # code...
                break;
            case 'comm': //评论
                $list=D('comment')->user_comment_list($uid, $limit);
                break;
            case 'likes': //收藏
                $list=D("likes")->user_likes_list($uid, $limit);
                break;
            case 'follows': //关注
                $list=D("user_follow")->user_follow_list($uid, $limit);
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
     * 我的文章 - 原创、爆料等列表
     */
    public function publish(){
        $t = $this->_get('t',"trim");
        $p = $this->_get('p', 'intval', 1);
        $status = $this->_get('status', 'trim');
        if($p<1){$p=1;}
        $pagesize=10;        
        $uid=$this->_user['id'];
        if(!in_array($t, array('article', 'bao'))) $t = 'all';
        if(!in_array($status, array('0', '1', '2', '3'))) $status = '';

        $count = array();
        $sum_article = D('article')->user_article_sum($uid, $status);
        $sum_item = D("item")->user_bao_sum($uid, $status);
        $count['article'] = isset($sum_article['count']) ? $sum_article['count'] : 0;//原创：攻畋+晒单        
        $count['bao'] = isset($sum_item['count']) ? $sum_item['count'] : 0;//爆料
        $count['all'] = array_sum($count);

        $this->get_publish_list($t, $uid, $status, $p, $pagesize);

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>isset($count[$t]) ? $count[$t] : 0,
            'url'=>"/index.php?m=user&a=get_publish_list&t={$t}&status={$status}&uid={$uid}",
        );
        $this->assign('page', json_encode($page));
        $this->assign("t",$t);
        $this->assign("status",$status);
        $this->assign('page_seo',set_seo('我的文章 - 个人中心'));
        $this->display();
    }

    /**
     * 我的文章 - 原创、爆料列表 - 按状态status区分, AJAX翻页请求
     */
    public function get_publish_list($t = 'article', $uid = 0, $status = 1, $p = 1, $pagesize = 8) {
        if (IS_AJAX) {
            $t = $this->_get('t', 'trim');
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');    
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 8);
            $status = $this->_get('status', 'trim');
        }        
        if($p<1){$p=1;}
        if(!in_array($status, array('0', '1', '2', '3'))) $status = '';

        $field_article = "'article' as type, id,cate_id,title,intro,likes,comments,add_time,zan,status,orig_id,img,isbest";
        $field_item = "'bao' as type, id,cate_id,title,intro,likes,comments,add_time,zan,status,orig_id,img,isbest";
        $limit = $pagesize*($p-1) . ',' . $pagesize;
        switch ($t) {
            case 'article': //原创：攻畋+晒单
                $list=D('article')->user_article_list($uid, $status, $field_article, $limit);
                break;
            case 'bao': //爆料
                $list = D("item")->user_bao_list($uid, $status, $field_item, $limit);
                break;
            default:
                $sql = array();
                $sql1 = D('article')->user_article_sql($uid, $status, $field_article, '', '');
                $sql2 = D("item")->user_bao_sql($uid, $status, $field_item, '', '');
                $order = "add_time desc";
                $list = M()->table("(".$sql1." union all ".$sql2.") a")->order($order)->limit($limit)->select();
                break;
        }
        $this->assign("publish_list",$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("publish_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    //我的收藏
    public function likes(){
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}
        $pagesize=1;        
        $uid=$this->_user['id'];

        $count = D("likes")->user_likes_count($uid);//收藏 

        $this->get_likes_list($uid, $p, $pagesize);

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count, 
            'url'=>'/index.php?m=user&a=get_likes_list&uid='.$uid,
        );
        $this->assign('page', json_encode($page));
        $this->assign('page_seo',set_seo('我的收藏 - 个人中心'));
        $this->display();
    }

    /**
     * 我的收藏 - AJAX翻页请求
     */
    public function get_likes_list($uid = 0, $p = 1, $pagesize = 8) {
        if (IS_AJAX) {
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');          
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 8);
        }
        if($p<1){$p=1;}

        $limit = $pagesize*($p-1) . ',' . $pagesize;        
        $list=D("likes")->user_likes_list($uid, $limit);
        $this->assign("likes_list",$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("likes_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    //删除收藏
    public function del_likes(){
        $itemid = $this->_get('itemid','intval');
        $xid = $this->_get('xid','intval');
        // $uid = $this->_get('uid','intval');
        $uid=$this->_user['id'];
        $mod = D("likes");
        //查找是否已收藏
        $islike=$mod->is_likes($uid, $xid, $itemid);
        if($islike){
            $r=$mod->delete_likes($uid, $xid, $itemid);
            if($r){
                $i_mod = get_mod($xid);
                $i_mod->where("id=$itemid")->setDec("likes");
                $this->ajaxReturn(1, '取消收藏成功');
            }else{
                $this->ajaxReturn(0,'删除失败！');
            }
        }else{
            $this->ajaxReturn(0,'删除失败！');
        }
    }

    /**
     * 个人中心 - 降价提醒(我的关注)
     */
    public function keysfollow(){
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}
        $pagesize=10;        
        $uid=$this->_user['id'];

        $count = D("notify_tag")->user_follow_count($uid);//收藏 

        //关注列表
        $this->get_keysfollow_list($uid, $p, $pagesize);        

        //热门关注列表
        $this->get_hot_keysfollow_list($uid);

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count, 
            'url'=>'/index.php?m=user&a=get_keysfollow_list&uid='.$uid,
        );
        $this->assign('page', json_encode($page));
        $this->assign('page_seo',set_seo('我的关注 - 个人中心'));
        $this->display();
    }

    /**
     * 降价提醒(我的关注) - AJAX翻页请求
     */
    public function get_keysfollow_list($uid = 0, $p = 1, $pagesize = 8) {
        if (IS_AJAX) {
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');          
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 8);
        }
        if($p<1){$p=1;}

        $limit = $pagesize*($p-1) . ',' . $pagesize;        
        $list=D("notify_tag")->user_follow_list($uid, $limit);
        $this->assign("keysfollow_list",$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("keysfollow_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    /**
     * 降价提醒(我的关注-热门关注) - AJAX翻页请求
     */
    public function get_hot_keysfollow_list($uid = 0) {
        if (IS_AJAX) {
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');
        }

        $list = D("notify_tag")->top_follow_list();
        $rand_keys = array_rand($list, 12);
        $top_list = array();
        $follows = D("notify_tag")->user_follow_tags($uid);
        foreach ($rand_keys as $key) {
            $top_list[$key] = $list[$key];
            $top_list[$key]['is_follow'] = isset($follows[$list[$key]['tag']]) ? 1 : 0;
        }
        $this->assign("hot_keysfollow_list",$top_list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("hot_keysfollow_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    /**
     * 关注tag
     */
    public function follow_tag_create(){
        $tag['userid'] = $this->_user['id'];
        $tag['tag'] = $this->_post('tag','trim');
        $notify_tag = D("notify_tag");
        $result = $notify_tag->follow($tag['userid'], $tag['tag']);
        if ($result) {
            $this->ajaxReturn("1",'设置关注成功!',$result);
        } else {
            $this->ajaxReturn("0",'设置关注失败!');
        }
    }

    /**
     * 推送tag
     */
    public function notify_tag_create(){
        $tag['userid'] = $this->_user['id'];
        $tag['tag'] = $this->_post('tag','trim');
        $notify_tag = D("notify_tag");
        $result = $notify_tag->follow($tag['userid'], $tag['tag'], true);
        if ($result) {
            $this->ajaxReturn("1",'设置推送成功!',$result);
        } else {
            $this->ajaxReturn("0",'设置推送失败!');
        }
    }

    /**
     * 取消推送tag
     */
    public function notify_tag_del(){
        $notify_tag = D("notify_tag");
        $tag['userid'] = $this->_user['id'];
        $tag['tag'] = $this->_post('tag','trim');
        $result = $notify_tag->unfollow($tag['userid'], $tag['tag'], true);
        if ($result) {
            $this->ajaxReturn("1",'删除推送成功!');
        } else {
            $this->ajaxReturn("0",'删除推送失败!');
        }  
    }

    /**
     * 删除关注tag
     */
    public function follow_tag_del(){
        $notify_tag = D("notify_tag");
        $tag['userid'] = $this->_user['id'];
        $tag['tag'] = $this->_post('tag','trim');
        $result = $notify_tag->unfollow($tag['userid'], $tag['tag']);
        if ($result) {
            $this->ajaxReturn("1",'删除关注成功!');
        } else {
            $this->ajaxReturn("0",'删除关注失败!');
        }        
    }


    /**
     * 我关注的用户
     */
    public function userfollow() {
        $t = $this->_get('t',"trim");
        $p = $this->_get('p', 'intval', 1);
        if($p<1){$p=1;}
        $pagesize=10;        
        $uid=$this->_user['id'];
        if($t != 'fans') $t = 'follows';

        $count = array();
        $count['follows'] = D("user_follow")->user_follow_count($uid);//关注的用户 
        $count['fans'] = D("user_follow")->user_fans_count($uid);//粉丝 

        //关注列表
        $this->get_userfollow_list($t, $uid, $p, $pagesize);

        // if ($this->visitor->is_login) {
        //     D('user_msgtip')->clear_tip($this->visitor->info['id'], 1);
        // }

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count[$t], 
            'url'=>"/index.php?m=user&a=get_userfollow_list&t={$t}&uid={$uid}",
        );
        $this->assign('count', $count);
        $this->assign('t', $t);
        $this->assign('page', json_encode($page));
        $this->assign('page_seo',set_seo('我的关注 - 个人中心'));
        $this->display();
    }

    /**
     * 我关注的用户 - AJAX翻页请求
     */
    public function get_userfollow_list($t = 'fans', $uid = 0, $p = 1, $pagesize = 8) {
        if (IS_AJAX) {
            $t = $this->_get('t',"trim");
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');          
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 8);
        }
        if($p<1){$p=1;}

        $limit = $pagesize*($p-1) . ',' . $pagesize;
        switch ($t) {
            case 'fans':            
                $list=D("user_follow")->user_fans_list($uid, $limit);                
                break;
            
            default:
                $t = "follows";
                $list=D("user_follow")->user_follow_list($uid, $limit);
                break;
        }

        $this->assign("userfollow_{$t}_list",$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("userfollow_{$t}_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    /**
     * 关注
     */
    public function follow() {
        $follow_uid = $this->_get('uid', 'intval');
        !$follow_uid && $this->ajaxReturn(0, L('follow_invalid_user'));

        $uid = $this->visitor->info['id'];
        $follow_uid == $uid && $this->ajaxReturn(0, L('follow_self_not_allow'));
        $user_mod = D('user');
        if (!$user_mod->get_user_by_uid($follow_uid)) {
            $this->ajaxReturn(0, L('follow_invalid_user'));
        }

        //判断是否已经关注
        $is_follow = D('user_follow')->is_follow($uid, $follow_uid);
        $is_follow && $this->ajaxReturn(0, L('user_is_followed'));

        //关注
        $return = D('user_follow')->follow($uid, $follow_uid);
        !$return && $this->ajaxReturn(0, L('follow_user_failed'));

        $this->ajaxReturn(1, L('follow_user_success'), $return);
    }

    /**
     * 取消关注
     */
    public function unfollow() {
        $follow_uid = $this->_get('uid', 'intval');
        !$follow_uid && $this->ajaxReturn(0, L('unfollow_invalid_user'));

        $uid = $this->visitor->info['id'];

        //取消关注
        $result = D('user_follow')->unfollow($uid, $follow_uid);
        
        if ($result) {
            $this->ajaxReturn(1, L('unfollow_user_success'));
        } else {
            $this->ajaxReturn(0, L('unfollow_user_failed'));
        }
    }

    // /**
    //  * 移除粉丝
    //  */
    // public function delfans() {
    //     $uid = $this->_get('uid', 'intval');
    //     !$uid && $this->ajaxReturn(0, L('delete_invalid_fans'));
    //     $user_follow_mod = M('user_follow');
    //     if ($user_follow_mod->where(array('follow_uid'=>$this->visitor->info['id'], 'uid'=>$uid))->delete()) {
    //         $user_mod = M('user');
    //         //减少我的粉丝人数
    //         $user_mod->where(array('id'=>$this->visitor->info['id']))->setDec('fans');
    //         //减少Ta的关注人数
    //         M('user')->where(array('id'=>$uid))->setDec('follows');
    //         //删除Ta微薄中我的内容
    //         M('topic_index')->where(array('author_id'=>$this->visitor->info['id'], 'uid'=>$uid))->delete();
    //         $this->ajaxReturn(1, L('delete_fans_success'));
    //     } else {
    //         $this->ajaxReturn(0, L('delete_fans_failed'));
    //     }
    // }

    /**
     * 我的抽奖
     */
    public function lucky() {
        $t = $this->_get('t',"trim"); 
        $p = $this->_get('p', 'intval', 1);
        $uid=$this->_user['id'];
        if($p<1){$p=1;}
        $pagesize = 10;
        if($t != "lucky") $t = "win";

        //抽奖记录
        $count = D('score_order')->user_order_counts($t, $uid);
        $this->get_score_order_list($t, $uid, $p, $pagesize);

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=> $count,
            'url'=> "/index.php?m=user&a=get_score_order_list&t={$t}&uid={$uid}",
        );
        $this->assign('page', json_encode($page));
        $this->assign('t', $t);
        $this->assign('page_seo',set_seo('我的抽奖 - 个人中心'));
        $this->display();
    }

    /**
     * 我的兑换
     */
    public function exchange() {
        $p = $this->_get('p', 'intval', 1);
        $uid=$this->_user['id'];
        if($p<1){$p=1;}
        $pagesize = 10;
        $t = "exchange";

        //抽奖记录
        $count = D('score_order')->user_order_counts($t, $uid);
        $this->get_score_order_list($t, $uid, $p, $pagesize);

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=> $count,
            'url'=> "/index.php?m=user&a=get_score_order_list&t={$t}&uid={$uid}",
        );
        $this->assign('page', json_encode($page));
        $this->assign('page_seo',set_seo('我的兑换 - 个人中心'));
        $this->display();
    }

    /**
     * 积分兑换/抽奖记录，ajax分页请求
     */
    public function get_score_order_list($t = 'exchange', $uid = 0, $p = 1, $pagesize = 10) {
        if (IS_AJAX) {
            $t = $this->_get('t', 'trim');  //lucky, win, exchange
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');    
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 20);
        }
        if($p<1){$p=1;}
        if($pagesize<1){$pagesize=10;}

        //抽奖/兑换记录
        $limit = $pagesize*($p-1) . ',' . $pagesize;
        $list = D('score_order')->user_order_list($t, $uid, $limit);

        if($t != "exchange"){
            $t = "lucky";
        }
        $this->assign("{$t}_list",$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $this->assign('item', $item);    
            $data = array(
                'list' => $this->fetch("{$t}_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    //我的优惠券
    public function tick(){
        $p = $this->_get('p', 'intval', 1);
        $uid=$this->_user['id'];
        if($p<1){$p=1;}
        $pagesize = 12; //12
        $t = $this->_get('t', 'trim');  //all, valid
        if($t != 'all') $t = 'valid';

        //清除过期超过6个月的券
        D('tk')->clear($uid);

        //总数
        $count = D('tk')->user_tick_count($t, $uid);

        //关注列表
        $this->get_tick_list($t, $uid, $p, $pagesize); 

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count, 
            'url'=>"/index.php?m=user&a=get_tick_list&t=$t&uid=$uid",
        );
        $this->assign('page', json_encode($page));
        $this->assign('t', $t);
        $this->assign('page_seo',set_seo('我的卡券 - 个人中心'));
        $this->display();
    }

    /**
     * 我的优惠券 - AJAX翻页请求
     */
    public function get_tick_list($t = '', $uid = 0, $p = 1, $pagesize = 8) {
        if (IS_AJAX) {
            $t = $this->_get('t', 'trim');  //valid
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');          
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 8);
        }
        if($p<1){$p=1;}

        //商城
        $orig_list = D("item_orig")->orig_cache();
        $this->assign("orig_list",$orig_list);

        $limit = $pagesize*($p-1) . ',' . $pagesize;        
        $list = D('tk')->user_tick_list($t, $uid, $limit);
        $this->assign("tick_list",$list);

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("tick_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }

    /**
     * 积分记录
     */
    public function score(){
        $p = $this->_get('p', 'intval', 1);
        $uid=$this->_user['id'];
        if($p<1){$p=1;}
        $pagesize = 15; //15

        $user = $this->_user;
        $user['grade'] = D("grade")->get_grade($user['exp']);
        $user['next_grade'] = D("grade")->get_info($user['grade']+1);
        $user['w']=($user['exp']*100)/$user['next_grade']['min'];
        $user['lft']=$user['next_grade']['min']-$user['exp'];

        //总数
        $count = D("score_log")->user_score_log_count('', $uid);
        //列表
        $this->get_score_list('', $uid, $p, $pagesize); 

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count, 
            'url'=>"/index.php?m=user&a=get_score_list&uid=$uid",
        );
        $this->assign('page', json_encode($page));
        $this->assign('page_seo',set_seo('积分记录 - 个人中心'));
        $this->assign('user',$user);
        $this->display();
    }

    /**
     * 违规记录
     */
    public function score_illegal(){
        $p = $this->_get('p', 'intval', 1);
        $uid=$this->_user['id'];
        if($p<1){$p=1;}
        $pagesize = 15; //15

        //总数
        $count = D("score_log")->user_score_log_count('illegal', $uid);
        //列表
        $this->get_score_list('illegal', $uid, $p, $pagesize); 

        $page = array(
            'p'=>$p, 
            'size'=>$pagesize, 
            'count'=>$count, 
            'url'=>"/index.php?m=user&a=get_score_list&t=illegal&uid=$uid",
        );
        $this->assign('page', json_encode($page));
        $this->assign('page_seo',set_seo('违规记录 - 个人中心'));
        $this->display();
    }

    /**
     * 积分记录 - AJAX翻页请求
     */
    public function get_score_list($t = '', $uid = 0, $p = 1, $pagesize = 8) {
        if (IS_AJAX) {
            $uid = $this->_get('uid', 'intval', 0);
            !$uid && $this->ajaxReturn(0, '用户不存在');          
            $p = $this->_get('p', 'intval', 1);
            $pagesize = $this->_get('pagesize', 'intval', 8);
            $t = $this->_get('t', 'trim');  //illegal
        }
        if($p<1){$p=1;}

        $limit = $pagesize*($p-1) . ',' . $pagesize;        
        $list = D('score_log')->user_score_log_list($t, $uid, $limit);
        $this->assign("score_list",$list);

        $this->assign("lang",L('action'));

        //AJAX分页请求
        if (IS_AJAX) {
            $data = array(
                'list' => $this->fetch("score_list"),
            ); 
            $this->ajaxReturn(1, "", $data);
        }
    }


    /**
     * 用户登陆
     */
    public function login() {
        $this->visitor->is_login && IS_AJAX && $this->ajaxReturn(0, '已登录');
        $this->visitor->is_login && $this->redirect('user/index');
        if (IS_POST) {
            //封IP start
            $kill_ip=C('pin_kill_ip');
            $kill_ip = explode("\n",$kill_ip);
            $myip = get_client_ip();
            if(in_array($myip,$kill_ip)){
                IS_AJAX && $this->ajaxReturn(0, '您的账户已被禁用');
                $this->error('您的账户已被禁用');
            }
            //封IP end

            //连接用户中心
            $passport = $this->_user_server();

            // echo "<pre>";print_r($_POST);print_r($_SESSION);echo "</pre>";exit;

            $type = $this->_post('type', 'trim');
            if ($type == 'mobile') {
                $mobile = $this->_post('mobile','trim');
                $verify_code = $this->_post('phone_verify', 'trim');
                $remember = $this->_post('remember');
                $uid = $passport->auth_mobile($mobile, $_SESSION['phone_verify_'.md5($mobile)],md5($verify_code));
                    if (!$uid) {
                        IS_AJAX && $this->ajaxReturn(0, $passport->get_error());
                        $this->error($passport->get_error());
                    }
                    else{
                    session('phone_verify_'.md5($mobile), NULL);
                    }
            }
            else{
                $username = $this->_post('username', 'trim');
                $password = $this->_post('password', 'trim');
                $remember = $this->_post('remember');

                $uid = $passport->auth($username, $password);
                if (!$uid) {
                    IS_AJAX && $this->ajaxReturn(0, $passport->get_error());
                    $this->error($passport->get_error());
                }
            }

            //登陆
            $this->visitor->login($uid, $remember);
            //登陆完成钩子
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'login');
            tag('login_end', $tag_arg);
            //同步登陆
            $synlogin = $passport->synlogin($uid);

            if (cookie('user_bind_info')) {
                $user_bind_info = object_to_array(cookie('user_bind_info'));
                $oauth = new oauth($user_bind_info['type']);
                $bind_info = array(
                    'pin_uid' => $uid,
                    'keyid' => $user_bind_info['keyid'],
                    'bind_info' => $user_bind_info['bind_info'],
                    'keyname' => $user_bind_info['keyname'],
                );
                $oauth->bindByData($bind_info);
                //临时头像转换
                $this->_save_avatar($uid, $user_bind_info['temp_avatar']);
                //清理绑定COOKIE
                cookie('user_bind_info', NULL);
                $this->success(L('bind_successe').$username.$synlogin, U('user/index'));
            }

            if (IS_AJAX) {
                // $this->assign('visitor', $this->visitor->info);
                // $resp = $this->fetch('public:top_visitor');
                $this->ajaxReturn(1, L('login_successe').$synlogin,$resp);
            } else {
                //跳转到登陆前页面（执行同步操作）
                $ret_url = $this->_post('ret_url', 'trim');
                //$this->success(L('login_successe').$synlogin, $ret_url);
                $this->success('欢迎回来，亲爱的'.$username.$synlogin, $ret_url);
            }
        } else {
            /* 同步退出外部系统 */
            if (!empty($_GET['synlogout'])) {
                $passport = $this->_user_server();
                $synlogout = $passport->synlogout();
            }
            if (IS_AJAX) {
                $resp = $this->fetch('dialog:login');
                $this->ajaxReturn(1, '', $resp);
            } else {
                //来路
                $ret_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : __APP__;
                $this->assign('ret_url', $ret_url);
                $this->assign('synlogout', $synlogout);
                $this->assign("page_seo",set_seo('用户登录'));
                $this->display();
            }
        }
    }

    /**
     * 用户退出
     */
    public function logout() {
        $this->visitor->logout();
        //同步退出
        $passport = $this->_user_server();
        $synlogout = $passport->synlogout();
        //跳转到退出前页面（执行同步操作）
        $this->success(L('logout_successe').$synlogout, U('user/index'));
    }

    /**
     * 用户绑定
     */
    public function binding() {
        $user_bind_info = object_to_array(cookie('user_bind_info'));
        $this->assign('user_bind_info', $user_bind_info);
        $this->assign("page_seo",set_seo('用户绑定'));
        $this->display();
    }

     /**
     * 已存在用户绑定
     */
    public function bind_exist() {
        $user_bind_info = object_to_array(cookie('user_bind_info'));
        $this->assign('user_bind_info', $user_bind_info);
        $this->assign("page_seo",set_seo('已存在用户绑定'));
        $this->display();
    }


    /**
    * 用户注册
    */
    public function register() {
        $this->visitor->is_login && IS_AJAX && $this->ajaxReturn(0, '已登录');
        $this->visitor->is_login && $this->redirect('user/index');

        //关闭注册
        if (!C('pin_reg_status')) {
            IS_AJAX && $this->ajaxReturn(0, C('pin_reg_closed_reason'));
            $this->error(C('pin_reg_closed_reason'));
        }

        if (IS_POST) {
            //封IP start
            $kill_ip=C('pin_kill_ip');
            $kill_ip = explode("\n",$kill_ip);
            $myip = get_client_ip();
            if(in_array($myip,$kill_ip)){
                IS_AJAX && $this->ajaxReturn(0, '您的IP已被禁用');
                $this->error('您的IP已被禁用');
            }
            //封IP end
            //方式
            // $type = $this->_post('type', 'trim', 'reg');
            // if ($type == 'reg') {
            //     //验证
            //     $agreement = $this->_post('agreement');
            //     !$agreement && $this->error(L('agreement_failed'));

            //     // 验证码
            //     $captcha = $this->_post('captcha', 'trim');
            //     if(session('captcha') != md5($captcha)){
            //         $this->error(L('captcha_failed'));
            //     }
            // }
            $mobile = $this->_post('mobile','trim');
            $verify_code = $this->_post('phone_verify', 'trim');
            if(!isset($_SESSION['phone_verify_'.md5($mobile)])){
                IS_AJAX && $this->ajaxReturn(0, '手机验证码未发送或已过期');
                $this->error('手机验证码未发送或已过期');
            }
            else if(session('phone_verify_'.md5($mobile)) != md5($verify_code)){
                IS_AJAX && $this->ajaxReturn(0, L('verify_code_error'));
                $this->error(L('verify_code_error'));
            }
            session('phone_verify_'.md5($mobile), NULL);
            $username = $this->_post('username', 'trim');
            // $email = $this->_post('email','trim');
            $password = $this->_post('password', 'trim');
            // $repassword = $this->_post('repassword', 'trim');
            // if ($password != $repassword) {
            //     $this->error(L('inconsistent_password')); //确认密码
            // }
            $gender = $this->_post('gender','intval', '0');
            //用户禁止
            $ipban_mod = D('ipban');
            $ipban_mod->clear(); //清除过期数据
            // $is_ban = $ipban_mod->where("(type='name' AND name='".$username."') OR (type='email' AND name='".$email."')")->count();
            $is_ban = $ipban_mod->where("(type='name' AND name='".$username."')")->count();
            $is_ban && IS_AJAX && $this->ajaxReturn(0, L('register_ban'));
            $is_ban && $this->error(L('register_ban'));
            //连接用户中心
            $passport = $this->_user_server();
            //注册
            $uid = $passport->register($username, $password, '', $gender, $mobile);
            !$uid && IS_AJAX && $this->ajaxReturn(0, $passport->get_error());
            !$uid && $this->error($passport->get_error());
            //是否通过朋友分享注册的
            if(trim($_SESSION['tg'])!=''){
                $suid = M("user")->field('try_user.*')->join("try_share as s on s.uid=try_user.id")->where("s.dm='$_SESSION[tg]'")->find();
                //查找一天是否超过5次
                $time=time();
                $start=strtotime(date('Y-m-d',$time));
                $end = strtotime(date('Y-m-d',$time))+24*3600;
                $count = M("score_log")->where("add_time>$start and $end>add_time and uid=$suid[id] and action='share_register'")->count();
                if($count<5){
                    //给用户加积分
                    M("user")->where("id=$suid[id]")->setField(array("coin"=>$suid['coin']+5,"offer"=>$suid['offer']+5,'score'=>$suid['score']+5,'exp'=>$suid['exp']+5));
                    //积分日志
                    set_score_log(array('id'=>$suid['id'],'username'=>$suid['username']),'share_register',5,5,5,5);
                }
            }
            //第三方帐号绑定
            if (cookie('user_bind_info')) {
                $user_bind_info = object_to_array(cookie('user_bind_info'));
                $oauth = new oauth($user_bind_info['type']);
                $bind_info = array(
                    'pin_uid' => $uid,
                    'keyid' => $user_bind_info['keyid'],
                    'bind_info' => $user_bind_info['bind_info'],
                );
                $oauth->bindByData($bind_info);
                //临时头像转换
                $this->_save_avatar($uid, $user_bind_info['temp_avatar']);
                //清理绑定COOKIE
                cookie('user_bind_info', NULL);
            }
            //注册完成钩子
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'register');
            tag('register_end', $tag_arg);
            //登陆
            $this->visitor->login($uid);
            //登陆完成钩子
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'login');
            tag('login_end', $tag_arg);
            //同步登陆
            $synlogin = $passport->synlogin($uid);

            if (IS_AJAX) {
                $this->ajaxReturn(1, L('register_successe').$synlogin);
            } else {
                $this->success(L('register_successe').$synlogin, U('user/index'));
            }
        } else {
            $this->assign("page_seo",set_seo('用户注册'));
            $this->display();
        }
    }


    /**
    * 找回密码
    */
    public function findpwd() {
        $this->visitor->is_login && $this->redirect('user/index');
        $this->_config_seo();
        $this->display();
    }

    /**
     * 重置密码
     */
    public function resetpwd() {
        $this->visitor->is_login && $this->redirect('user/index');

        if (IS_POST && isset($_SESSION['mobile'])) {
            $password   = $this->_post('password','trim');
            $repassword = $this->_post('repassword','trim');
            !$password && $this->error(L('no_new_password'));
            $password != $repassword && $this->error(L('inconsistent_password'));
            $passlen = strlen($password);
            if ($passlen < 6 || $passlen > 20) {
                $this->error('password_length_error');
            }

            $mobile = $_SESSION['mobile'];
            $user = $this->_mod->get_user_by_mobile($mobile);
            !$user && $this->error(L('user_not_exists'));
            session('mobile', NULL);

            //连接用户中心
            $passport = $this->_user_server();
            $result = $passport->edit($user['id'], '', array('password'=>$password), true);
            if (!$result) {
                $this->error($passport->get_error());
            }
            $this->success(L('reset_password_success'), U('user/login'));
        } else if (IS_POST) {
            $mobile = $this->_post('mobile','trim');
            !$mobile && $this->error("手机号码不能为空");

            //手机验证码
            $verify_code = $this->_post('phone_verify', 'trim');
            if(!isset($_SESSION['phone_verify_'.md5($mobile)])){
                $this->error('手机验证码未发送或已过期');
            }
            else if(session('phone_verify_'.md5($mobile)) != md5($verify_code)){
                $this->error(L('verify_code_error'));
            }
            session('phone_verify_'.md5($mobile), NULL);

            // 图片验证码
            $captcha = $this->_post('captcha', 'trim');
            if(session('captcha') != md5($captcha)){
                $this->error(L('captcha_failed'));
            }
            session('captcha', NULL);

            $user = $this->_mod->get_user_by_mobile($mobile);
            !$user && $this->error(L('user_not_exists'));
            $_SESSION['mobile'] = $mobile;

            $this->_config_seo();
            $this->display();
        }else{
            $this->redirect('user/findpwd');
        }
    }

    /**
     * 第三方头像保存
     */
    private function _save_avatar($uid, $img) {
        //获取后台头像规格设置
        $avatar_size = explode(',', C('pin_avatar_size'));
        //会员头像保存文件夹
        $avatar_dir = C('pin_attach_path') . 'avatar/' . avatar_dir($uid);
        !is_dir($avatar_dir) && mkdir($avatar_dir,0777,true);
        //生成缩略图
        $img = C('pin_attach_path') . 'avatar/temp/' . $img;
        foreach ($avatar_size as $size) {
            Image::thumb($img, $avatar_dir.md5($uid).'_'.$size.'.jpg', '', $size, $size, true);
        }
        @unlink($img);
    }

    /**
     * 用户消息提示
     */
    public function msgtip() {
        $result = D('user_msgtip')->get_list($this->visitor->info['id']);
        $this->ajaxReturn(1, '', $result);
    }

    /**
    * 基本信息修改
    */
    public function profile() {
        if( IS_POST ){
            foreach ($_POST as $key=>$val) {
                $_POST[$key] = Input::deleteHtmlTags($val);
            }
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
			$data['address']=$this->_post('address','trim');
            if (false !== M('user')->where(array('id'=>$this->visitor->info['id']))->save($data)) {
                $msg = array('status'=>1, 'info'=>L('edit_success'));
            }else{
                $msg = array('status'=>0, 'info'=>L('edit_failed'));
            }
            $this->assign('msg', $msg);
        }
        $info = $this->visitor->get();
        $this->assign('info', $info);
        $this->assign("page_seo",set_seo('基本信息修改'));
        $this->display();
    }
    /**
    * 绑定手机号
    */
     public function phone_bind() {
        if( IS_POST ){
            foreach ($_POST as $key=>$val) {
                $_POST[$key] = Input::deleteHtmlTags($val);
            }

            $verify_code = $this->_post('phone_verify', 'trim');
            $mobile=$this->_post('mobile','trim');
            if(!isset($_SESSION['phone_verify_'.md5($mobile)])){
                $this->error('手机验证码未发送或已过期');
            }
            else if(session('phone_verify_'.md5($mobile)) != md5($verify_code)){
                $this->error(L('verify_code_error'));
            }
            session('phone_verify_'.md5($mobile), NULL);
            $data['mobile']=$mobile;
            if (false !== M('user')->where(array('id'=>$this->visitor->info['id']))->save($data)) {
                $msg = array('status'=>1, 'info'=>L('edit_success'));
            }else{
                $msg = array('status'=>0, 'info'=>L('edit_failed'));
            }
            $this->assign('msg', $msg);
        }
        $info = $this->visitor->get();
        $this->assign('info', $info);
        $this->assign("page_seo",set_seo('手机号绑定'));
        $this->display();
    }

      /**
    * 发送手机验证码
    */
     public function phone_send() {
        $data['phone'] = $this->_post('mobile','trim');
        include_once LIB_PATH . 'Pinlib/ChuanglanSmsHelper/ChuanglanSmsApi1.php';
        $clapi  = new ChuanglanSmsApi();
        $code = String::randString(4, 1);
        $result = $clapi->sendSMS($data['phone'], '【白菜哦】菜友您好，您的验证码是'. $code  .",请勿向任何人提供此验证码.");

        if(!is_null(json_decode($result))){
            $output=json_decode($result,true);
            if(isset($output['code'])  && $output['code']=='0'){
                $msg= '短信发送成功！';
                session('phone_verify_'.md5($data['phone']),md5($code));
            }else{
                 $msg= $output['errorMsg'];
            }
        }
        $this->ajaxReturn($output['code'],  $msg, "123");
    }

    /**
     * 修改头像
     */
    public function upload_avatar() {
        if (!empty($_FILES['avatar']['name'])) {
            //会员头像规格
            //$avatar_size = explode(',', C('pin_avatar_size'));
            //回去会员头像保存文件夹
            $uid = abs(intval($this->visitor->info['id']));
            $suid = sprintf("%09d", $uid);
            $dir1 = substr($suid, 0, 3);
            $dir2 = substr($suid, 3, 2);
            $dir3 = substr($suid, 5, 2);
            $avatar_dir = $dir1.'/'.$dir2.'/'.$dir3.'/';
            //上传头像
            $suffix = '';
            //foreach ($avatar_size as $size) {
            //    $suffix .= '_'.$size.',';
            //}
            $result = $this->_upload($_FILES['avatar'], 'avatar/'.$avatar_dir,array() , md5($uid));
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
				//是否首次上传图片
				$info = M("user")->where("id=$uid")->find();
				if(intval($info['is_avator'])==0){//未传过则加积分
					$data['score']=$info['score']+10;
					$data['is_avator']=1;
					M("user")->where("id=$info[id]")->save($data);
					//积分日志
					set_score_log(array('id'=>$info['id'],'username'=>$info['username']),'upload_avator',10,'','','');
				}
                $data = IMG_ROOT_PATH.'/data/upload/avatar/'.$avatar_dir.md5($uid).'.jpg';
                $upyun = new UpYun1('baicaiopic', '528', 'lzw123456');
                $url = $data."\n";

                $upyun->purge($url);
                $this->ajaxReturn(1, L('upload_success'), $data);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }
    public function upload_avatar1() {
        $data=$this->_post('data');
        $uid = abs(intval($this->visitor->info['id']));
        $data = substr(strstr($data,','),1);
        $img=base64_decode($data);
        $file = 'upload/'.md5($uid).'.jpg';
        file_put_contents($file, $img);
        $suid = sprintf("%09d", $uid);
        $dir1 = substr($suid, 0, 3);
        $dir2 = substr($suid, 3, 2);
        $dir3 = substr($suid, 5, 2);
        $avatar_dir = $dir1.'/'.$dir2.'/'.$dir3.'/';
        $upload_path = '/'.C('pin_attach_path') . 'avatar/'. $avatar_dir .md5($uid).'.jpg';
        $upyun = new UpYun2('baicaiopic', '528', 'lzw123456');
        $fh = fopen($file, 'rb');
        $rsp = $upyun->writeFile($upload_path, $fh, True);   // 上传图片，自动创建目录
        fclose($fh);
        $upyun1 = new UpYun1('baicaiopic', '528', 'lzw123456');
        $data = IMG_ROOT_PATH.'/data/upload/avatar/'.$avatar_dir.md5($uid).'.jpg';
        $url = $data."\n";
        $upyun1->purge($url);
        @ unlink($file);
        $this->ajaxReturn(1, L('upload_success'), $data);
    }
    /**
     * 修改密码
     */
    public function password() {
        if( IS_POST ){
            $oldpassword = $this->_post('oldpassword','trim');
            $password   = $this->_post('password','trim');
            $repassword = $this->_post('repassword','trim');
            !$password && $this->error(L('no_new_password'));
            $password != $repassword && $this->error(L('inconsistent_password'));
            $passlen = strlen($password);
			$captcha = $this->_post('captcha', 'trim');
			if(session('captcha')!= md5($captcha)){
				$this->error(L('captcha_failed'));
			}
            if ($passlen < 6 || $passlen > 20) {
                $this->error('password_length_error');
            }
            //连接用户中心
            $passport = $this->_user_server();
            $result = $passport->edit($this->visitor->info['id'], $oldpassword, array('password'=>$password));
            if ($result) {
                $msg = array('status'=>1, 'info'=>L('edit_password_success'));
            } else {
                $msg = array('status'=>0, 'info'=>$passport->get_error());
            }
            $this->assign('msg', $msg);
        }
        $this->assign("page_seo",set_seo('修改密码'));
        $this->display();
    }

    /**
     * 帐号绑定
     */
    public function bind() {
        //获取已经绑定列表
        $bind_list = M('user_bind')->field('type')->where(array('uid'=>$this->visitor->info['id']))->select();
        $binds = array();
        if ($bind_list) {
            foreach ($bind_list as $val) {
                $binds[] = $val['type'];
            }
        }

        //获取网站支持列表
        $oauth_list = $this->oauth_list;
        foreach ($oauth_list as $type => $_oauth) {
            $oauth_list[$type]['isbind'] = '0';
            if (in_array($type, $binds)) {
                $oauth_list[$type]['isbind'] = '1';
            }
        }
        $this->assign('oauth_list', $oauth_list);
        $this->assign("page_seo",set_seo('帐号绑定'));
        $this->display();
    }

    /**
     * 个人空间banner背景设置
     */
    public function custom() {
        $cover = $this->visitor->get('cover');
        $this->assign('cover', $cover);
        $this->_config_seo();
        $this->display();
    }

    /**
     * 取消封面
     */
    public function cancle_cover() {
        $result = M('user')->where(array('id'=>$this->visitor->info['id']))->setField('cover', '');
        !$result && $this->ajaxReturn(0, L('illegal_parameters'));
        $this->ajaxReturn(1, L('edit_success'));
    }

    /**
     * 上传封面图片
     */
    public function upload_cover() {
        if (!empty($_FILES['cover']['name'])) {
            $data_dir = date('ym/d');
            $file_name = md5($this->visitor->info['id']);
            $result = $this->_upload($_FILES['cover'], 'cover/'.$data_dir, array('width'=>'900', 'height'=>'330', 'remove_origin'=>true), $file_name);
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $cover = $data_dir.'/'.$file_name.'_thumb.'.$ext;
                $data = '<img src="./data/upload/cover/'.$data_dir.'/'.$file_name.'_thumb.'.$ext.'?'.time().'">';
                //更新数据
                M('user')->where(array('id'=>$this->visitor->info['id']))->setField('cover', $cover);
                $this->ajaxReturn(1, L('upload_success'), $data);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }

    /**
     * 收货地址
     */
    public function address() {
        $user_address_mod = M('user_address');
        $id = $this->_get('id', 'intval');
        $type = $this->_get('type', 'trim', 'edit');
        if ($id) {
            if ($type == 'del') {
                $user_address_mod->where(array('id'=>$id, 'uid'=>$this->visitor->info['id']))->delete();
                $msg = array('status'=>1, 'info'=>L('delete_success'));
                $this->assign('msg', $msg);
            } else {
                $info = $user_address_mod->find($id);
                $this->assign('info', $info);
            }
        }
        if (IS_POST) {
            $consignee = $this->_post('consignee', 'trim');
            $address = $this->_post('address', 'trim');
            $zip = $this->_post('zip', 'trim');
            $mobile = $this->_post('mobile', 'trim');
            $id = $this->_post('id', 'intval');
            if ($id) {
                $result = $user_address_mod->where(array('id'=>$id, 'uid'=>$this->visitor->info['id']))->save(array(
                    'consignee' => $consignee,
                    'address' => $address,
                    'zip' => $zip,
                    'mobile' => $mobile,
                ));
                if ($result) {
                    $msg = array('status'=>1, 'info'=>L('edit_success'));
                } else {
                    $msg = array('status'=>0, 'info'=>L('edit_failed'));
                }
            } else {
                $result = $user_address_mod->add(array(
                    'uid' => $this->visitor->info['id'],
                    'consignee' => $consignee,
                    'address' => $address,
                    'zip' => $zip,
                    'mobile' => $mobile,
                ));
                if ($result) {
                    $msg = array('status'=>1, 'info'=>L('add_address_success'));
                } else {
                    $msg = array('status'=>0, 'info'=>L('add_address_failed'));
                }
            }
            $this->assign('msg', $msg);
        }
        $address_list = $user_address_mod->where(array('uid'=>$this->visitor->info['id']))->select();
        $this->assign('address_list', $address_list);
        $this->assign('page_seo',set_seo('收货地址'));
        $this->display();
    }

    /**
     * 检测用户
     */
    public function ajax_check() {
        $type = $this->_get('type', 'trim', 'email');
        $user_mod = D('user');
        switch ($type) {
            case 'email':
                $email = $this->_get('email', 'trim');
                $user_mod->email_exists($email) ? $this->ajaxReturn(0) : $this->ajaxReturn(1);
                break;

            case 'username':
                $username = $this->_get('username', 'trim');
                $user_mod->name_exists($username) ? $this->ajaxReturn(0) : $this->ajaxReturn(1);
                break;

            case 'mobile':
                $mobile = $this->_get('mobile', 'trim');
                $user_mod->mobile_exists($mobile) ? $this->ajaxReturn(0) : $this->ajaxReturn(1);
                break;
        }
    }



    // //爆料达人
    // public function getu(){
    //     $count=M("user")->count();
    //     $pager=$this->_pager($count,4);
    //     $user_list = M("user")->order("shares desc, id asc")->limit($pager->firstRow.",".$pager->listRows)->select();
    //     $arr = M("user_follow")->where("uid=$info[id]")->select();
    //     foreach($arr as $key=>$val){
    //         $follow_uid[$val['follow_uid']]=1;
    //     }
    //     foreach($user_list as $key=>$val){
    //         $user_list[$key]['follow']=$follow_uid[$val['id']];
    //     }
    //     $this->assign('user_list',$user_list);
    //     $resp = $this->fetch('dialog:ulist');
    //     $this->ajaxReturn(1, '', $resp);
    // }



	//我的评论
	public function comments(){
		!$this->visitor->is_login && $this->redirect('user/login');
		$user = $this->visitor->get();
		$t = $this->_get("t","trim");
		$mod_comment = M("comment");
		$time = time()-24*3600*10;
		$pagesize = 5;
		$where =" 1=1 and uid=$user[id] ";
		if($t=="r"){$where .=" and add_time>$time ";}
		$count = $mod_comment->where($where)->count();
		$pager = $this->_pager($count,$pagesize);
		$list = $mod_comment->where($where)->order("add_time desc,id desc")->limit($pager->firstRow.",".$pager->listRows)->select();
		foreach($list as $key=>$val){
			$arr=array();
			switch($val['xid']){
				case "1":$mod=M('item');$path="item";$url=U('item/index',array('id'=>$val['itemid']));break;
				case "2":$mod=M("zr");$path="zr";$url=U('zr/show',array('id'=>$val['itemid']));break;
				case "3":$mod=M("article");$path="article";$url=U('article/show',array('id'=>$val['itemid']));break;
			}
			$arr = $mod->where("id=$val[itemid]")->field("title,img")->find();
			$list[$key]['title']=$arr['title'];
			if($val['xid']=='1'){$list[$key]['img']=attach($arr['img'],$path);}else{$list[$key]['img']=attach($arr['img'],$path);}
			$list[$key]['url']=$url;
		}
		$this->assign('list',$list);
		$this->assign('page_bar',$pager->fshow());
		$this->assign('t',$t);
		$this->display();
	}
	//删除评论
	public function del_comment(){
		$id = $this->_get('id','intval');
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
			$this->ajaxReturn(1, '');
		}else{
			$this->ajaxReturn(0,'删除失败！');
		}
	}


	//我的分享
	public function share(){
		$user = $this->visitor->get();
		$t = $this->_get('t','trim');
		!$t&&$t='gn';
		$mod=M("share");
		$num['gn']=$mod->where("o.ismy=0 and try_share.uid='$user[id]' and try_share.xid=1")->join(array("try_item i ON i.id=try_share.item_id ","try_item_orig o ON o.id=i.orig_id"))->count();
		$num['ht']=$mod->where("o.ismy=1 and try_share.uid='$user[id]' and try_share.xid=1")->join(array("try_item i ON i.id=try_share.item_id ","try_item_orig o ON o.id=i.orig_id"))->count();
		$num['best']=$mod->where(" i.isbest=1 and try_share.uid='$user[id]' and try_share.xid=1")->join("try_item i ON i.id=try_share.item_id")->count();
		$num['zr']=$mod->where("try_share.uid='$user[id]' and try_share.xid=2")->join("try_zr z ON z.id=try_share.item_id")->count();
		$num['sd']=$mod->where("try_share.uid=$user[id] and try_share.xid=3 and a.cate_id=10")->join("try_article a ON a.id=try_share.item_id")->count();
		$num['gl']=$mod->where("try_share.uid=$user[id] and try_share.xid=3 and a.cate_id in(select id from try_article_cate where pid=9 or id=9)")->join("try_article a ON a.id=try_share.item_id")->count();
		$pagesize=5;
		$pager=$this->_pager($num[$t],$pagesize);
		switch($t){
			case "gn":
				$list = $mod->field("i.*,try_share.dm")->where("o.ismy=0 and try_share.uid='$user[id]' and try_share.xid=1")->join(array("try_item i ON i.id=try_share.item_id ","try_item_orig o ON o.id=i.orig_id"))->limit($pager->firstRow.",".$pager->listRows)->order("i.id desc")->select();
				break;
			case "ht":
				$list = $mod->field("i.*,try_share.dm")->where("o.ismy=1 and try_share.uid='$user[id]' and try_share.xid=1")->join(array("try_item i ON i.id=try_share.item_id ","try_item_orig o ON o.id=i.orig_id"))->limit($pager->firstRow.",".$pager->listRows)->order("i.id desc")->select();
				break;
			case "best":
				$list = $mod->field("i.*,try_share.dm")->where(" i.isbest=1 and try_share.uid='$user[id]' and try_share.xid=1")->join("try_item i ON i.id=try_share.item_id")->limit($pager->firstRow.",".$pager->listRows)->order("i.id desc")->select();
				break;
			case "zr":
				$list = $mod->field("z.*,try_share.dm")->where("try_share.uid=$user[id] and try_share.xid=2")->join("try_zr z ON z.id=try_share.item_id")->limit($pager->firstRow.",".$pager->listRows)->order("z.id desc")->select();
				break;
			case "sd":
				$list=$mod->field("a.*,try_share.dm")->where("try_share.uid=$user[id] and try_share.xid=3 and a.cate_id=10")->join("try_article a ON a.id=try_share.item_id")->limit($pager->firstRow.",".$pager->listRows)->order("a.id desc")->select();
				break;
			case "gl":
				$list=$mod->field("a.*,try_share.dm")->where("try_share.uid=$user[id] and try_share.xid=3 and a.cate_id in(select id from try_article_cate where pid=9 or id=9)")->join("try_article a ON a.id=try_share.item_id")->limit($pager->firstRow.",".$pager->listRows)->order("a.id desc")->select();
				break;
		}

		$this->assign('list',$list);
		$this->assign('page_bar',$pager->fshow());
		$this->assign('t',$t);
		$this->assign('num',$num);
		$this->assign('page_seo',set_seo('我的分享'));
		$this->display();
	}
	//删除文章
	public function del_article(){
		!$this->visitor->is_login && $this->redirect('user/login');
		$user = $this->visitor->get();
		$id = $this->_get('id','intval');
		!id&&$this->ajaxReturn(0,'无效的文章信息');
		$mod=M("article");
        $item = $mod->where("id=$id")->find();
            $time = time();
            if($item['add_time'] !=0 && ($time-$item['add_time'] > 604800)){
                $this->ajaxReturn(0,'该文章发布时间超过7天，不能删除，如需删除，请联系管理员。');
            }
		$r = $mod->where("uid=$user[id] and id=$id")->delete();
		if($r){
			//删除评论
			M('comment')->where("uid=$user[id] and itemid=$id and xid=3")->delete();
			//删除收藏信息
			M("likes")->where("uid=$user[id] and itemid=$id and xid=3")->delete();
			$this->ajaxReturn(1,'成功删除分享信息');
		}else{
			$this->ajaxReturn(0,'删除分享信息失败');
		}
	}
	//删除转让
	public function del_zr(){
		$user = $this->visitor->get();
		$id = $this->_get('id','intval');
		!id&&$this->ajaxReturn(0,'无效的转让商品信息');
		$mod=M("zr");
		$r = $mod->where("uid=$user[id] and id=$id")->delete();
		if($r){
			//删除评论
			M('comment')->where("uid=$user[id] and itemid=$id and xid=2")->delete();
			//删除收藏信息
			M("likes")->where("uid=$user[id] and itemid=$id and xid=2")->delete();
			$this->ajaxReturn(1,'成功删除闲置转让信息');
		}else{
			$this->ajaxReturn(0,'删除闲置转让信息失败');
		}
	}
    //关闭交易
    public function close_zr(){
        $user = $this->visitor->get();
        $id = $this->_get('id','intval');
        !id&&$this->ajaxReturn(0,'无效的转让商品信息');
        $mod=M("zr");
        $r=$mod->where("uid=$user[id] and id=$id")->getField('status');
        if($r ==4){
            M()->query("update try_zr set status=1 where id=$id");
            $this->ajaxReturn(2,'成功开启闲置转让信息');
        }elseif($r == 1){
            M()->query("update try_zr set status=4 where id=$id");
            $this->ajaxReturn(1,'成功关闭闲置转让信息');
        }


    }
	//签到
            public function sign(){
                $user = $this->visitor->get();
                $mod = M("user");
                //查询是否已签到
                $user = $mod->where("id=$user[id]")->find();
                $time = time();
                                     $date = strtotime(date('Ymd'));
                $signtime=$user['sign_date'];
                $ds=intval(($time-$signtime)/86400); //60s*60min*24h
                $data['id']=$user['id'];
                $data['sign_date']=$time;
                         //   if($signtime <$date){
                if($ds>1){//如果大于1，则签到清零+1,积分+5
                    $data['score']=$user['score']+5;
                                               $data['exp']=$user['exp']+5;
                    $data['sign_num']=1;
                    $data['all_sign']=$user['all_sign']+1;
                    $mod->save($data);
                    //积分日志
                    set_score_log($user,'sign',5,'','',5);
                    $this->ajaxReturn(1,"您已连续签到1天，成功获取5个积分！");
                           }    
                elseif($signtime >= $date){//当天以签到
                //}elseif($ds==0){//当天以签到
                    $this->ajaxReturn(0,"您今天已签到！");
                }else{//否则在原基础上+1
                    $max_score = $user['sign_num']+5;
                    $data['sign_num']=$user['sign_num']+1;
                    $data['all_sign']=$user['all_sign']+1;
                    if($max_score>10){$max_score=10;}
                    $data['score']=$user['score']+$max_score;
                                               $data['exp']=$user['exp']+$max_score;
                    $mod->save($data);
                    //积分日志
                    set_score_log($user,'sign',$max_score,'','',$max_score);
                    $this->ajaxReturn(1,'您已连续签到'.$data['sign_num'].'天，成功获取'.$max_score.'个积分！');
                }
            }

	public function del_share(){
		$dm=$this->_get('dm','trim');
		$mod=M("share");
		$r=$mod->where("dm='$dm'")->delete();
		if($r){
			$this->ajaxReturn("1",'删除成功');
		}else{
			$this->ajaxReturn("0",'删除失败');
		}
	}
    public function messg(){
        $info = $this->visitor->get();
        $_SESSION['user_info']['message']=M('message')->where("to_id='".$info['id']."' and ck_status=0")->count();
        $this->ajaxReturn("1",$_SESSION['user_info']['message']);
    }

      //查询某个用户的推送时段

    public function push_range_byuser($data){
        $userid = $data['userid'];
        $user = M("user");
        $list = $user->where(array('id'=>$userid))->field("push_range")->select();
       $code = 10001;
        if(count($list) < 1){
            $code = 10002;
        }
        echo get_result($code,$list);return ;
    }

    //更新推送时段

    public function push_range_modify($data){
        $push_info['push_range'] = $data['push_range'];
        $push_info['id'] = $data['userid'];
        $user = M("user");
        $user->save($push_info);
        echo get_result(10001, '更新成功!');
    }



    public function notify_tag_byuser(){
        $userid = $this->_post('userid','trim');
        $notify_tag = M("notify_tag");
        $list = $notify_tag->where(array('userid'=>$userid))->select();
        if(count($list) < 1){
           $this->ajaxReturn("0",'设置关注标签失败!');
        }
         $this->ajaxReturn("1",'设置关注标签成功!',$list);
    }

    //更新推送tag

    public function notify_tag_modify(){
        $tag['id'] = $this->_post('id','trim');
        $tag['tag'] = $this->_post('tag','trim');
        $tag['userid'] = $this->_post('userid','trim');
        $notify_tag = M("notify_tag");
        $list = $notify_tag->where(array('userid' =>$userid,'tag'=>$tag ))->select();
        if(count($list)>0){
            echo get_result(10001, '标签已存在!');
        }
        else{
        $notify_tag->save($tag);
        echo get_result(10001, '更新成功!');
        }
    }



    //是否选中推送
    public function is_notify_tag($data){
        $notify_tag = M("notify_tag");
        $list = $notify_tag->where(array("tag"=>$data['tag'],'userid' =>$data['userid'],'p_sign'=>1))->select();
         if(count($list)>0){
            echo get_result(10001, '已关注推送!');
        }
        else{
            echo get_result(10002, '未关注推送!');
        }
    }

     //是否选中关注
    public function is_follow_tag($data){
        $notify_tag = M("notify_tag");
        $list = $notify_tag->where(array("tag"=>$data['tag'],'userid' =>$data['userid'],'f_sign'=>1))->select();
         if(count($list)>0){
            echo get_result(10001, '已关注!');
        }
        else{
            echo get_result(10002, '未关注!');
        }
    }


}
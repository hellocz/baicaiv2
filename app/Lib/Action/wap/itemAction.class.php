<?php

class itemAction extends frontendAction {

    public function _initialize() {
        parent::_initialize();
        //访问者控制
        if (!$this->visitor->is_login && in_array(ACTION_NAME, array('share_item', 'fetch_item', 'publish_item', 'like', 'unlike', 'delete', 'comment','publish'))) {
            IS_AJAX && $this->ajaxReturn(0, L('login_please'));
            $this->redirect('user/login');
        }
    }

    /**
     * 商品详细页
     */
    public function index() {
        $id = $this->_get('id', 'intval');
        !$id && $this->_404();
        $item_mod = M('item');
        $item = $item_mod->field('id,cate_id,title,uid,img,uname,intro,price,url,likes,comments,tag_cache,seo_title,seo_keys,seo_desc,add_time,content,zan,status,orig_id,go_link')->where(array('id' => $id))->find();
		
		
		
        !$item && $this->error('该信息不存在或已删除');
		($item['status']==0)&&$this->error('该信息未通过审核');

          if(isset($_SESSION['admin']['role_id']) && $_SESSION['admin']['role_id'] == 1) {
           
        }
        else{
        ($item['add_time']>time() || $item['add_time']==0)&&$this->error('该信息暂未发布' . ($_SESSION['admin']['role_id']));
       }
        //来源
        $orig = M('item_orig')->field('name,img')->find($item['orig_id']);
        //商品相册
        $img_list = M('item_img')->field('url')->where(array('item_id' => $id))->order('ordid')->select();
        //标签
        $item['tag_list'] = unserialize($item['tag_cache']);
        //可能还喜欢
        $item_tag_mod = M('item_tag');
        $db_pre = C('DB_PREFIX');
        $item_tag_table = $db_pre . 'item_tag';
		$i=1;
		
        //第一页评论不使用AJAX利于SEO
        $item_comment_mod = M('item_comment');
        $pagesize = 8;
        $map = array('item_id' => $id);
        $count = $item_comment_mod->where($map)->count('id');
        $pager = $this->_pager($count, $pagesize);
        $pager->path = 'comment_list';
        $pager_bar = $pager->fshow();
        $cmt_list = $item_comment_mod->where($map)->order('id DESC')->limit($pager->firstRow . ',' . $pager->listRows)->select();
        $item_mod->where(array('id' => $id))->setInc('hits'); //点击量
		//凑单品等链接
		$item['go_link']=unserialize($item['go_link']);	
        $time = time();
        $time_day = $time - 86400;

        $item['content'] = preg_replace('/max-width:800px/','max-width:100%',$item['content']);
        $item['content'] = preg_replace('/<img/','<img style="max-width:100%"',$item['content']);

        if(strpos($item['content'], "www.baicaio.com") !== false){
              $item['content']= str_replace("www.baicaio.com","m.baicaio.com",$item['content']);
          }

        $orig_name=getly($item['orig_id']);

        $base1 = stripos($item['content'],$orig_name);

        $base2 = stripos($item['content'],"前往" . $orig_name);

        if($base2 == false || $base2-$base1 > 6){
        $item['content'] = preg_replace("/($orig_name)/i","<a href=/wap-orig-show-id-" . $item['orig_id'] . " target='_blank'>$1</a>",$item['content'],1);
        }

        $where_day['cate_id'] = $item['cate_id'];
        $where_day['add_time'] = array("lt",$time);
        $where_day['status'] = 1;
        $day_list=M('item')->field("id,orig_id,title,img,price,add_time,hits,comments,likes,zan")->where($where_day)->order("add_time desc")->limit(0,10)->select();
        foreach($day_list as $key=>$val){
            $day_list[$key]['orig_name']=getly($val['orig_id']);
            $day_list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits'] /10);
        }
        $this->assign('day_list',$day_list);

        $this->assign('item', $item);
        $this->assign('orig', $orig);
        $this->assign('img_list', $img_list);
        $this->assign('cmt_list', $cmt_list);
        $this->assign('page_bar', $pager_bar);
        $this->_config_seo(C('pin_seo_config.item'), array(
            'item_title' => $item['title'] . $item['price'],
            'item_intro' => substr(strip_tags($item['content']),0,200),
            'item_tag' => implode(' ', $item['tag_list']),
            'user_name' => $item['uname'],
            'seo_title' => $item['seo_title'],
            'seo_keywords' => $item['seo_keys'],
            'seo_description' => $item['seo_desc'],
        ));
		//面包削
		if($item['cate_id'])
		{
			$strpos = getpos($item['cate_id'],'');
		}
        $mod=M("item");
        if($type==""||$type=='isnice'){
            $where=" and isnice=1 ";
            $order =" add_time desc";
            $tab = "isnice";
        }else{
            $where=" and isbao=1 ";
            $order =" add_time desc";
            $tab = "isbao";
        }   
        $time=time();       
        $pagesize=18;
        $count = 500; //$mod->where("status=1 and add_time<$time ".$where)->count();
        $pager = $this->_pager($count,$pagesize);
        $list = $mod->where("status=1 and add_time<$time ".$where)->limit($pager->firstRow.",".$pager->listRows)->order($order)->select();
        foreach($list as $key=>$val){
            $list[$key]['orig_name']=getly($val['orig_id']);
            $list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits'] /10);
        }
        /*
        foreach ($list as $key=>$val) {
            if($val["sh_time"]>$val["ds_time"]){
                $list[$key]['add_time']=$val["sh_time"];
            }else{
                $list[$key]['add_time']=$val["ds_time"];
            } 
        }   
        */
        /*echo "<pre>";
        var_dump($list);*/
        $this->assign('item_list',$list);
        $this->assign("tab",$tab);
        $this->assign('pagebar',$pager->fshow());
        $p = $this->_get("p",'intval');
        if($p<1){$p=1;}
        $this->assign('p',$p);
		$this->assign("strpos",$strpos);
	//	$pre = $item_mod->where("id<$id and status=1")->field("id,title")->find();
	//	$next = $item_mod->where("id>$id and status=1")->field("id,title")->find();
	//	$this->assign("pre",$pre);
	//	$this->assign("next",$next);
		//评论
		$this->assign('xid',1);
		$this->assign('itemid',$id);
		
        $this->display();
    }

    /**
     * 点击去购买
     */
    public function tgo() {
        $url = $this->_get('to', 'base64_decode');
        redirect($url);
    }

    /**
     * AJAX获取评论列表
     */
    public function comment_list() {
        $id = $this->_get('id', 'intval');
        !$id && $this->ajaxReturn(0, L('invalid_item'));
        $item_mod = M('item');
        $item = $item_mod->where(array('id' => $id, 'status' => '1'))->count('id');
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        $item_comment_mod = M('item_comment');
        $pagesize = 8;
        $map = array('item_id' => $id);
        $count = $item_comment_mod->where($map)->count('id');
        $pager = $this->_pager($count, $pagesize);
        $pager->path = 'comment_list';
        $cmt_list = $item_comment_mod->where($map)->order('id DESC')->limit($pager->firstRow . ',' . $pager->listRows)->select();
        $this->assign('cmt_list', $cmt_list);
        $data = array();
        $data['list'] = $this->fetch('comment_list');
        $data['page'] = $pager->fshow();
        $this->ajaxReturn(1, '', $data);
    }

    /**
     * 评论一个商品
     */
    public function comment() {
        foreach ($_POST as $key=>$val) {
            $_POST[$key] = Input::deleteHtmlTags($val);
        }
        $data = array();
        $data['item_id'] = $this->_post('id', 'intval');
        !$data['item_id'] && $this->ajaxReturn(0, L('invalid_item'));
        $data['info'] = $this->_post('content', 'trim');
        !$data['info'] && $this->ajaxReturn(0, L('please_input') . L('comment_content'));
        //敏感词处理
        $check_result = D('badword')->check($data['info']);
        switch ($check_result['code']) {
            case 1: //禁用。直接返回
                $this->ajaxReturn(0, L('has_badword'));
                break;
            case 3: //需要审核
                $data['status'] = 0;
                break;
        }
        $data['info'] = $check_result['content'];
        $data['uid'] = $this->visitor->info['id'];
        $data['uname'] = $this->visitor->info['username'];

        //验证商品
        $item_mod = M('item');
        $item = $item_mod->field('id,uid,uname')->where(array('id' => $data['item_id'], 'status' => '1'))->find();
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        //写入评论
        $item_comment_mod = D('item_comment');
        if (false === $item_comment_mod->create($data)) {
            $this->ajaxReturn(0, $item_comment_mod->getError());
        }
        $comment_id = $item_comment_mod->add();
        if ($comment_id) {
            $this->assign('cmt_list', array(
                array(
                    'uid' => $data['uid'],
                    'uname' => $data['uname'],
                    'info' => $data['info'],
                    'add_time' => time(),
                )
            ));
            $resp = $this->fetch('comment_list');
            $this->ajaxReturn(1, L('comment_success'), $resp);
        } else {
            $this->ajaxReturn(0, L('comment_failed'));
        }
    }

    //分享商品弹窗
    public function share_item() {
		$this->assign('page_seo',set_seo('我要爆料'));
        $this->display();
    }

    //获取商品信息
    public function fetch_item() {		
        $url = $this->_post('url', 'trim');
        $url == '' && $this->error(L('please_input') . L('correct_itemurl'));
        //获取商品信息
        $itemcollect = new itemcollect();
        if($itemcollect->url_parse($url)){ 
			if (!$info = $itemcollect->fetch()) {
				//$this->error(L('fetch_item_failed'));
			}
		}
		//查询是否重复
		$cf = M("item")->where("key_id='$info[key_id]'")->find();
		//if($cf){
		//	$this->error('请勿重复提交');
		//}
		$this->assign('url', $url);
        $this->assign('item', $info);
		$item_cate=M("item_cate")->where("pid=0")->select();
		$this->assign('item_cate',$item_cate);
		$this->assign('page_seo',set_seo('我要爆料'));
        $this->display();
    }

    //发布商品
    public function publish_item() {
		$user = $this->visitor->get();		
        $item_mod = D('item');
		//过滤字符
		$kill_word = C("pin_kill_word");
		$kill_word = explode(",",$kill_word);
		if(in_array($_POST['content'],$kill_word)||in_array($_POST['title'],$kill_word)){
			$this->error('您发表的内容有非法字符');
		}
        $item = $item_mod->create();
        $item['intro'] = $this->_post('title', 'trim');
        $item['info'] = Input::deleteHtmlTags($item['info']);
        $item['uid'] = $this->visitor->info['id'];
        $item['uname'] = $this->visitor->info['username'];
		$item['isbao'] = '1';
		$status = $this->_post("status",'intval');
		if($status!=2){$status=0;}
        $item['status'] = $status;
		//添加凑单品，活动入口链接
		$arr[] = array('name'=>'直达链接','link'=>$this->_post('url',"trim"));
		$link_type=$this->_post("link_type");
		$link_url =$this->_post("link_url");
		foreach($link_type as $key=>$val){
			$arr[]=array('name'=>$val,'link'=>$link_url[$key]); 
		}
		$item['go_link']=serialize($arr);
		foreach($_POST['imgs'] as $key=>$val){
			$item['imgs'][$key]['url']=$val;
		}		
        //添加商品
        $result = $item_mod->publish($item);		
        if ($result) {
			
            //发布商品钩子
            $tag_arg = array('uid' => $item['uid'], 'uname' => $item['uname'], 'action' => 'pubitem');
            tag('pubitem_end', $tag_arg);
			$this->success(L('publish_item_success'),U('user/publish'));
        } else {
            $this->error($item_mod->getError());
        }
    }
	//上传图片
	public function uploadimg(){
		//上传图片
        if (!empty($_FILES['J_img']['name'])) {
            $art_add_time = date('ym/d');
            $result = $this->_upload($_FILES['J_img'], 'item/' . $art_add_time);
            if ($result['error']) {
				$this->ajaxReturn(0, $result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                //$data['J_img'] = $art_add_time . str_replace('.' . $ext, '.' . $ext, $result['info'][0]['savename']);
				$data['J_img'] = get_rout_img($art_add_time .'/'. str_replace('.' . $ext, '.' . $ext, $result['info'][0]['savename']),'item');
            }
        }
        $this->ajaxReturn(1, L('operation_success'),$data['J_img']);
	}
    /**
     * 喜欢一个商品
     * 返回status(todo)
     */
    public function like() {
        $id = $this->_get('id', 'intval');
        $aid = $this->_get('aid', 'intval');
        !$id && $this->ajaxReturn(0, L('invalid_item'));
        $item_mod = M('item');
        $item = $item_mod->field('id,uid,uname')->where(array('id' => $id, 'status' => '1'))->find();
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        $uid = $this->visitor->info['id'];
        $uname = $this->visitor->info['username'];
        $item['uid'] == $uid && $this->ajaxReturn(0, L('like_own')); //自己的商品
        $like_mod = M('item_like');
        //是否已经喜欢过
        $is_liked = $like_mod->where(array('item_id' => $item['id'], 'uid' => $uid))->count();
        $is_liked && $this->ajaxReturn(0, L('you_was_liked'));
        if ($like_mod->add(array('item_id' => $item['id'], 'uid' => $uid, 'add_time' => time()))) {
            //增加商品喜欢数
            $item_mod->where(array('id' => $id))->setInc('likes');
            //增加用户被喜欢数
            M('user')->where(array('id' => $item['uid']))->setInc('likes');
            //增加专辑喜欢
            $aid && M('album')->where(array('id' => $aid))->setInc('likes');
            //添加喜欢钩子
            $tag_arg = array('uid' => $uid, 'uname' => $uname, 'action' => 'likeitem');
            tag('likeitem_end', $tag_arg);
            $this->ajaxReturn(1, L('like_success'));
        } else {
            $this->ajaxReturn(0, L('like_failed'));
        }
    }

    /**
     * 删除喜欢
     */
    public function unlike() {
        $id = $this->_get('id', 'intval');
        !$id && $this->ajaxReturn(0, L('invalid_item'));
        $uid = $this->visitor->info['id'];
        $like_mod = M('item_like');
        if ($like_mod->where(array('uid' => $uid, 'item_id' => $id))->delete()) {
            //喜欢数不减少~
            $this->ajaxReturn(1, L('unlike_success'));
        } else {
            $this->ajaxReturn(1, L('unlike_failed'));
        }
    }

    /**
     * 删除商品
     */
    public function delete() {
        $id = $this->_get('id', 'intval');
        $album_id = $this->_get('album_id', 'intval');
        !$id && $this->ajaxReturn(0, L('invalid_item'));
        $uid = $this->visitor->info['id'];
        $uname = $this->visitor->info['username'];
        if ($album_id) {
            //删除专辑里面的商品
            $result = M('album')->where(array('id' => $album_id, 'uid' => $uid))->count();
            if ($result) {
                M('album_item')->where(array('album_id' => $album_id, 'item_id' => $id))->delete();
                //减少专辑商品数量
                M('album')->where(array('id' => $album_id))->setDec('items');
                //刷新专辑封面
                D('album')->update_cover($album_id);
                $this->ajaxReturn(1, L('del_item_success'));
            } else {
                $this->ajaxReturn(0, L('del_item_failed'));
            }
        } else {
            $result = D('item')->where(array('id' => $id, 'uid' => $uid))->delete();
            //减少用户分享数量
            M('user')->where(array('id' => $uid))->setDec('shares');
            if ($result) {
                //添加删除钩子
                $tag_arg = array('uid' => $uid, 'uname' => $uname, 'action' => 'delitem');
                tag('delitem_end', $tag_arg);
                $this->ajaxReturn(1, L('del_item_success'));
            } else {
                $this->ajaxReturn(0, L('del_item_failed'));
            }
        }
    }
	public function publish(){
		!$this->visitor->is_login && $this->redirect('user/login');
		$user = $this->visitor->get();
		$this->display();
	}
	
	public function edit(){
		 if (IS_POST) {
			$user = $this->visitor->get();
			$item_uid = M("item")->where("id=$_POST[id]")->getField('uid');
			$item_uid != $user['id'] && $this->_404();
			$item_mod = D('item');
			$item = $item_mod->create();
			$item['intro'] = $this->_post('title', 'trim');
			$item['info'] = Input::deleteHtmlTags($item['info']);
			$item['status'] = $this->_post("status",'intval');
			//添加凑单品，活动入口链接
			$link_type=$this->_post("link_type");
			$link_url =$this->_post("link_url");
			foreach($link_type as $key=>$val){
				if($link_url[$key]!=""){
					$arr[]=array('name'=>$val,'link'=>$link_url[$key]);
				}
			}
			$item['go_link']=serialize($arr);
			foreach($_POST['imgs'] as $key=>$val){
				$item['imgs'][$key]['url']=$val;
			}
			//编辑相册
			$imgs = M("item_img")->where("item_id=$item[id]")->select();
			$item_img_mod = D('item_img');
			foreach($item['imgs'] as $key=>$_img){
				$f=false;
				foreach($imgs as $k=>$v){
					if($_img['url']==$v['url']){
						$f=true;
					}
				}
				if($f==false){
					$_img['item_id'] = $item['id'];
					$item_img_mod->create($_img);
                    $item_img_mod->add();
				}
			}
			//编辑商品
			$result=$item_mod->where(array('id'=>$item['id'],'uid'=>$user['id']))->save($item);
			if ($result) {
				$this->success(L('publish_item_success'),U('user/publish'));
			} else {
				$this->error('编辑失败');
			}
        }else{
			!$this->visitor->is_login && $this->redirect('user/login');
			$user = $this->visitor->get();
			$id = $this->_get("id","intval");		 
			$item = M("item")->where("uid=$user[id] and id=$id")->find();
			!$id && $this->_404();
			!$item && $this->_404();
			//相册
			$item['imgs'] = M('item_img')->where(array('item_id'=>$id))->select();
			$item['go_link'] = unserialize($item['go_link']);
			$this->assign('item',$item);
			$this->assign('page_seo',set_seo('编辑爆料'));
			$this->display();
		}
	}
	
	public function delimg(){
		$id = $this->_get("id",'intval');
		$url = $this->_get("url",'trim');
		if($id){
			M("item_img")->where("id=$id")->delete();
		}
		if($url){
			if(strpos($url,"/",0)==0){
				$url = substr($url,(strlen($url)-1)*-1);
			}
			unlink($url);			
		}
		$this->ajaxReturn(1, '删除成功');
	}
}
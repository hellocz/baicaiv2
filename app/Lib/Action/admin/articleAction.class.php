<?php
class articleAction extends backendAction
{
    public function _initialize() {
        parent::_initialize();
        $this->_mod = D('article');
        $this->_cate_mod = D('article_cate');
    }

    public function _before_index() {
        $res = $this->_cate_mod->field('id,name')->select();
        $cate_list = array();
        foreach ($res as $val) {
            $cate_list[$val['id']] = $val['name'];
        }
        $this->assign('cate_list', $cate_list);

        $p = $this->_get('p','intval',1);
        $this->assign('p',$p);

        //默认排序
        $this->sort = 'id';
        $this->order = 'desc';
    }
	public function check(){
		$map=array();
		$map['status']=0;
		$count = $this->_mod->where($map)->count('id');
		$this->ajaxReturn(1,$count);
		exit;
	}
    public function check1(){
        $map=array();
        $map['status']=0;
        $mod = D($this->_name);
        $this->assign('search', array(
            'status'  =>  $map['status'],

        ));
        !empty($mod) && $this->_list($mod, $map);
       $this->display('index');
    }

    protected function _search() {
        $map = array();
        ($time_start = $this->_request('time_start', 'trim')) && $map['add_time'][] = array('egt', strtotime($time_start));
        ($time_end = $this->_request('time_end', 'trim')) && $map['add_time'][] = array('elt', strtotime($time_end)+(24*60*60-1));
        ($status = $this->_request('status'))&& $map['status'] = $status ;
        ($keyword = $this->_request('keyword', 'trim')) && $map['title'] = array('like', '%'.$keyword.'%');
        $cate_id = $this->_request('cate_id', 'intval');
        $selected_ids = '';
        if ($cate_id) {
            $id_arr = $this->_cate_mod->get_child_ids($cate_id, true);
            $map['cate_id'] = array('IN', $id_arr);
            $spid = $this->_cate_mod->where(array('id'=>$cate_id))->getField('spid');
            $selected_ids = $spid ? $spid . $cate_id : $cate_id;
        }
        $this->assign('search', array(
            'time_start' => $time_start,
            'time_end' => $time_end,
            'cate_id' => $cate_id,
            'selected_ids' => $selected_ids,
            'status'  => $status,
            'keyword' => $keyword,
        ));
        return $map;
    }

    public function _before_add()
    {
        $author = $_SESSION['pp_admin']['username'];
        $this->assign('author',$author);

        $site_name = D('setting')->where(array('name'=>'site_name'))->getField('data');
        $this->assign('site_name',$site_name);

        $first_cate = $this->_cate_mod->field('id,name')->where(array('pid'=>0))->order('ordid DESC')->select();
        $this->assign('first_cate',$first_cate);
		$orig_list = M("item_orig")->order("ordid asc")->field("id,name")->select();
        $settlesRes = array(); 
            foreach ($orig_list as $set) {
                $settlesRes[iconv('UTF-8', 'GBK', $set['name'])] = $set;
            }
            ksort($settlesRes);
		$this->assign("orig_list",$settlesRes);
		
    }

    protected function _before_insert($data) {

        //上传图片
        if (!empty($_FILES['img']['name'])) {
            $art_add_time = date('ym/d/');
            $result = $this->_upload($_FILES['img'], 'article/' . $art_add_time);
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $data['img'] = get_rout_img($art_add_time .'/'. str_replace('.' . $ext, '.' . $ext, $result['info'][0]['savename']),'article');
            }
        }
		$data['uid'] = 0;
        $data['uname'] = $_SESSION['admin']['username'];
		$data['add_time']=strtotime($_POST['add_time']);
        return $data;
    }

    public function _before_edit(){
        $id = $this->_get('id','intval');

        $article = $this->_mod->field('id,cate_id,item_cate_id')->where(array('id'=>$id))->find();
        $spid = $this->_cate_mod->where(array('id'=>$article['cate_id']))->getField('spid');
        if( $spid==0 ){
            $spid = $article['cate_id'];
        }else{
            $spid .= $article['cate_id'];
        }
        $this->assign('selected_ids',$spid);
        $spid_item_cate = M("item_cate")->where(array('id'=>$article['item_cate_id']))->getField('spid');
        if( $spid_item_cate==0 ){
            $spid_item_cate = $article['item_cate_id'];
        }else{
            $spid_item_cate .= $article['item_cate_id'];
        }
        $this->assign('selected_item_cate_ids',$spid_item_cate);
		$orig_list = M("item_orig")->order("ordid asc")->field("id,name")->select();
        $settlesRes = array(); 
            foreach ($orig_list as $set) {
                $settlesRes[iconv('UTF-8', 'GBK', $set['name'])] = $set;
            }
            ksort($settlesRes);
		$this->assign('img_dir',$this->_get_imgdir());
		$this->assign("orig_list",$settlesRes);
    }

    protected function _before_update($data) {
		//如果是管理员发表的则直接通过
		$item_uid=M("article")->where("id=$data[id]")->getField("uid");
		//if($item_uid==0){
		//	$data['status']=1;
		$data['add_time']=strtotime($_POST['add_time']);
        return $data;
    }

    /**
     * 单页管理
     */
    public function page() {
        $prefix = C('DB_PREFIX');
        $sort = $this->_request("sort", 'trim', 'ordid');
        $order = $this->_request("order", 'trim', 'DESC');

        $tree = new Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $result = $this->_cate_mod->field('id,pid,name,last_time')->join($prefix .'article_page on '.$prefix .'article_page.cate_id ='.$prefix .'article_cate.id')->where(array('type'=>1))->order($sort . ' ' . $order)->select();
        $array = array();
        foreach($result as $r) {
            //是否有下一级
            if ($this->_cate_mod->where(array('pid'=>$r['id']))->count('id')) {
                $r['str_manage'] = '';
            } else {
                $r['str_manage'] = '<a href="'.U('article/page_edit', array('cate_id'=>$r['id'])).'">'.L('edit').'</a>';
            }
            $r['parentid_node'] = ($r['pid'])? ' class="child-of-node-'.$r['pid'].'"' : '';
            $r['last_time'] = $r['last_time'] ? date('Y-m-d H:i:s', $r['last_time']) : '-';
            $array[] = $r;
        }
        $str  = "<tr id='node-\$id' \$parentid_node>
                <td align='center'>\$id</td>
                <td>\$spacer\$name</td>
                <td align='center'>\$last_time</td>
                <td align='center'>\$str_manage</td>
                </tr>";
        $tree->init($array);
        $list = $tree->get_tree(0, $str);
        $this->assign('list', $list);
        $this->assign('list_table', true);
        $this->display();
    }

    /**
     * 单页内容编辑
     */
    public function page_edit() {
        $page_mod = D('article_page');
        if (IS_POST) {
            if (false === $data = $page_mod->create()) {
                $this->error($page_mod->getError());
            }
            if (!$page_mod->where(array('cate_id'=>$data['cate_id']))->count()) {
                $page_mod->add($data);
            } else {
                $page_mod->save($data);
            }
            $this->success(L('operation_success'), U('article/page'));
        } else {
            $cate_id = $this->_get('cate_id','intval');
            $cate_info = $this->_cate_mod->field('id,name')->where(array('type'=>1, 'id'=>$cate_id))->find();
            !$cate_info && $this->redirect('article/page');
            $this->assign('cate_info', $cate_info);
            $info = $page_mod->where(array('cate_id'=>$cate_id))->find();
            $this->assign('info', $info);
            $this->display();
        }
    }
	public function set_score(){
		$id = $this->_get('id','intval');
		//查询文章类型
		$cate_id = M("article")->where("id=$id")->getField("cate_id");
		if($cate_id==10){
			$this->assign('min_score',20);
		}else{
			$this->assign('min_score',40);
		}
		$this->assign('id',$id);		
		$response = $this->fetch();
		$this->ajaxReturn(1, '', $response);
	}
	
	public function check_done(){
		$id = $this->_post('id','intval');
		$score = $this->_post('score','intval');
		$coin = $this->_post('coin','intval');
		$exp = $this->_post('exp','intval');
		$offer = $this->_post('offer','intval');
		$score=($score)?$score:5;
		$coin=($coin)?$coin:5;
		$exp=($exp)?$exp:5;
		$offer=($offer)?$offer:5;
		$article = M('article')->where("id=$id")->find();	
		$datas['id']=$id;
        $datas['status']=1;
		if($article){
			if(false !== M("article")->save($datas)){
				if($article['uid']>0){
					$user = M('user')->where("id=$article[uid]")->find();
					//设置积分
					set_score($user,"$score","$coin","$offer","$exp");
					//积分日志
					$xc = array();
					$xc['ftid']=$article['uid'];
					$xc['to_id']=$article['uid'];
					$xc['to_name']=$article['uname'];
					$xc['from_id']=0;
					$xc['from_name']='tryine';
					$xc['add_time']=time();
					if($article['cate_id'] ==10){
						$xc['info'] ='您的晒单>>'.$article['title'].'通过审核，感谢您的爆料,系统给您奖励积分：'.$score.'，金币：'.$coin.'，贡献值：'.$offer.'，经验：'.$exp.'.';
					}else{
						$xc['info'] ='您的攻略>>'.$article['title'].'通过审核，感谢您的爆料,系统给您奖励积分：'.$score.'，金币：'.$coin.'，贡献值：'.$offer.'，经验：'.$exp.'.';
					}

					M('message')->add($xc);
					set_score_log($user,'publish_article',"$score","$coin","$offer","$exp");			
				}
				IS_AJAX && $this->ajaxReturn(1, L('operation_success'),'', 'edit');
			}else {
                IS_AJAX && $this->ajaxReturn(0, L('operation_failure'),'', 'edit');
            }			
		} else {
            IS_AJAX && $this->ajaxReturn(0, L('illegal_parameters'),'', 'edit');
        }
	}
    /**
     * ajax获取标签
     */
    public function ajax_gettags() {
        $title = $this->_get('title', 'trim');
        if ($title) {
            $tags = D('tag')->get_tags_by_title($title);
            $tags = implode('、', $tags);
            $this->ajaxReturn(1, L('operation_success'), $tags);
        } else {
            $this->ajaxReturn(0, L('operation_failure'));
        }
    }
	
	/**
     * 文章图片上传目录
     *
     * @staticvar null $dir
     * @return string
     */
    private function _get_imgdir() {
        static $dir = null;
        if ($dir === null) {
            $dir = './data/upload/article/';
        }
        return $dir;
    }
}
<?php
class articleAction extends frontendAction {

    public function index(){
		$isbest = ($this->_get("isbest","intval")!="");
		$more = $this->_get('more','trim');
		$p=$this->_get('p') ? $this->_get('p','intval') : 1;
		$keywords = $this->_get('keywords','trim');
		if($isbest==1){
			$where['isbest']=1;
			$tab=1;
		}else{
			$tab=2;
		}
		$cate_id = $this->_get("id",'intval');
		$cate_id = ($cate_id!="")?$cate_id:9;
		//$spage_size = C('pin_wall_spage_size'); //每次加载个数
        //$spage_max = C('pin_wall_spage_max'); //每页加载次数
        //$page_size = $spage_size * $spage_max; //每页显示个数
		$pagesize=8;
		$start=($p-1)*$pagesize;
		$time=time();
		$where['status']=array('in','1,4');
		$where['add_time']=array('lt',$time);
		$where['_string']=" cate_id=$cate_id or cate_id in(select id from try_article_cate where pid=$cate_id) ";
		if($keywords){
			$where['_string'].=") AND (title like '%".$keywords."%'";
			$this->assign("keywords",$keywords);
		}
		$count = M("article")->where($where)->count();
		$pager = $this->_pager($count, $page_size);
		$article_list = M("article")->where($where)->order("add_time desc")->limit($start . ',' . $pagesize)->select();
		$this->assign("article_list",$article_list);
		
		if($more == 'more'){
			$more_arr="";
			foreach($article_list as $key=>$r){
				$more_arr.="<li><a href='".U('wap/article/show',array('id'=>$r['id']))."' title='".$r['title']."'><div class='image_wrap'>";
				$more_arr.="<div class='image'><img src='".attach($r['img'],'article')."' title='$r[title]' alt='$r[title]' /></div></div>";
				$more_arr.="<address><span>".fdate($r['add_time'])."</span>".$r['sc']."</address><h2>".$r['title']."</h2>";
				$more_arr.="<div class='tips'><span><i class='icons icon_comment'></i>".$r['comments']."</span></div></a></li>";
			}
			echo $more_arr;
			exit;
		}
		
		$this->assign("tab", $tab);	
		$this->assign("id",$cate_id);
		$this->assign("count",$count);
		$this->assign("pagesize",$pagesize);
		
		//$hot_list = M("article")->where($where)->order("ishot desc,id desc")->limit(10)->select();
		//$this->assign('hot_list',$hot_list);
		//SEO信息
		$seo = M("article_cate")->where("id='$cate_id'")->find();
		$this->_config_seo(C('pin_seo_config.cate'), array(
		'cate_name' => $seo['name'],
		'seo_title' => $seo['seo_title'],
		'seo_keywords' => $seo['seo_keys'],
		'seo_description' => $seo['seo_desc'],
		));	
		$this->assign("bcid",getbcid($cate_id));
        $this->display();
    }

    public function show() {
		$id=$this->_get("id","intval");
		!$id && $this->_404();
		$model = M("article");
		$item = $model->where("id=$id")->find();
		!$item&&$this->error('文章内容不存在或未通过审核');
		//标签
        $item['tag_list'] = explode(" ",$item['tags']);
		//面包削
		$this->assign("strpos",getapos($item['cate_id'],''));
		//可能还喜欢
        $item_tag_mod = M('item_tag');
        $db_pre = C('DB_PREFIX');
        $item_tag_table = $db_pre . 'item_tag';
        $item['tag_list'] = explode("、",$item['tags']);
        $maylike_list = array_slice($item['tag_list'], 0, 3, true);
		$i=1;
        foreach ($maylike_list as $key => $val) {
            $maylike_list[$key] = array('name' => $val);
            //$maylike_list[$key]['list'] = $item_tag_mod->field('i.id,i.img,i.intro,i.title,' . $item_tag_table . '.tag_id')->where(array($item_tag_table . '.tag_id' => $key, 'i.id' => array('neq', $id)))->join($db_pre . 'item i ON i.id = ' . $item_tag_table . '.item_id')->order('i.id DESC')->limit(9)->select();
			$where_maylike_list['tag_cache'] = array('like', '%'.$val.'%');
			$where_maylike_list['add_time'] = array('lt', time());
			$where_maylike_list['status'] = 1;

			$maylike_list[$key]['list'] = M("item")->field("id,img,intro,title")->where($where_maylike_list)->order("add_time desc")->limit(4)->select();
			foreach($maylike_list[$key]['list'] as $k=>$v){
				$maylike_list[$key]['list'][$k]['num'] = $i++;
			}
        }
		$this->assign('maylike_list', $maylike_list);

		$item['info'] = preg_replace('/max-width:800px/','max-width:100%',$item['info']);
        $item['info'] = preg_replace('/<img/','<img style="max-width:100%"',$item['info']);

        $add_time = intval($item['add_time']);
        $time = time();
		
		//上下页
		$pre = $model->where("add_time<$add_time and (status=1 or status=4) and cate_id=$item[cate_id]")->order("add_time desc,id desc")->field("id,title")->find();
		$next = $model->where("add_time>$add_time and add_time <$time and (status=1 or status=4) and cate_id=$item[cate_id]")->order("add_time desc,id desc")->field("id,title")->find();
		$this->assign("pre",$pre);
		$this->assign("next",$next);
		$this->assign('item',$item);
		$this->assign("bcid",getbcid($item['cate_id']));
		//评论
		$this->assign('xid',3);
		$this->assign('itemid',$id);
		$this->_config_seo(array('title'=>'{article_title}','keywords' => '{article_tag}','description' => '{article_intro}' ), array(
			'article_title' => $item['title'],
            'article_intro' => $item['intro'],
            'article_tag' => implode(' ', $item['tag_list']),
            'seo_title' => $item['seo_title'],
            'seo_keywords' => $item['seo_keys'],
            'seo_description' => $item['seo_desc'],
        ));
    	$this->display();
    }
	//发布晒单、攻略
	public function publish(){
		$t = $this->_get('t',"trim");
		!$t && $this->_404();
		if($t=='sd'){$tk="晒单";}else{$tk="攻略";}
		$this->assign('page_seo',set_seo('发布'.$tk));
		$this->display('publish_'.$t);
	}
	public function insert(){
		$mod = D("article");
		$t=$this->_post('t',"trim");
		//过滤字符
		$kill_word = C("pin_kill_word");
		$kill_word = explode(",",$kill_word);
		if(in_array($_POST['info'],$kill_word)||in_array($_POST['title'],$kill_word)){
			$this->error('您发表的内容有非法字符');
		}
		if (false === $data = $mod->create()) {
			IS_AJAX && $this->ajaxReturn(0, $mod->getError());
			$this->error($mod->getError());
		}
		$user = $this->visitor->get();
		$data['uid']=$user['id'];
		$data['uname']=$user['username'];
		$data['author']=$user['username'];		
		$data['intro']=msubstr(strip_tags($data['info']),0,250);
		$data['status']=$_POST['status'] == 2 ? 2 : 0;
		if($data['tags']==""){
			$data['tags'] = D('tag')->get_tags_by_title($data['title']);
            $data['tags'] = implode(' ', $data['tags']);
		}//print_r($data);exit;
		
		if( $mod->add($data) ){
			if( method_exists($this, '_after_insert')){
				$id = $mod->getLastInsID();
				$this->_after_insert($id);
			}
			IS_AJAX && $this->ajaxReturn(1, L('operation_success'), '', 'add');
			if($t=='sd'){
				$jumpUrl=U('wap/user/publish',array('t'=>'sd'));
			}else{
				$jumpUrl=U('wap/user/publish',array('t'=>'gl'));
			}
			$this->success(L('操作成功'),$jumpUrl);
		} else {
			IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
			$this->error(L('操作失败'));
		}
	}
	//上传图片
	public function uploadimg(){
		//上传图片
        if (!empty($_FILES['J_img']['name'])) {
            $art_add_time = date('ym/d');
            $result = $this->_upload($_FILES['J_img'], 'article/' . $art_add_time);
            if ($result['error']) {
				$this->ajaxReturn(0, $result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $data['J_img'] = $art_add_time .'/'. str_replace('.' . $ext, '.' . $ext, $result['info'][0]['savename']);
            }
        }
        $this->ajaxReturn(1, L('operation_success'),$data['J_img']);
	}
	//修改晒单/攻略信息
	public function edit(){
		$id=$this->_request('id','intval');
		!$id&&$this->_404();
		$t = $this->_request('t','trim');
		!$t && $this->_404();
		if($t=='scg' || $t=='sth'){$t='sd';}
		if($t=='gcg' || $t=='gth'){$t='gl';}
		$mod = D("article");
		if(IS_POST){
			if (false === $data = $mod->create()) {
				IS_AJAX && $this->ajaxReturn(0, $mod->getError());
				$this->error($mod->getError());
			}
			$user = $this->visitor->get();		
			$data['intro']=msubstr(strip_tags($data['info']),0,250);
			$data['status']=$this->_post("status","intval");
			if($data['tags']==""){
				$data['tags'] = D('tag')->get_tags_by_title($data['title']);
				$data['tags'] = implode(' ', $data['tags']);
			}			
			if( $mod->save($data) ){
				IS_AJAX && $this->ajaxReturn(1, L('operation_success'), '', 'edit');
				$this->success(L('operation_success'),U('user/publish',array('t'=>$t)));
			} else {
				IS_AJAX && $this->ajaxReturn(0, L('operation_failure'));
				$this->error(L('operation_failure'));
			}
		}else{			
			$item = $mod->where("id=$id")->find();
			$this->assign('item',$item);
			$this->assign('t',$t);
			if($t=='sd'){$pt="编辑晒单";}else{$pt='编辑攻略';}
			$this->assign('page_seo',set_seo($pt));
			$template = ($t=='sd')?'edit_sd':'edit_gl';
			$this->display($template);
		}
	}
}
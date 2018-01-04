<?php

/**
 * 逛宝贝页面
 */
class bookAction extends frontendAction {

    public function _initialize() {
        parent::_initialize();
        $this->assign('nav_curr', 'book');
    }

    /**
     * 逛宝贝首页
     */
    public function index() {
        $this->display();
    }

    public function index_ajax() {
        $tag = $this->_get('tag', 'trim'); //标签
        $sort = $this->_get('sort', 'trim', 'hot'); //排序
        switch ($sort) {
            case 'hot':
                $order = 'hits DESC,id DESC';
                break;
            case 'new':
                $order = 'id DESC';
                break;
        }
        $where = array();
        $tag && $where['intro'] = array('like', '%' . $tag . '%');
        $this->wall_ajax($where, $order);
    }

    /**
     * 按分类查看
     */
    public function cate() {
        $cid = $this->_get('cid', 'intval');
        !$cid && $this->_404();
        //分类数据
        if (false === $cate_data = F('cate_data')) {
            $cate_data = D('item_cate')->cate_data_cache();
        }
        //当前分类信息
        if (isset($cate_data[$cid])) {
            $cate_info = $cate_data[$cid];
        } else {
            $this->_404();
        }
        //分类列表
        if (false === $cate_list = F('cate_list')) {
            $cate_list = D('item_cate')->cate_cache();
        }
        //分类关系
        if (false === $cate_relate = F('cate_relate')) {
            $cate_relate = D('item_cate')->relate_cache();
        }
        //获取当前分类的顶级分类
        $tid = $cate_relate[$cid]['tid'];

        //商品
        $sort = $this->_get('sort', 'trim');
        $min_price = $this->_get('min_price', 'intval');
        $max_price = $this->_get('max_price', 'intval');
        //条件
		$time=time();
        $where = array();
		$where['add_time']=array('lt',$time);
        //排序：潮流(pop)，最热(hot)，最新(new)
        switch ($sort) {
            case 'pop':
                $order = 'likes DESC';
                break;
            case 'hot':
                $order = 'hits DESC';
                break;
            case 'new':  
				$order = 'id DESC';
                break;
			default: 
				$order = 'id DESC';
				break;
        }
        //分类
        if ($cate_info['type'] == 0) {
            $min_price && $where['price'][] = array('egt', $min_price);
            $max_price && $where['price'][] = array('elt', $max_price); //价格
            //实物分类
            $cate_relate[$cid]['sids'][] = $cid;
            $where['cate_id'] = array('in', $cate_relate[$cid]['sids']);
            $this->waterfall($where, $order);
        } else {
            //标签组
            $min_price && $where['i.price'][] = array('egt', $min_price);
            $max_price && $where['i.price'][] = array('elt', $max_price); //价格
            $db_pre = C('DB_PREFIX');
            $item_tag_table = $db_pre . 'item_tag';
            $tag_ids = M('item_cate_tag')->where(array('cate_id' => $cid))->getField('tag_id', true);
            if ($tag_ids) {
                $where[$item_tag_table . '.tag_id'] = array('IN', $tag_ids);
                $pentity_id = D('item_cate')->get_pentity_id($cid); //向上找实体分类
                $cate_relate[$pentity_id]['sids'][] = $pentity_id;
                $where['i.cate_id'] = array('IN', $cate_relate[$pentity_id]['sids']); //分类条件
                $this->tcate_waterfall($where, 'i.' . $order);
            }
        }

        $this->assign('cate_list', $cate_list); //分类
        $this->assign('tid', $tid); //顶级分类ID
        $this->assign('cate_info', $cate_info); //当前分类信息
        $this->assign('sort', $sort); //排序
        $this->assign('min_price', $min_price); //最低价格
        $this->assign('max_price', $max_price); //最高价格
        $this->assign('nav_curr', 'cate'); //导航设置
        //SEO
        $this->_config_seo(C('pin_seo_config.cate'), array(
            'cate_name' => $cate_info['name'],
            'seo_title' => $cate_info['seo_title'],
            'seo_keywords' => $cate_info['seo_keys'],
            'seo_description' => $cate_info['seo_desc'],
        ));
		//面包削
		$this->assign("strpos",getpos($cid,''));
        $this->display();
    }
	
	public function cate_ajax(){
		$spage_size = C('pin_wall_spage_size'); //每次加载个数
        $spage_max = C('pin_wall_spage_max'); //加载次数
        $p = $this->_get('p', 'intval', 1); //页码
		$cid = $this->_get('cid', 'intval');
        //条件
        $where = array('status'=>'1','cate_id'=>$cid);
		//排序
		$order = 'id DESC';
        //计算开始
        $start = $spage_size * $spage_max * ($p - 1);
        $item_mod = M('item');
        $count = $item_mod->where($where)->count('id');
        $field == '' && $field = 'id,uid,uname,title,intro,img,price,likes,comments,comments_cache,url,add_time,orig_id';
        $item_list = $item_mod->field($field)->where($where)->order($order)->limit($start.','.$spage_size * $spage_max)->select();
		foreach($item_list as $key=>$val){
			$item_list[$key]['orig_name']=getly($val['orig_id']);
		}
        $this->assign('item_list', $item_list);
        $resp = $this->fetch('public:item_list');
        $data = array(
            'isfull' => 1,
            'html' => $resp
        );
        $count <= $start + $spage_size && $data['isfull'] = 0;
        $this->ajaxReturn(1, '', $data);
	}
	
	public function gny(){
		$tp = $this->_get('tp',"intval");
		$isnice = $this->_get('isnice','intval');
		$isbao = $this->_get("isbao","intval");
		$ispost = $this->_get('ispost','intval');
		$orig_id = $this->_get('origid','intval');
		$cateid = $this->_get('cateid','intval');
		
		$keywords = $this->_get('keywords','trim');
		$more = $this->_get('more','trim');
		$p=$this->_get('p') ? $this->_get('p','intval') : 1;
		if($isnice==""&&$isbao==""){
			$isnice = 1;
		}
		if($isnice==1){
			$where .=" and i.isnice=1 ";
			$order =" i.isnice desc,";
			$tab = "isnice";
		}
		if($isbao==1){
			$where .=" and i.isbao=1 ";
			$order =" i.isbao desc,";
			$tab = "isbao";
		}
		if($ispost==1){
			$where .= " and i.ispost=1 ";
		}
		if($orig_id){
			$where .= " and i.orig_id=$orig_id ";
		}else{
			$orig_id=0;
		}
		if($cateid){
			$where .= " and i.cate_id=$cateid ";
		}else{
			$cateid=0;
		}
		if($keywords){
			$where .= " and i.title like '%".$keywords."%' ";
			$this->assign('keywords', $keywords);
		}
		$time=time();
		$db_pre = C('DB_PREFIX');
		//$spage_size = C('pin_wall_spage_size'); //每次加载个数
        //$spage_max = C('pin_wall_spage_max'); //每页加载次数
        //$page_size = $spage_size * $spage_max; //每页显示个数
		$pagesize=18;
		$start=($p-1)*$pagesize;
		$item_orig = M("item_orig");
		$count = $item_orig->where($db_pre."item_orig.ismy='$tp' and i.status=1 and i.add_time<$time ".$where)->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->count();
		//$pager = $this->_pager($count, $page_size);
        !$field && $field = 'i.id,i.uid,i.uname,i.title,i.intro,i.img,i.price,i.likes,i.comments,i.comments_cache,i.add_time,i.orig_id,i.url,i.go_link,i.zan';
        $item_list = $item_orig->where($db_pre."item_orig.ismy='$tp' and i.status=1 and i.add_time<$time ".$where)->join($db_pre . 'item i ON i.orig_id = ' . $db_pre . 'item_orig.id')->field($field)->order($order."i.id desc")->limit($start. ',' . $pagesize)->select();
		
		foreach ($item_list as $key => $val) {
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
        }
		$this->assign('item_list', $item_list);
		
		if($more == 'more'){
			$more_arr="";
			foreach($item_list as $key=>$r){
				$more_arr.="<li><a href='".U('wap/item/index',array('id'=>$r['id']))."' title='".$r['title']."'><div class='image_wrap'>";
				$more_arr.="<div class='image'><img src='".attach($r['img'],'item')."' title='$r[title]' alt='$r[title]' /></div></div>";
				$more_arr.="<address><span>".fdate($r['add_time'])."</span>".getly($r['orig_id'])."</address><h2>".$r['title']."</h2>";
				$more_arr.="<div class='tips'><span><i class='icons icon_comment'></i>".$r['comments']."</span></div></a></li>";
			}
			echo $more_arr;
			exit;
		}
		//当前页码
        //$p = $this->_get('p', 'intval', 1);
        //$this->assign('p', $p);
        //$this->assign('page_bar', $pager->fshow());
        
		//热门置顶
		//$hot_list = $item_orig->where($db_pre."item_orig.ismy=$tp and i.status=1 and i.add_time<$time ")->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->order("i.hits,i.id desc")->limit(10)->select();
		//$this->assign("hot_list",$hot_list);
		//SEO
		if($tp==1){//海淘
			$this->_config_seo(C('pin_seo_config.cate'), array(
            'cate_name' => '海淘频道',
            'seo_title' => $cate_info['seo_title'],
            'seo_keywords' => $cate_info['seo_keys'],
            'seo_description' => $cate_info['seo_desc'],
			));
		}elseif($tp==0){
		$page_seo['title'] = "国内商品优惠劵|国内商品活动信息优惠劵";
        $page_seo['keywords'] = "国内商品优惠劵|国内商品活动信息优惠劵";
        $page_seo['description'] = "白菜哦实时更新国内电商优惠促销活动优惠劵,众多神价都是全网独家。电商自营,和品牌直营的旗舰店,在正品行货中寻觅神价格,好活动。";
		}
		
		$this->assign("tp",$tp);
		$this->assign("tab",$tab);
		$this->assign("origid",$orig_id);
		$this->assign("cateid",$cateid);
		$this->assign("count",$count);
		$this->assign("pagesize",$pagesize);
        if($cateid!=0){
            $cate=M("item_cate")->where("id=$cateid")->find();
            $this->assign('cate_url',U("book/gny",array('tp'=>$tp,'origid'=>$orig_id,)));
            $this->assign('cate',$cate['name']);
        $page_seo['title'] = $cate['seo_title'];
        $page_seo['keywords'] = $cate['seo_keys'];
        $page_seo['description'] = $cate['seo_desc'];
        }
		if($orig_id!=0){
			$orig=M("item_orig")->where("id=$orig_id")->find();
			$this->assign('orig_url',U("book/gny",array('tp'=>$tp,'cateid'=>$cateid,)));
			$this->assign('orig',$orig['name']);
            $page_seo['title'] = $orig['seo_title'];
            $page_seo['keywords'] = $orig['seo_keys'];
            $page_seo['description'] = $orig['seo_desc'];
		}
		$this->assign('page_seo', $page_seo);
		//可直邮
		if($ispost==1){$cispost=0;}else{$cispost=1;}
		$this->assign("lb_url",U('book/gny',array('tp'=>$tp,'tab'=>$tab,'dss'=>'lb',"$tab"=>'1',"ispost"=>$cispost)));
		$this->assign("cc_url",U('book/gny',array('tp'=>$tp,'tab'=>$tab,'dss'=>'cc',"$tab"=>'1',"ispost"=>$cispost)));
		$this->assign("post_url",U('book/gny',array('tp'=>$tp,'tab'=>$tab,'dss'=>$dss,"$tab"=>1,"ispost"=>$cispost)));
		$this->assign('ispost',$ispost);
		$this->display();
	}
	public function best(){		
		$more = $this->_get('more','trim');
		$p=$this->_get('p') ? $this->_get('p','intval') : 1;
		$db_pre = C('DB_PREFIX');
        $pagesize = 18; //每页显示个数
		$start=($p-1)*$pagesize;
		$item= M("item");
		$count = $item->where("isbest='1' and status=1 ")->count();
		//$pager = $this->_pager($count, $page_size);
		$time=time();
        $item_list = $item->where("isbest='1' and status=1 and add_time<$time ")->order("isnice desc,ishot desc,id desc")->limit($start. ',' . $pagesize)->select();
		/*foreach ($item_list as $key => $val) {
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
			//商品相册
			$item_list[$key]['img_list'] = M('item_img')->field('url')->where(array('item_id' => $val['id']))->order('ordid')->select();
        }*/
		$this->assign('item_list', $item_list);
		
		if($more == 'more'){
			$more_arr="";
			foreach($item_list as $key=>$r){
				$more_arr.="<li><a href='".U('wap/item/index',array('id'=>$r['id']))."' title='".$r['title']."'><div class='image_wrap'>";
				$more_arr.="<div class='image'><img src='".attach($r['img'],'item')."' title='$r[title]' alt='$r[title]' /></div></div>";
				$more_arr.="<address><span>".fdate($r['add_time'])."</span>".getly($r['orig_id'])."</address><h2>".$r['title']."</h2>";
				$more_arr.="<div class='tips'><span><i class='icons icon_comment'></i>".$r['comments']."</span></div></a></li>";
			}
			echo $more_arr;
			exit;
		}
		//当前页码
        //$p = $this->_get('p', 'intval', 1);
        //$this->assign('p', $p);
        //$this->assign('page_bar', $pager->fshow());        
		$this->assign("bcid","best");
		$this->assign("count",$count);
		$this->assign("pagesize",$pagesize);
		//热门置顶
		//$hot_list = $item->where("isbest='1' and status=1 and add_time<$time ")->order("hits,id desc")->limit(10)->select();
		//$this->assign("hot_list",$hot_list);
		$this->_config_seo(C('pin_seo_config.cate'), array(
            'cate_name' => '精品汇',
            'seo_title' => $cate_info['seo_title'],
            'seo_keywords' => $cate_info['seo_keys'],
            'seo_description' => $cate_info['seo_desc'],
			));
		$this->display();
	}
    /**
     * 标签分类瀑布
     */
    public function tcate_waterfall($where, $order = 'i.id DESC', $field = '') {
        $db_pre = C('DB_PREFIX');
        $item_tag_table = $db_pre . 'item_tag';
        $item_tag_mod = M('item_tag');
        $where_init = array('i.status' => '1');
        $where = array_merge($where_init, $where);
        $count = $item_tag_mod->where($where)->join($db_pre . 'item i ON i.id = ' . $item_tag_table . '.item_id')->count();
        $spage_size = C('pin_wall_spage_size'); //每次加载个数
        $spage_max = C('pin_wall_spage_max'); //每页加载次数
        $page_size = $spage_size * $spage_max; //每页显示个数
        $pager = $this->_pager($count, $page_size);
        !$field && $field = 'i.id,i.uid,i.uname,i.title,i.intro,i.img,i.price,i.likes,i.comments,i.comments_cache,go_link,i.add_time';
        $item_list = $item_tag_mod->field($field)->where($where)->join($db_pre . 'item i ON i.id = ' . $item_tag_table . '.item_id')->order($order)->limit($pager->firstRow . ',' . $spage_size)->select();
        foreach ($item_list as $key => $val) {
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
        }
        $this->assign('item_list', $item_list);
        //当前页码
        $p = $this->_get('p', 'intval', 1);
        $this->assign('p', $p);
        //当前页面总数大于单次加载数才会执行动态加载
        if (($count - ($p - 1) * $page_size) > $spage_size) {
            $this->assign('show_load', 1);
        }
        //总数大于单页数才显示分页
        $count > $page_size && $this->assign('page_bar', $pager->fshow());
        //最后一页分页处理
        if ((count($item_list) + $page_size * ($p - 1)) == $count) {
            $this->assign('show_page', 1);
        }
    }
    public function tcate_wall_ajax($where, $order = 'i.id DESC', $field = '') {
        $db_pre = C('DB_PREFIX');
        $item_tag_table = $db_pre . 'item_tag';
        $item_tag_mod = M('item_tag');

        $spage_size = C('pin_wall_spage_size'); //每次加载个数
        $spage_max = C('pin_wall_spage_max'); //加载次数
        $p = $this->_get('p', 'intval', 1); //页码
        $sp = $this->_get('sp', 'intval', 1); //子页
        //条件
        $where_init = array('i.status' => '1');
        $where = array_merge($where_init, $where);
        //计算开始
        $start = $spage_size * ($spage_max * ($p - 1) + $sp);
        $item_mod = M('item');
        $count = $item_tag_mod->where($where)->join($db_pre . 'item i ON i.id = ' . $item_tag_table . '.item_id')->count();
        !$field && $field = 'i.id,i.uid,i.uname,i.title,i.intro,i.img,i.price,i.likes,i.comments,i.comments_cache,url';
        $item_list = $item_tag_mod->field($field)->where($where)->join($db_pre . 'item i ON i.id = ' . $item_tag_table . '.item_id')->order($order)->limit($start . ',' . $spage_size)->select();
        foreach ($item_list as $key => $val) {
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
        }
		
        $this->assign('item_list', $item_list);
        $resp = $this->fetch('public:waterfall');
        $data = array(
            'isfull' => 1,
            'html' => $resp
        );
        $count <= $start + $spage_size && $data['isfull'] = 0;
        $this->ajaxReturn(1, '', $data);
    }
}
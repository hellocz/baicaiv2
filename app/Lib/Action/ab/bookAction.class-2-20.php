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
        $hot_tags = explode(',', C('pin_hot_tags')); //热门标签
        $page_max = C('pin_book_page_max'); //发现页面最多显示页数
        $sort = $this->_get('sort', 'trim'); //排序
        $tag = $this->_get('tag', 'trim'); //当前标签
		$time=time();
        $where = array();
		$where['ds_time']=array('lt',$time);
        $tag && $where['tag_cache'] = array('like', '%' . $tag . '%');
        //排序：最热(hot)，最新(new)
        switch ($sort) {
            case 'hot':
                $order = 'hits DESC,id DESC';
                break;
            case 'new':
                $order = 'id DESC';
                break;
			default:
				$order = 'id DESC';
				break;
        }
        $this->waterfall($where, $order, '', $page_max);

        $this->assign('hot_tags', $hot_tags);
        $this->assign('tag', $tag);
        $this->assign('sort', $sort);
        $this->_config_seo(C('pin_seo_config.book'), array('tag_name' => $tag)); //SEO
		$strpos = ($tag)?"$tag":" 所有商品";
		$this->assign('strpos',$strpos);
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
		$where['ds_time']=array('lt',$time);
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
	public function gny(){
		$tp = $this->_get('tp',"intval");
		$isnice = $this->_get('isnice','intval');
		$isbao = $this->_get("isbao","intval");
		$ispost = $this->_get('ispost','intval');
		$orig_id = $this->_get('origid','intval');
		$cateid = $this->_get('cateid','intval');
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
		$time=time();
		$db_pre = C('DB_PREFIX');
		$spage_size = C('pin_wall_spage_size'); //每次加载个数
        $spage_max = C('pin_wall_spage_max'); //每页加载次数
        //$page_size = $spage_size * $spage_max; //每页显示个数
		$page_size=8;
		$item_orig = M("item_orig");
		$count = $item_orig->where($db_pre."item_orig.ismy='$tp' and i.status=1 and i.ds_time<$time ".$where)->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->count();
		$pager = $this->_pager($count, $page_size);
        !$field && $field = 'i.id,i.uid,i.uname,i.title,i.intro,i.img,i.price,i.likes,i.comments,i.comments_cache,i.add_time,i.orig_id,i.url,i.go_link,i.zan';
        $item_list = $item_orig->where($db_pre."item_orig.ismy='$tp' and i.status=1 and i.ds_time<$time ".$where)->join($db_pre . 'item i ON i.orig_id = ' . $db_pre . 'item_orig.id')->field($field)->order($order."i.id desc")->limit($pager->firstRow . ',' . $spage_size)->select();
		
		foreach ($item_list as $key => $val) {
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
        }
		$this->assign('item_list', $item_list);
		//当前页码
        $p = $this->_get('p', 'intval', 1);
        $this->assign('p', $p);
        $this->assign('page_bar', $pager->fshow());
        
		//热门置顶
		$hot_list = $item_orig->where($db_pre."item_orig.ismy=$tp and i.status=1 and i.ds_time<$time ")->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->order("i.hits,i.id desc")->limit(10)->select();
		$this->assign("hot_list",$hot_list);
		//SEO
		if($tp==1){//海淘
			$this->_config_seo(C('pin_seo_config.cate'), array(
            'cate_name' => '海淘频道',
            'seo_title' => $cate_info['seo_title'],
            'seo_keywords' => $cate_info['seo_keys'],
            'seo_description' => $cate_info['seo_desc'],
			));
		}elseif($tp==0){
			$this->_config_seo(C('pin_seo_config.cate'), array(
            'cate_name' => '国内频道',
            'seo_title' => $cate_info['seo_title'],
            'seo_keywords' => $cate_info['seo_keys'],
            'seo_description' => $cate_info['seo_desc'],
			));
		}
		//表现形式
        $dss =$this->_get("dss","trim");
		$dss = ($dss=="")?$_SESSION['dss']:$dss;
		$dss = ($dss=="")?"cc":$dss;
		$_SESSION['dss']=$dss;
		$this->assign("dss",$dss);
		$this->assign("tp",$tp);
		$this->assign("tab",$tab);
		$this->assign("origid",$orig_id);
		$this->assign("cateid",$cateid);
		$this->assign("count",$count);
		if($orig_id!=0){
			$orig=M("item_orig")->where("id=$orig_id")->getField("name");
			$this->assign('orig_url',U("book/gny",array('tp'=>$tp,'cateid'=>$cateid,)));
			$this->assign('orig',$orig);
		}
		if($cateid!=0){
			$cate=M("item_cate")->where("id=$cateid")->getField("name");
			$this->assign('cate_url',U("book/gny",array('tp'=>$tp,'origid'=>$orig_id,)));
			$this->assign('cate',$cate);
		}
		//可直邮
		if($ispost==1){$cispost=0;}else{$cispost=1;}
		$this->assign("lb_url",U('book/gny',array('tp'=>$tp,'tab'=>$tab,'dss'=>'lb',"$tab"=>'1',"ispost"=>$cispost)));
		$this->assign("cc_url",U('book/gny',array('tp'=>$tp,'tab'=>$tab,'dss'=>'cc',"$tab"=>'1',"ispost"=>$cispost)));
		$this->assign("post_url",U('book/gny',array('tp'=>$tp,'tab'=>$tab,'dss'=>$dss,"$tab"=>1,"ispost"=>$cispost)));
		$this->assign('ispost',$ispost);
		$this->display();
	}
	public function best(){		
		$db_pre = C('DB_PREFIX');
        $page_size = 16; //每页显示个数
		$item= M("item");
		$count = $item->where("isbest='1' and status=1 ")->count();
		$pager = $this->_pager($count, $page_size);
		$time=time();
        $item_list = $item->where("isbest='1' and status=1 and ds_time<$time ")->order("isnice desc,ishot desc,id desc")->limit($pager->firstRow . ',' . $page_size)->select();
		foreach ($item_list as $key => $val) {
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
			//商品相册
			$item_list[$key]['img_list'] = M('item_img')->field('url')->where(array('item_id' => $val['id']))->order('ordid')->select();
        }
		$this->assign('item_list', $item_list);
		//当前页码
        $p = $this->_get('p', 'intval', 1);
        $this->assign('p', $p);
        $this->assign('page_bar', $pager->fshow());        
		$this->assign("bcid","best");
		//热门置顶
		$hot_list = $item->where("isbest='1' and status=1 and ds_time<$time ")->order("hits,id desc")->limit(10)->select();
		$this->assign("hot_list",$hot_list);
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
        !$field && $field = 'i.id,i.uid,i.uname,i.title,i.intro,i.img,i.price,i.likes,i.comments,i.comments_cache,go_link';
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

    public function cate_ajax() {
        $cid = $this->_get('cid', 'intval');
        $sort = $this->_get('sort', 'trim', 'pop');
        $min_price = $this->_get('min_price', 'intval');
        $max_price = $this->_get('max_price', 'intval');

        //分类数据
        if (false === $cate_data = F('cate_data')) {
            $cate_data = D('item_cate')->cate_data_cache();
        }
        //分类关系
        if (false === $cate_relate = F('cate_relate')) {
            $cate_relate = D('item_cate')->relate_cache();
        }

        //条件
        $where = array();
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
        }
        if ($cate_data[$cid]['type'] == 0) {
            //实物分类
            $min_price && $where['price'][] = array('egt', $min_price);
            $max_price && $where['price'][] = array('elt', $max_price); //价格

            array_push($cate_relate[$cid]['sids'], $cid);
            $where['cate_id'] = array('in', $cate_relate[$cid]['sids']); //分类

            $this->wall_ajax($where, $order);
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
                array_push($cate_relate[$pentity_id]['sids'], $pentity_id);
                $where['i.cate_id'] = array('IN', $cate_relate[$pentity_id]['sids']); //分类条件
                $this->tcate_wall_ajax($where, 'i.' . $order);
            }
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
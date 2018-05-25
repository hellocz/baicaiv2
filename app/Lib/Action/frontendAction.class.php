<?php
/**
 * 前台控制器基类
 *
 * @author andery
 */

class frontendAction extends baseAction {

    protected $visitor = null;
    
    public function _initialize() {
        parent::_initialize();
        //网站状态
        if (!C('pin_site_status')) {
            header('Content-Type:text/html; charset=utf-8');
            exit(C('pin_closed_reason'));
        }
        //初始化访问者
        $this->_init_visitor();
        //第三方登陆模块
        $this->_assign_oauth();
        //网站导航选中
        $this->assign('nav_curr', '');
    }
    
    /**
    * 初始化访问者
    */
    private function _init_visitor() {
        $this->visitor = new user_visitor();
        $this->assign('visitor', $this->visitor->info);
    }

    /**
     * 第三方登陆模块
     */
    private function _assign_oauth() {
        if (false === $oauth_list = F('oauth_list')) {
            $oauth_list = D('oauth')->oauth_cache();
        }
        $this->assign('oauth_list', $oauth_list);
    }

    /**
     * SEO设置
     */
    protected function _config_seo($seo_info = array(), $data = array()) {
        $page_seo = array(
            'title' => C('pin_site_title'),
            'keywords' => C('pin_site_keyword'),
            'description' => C('pin_site_description')
        );
        $page_seo = array_merge($page_seo, $seo_info);
        //开始替换
        $searchs = array('{site_name}', '{site_title}', '{site_keywords}', '{site_description}');
        $replaces = array(C('pin_site_name'), C('pin_site_title'), C('pin_site_keyword'), C('pin_site_description'));
        preg_match_all("/\{([a-z0-9_-]+?)\}/", implode(' ', array_values($page_seo)), $pageparams);
        if ($pageparams) {
            foreach ($pageparams[1] as $var) {
                $searchs[] = '{' . $var . '}';
                $replaces[] = $data[$var] ? strip_tags($data[$var]) : '';
            }
            //符号
            $searchspace = array('((\s*\-\s*)+)', '((\s*\,\s*)+)', '((\s*\|\s*)+)', '((\s*\t\s*)+)', '((\s*_\s*)+)');
            $replacespace = array('-', ',', '|', ' ', '_');
            foreach ($page_seo as $key => $val) {
                $page_seo[$key] = trim(preg_replace($searchspace, $replacespace, str_replace($searchs, $replaces, $val)), ' ,-|_');
            }
        }
        $this->assign('page_seo', $page_seo);
    }

    /**
    * 连接用户中心
    */
    protected function _user_server() {
        $passport = new passport(C('pin_integrate_code'));
        return $passport;
    }

    /**
     * 前台分页统一
     */
    protected function _pager($count, $pagesize) {
        $pager = new Page($count, $pagesize);
        $pager->rollPage = 5;
        $pager->setConfig('prev', '<');
        $pager->setConfig('theme', '%upPage% %first% %linkPage%  %downPage%');
        return $pager;
    }

    /**
     * 瀑布显示
     */
    public function waterfall($where = array(), $order = 'id DESC', $field = '', $page_max = '', $target = '') {
        $time=time();
        $spage_size = C('pin_wall_spage_size'); //每次加载个数
        $spage_max = C('pin_wall_spage_max'); //每页加载次数
        $page_size = $spage_size * $spage_max; //每页显示个数
        $item_mod = M('item');
        $where_init = array('status'=>'1');
        $where = $where ? array_merge($where,$where_init) : $where_init;
        $where['add_time']=array('lt',$time);
        //echo "<pre>";
        $count = $item_mod->where($where)->count('id');
        //控制最多显示多少页
        //if ($page_max && $count > $page_max * $page_size) {
        //    $count = $page_max * $page_size;
        //}
        //查询字段
        $field == '' && $field = 'id,uid,uname,orig_id,title,intro,img,price,likes,comments,comments_cache,url,zan,hits,go_link,add_time';
        //分页
        $pager = $this->_pager($count, $page_size);
        $target && $pager->path = $target;
        $item_list = $item_mod->field($field)->where($where)->order($order)->limit($pager->firstRow.','.$page_size)->select();
    
        foreach ($item_list as $key=>$val) {
            /*
            if($val["sh_time"]>$val["ds_time"]){
                $item_list[$key]['add_time']=$val["sh_time"];
                
            }else{
                $item_list[$key]['add_time']=$val["ds_time"];
                
            }
            */
            $item_list[$key]['zan'] = $item_list[$key]['zan']   +intval($item_list[$key]['hits'] /10);
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
            $item_list[$key]['orig_name']=getly($val['orig_id']);
        }       
        
    
        $this->assign('item_list', $item_list);
        
        /*echo "<pre>";
        var_dump($item_list);*/
        
        
        //当前页码
        $p = $this->_get('p', 'intval', 1);
        $this->assign('p', $p);
        //当前页面总数大于单次加载数才会执行动态加载
        if (($count - ($p-1) * $page_size) > $spage_size) {
            $this->assign('show_load', 1);
        }
        //总数大于单页数才显示分页
        $count > $page_size && $this->assign('page_bar', $pager->fshow());
        //最后一页分页处理
        if ((count($item_list) + $page_size * ($p-1)) == $count) {
            $this->assign('show_page', 1);
        }
        $this->assign("count",$count);
        
                            $this->assign("zh_count",$count);
    }


    /**
     * 瀑布显示
     */
    public function waterfall_xs($where = array(), $order = 'add_time DESC',$q, $field = '', $page_max = '', $target = '') {
        $time=time();
        $p = $this->_get('p', 'intval', 1);
        

        require LIB_PATH . 'Pinlib/php/lib/XS.php';
        $xs = new XS('baicai');
        $search = $xs->search;   //  获取搜索对象
        $search->setLimit(50,20*($p-1)); 
        $search->setSort('add_time',false);
        //$search->setFuzzy(true);
       // $search->addQueryTerm('title',$q,XS_CMD_QUERY_OP_OR);
       // $search->addQueryTerm(,$q,XS_CMD_QUERY_OP_OR);
       // $search->addQueryTerm('status','1',XS_CMD_QUERY_OP_AND);
       // $search->addRange('status',2,null);
        $search->setQuery($q);

        $docs = $search->search();
    //    $ss_cate = $search->getExpandedQuery($q);
     //   var_dump( $ss_cate);
     //   $this->assign('ss_cate', $ss_cate);
        //$docs = $search->search();
        $count = $search->count();
        //echo "<pre>";
        //var_dump($where);
        //$count = $item_mod->where($where)->count('id');
        //控制最多显示多少页
        //if ($page_max && $count > $page_max * $page_size) {
        //    $count = $page_max * $page_size;
        //}
        //查询字段
        $field = 'id,uid,uname,orig_id,title,intro,img,price,likes,comments,comments_cache,url,zan,hits,go_link,add_time';
        //分页
        $item_mod = M('item');
        $pager = $this->_pager($count, 20);
        $target && $pager->path = $target;

        foreach ($docs as $doc) {
            if($str==""){
                 $str=$doc->id;
            }
            else{
               $str.=",".$doc->id;
            }
        }
        $str && $where1['id'] = array('in', $str);
        $where1['add_time'] = array('lt',time());
        $str && $item_list = $item_mod->field($field)->where($where1)->order($order)->limit(20)->select();
    
        //$prefix = "/usr/local/xunsearch";  
        //require_once("$prefix/sdk/php/lib/XS.php");
       /* 

        $item_list = Array();
        foreach ($docs as $doc) {

            $item['title'] = $doc->title;
            $item['img'] = $doc->img;
            $item['id'] = $doc->id;
            $item['price'] = $doc->price;
            $item['add_time'] = $doc->add_time;
            $item['zan'] = $doc->zan;
            $item['hits'] = $doc->hits;
            $item['comments_cache'] = $doc->comments_cache;
            $item['orig_id'] = $doc->orig_id;
            $item['go_link'] = $doc->go_link;
            array_push($item_list,$item);
            # code...
        }
*/
        foreach ($item_list as $key=>$val) {
            /*
            if($val["sh_time"]>$val["ds_time"]){
                $item_list[$key]['add_time']=$val["sh_time"];
                
            }else{
                $item_list[$key]['add_time']=$val["ds_time"];
                
            }
            */
            $item_list[$key]['zan'] = $item_list[$key]['zan']   +intval($item_list[$key]['hits'] /10);
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
            $item_list[$key]['orig_name']=getly($val['orig_id']);
        }       
        
    
        $this->assign('item_list', $item_list);
        
        /*echo "<pre>";
        var_dump($item_list);*/
        
        
        //当前页码
        
        $this->assign('p', $p);
        //当前页面总数大于单次加载数才会执行动态加载
        if (($count - ($p-1) * $page_size) > $spage_size) {
            $this->assign('show_load', 1);
        }
        //总数大于单页数才显示分页
        $count > $page_size && $this->assign('page_bar', $pager->fshow());
        //最后一页分页处理
        if ((count($item_list) + $page_size * ($p-1)) == $count) {
            $this->assign('show_page', 1);
        }
        $this->assign("count",$count);
        
        $this->assign("zh_count",$count);
        if($count == 0 ){
            $this->waterfall($where, $order);
        }
    }


    /**
     * 瀑布加载
     */
    public function wall_ajax($where = array(), $order = 'id DESC', $field = '') {
        $spage_size = C('pin_wall_spage_size'); //每次加载个数
        $spage_max = C('pin_wall_spage_max'); //加载次数
        $p = $this->_get('p', 'intval', 1); //页码

        //条件
        $where_init = array('status'=>'1');
        $where = array_merge($where_init, $where);
        //计算开始
        $start = $spage_size * $spage_max * ($p - 1);
        $item_mod = M('item');
       // print_r($where);
        $count = $item_mod->where($where)->count('id');
        $field == '' && $field = 'id,uid,uname,title,intro,img,price,likes,comments,comments_cache,url,add_time,orig_id,hits,zan';
        $item_list = $item_mod->field($field)->where($where)->order($order)->limit($start.','.$spage_size)->select();
        foreach ($item_list as $key=>$val) {
            /*
            if($val["sh_time"]>$val["ds_time"]){
                $item_list[$key]['add_time']=$val["sh_time"];
                
            }else{
                $item_list[$key]['add_time']=$val["ds_time"];
                
            }
            */
            $item_list[$key]['zan'] = $item_list[$key]['zan']   +intval($item_list[$key]['hits'] /10);
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
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
	
	/**
     * 瀑布显示,搜索国内或海淘
     */
    public function waterfall_tp($where = array(), $order = 'id DESC', $tp='', $isbest='', $share =array() , $field = '', $page_max = '', $target = '') {
        $spage_size = C('pin_wall_spage_size'); //每次加载个数
        $spage_max = C('pin_wall_spage_max'); //每页加载次数
        $page_size = $spage_size * $spage_max; //每页显示个数
        $item_mod = M('item_orig');
        $where_init = array('status'=>'1');
        $where = $where ? array_merge($where_init, $where) : $where_init;
        $gn_where = $gw_where = $where;
        $count = $item_mod->count('id');//$count = $item_mod->where($where)->count('id');
		
		
		$db_pre = C('DB_PREFIX');
   /*       $zh_where = $gn_where = $gw_where = $jp_where =$where;

       $zh_where['_string'] = $zh_where['_string'] . ' and ';
      $gn_where['_string'] =$db_pre."item_orig.ismy=0 and i.status=1";
        $gw_where['_string'] = $db_pre."item_orig.ismy=1 and i.status=1";
        $jp_where['_string'] = "i.isbest=1";
*/

        if($tp != '') {
            if($tp != '9' and $tp != '10'){
            $where['_string'] = $where['_string'] . ' and ' . $db_pre . "item_orig.ismy='$tp' and i.status=1";
            }
            else{
            $where['_string'] = $where['_string'] . $db_pre . "item_orig.ismy='$tp' and i.status=1"; 
            }
        }else{
            $where['_string']=$where['_string'];
        }
        if($isbest != ''){
            $where['_string'] = $where['_string'] . " and i.isbest=1";
        }

        $count = $item_mod->where($where)->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->count();
        //显示各个数量
/*
        $zh_count = $item_mod->where($zh_where)->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->count();
        $gn_count = $item_mod->where($gn_where)->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->count();
        $gw_count = $item_mod->where($gw_where)->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->count();
        $jp_count = $item_mod->where($jp_where)->join($db_pre."item i ON i.orig_id=".$db_pre."item_orig.id")->count();
        $article = M('article');
        $share['cate_id'] = 10;
        $sd_count = $article->where($share)->count('id');
        $share['cate_id'] = 9;
        $gl_count = $article->where($share)->count('id');
        */
        //控制最多显示多少页
        //if ($page_max && $count > $page_max * $page_size) {
        //    $count = $page_max * $page_size;
        //}
        //查询字段
        $field == '' && $field = 'i.id,i.uid,i.uname,i.orig_id,i.title,i.intro,i.img,i.price,i.likes,i.comments,i.comments_cache,i.url,i.zan,i.go_link,i.add_time';
        //分页
        $pager = $this->_pager($count, $page_size);
        $target && $pager->path = $target;
       // $item_list = $item_mod->field($field)->where($where)->join($db_pre . 'item i ON i.orig_id = ' . $db_pre . 'item_orig.id')->order($order)->limit($pager->firstRow.','.$page_size)->select();
        
       // $prefix = "/usr/local/xunsearch";  
        //加载XS.php，这步是必须的  
        //require_once("$prefix/sdk/php/lib/XS.php");
        //require_once("$prefix/sdk/php/lib/XS.php");
        require LIB_PATH . 'Pinlib/php/lib/XS.php';

        $xs = new XS('baicai');
        $search = $xs->search;   //  获取搜索对象
        $search->setLimit(20); 
        $item_list = $search->setQuery("白菜哦")->search();
        
        foreach ($item_list as $key=>$val) {
            isset($val['comments_cache']) && $item_list[$key]['comment_list'] = unserialize($val['comments_cache']);
        }
        $this->assign('item_list', $item_list);
        //当前页码
        $p = $this->_get('p', 'intval', 1);
        $this->assign('p', $p);
        //当前页面总数大于单次加载数才会执行动态加载
        if (($count - ($p-1) * $page_size) > $spage_size) {
            $this->assign('show_load', 1);
        }
        //总数大于单页数才显示分页
        $count > $page_size && $this->assign('page_bar', $pager->fshow());
        //最后一页分页处理
        if ((count($item_list) + $page_size * ($p-1)) == $count) {
            $this->assign('show_page', 1);
        }
        $this->assign("count",$count);
        /*
        $this->assign("zh_count",$zh_count);
        $this->assign("gn_count",$gn_count);
        $this->assign("gw_count",$gw_count);
        $this->assign("jp_count",$jp_count);
        $this->assign("sd_count",$sd_count);
        $this->assign("gl_count",$gl_count);
*/
    }
}
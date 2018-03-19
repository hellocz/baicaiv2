<?php

/**
 * 搜索页面
 */
class searchAction extends frontendAction {

    public function index() {
        $q = $this->_get('q', 'trim');
        $t = $this->_get('t', 'trim', 'item');
        $action = '_search_' . $t;
        $this->$action($q);
        //搜索记录
        $search_history = (array) cookie('search_history');
        if (!$search_history) {
            $q && $search_history = array(array('q' => urlencode($q), 't' => $t));
        } else {
            foreach ($search_history as $key => $val) {
                $search_history[$key] = $val = (array) $val;
                if ($val['q'] == urlencode($q) && $val['t'] == $t) {
                    unset($search_history[$key]);
                }
            }
            $q && array_unshift($search_history, array('q' => urlencode($q), 't' => $t));
            $search_history = array_slice($search_history, 0, 10, true);
        }
        cookie('search_history', $search_history);
        $this->assign('q', $q);
        $this->assign('t', $t);
        $this->assign('search_history', $search_history);
		$this->assign('strpos',$q);
        $this->display($t);
    }

    public function clear_history() {
        cookie('search_history', NULL);
        $this->redirect('search/index');
    }

    /**
     * 搜宝贝
     */
    private function _search_item($q) {
        $sort = $this->_get('sort', 'trim', 'new'); //排序
		$more = $this->_get('more','trim');
		$p=$this->_get('p','intval') ? $this->_get('p','intval') : 1;
        if ($q) {

            require LIB_PATH . 'Pinlib/php/lib/XS.php';
        $xs = new XS('baicai');
        $search = $xs->search;   //  获取搜索对象
        $search->setLimit(18,18*($p-1)); 
        $search->setSort('add_time',false);
        $search->setQuery($q);

        $docs = $search->search();
        $count = $search->count();
        $field = 'id,uid,uname,orig_id,title,intro,img,price,likes,comments,comments_cache,url,zan,hits,go_link,add_time';
        //分页
        $item_mod = M('item');

        foreach ($docs as $doc) {
            if($str==""){
                 $str=$doc->id;
            }
            else{
               $str.=",".$doc->id;
            }
        }
        $str && $where1['id'] = array('in', $str);
        $str && $item_list = $item_mod->field($field)->where($where1)->order('add_time DESC')->select();


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
			$this->assign('item_list', $item_list);
			$this->assign('pagesize', $pagesize);
			$this->assign('count', $count);
            //IS_AJAX && $this->wall_ajax($where, $order);
            //$this->waterfall($where, $order);
        }
        $this->assign('sort', $sort);
        $this->assign('nav_curr', 'book');
        $this->_config_seo(array(
            'title' => sprintf(L('search_item_title'), $q) . '-' . C('pin_site_name'),
        ));
    }
    private function _search_item_bao($q) {
        $sort = $this->_get('sort', 'trim', 'new'); //排序
        $more = $this->_get('more','trim');
        $p=$this->_get('p','intval') ? $this->_get('p','intval') : 1;
        if ($q) {
            $item_mod = M('item_diu');
            $pagesize = 18;
            $start=($p-1)*$pagesize;
            $where = array('status' => '1');
            $where1['title'] = array('like', '%' . $q . '%');
            $where1['content'] = array('like', '%' . $q . '%');
            $where1['_logic'] = 'or';
            $where['_complex'] =  $where1;
            switch ($sort) {
                case 'hot':
                    $order = 'hits DESC,id DESC';
                    break;
                case 'new':
                    $order = 'add_time DESC';
                    break;
            }
            $count = $item_mod->where($where)->count('id');
            $item_list = $item_mod->field('id,title,img,add_time,orig_id,comments')->where($where)->order($order)->limit($start.','.$pagesize)->select();
            if($more == 'more'){
                $more_arr="";
                foreach($item_list as $key=>$r){
                    $more_arr.="<li><a href='".U('wap/bitem/index',array('id'=>$r['id']))."' title='".$r['title']."'><div class='image_wrap'>";
                    $more_arr.="<div class='image'><img src='".attach($r['img'],'item')."' title='$r[title]' alt='$r[title]' /></div></div>";
                    $more_arr.="<address><span>".fdate($r['add_time'])."</span>".getly($r['orig_id'])."</address><h2>".$r['title']."</h2>";
                    $more_arr.="<div class='tips'><span><i class='icons icon_comment'></i>".$r['comments']."</span></div></a></li>";
                }
                echo $more_arr;
                exit;
            }
            $this->assign('item_list', $item_list);
            $this->assign('pagesize', $pagesize);
            $this->assign('count', $count);
            //IS_AJAX && $this->wall_ajax($where, $order);
            //$this->waterfall($where, $order);
        }
        $this->assign('sort', $sort);
        $this->assign('nav_curr', 'book');
        $this->_config_seo(array(
            'title' => sprintf(L('search_item_title'), $q) . '-' . C('pin_site_name'),
        ));
    }

    /**
     * 搜专辑
     */
    private function _search_album($q) {
        $sort = $this->_get('sort', 'trim', 'hot'); //排序
        if ($q) {
            $album_mod = M('album');
            $pagesize = 39;
            $where = array('status' => '1');
            $where['title'] = array('like', '%' . $q . '%');
            switch ($sort) {
                case 'hot':
                    $order = 'follows DESC,id DESC';
                    break;
                case 'new':
                    $order = 'id DESC';
                    break;
            }
            $count = $album_mod->where($where)->count('id');
            $pager = $this->_pager($count, $pagesize);
            $album_list = $album_mod->field('id,uid,uname,title,cover_cache')->where($where)->order($order)->limit($pager->firstRow . ',' . $pager->listRows)->select();
            foreach ($album_list as $key => $val) {
                $album_list[$key]['cover'] = unserialize($val['cover_cache']);
            }
            $this->assign('album_list', $album_list);
            $this->assign('page_bar', $pager->fshow());
        }
        $this->assign('sort', $sort);
        $this->assign('nav_curr', 'album');
        $this->_config_seo(array(
            'title' => sprintf(L('search_album_title'), $q) . '-' . C('pin_site_name'),
        ));
    }

    /**
     * 搜用户
     */
    private function _search_user($q) {
        if ($q) {
            $user_mod = M('user');
            $where = array('status' => '1');
            $where['username'] = array('like', '%' . $q . '%');
            $count = $user_mod->where($where)->count('id');
            $pager = $this->_pager($count, $pagesize);
            $user_list = $user_mod->field('id,username,province,city,fans,tags,intro')->where($where)->order('id DESC')->limit($pager->firstRow . ',' . $pager->listRows)->select();
            $this->assign('count', $count);
            $this->assign('user_list', $user_list);
            $this->assign('page_bar', $pager->fshow());
        }
         $this->_config_seo(array(
            'title' => sprintf(L('search_user_title'), $q) . '-' . C('pin_site_name'),
        ));
    }

}
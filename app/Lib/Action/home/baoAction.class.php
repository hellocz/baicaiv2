<?php
class baoAction extends frontendAction {
    
    public function index() {

		$type = $this->_get('type','trim');
		$dss = $this->_get('dss','trim');
        //热门
		$mod=M("item_diu");
		$where=" and isbao=1 ";
		$order =" add_time desc";
		$time=time();		
		$pagesize=21;
		$count = 1000; //$mod->where("status=1 and add_time<$time ".$where)->count();
		$pager = $this->_pager($count,$pagesize);
		$list = M("item_diu")->where("status=1 and add_time<$time and ds_time < $time")->limit($pager->firstRow.",".$pager->listRows)->order($order)->select();	
		foreach($list as $key=>$val){
			$list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits']);
		}
		$this->assign('item_list',$list);
		$this->assign('pagebar',$pager->fshow());
		$p = $this->_get("p",'intval');
		if($p<1){$p=1;}
		$this->assign('p',$p);
        		$this->_config_seo();
        		$this->display();
    }
     public function search() {
     		$q = $this->_get('q', 'trim');
		$type = $this->_get('type','trim');
		$dss = $this->_get('dss','trim');
	        
	//        $this->_action_diu($q);
		$mod=M("item_diu");
		$order =" add_time desc";
		$day = $this->_get('day', 'trim');
		$day_w=$day > 0 ? (time()-($day*86400)) : 0;
		$time=time();		
		$pagesize=21;
		$where = array('status' => '1');
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
		 if ($q) {
		        	$where = array('status' => '1');
		            	$q_list=explode(" ",$q);
		            	$q_info="";
		            $search_content= Array();
		            foreach($q_list as $key=>$r){
		                $and=$key == 0 ? "" : " and ";
		          //      $q_info.="$or title like '%".$r."%' or intro like '%".$r."%' ";
		          //      $q_info.="$and title like %".$r."% ";
		           //     Array_push( $where['title'],'like',"%$r%");
		           //     $where['title']=array('like',"%$r%");
		                $search_content[$key] ="%$r%";
		            }

		            $where1['title'] =array('like',$search_content,'AND');

		            $where1['content'] =array('like',$search_content,'AND');

		            $where1['_logic'] = 'or';
		            $where['_complex'] = $where1;
		            $where['_string'] ="add_time > ".$day_w."";
		        }
		$count = M("item_diu")->where($where)->count('id'); 
		$pager = $this->_pager($count,$pagesize);
		$list = M("item_diu")->where($where)->limit($pager->firstRow.",".$pager->listRows)->order($order)->select();	
		foreach($list as $key=>$val){
			$list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits']);
		}
		$this->assign('item_list',$list);
		$this->assign('pagebar',$pager->fshow());
		$p = $this->_get("p",'intval');
		if($p<1){$p=1;}
		$this->assign('p',$p);
		$this->assign('q', $q);
        		$this->assign('search_history', $search_history);
        		$this->assign('strpos_bao',$q);
        		$this->display();
    }

    /**
     * 搜宝贝
     */
    private function _action_diu($q) {
        $sort = $this->_get('sort', 'trim', 'new');
        $day = $this->_get('day', 'trim');
        $day_w=$day > 0 ? (time()-($day*86400)) : 0;
        if ($q) {
        	$where = array('status' => '1');
            	$q_list=explode(" ",$q);
            	$q_info="";
            $search_content= Array();
            foreach($q_list as $key=>$r){
                $and=$key == 0 ? "" : " and ";
          //      $q_info.="$or title like '%".$r."%' or intro like '%".$r."%' ";
          //      $q_info.="$and title like %".$r."% ";
           //     Array_push( $where['title'],'like',"%$r%");
           //     $where['title']=array('like',"%$r%");
                $search_content[$key] ="%$r%";
            }

            $where1['title'] =array('like',$search_content,'AND');

            $where1['content'] =array('like',$search_content,'AND');

            $where1['_logic'] = 'or';
            $where['_complex'] = $where1;

            //$where['intro'] = array('like', '%' . $q . '%');
	$where['_string'] ="add_time > ".$day_w."";
            switch ($sort) {
                case 'hot':
                    $order = 'likes DESC,zan DESC,hits DESC,id DESC';
                    break;
                case 'new':
                    $order = 'add_time DESC';
                    break;
            }
            IS_AJAX && $this->wall_ajax($where, $order);
            if($tp != ''){
                $q_info1="";
                foreach($q_list as $key=>$r){
                    $or=$key == 0 ? "" : " or ";
                    $q_info1.="$or i.title like '%".$r."%' or i.intro like '%".$r."%' ";
                }
				$where = array('i.status' => '1');
				$where['_string'] ="($q_info1) and (add_time > ".$day_w.")";
			//	$this->waterfall_tp($where, $order,$tp);
			}else{
				//$this->waterfall($where, $order);
			}
			
        }
        $this->assign('day', $day);
        $this->assign('sort', $sort);
        $this->assign('nav_curr', 'book');
        $this->_config_seo(array(
            'title' => sprintf(L('search_item_title'), $q) . '-' . C('pin_site_name'),
        ));
    }
}

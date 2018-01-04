<?php
class origAction extends frontendAction {

    public function index() {
		$p = $this->_get('p','trim');
		$t = $this->_get('t','trim');
		$k = $this->_get('k','trim');
		!$k&&$k=0;
		
		
		
		if($t=="e"){
			$hot_list = M("express")->order("is_hot desc,id asc")->limit(21)->select();
			if($p){
				$list = M()->query("select e.* from try_express e,try_cosler c  where CONV( HEX( LEFT( CONVERT( e.name  USING gbk ) , 1 ) ) , 16, 10 ) BETWEEN c.cBegin AND c.cEnd AND c.fPY = '$p' order by e.id asc");						
			}else{
				$list = M("express")->order("id asc")->select();
			}
		}else{		
			$hot_list = M("item_orig")->where("ismy=$k")->order("is_hot desc,id asc")->limit(21)->select();	
			$count = M()->query("SELECT COUNT(name) FROM try_item_orig  where ismy=".$k);					
			if($p){
				$list = M()->query("select i.* from try_item_orig i where fristPinyin(i.name) = '$p' AND i.ismy='$k' order by i.id asc");
				

			}else{
				$list = M("item_orig")->where("ismy=$k")->order("id asc")->select();
			}
			
			
			
			
		}
		
		$this->assign("hot_list",$hot_list);
		$this->assign("list",$list);
		$this->_config_seo(array(
            'seo_title' => '商城导航',
            'seo_keywords' => '商城导航',
            'seo_description' => '商城导航',
        ));
		$this->assign('t',$t);
		$this->assign('p',$p);
		$this->assign('k',$k);
        $this->display();
    }

    public function show()
	{
		$id = $this->_get("id","intval");
		!$id && $this->_404();
		$model = M("item_orig");
		$orig_info = $model->where("id=$id")->find();
		$this->assign('info',$orig_info);
		//商品
		$count =100;// M("item")->where("orig_id=$id")->count();
        $page_size = 16; //每页显示个数
        $pager = $this->_pager($count, $page_size);
        $time=time();
        $list = M("item")->where("orig_id='$id' and status=1 and add_time<$time and ds_time < $time ")->limit($pager->firstRow . ',' . $page_size)->order("add_time desc")->select();
        foreach($list as $key=>$val){
				
		$list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits'] /10);
			}
        $this->assign('list', $list);
        //当前页码
        $p = $this->_get('p', 'intval', 1);
        $this->assign('p', $p);
        $this->assign('page_bar', $pager->fshow());		
        //$this->_config_seo();
        //$this->_config_seo(C('pin_seo_config.orig'), array('orig_name' => $orig_info['name']));
        $page_seo['title'] = $orig_info['seo_title'];
        $page_seo['keywords'] = $orig_info['seo_keys'];
        $page_seo['description'] = $orig_info['seo_desc'];
        $this->assign('page_seo', $page_seo);
    	$this->display();
    }
}
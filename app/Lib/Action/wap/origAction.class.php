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
				$list = M()->query("select e.* from try_express e,try_cosler c  where CONV( HEX( LEFT( CONVERT( e.name  USING gbk ) , 1 ) ) , 16, 10 ) BETWEEN c.cBegin AND c.cEnd AND c.fPY = '$p' order by i.id asc");	
			}else{
				$list = M("express")->order("id asc")->select();
			}
		}else{			
			$hot_list = M("item_orig")->where("ismy=$k")->order("is_hot desc,id asc")->limit(21)->select();		
			if($p){
				$list = M()->query("select i.* from try_item_orig i,try_cosler c  where CONV( HEX( LEFT( CONVERT( i.name  USING gbk ) , 1 ) ) , 16, 10 ) BETWEEN c.cBegin AND c.cEnd AND c.fPY = '$p' AND i.ismy='$k' order by i.id asc");	
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
		$more = $this->_get('more','trim');
		$p=$this->_get('p') ? $this->_get('p','intval') : 1;
		!$id && $this->_404();
		$model = M("item_orig");
		$orig_info = $model->where("id=$id")->find();
		$this->assign('info',$orig_info);
		//商品
		$count = M("item")->where("orig_id=$id")->count();
        $pagesize = 16; //每页显示个数
		$start=($p-1)*$pagesize;
        //$pager = $this->_pager($count, $page_size);
        $list = M("item")->where("orig_id='$id'")->limit($start . ',' . $pagesize)->order("id desc")->select();
        $this->assign('list', $list);
		
		if($more == 'more'){
			$more_arr="";
			foreach($list as $key=>$r){
				$more_arr.="<li><a href='".U('wap/item/index',array('id'=>$r['id']))."' title='".$r['title']."'>";
				$more_arr.="<div class='w_zk_img'><img src='".attach($r['img'],'item')."' title='$r[title]' alt='$r[title]' /></div>";
				$more_arr.="<address><span>".fdate($r['add_time'])."</span>".$orig_info['name']."</address><h2>".$r['title']."</h2></a></li>";
			}
			echo $more_arr;
			exit;
		}
        //当前页码
        //$p = $this->_get('p', 'intval', 1);
        //$this->assign('p', $p);
		$this->assign('id', $id);
		$this->assign('count',$count);
		$this->assign('pagesize',$pagesize);
        //$this->assign('page_bar', $pager->fshow());		
        $page_seo['title'] = $orig_info['seo_title'];
        $page_seo['keywords'] = $orig_info['seo_keys'];
        $page_seo['description'] = $orig_info['seo_desc'];
        $this->assign('page_seo', $page_seo);
    	$this->display();
    }
}
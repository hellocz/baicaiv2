<?php
class origAction extends frontendAction {

    public function index() {
		
		

		$letters = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

		if (false === $list = F('orig_list')) {
    	$list=array();
		$list['0']['items'] = M("item_orig")->field("id,img,name,ismy")->where("name REGEXP '^[0-9]'")->order("id")->select();
		$list['0']['key'] = "0~9";
		foreach ($letters as $letter) {
			$list[$letter]['items'] = M("item_orig")->field("id,img,name,ismy")->where("fristPinyin(name) = '$letter'")->order("id")->select();
			$list[$letter]['key'] = $letter; 
			//M()->query("select i.* from try_item_orig i where fristPinyin(i.name) = '$letter' order by i.id asc");
		}
    	F('orig_list',$list);
    	}
		$this->assign("hot_list",$hot_list);
		$this->assign("list",$list);
		$this->_config_seo(array(
            'seo_title' => '商城导航',
            'seo_keywords' => '商城导航',
            'seo_description' => '商城导航',
        ));
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
		$time=time();
		$count = M("item")->where("orig_id='$id' and status=1 and add_time<$time ")->count();
        $page_size = 16; //每页显示个数
        $pager = $this->_pager($count, $page_size);
        
        $list = M("item")->where("orig_id='$id' and status=1 and add_time<$time ")->limit($pager->firstRow . ',' . $page_size)->order("add_time desc")->select();
        foreach($list as $key=>$val){
				
		$list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits'] /10);
			}

		$gl_list = M("article")->field("id, otitle")->where("orig_id = '$id' and status =1 and cate_id=9 and add_time<$time ")->select();


		$this->assign('gl_list',$gl_list);
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
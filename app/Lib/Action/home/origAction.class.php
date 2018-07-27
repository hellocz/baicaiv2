<?php
class origAction extends frontendAction {

    public function index() {

	$t = $this->_get('t','trim'); //商城分类：国内0，海淘1，转运公司e
	if(!in_array($t, array('0', '1', 'e'))) $t="0";

	// $letters = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

	if($t=="e"){
		$mod = D("express");
		$hot_list = $mod->hot_express_cache();
		$hot_list = array_slice($hot_list, 0, 9);

		$arr = $mod->express_cache();

	}else{
		$mod = D("item_orig");
		$hot_list = $mod->hot_orig_cache();
		$hot_list = array_slice($hot_list, 0, 9);

		$arr = $mod->orig_cache();
	}

	$list=array();
	foreach ($arr as $key => $val) {
		if($t!="e" && $val['ismy'] != $t){  //国内 国外 过滤
			continue;
		}
		$list[$val['letter']][]=$val;
	}
	ksort($list);

	$letters = array_keys($list);

	$this->assign("hot_list",$hot_list);
	$this->assign("list",$list);
	$this->assign("letters",$letters);
	$this->assign('t',$t);
	$this->_config_seo(array(
		'seo_title' => '商城导航',
		'seo_keywords' => '商城导航',
		'seo_description' => '商城导航',
	));
	$this->display();
    }

    public function show(){
        $id = $this->_get('id', 'intval');
        !$id && $this->_404();
        $info = D("item_orig")->get_info($id);
        !$info && $this->error('该信息不存在或已删除');

        //过滤筛选及查询结果
        //品牌
        $params = array('id' => $id);
        $where = array();
        $where['orig_id'] = $id;
        
        //筛选
        $this->filter($params, $where);

        $page_seo['title'] = $orig_info['seo_title'];
        $page_seo['keywords'] = $orig_info['seo_keys'];
        $page_seo['description'] = $orig_info['seo_desc'];
        $this->assign('page_seo', $page_seo);
        $this->assign('info', $info);
        $this->display();
    }
}
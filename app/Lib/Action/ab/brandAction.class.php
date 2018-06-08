<?php
class brandAction extends frontendAction {

    protected function _new_pager($count, $pagesize) {
        $pager = new Page($count, $pagesize);
        $pager->rollPage = 5;
        $pager->setConfig('prev', '<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>');
        $pager->setConfig('next', '<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>');
        // $pager->setConfig('theme', '%upPage% %first% %linkPage% %end% %downPage%');
        $pager->setConfig('theme', '%upPage% %first% %linkPage% %downPage%');
        return $pager;
    }

    public function index() {

        $q = $this->_get('q', 'trim');

        //分类品牌数据
        if (false === $cate_brand_list = F('cate_brand_list')) {
          $cate_brand_list = D('brand')->cate_brand_cache();
        }

        //过滤关键词，过滤空的category分类
        if(!empty($q)){
          $cate_brand_list_filter = array();

          if(count($cate_brand_list) > 0){
            foreach ($cate_brand_list as $p1 => $val1) {
              foreach ($val1['data'] as $p2 => $val2) {
                foreach ($val2['data'] as $brandid => $val) {
                  if(strpos($val['name'], $q) !== false){
                    $cate_brand_list_filter[$p1]['data'][$p2]['data'][$brandid] = $cate_brand_list[$p1]['data'][$p2]['data'][$brandid];
                  }
                }
                $cnt = count($cate_brand_list_filter[$p1]['data'][$p2]['data']);
                if($cnt > 0){
                  $cate_brand_list_filter[$p1]['data'][$p2]['p'] = $cate_brand_list[$p1]['data'][$p2]['p'];
                }
              }

              $cnt = count($cate_brand_list_filter[$p1]['data']);
              if($cnt > 0){
                $cate_brand_list_filter[$p1]['p'] = $cate_brand_list[$p1]['p'];
              }
            }
          }

          $cate_brand_list = $cate_brand_list_filter;
        }

        // echo "<pre>";
        // print_r($cate_brand_list);
        // echo "</pre>";
        // exit;

        $this->assign('cate_brand_list',$cate_brand_list);
        $this->_config_seo(array('title'=>'品牌导航'));
        $this->display();
    }

    public function nav() {

        $p1 = $this->_get('p1', 'intval'); //一级分类parent id
        $p2 = $this->_get('p2', 'intval'); //二级分类parent id
        $p = $this->_get('p', 'intval', 1);
        $q = $this->_get('q', 'trim');  //搜索关键字

        //分类品牌数据
        if (false === $cate_brand_list = F('cate_brand_list')) {
          $cate_brand_list = D('brand')->cate_brand_cache();
        }

        //过滤分类
        $cate_brand_list_filter = array();
        if(isset($cate_brand_list[$p1]) && isset($cate_brand_list[$p1]['data'][$p2])){
          $cate_brand_list_filter[$p1]['p'] = $cate_brand_list[$p1]['p'];
          $cate_brand_list_filter[$p1]['data'][$p2]['p'] = $cate_brand_list[$p1]['data'][$p2]['p'];
          $cate_brand_list_filter[$p1]['data'][$p2]['data'] = $cate_brand_list[$p1]['data'][$p2]['data'];
        }
        $cate_brand_list = $cate_brand_list_filter;

        //过滤关键词，过滤空的category分类
        if(!empty($q)){
          $cate_brand_list_filter = array();

          if(count($cate_brand_list) > 0){
            foreach ($cate_brand_list as $p1 => $val1) {
              foreach ($val1['data'] as $p2 => $val2) {
                foreach ($val2['data'] as $brandid => $val) {
                  if(strpos($val['name'], $q) !== false){
                    $cate_brand_list_filter[$p1]['data'][$p2]['data'][$brandid] = $cate_brand_list[$p1]['data'][$p2]['data'][$brandid];
                  }
                }
                $cnt = count($cate_brand_list_filter[$p1]['data'][$p2]['data']);
                if($cnt > 0){
                  $cate_brand_list_filter[$p1]['data'][$p2]['p'] = $cate_brand_list[$p1]['data'][$p2]['p'];
                }
              }

              $cnt = count($cate_brand_list_filter[$p1]['data']);
              if($cnt > 0){
                $cate_brand_list_filter[$p1]['p'] = $cate_brand_list[$p1]['p'];
              }
            }
          }

          $cate_brand_list = $cate_brand_list_filter;
        }


        //当前brand
        $cate_brand = array();
        if(isset($cate_brand_list[$p1]) && isset($cate_brand_list[$p1]['data'][$p2])){
          $cate_brand['p1'] = $cate_brand_list[$p1]['p'];
          $cate_brand['p2'] = $cate_brand_list[$p1]['data'][$p2]['p'];
          $cate_brand['data'] = $cate_brand_list[$p1]['data'][$p2]['data'];
        }

        $pagesize=168;
        $count = isset($cate_brand['data']) ? count($cate_brand['data']) : 0; 
        $pager = $this->_new_pager($count,$pagesize);
        $this->assign('p',$p);
        $this->assign('firstRow', $pager->firstRow);
        $this->assign('listRows', $pager->listRows);
        $this->assign('pagebar', $pager->newshow());

        // echo "<pre>";
        // print_r($pager);
        // echo "</pre>";
        // exit;

        $this->assign('cate_brand_list', $cate_brand);
        $this->_config_seo(array('title'=>'品牌导航'));
        $this->display();
    }

    
}


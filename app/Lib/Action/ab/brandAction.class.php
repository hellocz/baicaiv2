<?php
class brandAction extends frontendAction {

    protected function _pager($count, $pagesize) {
        $pager = new Page($count, $pagesize);
        $pager->rollPage = 5;
        $pager->setConfig('prev', '<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>');
        $pager->setConfig('next', '<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>');
        $pager->setConfig('theme', '%upPage% %first% %linkPage% %end% %downPage%');
        return $pager;
    }

    public function index() {

        if (false === $cate_brand_list = F('cate_brand_list')) {
          $cate_brand_list = $this->cate_brand_cache();
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

        $p1 = $this->_get('p1', 'intval', 1);
        $p2 = $this->_get('p2', 'intval', 1);
        $p = $this->_get('p', 'intval', 1);

        if (false === $cate_brand_list = F('cate_brand_list')) {
          $cate_brand_list = $this->cate_brand_cache();
        }
        $cate_brand_list_1 = array();
        if(isset($cate_brand_list[$p1]) && isset($cate_brand_list[$p1]['data'][$p2])){
          $cate_brand_list_1['p1'] = $cate_brand_list[$p1]['p'];
          $cate_brand_list_1['p2'] = $cate_brand_list[$p1]['data'][$p2]['p'];
          $cate_brand_list_1['data'] = $cate_brand_list[$p1]['data'][$p2]['data'];
        }

        // $pagesize=168;
        $pagesize=28;
        $count = isset($cate_brand_list_1['data']) ? count($cate_brand_list_1['data']) : 0; 
        $pager = $this->_pager($count,$pagesize);
        $this->assign('p',$p);
        $this->assign('firstRow', $pager->firstRow);
        $this->assign('listRows', $pager->listRows);
        $this->assign('pagebar', $pager->newshow());

        // echo "<pre>";
        // print_r($pager);
        // echo "</pre>";
        // exit;

        $this->assign('cate_brand_list', $cate_brand_list_1);
        $this->_config_seo(array('title'=>'品牌导航'));
        $this->display();
    }

    public function cate_brand_cache() {

          // $brand_map['id']=array('in',$brand_list_ids);
          // $list = M("brand")->field('id,name,chn_name,country,abstract,tb,img')->where($brand_map)->select();
          $list = M("brand")->field('id,name')->select();
          $brand_list = array();
          if(count($list) > 0){
            foreach ($list as $val) {
              $brand_list[$val['id']] = $val;
            }
          }

          //分类数据
          if (false === $cate_data = F('cate_data')) {
            $cate_data = D('item_cate')->cate_data_cache();
          }

          //二层category分类信息+一层brand品牌信息
          $cate_brand_list = array();
          if(count($cate_data) > 0){
            foreach ($cate_data as $id => $val) {
              list($p1,$p2) = explode('|', $val['spid']."||");
              if($val['pid'] === '0'){
                $cate_brand_list[$id]['p'] = $val;
              }else if(empty($p2)){
                $cate_brand_list[$p1]['data'][$id]['p'] = $val;
              }else if(!empty($val['top'])){
                $arr = unserialize($val['top']);
                foreach ($arr as $brandid) {
                  if(!isset($brand_list[$brandid])) continue;
                  $cate_brand_list[$p1]['data'][$p2]['data'][$brandid] = $brand_list[$brandid];
                }
              }            
            }
          }

          //过滤空的category分类
          if(count($cate_brand_list) > 0){
            foreach ($cate_brand_list as $p1 => $val1) {
              foreach ($val1['data'] as $p2 => $val2) {
                $cnt = count($cate_brand_list[$p1]['data'][$p2]['data']);
                if($cnt == 0){
                  unset($cate_brand_list[$p1]['data'][$p2]);
                }
                // else if($cnt > 3){
                //   $cate_brand_list[$p1]['data'][$p2]['data'] = array_slice($cate_brand_list[$p1]['data'][$p2]['data'], 0, 3, TRUE );
                // }
              }

              $cnt = count($cate_brand_list[$p1]['data']);
              if($cnt == 0){
                unset($cate_brand_list[$p1]);
              }
            }
          }

          F('cate_brand_list', $cate_brand_list);
          return $cate_brand_list;
    }
}


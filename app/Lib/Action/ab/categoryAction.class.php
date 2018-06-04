<?php
class categoryAction extends frontendAction {

    public function index() {

        // $item_cate = M("item_cate")->where("pid=0 and status=1 and is_index=1")->order("ordid asc")->select();
        // $item_cate = M("item_cate")->where("status=1")->order("ordid asc")->select();

        //分类数据
        if (false === $cate_data = F('cate_data')) {
          $cate_data = D('item_cate')->cate_data_cache();
        }

        //三层category分类信息
        $cate_list = array();
        if(count($cate_data) > 0){
          foreach ($cate_data as $id => $val) {
            list($p1,$p2) = explode('|', $val['spid']."||");
            if($val['pid'] === '0'){
              $cate_list[$id]['p'] = $val;
            }else if(empty($p2)){
              $cate_list[$p1]['data'][$id]['p'] = $val;
            }else{
              $cate_list[$p1]['data'][$p2]['data'][$id] = $val;
            }            
          }
        }
        // echo "<pre>";
        // print_r($cate_list);
        // echo "</pre>";
        // exit;     

        $this->assign('cate_list',$cate_list);
        $this->_config_seo(array('title'=>'目录分类'));
        $this->display();
    }
}


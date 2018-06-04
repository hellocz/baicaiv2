<?php
class categoryAction extends frontendAction {

    public function index() {

        // $item_cate = M("item_cate")->where("pid=0 and status=1 and is_index=1")->order("ordid asc")->select();
        // $item_cate = M("item_cate")->where("status=1")->order("ordid asc")->select();

        //分类数据
        if (false === $cate_data = F('cate_data')) {
          $cate_data = D('item_cate')->cate_data_cache();
        }

        $item_cate_list = array();
        // if(count($cate_data) > 0){
        //   foreach ($cate_data as $key => $value) {

        //   }
        // }

        // echo "<pre>";
        // print_r($cate_data);
        // echo "</pre>";
        // exit;

        $this->display();
    }
}


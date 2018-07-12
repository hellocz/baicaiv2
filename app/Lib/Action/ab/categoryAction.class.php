<?php
class categoryAction extends newfrontendAction {

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

    public function cate() {
        $id = $this->_get('id', 'intval');
        !$id && $this->_404();
        //分类数据
        if (false === $cate_data = F('cate_data')) {
            $cate_data = D('item_cate')->cate_data_cache();
        }
        //当前分类信息
        if (isset($cate_data[$id])) {
            $cate_info = $cate_data[$id];
        } else {
            $this->_404();
        }
        //分类关系
        if (false === $cate_relate = F('cate_relate')) {
            $cate_relate = D('item_cate')->relate_cache();
        }

        //天猫搜券
        $q = trim($cate_info['name']);
        $item_list = $this->search_quan($q);
        $cate_info['recommend']=array_slice($item_list,0,4);

        //过滤筛选及查询结果
        $params = array('id' => $id);
        array_push($cate_relate[$id]['sids'], $id);
        $where['cate_id'] = array('in', $cate_relate[$id]['sids']); //分类
        $this->filter($params, $where);

        //SEO
        $level = substr_count($cate_info['spid'],"|")+1;
        if(empty($cate_info['seo_title'])){
          if($level == 2){
            $child_cates =M("item_cate")->where("pid=$id")->field("name")->select();
            $child = "";
            foreach ($child_cates as $child_cate) {
              $child .= $child_cate['name'] . ",";
            }
            $child = rtrim($child, ',');
            $page_seo['title'] = $cate_info['name'] . "内部优惠券|" . $cate_info['name'] . "优惠活动|" . $cate_info['name'] . "海淘|白菜哦";
            $page_seo['keywords'] = $cate_info['name'] . "内部优惠券|" . $cate_info['name'] . "优惠活动|" . $cate_info['name'] . "海淘";
            $page_seo['description'] = "提供最新" . $cate_info['name'] . "相关内部优惠券大全,教你海淘" . $cate_info['name'] ."无需找代购,这里是白菜哦" . $cate_info['name'] . "优惠信息专栏,最新热门品牌榜等,下载APP不错过任何好价.包括" . $child . "等各类优惠促销";
          }
          else{
            $page_seo['title'] = $cate_info['name'] . "内部优惠券|" . $cate_info['name'] . "优惠活动|" . $cate_info['name'] . "海淘|白菜哦";
            $page_seo['keywords'] = $cate_info['name'] . "内部优惠券|" . $cate_info['name'] . "优惠活动|" . $cate_info['name'] . "海淘";
            $page_seo['description'] = "这里是白菜哦关于" . $cate_info['name'] . "的优惠信息活动专栏,提供2018年最新" . $cate_info['name'] ."十大品牌,全网" . $cate_info['name'] . "内部优惠券大全,教你海淘" . $cate_info['name'] . "无需找代购,下载APP不错过任何好价.";
          }
        }
        else{
          $page_seo['title'] = $cate_info['seo_title'];
          $page_seo['keywords'] = $cate_info['seo_keys'];
          $page_seo['description'] = $cate_info['seo_desc'];
        }

        $this->assign('info', $cate_info); //当前分类信息
        $this->assign('page_seo', $page_seo);
        $this->display();
    }
}


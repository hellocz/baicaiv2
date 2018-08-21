<?php
class brandAction extends frontendAction {

    public function index() {

        $q = $this->_get('q', 'trim');

        //分类品牌数据
        $cate_brand_list = D('brand')->cate_brand_cache();

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
        $cate_brand_list = D('brand')->cate_brand_cache();

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

        //分页
        $pagesize=168;
        $count = isset($cate_brand['data']) ? count($cate_brand['data']) : 0; 
        $pager = $this->_pager($count,$pagesize);
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

    public function show(){
        //brand品牌ID
        $id = $this->_get('id', 'intval');
        !$id && $this->_404();
        $brand = D("brand")->get_info($id);
        !$brand && $this->error('该信息不存在或已删除');
        // $brand['name'] = str_replace("&nbsp;","",$brand['name']);
        $brand['name'] = str_replace("&nbsp;","",$brand['chn_name']);
        $brand['abstract'] = trim($brand['abstract']);

        // 搜索关键词是否关注
        if($this->visitor->is_login){
          $brand['is_follow'] = D("notify_tag")->is_follow($this->visitor->info['id'], $brand['name']);
        }

        //分类ID
        $cid = $this->_get('cid', 'intval');
        $cate_info = "";
        if($cid){
          //分类数据
          $cate_data = D('item_cate')->cate_data_cache();        
          //当前分类信息
          if (isset($cate_data[$cid])) {
              $cate_info = $cate_data[$cid];
          }else{
              $cid = '';
          }
        }

        //天猫搜券
        //品牌
        $q = trim($brand['chn_name']);
        //分类信息
        if($cid){
          $q = trim($cate_info['name']) . " " . $q;
        }
        //搜索
        $item_list = $this->search_quan($q);
        $brand['recommend']=array_slice($item_list,0,4);

        //过滤筛选及查询结果
        $params = array('id' => $id);
        $filters = array('id' => $id);
        if($cid){
          $params['cid'] = $cid;
          $filters['cid'] = $cid;
        }
        $this->search($params, '_brand_', $filters);

        $page_seo['title'] = $brand['name'] . "怎么样_" . $brand['name'] . "品牌介绍_" . $brand['name'] . "旗舰店_白菜哦官网";
        $page_seo['keywords'] = $brand['name'] . "品牌介绍、" . $brand['name'] . "怎么样、" . $brand['name'] . "价格、" . $brand['name'] . "旗舰店、" . $brand['name'] . "官网";
        $page_seo['description'] = "汇总了" . $brand['name'] ."品牌介绍、" . $brand['name'] . "官网和" . $brand['name'] . "官方旗舰店的促销优惠，还可以搜索到" . $brand['name'] ."的最新内部优惠券，想知道" . $brand['name'] ."有什么知名产品，有没有折扣就快来这里看看吧！";
        $this->assign('page_seo', $page_seo);
        $this->assign('info', $brand);
        $this->display();
    }


    public function hot(){
      $p = $this->_get('p',"intval",1);
      $cateid = $this->_get('cateid','intval');
      $cate = M("item_cate")->where("id=$cateid")->find();
      $level = substr_count($cate['spid'],"|")+1;
      if(!empty($cate)){
              $brand_list_ids = unserialize($cate['top']);
              $brand_map['id']=array('in',$brand_list_ids);
              $brand_list = M("brand")->field('id,name,chn_name,country,abstract,tb,img')->where($brand_map)->select();
              $brand_names = array();

              $q = array();
              foreach ($brand_list as $key=>$val) {
                $brand_list[$key]['abstract'] = trim($brand_list[$key]['abstract']);                
                array_push($brand_names, trim($brand_list[$key]['chn_name']));

                $q[$key] = $cate['name'] . " " . trim($brand_list[$key]['chn_name']);
              }

              //搜券
              $item_list = $this->search_quan($q);
              foreach ($brand_list as $key=>$val) {
                $brand_list[$key]['recommend'] = isset($item_list[$key]) ? array_slice($item_list[$key],0,5) : array();
              }
              unset($item_list);

              $this->assign('brand_list',$brand_list);
          }

              
      $this->assign('cate_info', $cate);

      if(empty($cate['seo_title'])){
        if($level == 2){
          $child_cates =M("item_cate")->where("pid=$cateid")->field("name")->select();
          $child = "";
          foreach ($child_cates as $child_cate) {
            $child .= $child_cate['name'] . ",";
          }
          $child = rtrim($child, ',');
          $page_seo['title'] = $cate['name'] . "内部优惠券|" . $cate['name'] . "优惠活动|" . $cate['name'] . "海淘|白菜哦";
          $page_seo['keywords'] = $cate['name'] . "内部优惠券|" . $cate['name'] . "优惠活动|" . $cate['name'] . "海淘|白菜哦";
          $page_seo['description'] =  "提供最新" . $cate['name'] . "相关内部优惠券大全,教你海淘" . $cate['name'] ."无需找代购,这里是白菜哦" . $cate['name'] . "优惠信息专栏,最新热门品牌榜等,下载APP不错过任何好价.包括" . $child . "等各类优惠促销";
        }
        else{
          $page_seo['title'] = $cate['name'] . "哪个牌子好|2018最新" . $cate['name'] . "十大品牌榜|" .$cate['name'] . "知名品牌|什么" . $cate['name'] . "值得买";
          $page_seo['keywords'] = $cate['name'] . "哪个牌子好，2018最新" . $cate['name'] . "十大品牌榜，" . $cate['name'] . "知名品牌，什么" . $cate['name'] . "值得买";
          $page_seo['description'] =  "想知道" .  $cate['name'] . "哪个牌子最好，什么" .  $cate['name'] . "值得买，就来看看" .  $cate['name'] . "2018年最新品牌榜吧！前三名有" . $brand_names[0] . "、" . $brand_names[1] . "和" . $brand_names[2] . "。还提供最新" . $cate['name'] . "优惠券领取，以及" . $cate['name'] . "优惠活动和特价商品推荐，想购物来白菜哦，买得便宜又称心！";
        }
      }
      else{
          $page_seo['title'] = $cate['seo_title'];
          $page_seo['keywords'] = $cate['seo_keys'];
          $page_seo['description'] = $cate['seo_desc'];
      }
      $this->assign('page_seo', $page_seo);
      $this->assign("strpos",getpos($cateid,''));
      $this->assign('category',$cate['name']);
      $this->display();
    }

    
}


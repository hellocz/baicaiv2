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

    public function show(){
      $id = $this->_get('id', 'intval');
      !$id && $this->_404();
      $item = M("brand")->where(array('id' => $id))->find();
      !$item && $this->error('该信息不存在或已删除');
      $item['name'] = str_replace("&nbsp;","",$item['name']);
      $page_seo['title'] = $item['name'] . "怎么样_" . $item['name'] . "品牌介绍_" . $item['name'] . "旗舰店_白菜哦官网";
      $page_seo['keywords'] = $item['name'] . "品牌介绍、" . $item['name'] . "怎么样、" . $item['name'] . "价格、" . $item['name'] . "旗舰店、" . $item['name'] . "官网";
      $page_seo['description'] = "汇总了" . $item['name'] ."品牌介绍、" . $item['name'] . "官网和" . $item['name'] . "官方旗舰店的促销优惠，还可以搜索到" . $item['name'] ."的最新内部优惠券，想知道" . $item['name'] ."有什么知名产品，有没有折扣就快来这里看看吧！";
      $this->assign('page_seo', $page_seo);
      $this->assign('info', $item);
      $this->display();
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

        //分页
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


    public function hot(){
      $p = $this->_get('p',"intval",1);
      $cateid = $this->_get('cateid','intval');
      $cate = M("item_cate")->where("id=$cateid")->find();
      $level = substr_count($cate['spid'],"|")+1;
      if(!empty($cate)){
              include_once LIB_PATH . 'Pinlib/taobao/TopSdk.php';
              $c = new TopClient;
              $c->appkey = "23232602";
              $c->secretKey = "a91ec4b0a09a93dd2c9e85d88665ef26";
              $req = new TbkDgItemCouponGetRequest;
              $req->setAdzoneId("14718353");
             // $req->setPlatform(1);
              $req->setPageSize("100");
              $req->setPageNo("1");
              $brand_list_ids = unserialize($cate['top']);
              $brand_map['id']=array('in',$brand_list_ids);
              $brand_list = M("brand")->field('id,name,chn_name,country,abstract,tb,img')->where($brand_map)->select();
              $brand_names = array();
              foreach ($brand_list as $key=>$val) {
                $brand_list[$key]['abstract'] = trim($brand_list[$key]['abstract']);
                $req->setQ($cate['name'] . " " . trim($brand_list[$key]['chn_name']));
                $resp = $c->execute($req);
                $lists=$resp->results->tbk_coupon;
                array_push($brand_names, trim($brand_list[$key]['chn_name']));
                $item_list = array();
                 foreach ($lists as $list) {
                    $item['title'] = $list->title;
                    $item['user_type'] = intval($list->user_type);
                    $item['img'] = $list->pict_url;
                    $item['url'] = $list->item_url;
                    $item['coupon_url'] = $list->coupon_click_url;
                    $item['volume'] = intval($list->volume);
                    $item['coupon_info'] = $list->coupon_info;
                    $pattern = '/减((\d){1,})元/';
                    $pattern_num = preg_match($pattern,$item['coupon_info'],$pattern_result);
                    $item['coupon'] = floatval($pattern_result[1]);
                    $item['zk_final_price'] = floatval($list->zk_final_price);
                    $item['price'] = $item['zk_final_price'] - $item['coupon'];
                    array_push($item_list,$item);
                 }
            usort($item_list, 'sortByVolume');
            $brand_list[$key]['recommend']=array_slice($item_list,0,5);

              }

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


<?php

/**
 * 逛宝贝页面
 */
class categoryAction extends frontendAction {

    public function _initialize() {
        parent::_initialize();
        $this->assign('nav_curr', 'book');
    }

	public function index(){
		$p = $this->_get('p',"intval",1);
		$categoryid = $this->_get('categoryid','intval',447);
        $category = M("category")->where("id=$categoryid")->find();
		if(!empty($category)){
            include_once LIB_PATH . 'Pinlib/taobao/TopSdk.php';
            $c = new TopClient;
            $c->appkey = "23232602";
            $c->secretKey = "a91ec4b0a09a93dd2c9e85d88665ef26";
            $req = new TbkDgItemCouponGetRequest;
            $req->setAdzoneId("14718353");
           // $req->setPlatform(1);
            $req->setPageSize("100");
            $req->setPageNo("1");
            $brand_list_ids = unserialize($category['top']);
            $brand_map['id']=array('in',$brand_list_ids);
            $brand_list = M("brand")->field('id,name,country,abstract,tb,img')->where($brand_map)->select();
            foreach ($brand_list as $key=>$val) {
               $brand_list[$key]['abstract'] = trim($brand_list[$key]['abstract']);
                $req->setQ($category['name'] . "+" . $brand_list[$key]['name']);
           $resp = $c->execute($req);
           $lists=$resp->results->tbk_coupon;
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

            

           

        $this->assign('category',$category['name']);
		$this->display();
	}

    
}

<?php
class brandAction extends frontendAction {

    protected function _new_pager($count, $pagesize,$parameter='',$url='') {
        $pager = new Page($count, $pagesize,$parameter,$url);
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
        $brand = M("brand")->where(array('id' => $id))->find();
        !$brand && $this->error('该信息不存在或已删除');
        $brand['name'] = str_replace("&nbsp;","",$brand['name']);

        if(!empty($id)){
            include_once LIB_PATH . 'Pinlib/taobao/TopSdk.php';
            $c = new TopClient;
            $c->appkey = "23232602";
            $c->secretKey = "a91ec4b0a09a93dd2c9e85d88665ef26";
            $req = new TbkDgItemCouponGetRequest;
            $req->setAdzoneId("14718353");
           // $req->setPlatform(1);
            $req->setPageSize("100");
            $req->setPageNo("1");
            // $brand_list_ids = unserialize($cate['top']);
            // $brand_map['id']=array('in',$brand_list_ids);
            // $brand_list = M("brand")->field('id,name,chn_name,country,abstract,tb,img')->where($brand_map)->select();

            // $brand_names = array();
            $brand['abstract'] = trim($brand['abstract']);
            // $req->setQ($cate['name'] . " " . trim($brand['chn_name']));
            $req->setQ(trim($brand['chn_name']));
            $resp = $c->execute($req);
            $lists=$resp->results->tbk_coupon;
            // array_push($brand_names, trim($brand['chn_name']));
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
            $brand['recommend']=array_slice($item_list,0,4);
        }

        // $this->assign('brand',$brand);

        $p = $this->_get('p', 'intval', 1);
        $t = $this->_get('t','trim');
        if(!is_array($t)){
            $t = array_flip(explode(',', $t));
        }
        $property = $this->_get('property','trim');
        $cid = $this->_get('cid','intval',0);
        // $cpid = $this->_get('cpid','intval',0);
        $orig = $this->_get('orig','trim');
        if(!is_array($orig)){
            $orig = array_flip(explode(',', $orig));
        }
        $tag = $this->_get('tag','trim');
        if(!is_array($tag)){
            $tag = array_flip(explode(',', $tag));
        }
        $price = $this->_get('price','intval',0);
        $pricemin = $this->_get('pricemin','intval',0);
        $pricemax = $this->_get('pricemax','intval',0);
        $period = $this->_get('period','intval',0);
        $sortby = $this->_get('sortby','trim');
        // $dss = $this->_get('dss','trim');
        $dss_l = $_COOKIE['dss_l'];
        if($p<1){$p=1;}
        $time=time();
        $time = strtotime('2018-05-31 23:59:59'); //测试

        //文章类型
        $type_list = array(
            1 => "首页推荐", 
            2 => "热门优惠", 
            3 => "全网特价", 
        ); 
        //按属性，国内，国外
        $ismy_list = array(
            '1' => array('name' => '海淘', 'count' => 0),
            '0' => array('name' => '国内', 'count' => 0),
        );

        //标签列表
        $tag_list = array(
            1 => "凑单品", 
            2 => "包邮", 
            3 => "PRIME会员", 
            4 => "PLUS会员", 
            5 => "历史低价", 
            6 => "新低价", 
            7 => "可直邮", 
            8 => "需转运",
        );

        //价格列表
        $price_list = array(
            1 => array('min' => 0, 'max' => 50), 
            2 => array('min' => 50, 'max' => 100), 
            3 => array('min' => 100, 'max' => 150), 
            4 => array('min' => 150, 'max' => 200), 
            5 => array('min' => 200, 'max' => 500), 
            6 => array('min' => 500), 
        ); 

        //时间列表
        $period_list = array(
            '0' => "过去一周", 
            '1' => "过去一月", 
            '2' => "过去一年", 
        ); 

        //排序
        $sortby_list = array(
            'newest' => " add_time desc", 
            'hottest' => " hits desc", 
        );

        //商城列表
        $origs = M("item_orig")->order("ordid asc")->select();
        $orig_list = array();
        if(count($origs) > 0){
            foreach ($origs as $k => $val) {
                $orig_list[$val['id']] = $val;
            }
        }
        $origs = $orig_list;

        //分类列表
        if (false === $raw_cate_list = F('cate_list')) {
            $raw_cate_list = D('item_cate')->cate_cache();
        }
        $cate_list = $raw_cate_list;
        //分类，取两级目录
        if(count($cate_list) > 0){
            foreach ($cate_list['s'] as $k => $val) {
                if(!isset($cate_list['p'][$k])){
                    unset($cate_list['s'][$k]);
                }
            }
        }
        //分类数据
        if (false === $cate_data = F('cate_data')) {
          $cate_data = D('item_cate')->cate_data_cache();
        }

        //默认过滤选项
        $filter = array(
            'id' => $id,
            't' => array('1' => 'on'),  //必选
            // 'property' => array('1' => 'on', '0' => 'on'),  //国外，国内
            // 'cid' => '',
            // 'orig' => array(),
            // 'tag' => array(),
            // 'price' => '',
            // 'pricemin' => '',
            // 'pricemax' => '', 
            'period' => 0,  //必选
            // 'sortby' => '',
        );

        //查询条件
        $mod=M("item");
        $queryAllArr = array();
        $queryAllArr['where']="status=1 and isnice=1 and tag_cache like '%\"". trim($brand['chn_name']) ."\"%' ";
        $queryArr = array();
        $queryArr['where']="status=1 and isnice=1 and tag_cache like '%\"". trim($brand['chn_name']) ."\"%' ";

        //过滤条件, 固定条件，选项不会变化
        //时间
        if(array_key_exists($period, $period_list)){
            $filter['period'] = $period;
        }
        switch ($filter['period']) {
            case '1':
                $time_s = strtotime("-1 month", strtotime(date("Y-m-d 00:00:00", $time))+86400);
                $time_e = $time;
                break;
            case '2':
                $time_s = strtotime("-1 year", strtotime(date("Y-m-d 00:00:00", $time))+86400);
                $time_e = $time;
                break;                
            default:
                $time_s = strtotime("-7 day", strtotime(date("Y-m-d 00:00:00", $time))+86400);
                $time_e = $time;
                break;
        }
        $queryAllArr['where'].="and add_time between $time_s and $time_e ";
        $queryArr['where'].="and add_time between $time_s and $time_e ";
        //文章类型
        if(count($t) > 0){
            foreach ($t as $k => $val) {
                if(!isset($type_list[$k])) continue;
                if(isset($filter['t'])) unset($filter['t']);  //有选择并且t在type list列表内时，清掉默认选择
                $filter['t'][$k] = $val;
                break;  //单选
            }
        }
        //属性：国内，国外
        if(count($property) > 0){
            if(isset($filter['property'])) unset($filter['property']);
            foreach ($property as $k => $val) {
                if(!isset($ismy_list[$k])) continue;
                $filter['property'][$k] = $val;
            }
        }
        //分类过滤
        if($cid > 0 && count($cate_list) > 0){
            foreach ($cate_list['s'] as $k => $val) {
                if(isset($cate_list['s'][$k][$cid])){  //判断传过来的是否二级分类
                    $filter['cid']= $cid;
                    $arr = array($cid);
                    if(isset($raw_cate_list['s'][$cid])){
                        $arr = array_merge($arr, array_keys($raw_cate_list['s'][$cid]));
                    }
                    $queryArr['where'].="and cate_id in(". implode(', ', $arr) .") ";
                }
            }
        }
        //商城过滤
        if(count($orig) > 0){
            if(isset($filter['orig'])) unset($filter['orig']);
            foreach ($orig as $k => $val) {
                if(!isset($orig_list[$k])) continue;
                $filter['orig'][$k] = $k;
            }
            if(count($filter['orig']) > 0){
                $queryArr['where'].="and orig_id in(". implode(', ', array_keys($filter['orig'])) .") ";
            }
        }
        $orig_more = false;
        $arr = array_slice($orig_list, 5, null, TRUE);
        if(isset($filter['orig']) and count($filter['orig'])>0){
            foreach ($filter['orig'] as $k => $v) {
                if(array_key_exists($k, $arr)){
                    $orig_more = true;
                    break;
                }
            }
        }
        //标签
        if(count($tag) > 0){
            if(isset($filter['tag'])) unset($filter['tag']);
            foreach ($tag as $k => $val) {
                if(!array_key_exists($k, $tag_list)) continue;
                $filter['tag'][$k] = $tag_list[$k]; 
            }
            if(count($filter['tag']) > 0){
                $queryArr['where'].="and (`title` like '%". implode("%' OR `title` like '%", $filter['tag']) ."%') ";
            }
        }
        //价格        
        if($price > 0 && array_key_exists($price, $price_list)){
            $filter['price'] = $price;
            if(isset($price_list[$price]['min'])){
                $queryArr['where'].="and pure_price>={$price_list[$price]['min']} ";
            }
            if(isset($price_list[$price]['max'])){
                $queryArr['where'].="and pure_price<{$price_list[$price]['max']} ";
            }
        }else{
            if($pricemin>0){
                $filter['pricemin'] = $pricemin;
                $queryArr['where'].="and pure_price>={$pricemin} ";
            }
            if($pricemax>0){
                $filter['pricemax'] = $pricemax;
                $queryArr['where'].="and pure_price<={$pricemax} ";
            }
        }
        //排序
        $queryArr['order'] =" add_time desc"; 
        if(array_key_exists($sortby, $sortby_list)){
            $filter['sortby'] = $sortby;
            $queryArr['order'] = $sortby_list[$sortby]; 
        }
        // echo "<pre>";print_r($filter);echo "</pre>"; exit;

        //统计字段
        //tag字段
        $queryAllArr['group']['tag'] = '(case ';
        foreach ($tag_list as $key => $value) {
            $queryAllArr['group']['tag'] .= "when `title` like '%{$value}%' then {$key} ";
        }
        $queryAllArr['group']['tag'] .= "else -1 end)";

        //price字段
        $queryAllArr['group']['price'] = '(case ';
        foreach ($price_list as $key => $value) {
            $queryAllArr['group']['price'] .= "when `pure_price` >= {$value['min']} ";
            if(isset($value['max'])){
                $queryAllArr['group']['price'] .= "and `pure_price` < {$value['max']} ";
            }
            $queryAllArr['group']['price'] .= "then {$key} ";
        }
        $queryAllArr['group']['price'] .= "else -1 end)";

        //判断是否在价格范围内
        if(isset($filter['pricemin']) && isset($filter['pricemax'])){
            $queryAllArr['group']['price_range'] = "(case when pure_price>={$filter['pricemin']} and pure_price<={$filter['pricemax']} then 1 else 0 end)";
        }else if(isset($filter['pricemin'])){
            $queryAllArr['group']['price_range'] = "(case when pure_price>={$filter['pricemin']} then 1 else 0 end)";
        }else if(isset($filter['pricemax'])){
            $queryAllArr['group']['price_range'] = "(case when pure_price<={$filter['pricemax']} then 1 else 0 end)";
        }else{
            $queryAllArr['group']['price_range'] = "1";
        }

        //统计按推荐、按国内外、按分类、按商场数据
        $data =  $mod->field("orig_id, cate_id, {$queryAllArr['group']['tag']} as tag, {$queryAllArr['group']['price']} as price, {$queryAllArr['group']['price_range']} as price_range, count(id) as item_count")->where($queryAllArr['where'])->group("orig_id, cate_id, {$queryAllArr['group']['tag']}, {$queryAllArr['group']['price']}, {$queryAllArr['group']['price_range']}")->select();

        //统计
        $count = array();
        $count['total'] = 0;
        $count['list'] = 0;
        if(count($data) > 0){
            foreach ($data as $k => $val) {

                //国内外字段 //商场ID
                $ismy = -1;
                $orig_id = -1;
                if(isset($origs[$val['orig_id']])){
                    $ismy = $origs[$val['orig_id']]['ismy'];
                    $orig_id = $val['orig_id'];     
                }

                //一级和二级分类的id
                $cate_pid= -1;
                $cate_spid = -1;
                if(isset($cate_data[$val['cate_id']])){
                    list($p1,$p2) = explode('|', $cate_data[$val['cate_id']]['spid']."||");
                    //计算一级分类的商品数量
                    if($cate_data[$val['cate_id']]['pid']==0){
                        $cate_pid= $val['cate_id'];
                    }else if(!empty($p1)){
                        $cate_pid= $p1; 
                        //计算二级分类的商品数量
                        if(!empty($p2)){
                            $cate_spid = $p2; 
                        }
                    }
                }

                //tag, price
                $tag_id = $val['tag'];
                $price_id = $val['price'];
                $price_range = $val['price_range'];

                $item_count = $val['item_count'];

                $list_count = true;
                $ismy_count = true;
                $orig_count = true;
                $cate_count = true;
                if(isset($filter['property']) && !isset($filter['property'][$ismy])){
                    // $ismy_count = false;
                    $orig_count = false;
                    $cate_count = false;
                    $list_count = false;
                }
                if(isset($filter['cid']) && $filter['cid'] != $cate_spid){
                    $ismy_count = false;
                    // $cate_count = false;
                    $orig_count = false;
                    $list_count = false;
                }
                if(isset($filter['orig']) && !isset($filter['orig'][$orig_id])){
                    $ismy_count = false;
                    $cate_count = false;
                    // $orig_count = false;
                    $list_count = false;
                }
                if(isset($filter['tag']) && !isset($filter['tag'][$tag_id])){
                    $ismy_count = false;
                    $cate_count = false;
                    $orig_count = false;
                    $list_count = false;
                }
                if(isset($filter['price']) && !isset($filter['price'][$price_id])){
                    $ismy_count = false;
                    $cate_count = false;
                    $orig_count = false;
                    $list_count = false;
                }
                if($price_range == 0){
                    $ismy_count = false;
                    $cate_count = false;
                    $orig_count = false;
                    $list_count = false;
                }

                //全部
                $count['total'] += $item_count;

                if($list_count){
                    $count['list'] += $item_count;
                }

                //按国内外统计
                if($ismy_count){
                    if(isset($ismy_list[$ismy])){
                            $ismy_list[$ismy]['count'] += $item_count;
                    }
                }

                //按商城计算商品数量
                if($orig_count){
                    $orig_list[$orig_id]['count'] = (isset($orig_list[$orig_id]['count']) ? $orig_list[$orig_id]['count'] : 0) + $item_count;
                }

                //计算一级和二级分类的商品数量
                if($cate_count){
                    if($cate_pid > 0){
                        $cate_list['p'][$cate_pid]['count'] = (isset($cate_list['p'][$cate_pid]['count']) ? $cate_list['p'][$cate_pid]['count'] : 0) + $item_count;
                        if($cate_spid > 0){
                            $cate_list['s'][$cate_pid][$cate_spid]['count'] = (isset($cate_list['s'][$cate_pid][$cate_spid]['count']) ? $cate_list['s'][$cate_pid][$cate_spid]['count'] : 0) + $item_count;
                        }
                    }
                }

            }
        }
        // print_r($orig_list);

        //过滤没有商品的分类、商城等
        if(count($orig_list) > 0){
            foreach ($orig_list as $k => $val) {
                if(!isset($val['count'])){
                    //若无数据，但是为过滤条件，显示0
                    if(isset($filter['orig']) && isset($filter['orig'][$k])){
                        $orig_list[$k]['count'] = 0;
                    }else{
                        unset($orig_list[$k]);
                    }
                }
            }
        }
        if(count($cate_list) > 0){
            foreach ($cate_list['p'] as $k => $val) {
                $check = 0;              
                if(isset($cate_list['s'][$k])){
                    foreach ($cate_list['s'][$k] as $k2 => $val2) {
                        if(!isset($val2['count'])){
                            //若无数据，但是为过滤条件，显示0
                            if(isset($filter['cid']) && $filter['cid'] == $k2){
                                $cate_list['s'][$k][$k2]['count'] = 0;
                                $check = 1;
                            }else{
                                unset($cate_list['s'][$k][$k2]);
                            }
                        }
                    }
                }
                if(!isset($val['count'])){
                    if($check){
                        $cate_list['p'][$k]['count'] = 0;
                    }else{
                        unset($cate_list['p'][$k]);
                        unset($cate_list['s'][$k]);
                    }
                }
            }
        }
        // print_r($cate_list);exit;

         //生成URL
        $path = (defined('GROUP_NAME')?GROUP_NAME:'')."/".MODULE_NAME."/".ACTION_NAME;
        //$url['raw_pure'] = U($path);
        // change for this page - start
        $arr = array('id' => $filter['id']);
        $url['raw_pure'] = U($path, $arr);
        // change for this page - end
        $arr = $filter;
        $url['raw'] = U($path) . "?" . http_build_query($arr);
        $arr = $filter;
        $arr['t']= array('1' => 'on');
        $url['tuijan'] = U($path) . "?" . http_build_query($arr);
        $arr['t']= array('2' => 'on');
        $url['remen'] = U($path) . "?" . http_build_query($arr);
        $arr['t']= array('3' => 'on');
        $url['quanwang'] = U($path) . "?" . http_build_query($arr);
        $arr = $filter;
        $arr['sortby'] = 'newest';
        $url['newest'] = U($path) . "?" . http_build_query($arr);
        $arr['sortby'] = 'hottest';
        $url['hottest'] = U($path) . "?" . http_build_query($arr);
        // echo "<br>$url";exit;

        // 生成URL, param is array
        $param = array();
        $arr = array();
        foreach ($filter as $key => $value) {
            if($value === '' || (is_array($value) && count($value) == 0)) continue;
            if(is_array($value)){
                $param[$key] = implode(',', array_keys($value));
            }else{
                $param[$key] = $value;
            }
            $arr[$key] = $key . "=" . $param[$key];
        }
        $parameter = implode('&', $arr);
        // echo "<pre>";print_r($param);echo "<pre>";echo $parameter;exit;

        //分页
        $pagesize=24;
        $pager = $this->_new_pager($count['list'],$pagesize,$parameter);

        //查询列表
        $list = $mod->where($queryArr['where'])->order($queryArr['order'])->limit($pager->firstRow.",".$pager->listRows)->select();
        
        if(count($list)>=1){
            foreach($list as $key=>$val){
                $list[$key]['zan'] = $list[$key]['zan']   +intval($list[$key]['hits'] /10);

                //商品一级分类
                $cate_id = $list[$key]['cate_id'];
                $cate_name = '';
                if(isset($cate_data[$cate_id]) && $cate_data[$cate_id]['pid']==0){
                    $cate_name = $cate_data[$cate_id]['name'];
                }else if(isset($cate_data[$cate_id])){
                    list($p1,$p2) = explode('|', $cate_data[$cate_id]['spid']."||");
                    if(isset($cate_data[$p1])){
                        $cate_name = $cate_data[$p1]['name'];
                    }
                }
                $list[$key]['cate_name'] = $cate_name;
            }
        }
        // print_r($list);exit;

        $this->assign('total_count', $count['total']);
        $this->assign('filter', $filter);
        $this->assign("url", $url);

        $this->assign('type_list',$type_list);
        $this->assign('cate_list',$cate_list);
        $this->assign('orig_list',$orig_list);
        $this->assign('orig_more',$orig_more);
        $this->assign('ismy_list',$ismy_list);
        $this->assign('tag_list',$tag_list);
        $this->assign('period_list',$period_list);

        $this->assign('origs',$origs);
        $this->assign('list',$list);

        $this->assign('p',$p);
        $this->assign('pagebar',$pager->newshow());
        $this->assign("dss_l",$dss_l);

        $page_seo['title'] = $brand['name'] . "怎么样_" . $brand['name'] . "品牌介绍_" . $brand['name'] . "旗舰店_白菜哦官网";
        $page_seo['keywords'] = $brand['name'] . "品牌介绍、" . $brand['name'] . "怎么样、" . $brand['name'] . "价格、" . $brand['name'] . "旗舰店、" . $brand['name'] . "官网";
        $page_seo['description'] = "汇总了" . $brand['name'] ."品牌介绍、" . $brand['name'] . "官网和" . $brand['name'] . "官方旗舰店的促销优惠，还可以搜索到" . $brand['name'] ."的最新内部优惠券，想知道" . $brand['name'] ."有什么知名产品，有没有折扣就快来这里看看吧！";
        $this->assign('page_seo', $page_seo);
        $this->assign('info', $brand);
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


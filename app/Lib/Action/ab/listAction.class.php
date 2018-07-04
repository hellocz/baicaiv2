<?php
class listAction extends frontendAction {

    protected function _new_pager($count, $pagesize) {
        $pager = new Page($count, $pagesize);
        $pager->rollPage = 5;
        $pager->setConfig('prev', '<i class="icon5 icon5-a_14" style="margin-top: 5px;"></i>');
        $pager->setConfig('next', '<i class="icon5 icon5-a_15" style="margin-top: 5px;"></i>');
        // $pager->setConfig('theme', '%upPage% %first% %linkPage% %end% %downPage%');
        $pager->setConfig('theme', '%upPage% %first% %linkPage% %downPage%');
        return $pager;
    }

    public function index(){
        $p = $this->_get('p', 'intval', 1);
        $t = $this->_get('t','trim');
        $property = $this->_get('property','trim');
        $cid = $this->_get('cid','intval',0);
        // $cpid = $this->_get('cpid','intval',0);
        $orig = $this->_get('orig','trim');
        $tag = $this->_get('tag','trim');
        $price = $this->_get('price','intval',0);
        $pricemin = $this->_get('pricemin','intval',0);
        $pricemax = $this->_get('pricemax','intval',0);
        $period = $this->_get('period','intval',0);
        // $dss = $this->_get('dss','trim');
        // $dss = ($dss=="") ? $_COOKIE['dss'] : $dss;
        if($p<1){$p=1;}
        $time=time();
        $time = strtotime('2018-05-31 23:59:59'); //测试

        //按属性，国内，国外
        $ismy_list = array(
            '1' => array('name' => '海淘', 'count' => 0),
            '0' => array('name' => '国内', 'count' => 0),
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

        //标签列表
        $tag_list = array(
            0 => "凑单品", 
            1 => "包邮", 
            2 => "中亚PRIME会员", 
            3 => "京东PLUS会员", 
            4 => "历史低价", 
            5 => "新低价", 
            6 => "可直邮", 
            7 => "需转运",
        );

        //分类列表
        if (false === $cate_list = F('cate_list')) {
            $cate_list = D('item_cate')->cate_cache();
        }
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

        //过滤选项
        $filter = array(
            't' => array('1' => 'on'),
            'property' => array('1' => 'on', '2' => 'on'), 
            'orig' => array(),
            'tag' => array(),
            'pricemin' => '',
            'pricemax' => '', 
            'period' => 0,
        );

        //文章类型
        if(count($t) > 0){
            foreach ($t as $k => $val) {
                $filter['t'][$k] = $val;
                break;  //单选
            }
        }
        if(count($property) > 0){
            foreach ($property as $k => $val) {
                $filter['property'][$k] = $val;
            }
        }
        //category id
         if(isset($cate_list['s'][$cid])){
            $filter['cid']= $cid;
         }

        //商城
        if(count($orig) > 0){
            foreach ($orig as $k => $val) {
                if(!isset($orig_list[$k])) continue;
                $filter['orig'][$k] = $val;
            }
        }
        //标签
        if(count($tag) > 0){
            foreach ($tag as $k => $val) {
                if(!array_key_exists($k, $tag_list)) continue;
                $filter['tag'][$k] = $tag_list[$k];
            }
        }
        //价格
        $price_list = array(
            1 => "0~49元", 
            2 => "50~99元", 
            3 => "100~149元", 
            4 => "150~199元", 
            5 => "200~499元", 
            6 => "500元以上", 
            ); 
        if(array_key_exists($price, $price_list)){
            $filter['price'] = $price;
        }
        if($pricemax>0){
            $filter['pricemin'] = $pricemin;
            $filter['pricemax'] = $pricemax;
        }
        //时间
        $period_list = array(
            '0' => "过去一周", 
            '1' => "过去一月", 
            '2' => "过去一年", 
            ); 
        if(array_key_exists($period, $period_list)){
            $filter['period'] = $period;
            switch ($period) {
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
        }
        // echo date("Y-m-d H:i:s", $time_s) . "<br>";
        // echo date("Y-m-d H:i:s", $time_e) . "<br>";
        // print_r($filter);exit;

        //分页
        $pagesize=24;
        $count = 1000; //$mod->where("status=1 and add_time<$time ".$where)->count();
        $pager = $this->_new_pager($count,$pagesize);
        
        //查询
        $mod=M("item");
        $queryArr = array();
        $queryArr['where']="status=1 and add_time between $time_s and $time_e and isnice=1 ";
        $queryArr['order'] =" add_time desc"; 

        //首页推荐
        $data =  $mod->field('orig_id, cate_id, count(id) as item_count')->where($queryArr['where'])->group('orig_id, cate_id')->select();

        if(count($data) > 0){
            foreach ($data as $k => $val) {
                //全部
                $total_count += $val['item_count'];

                //按国内外统计
                 if(isset($orig_list[$val['orig_id']])){
                    $ismy = $orig_list[$val['orig_id']]['ismy'];
                    if(isset($ismy_list[$ismy])){
                        $ismy_list[$ismy]['count'] += $val['item_count'];
                    }
                }
                //按商城计算商品数量
                if(isset($orig_list[$val['orig_id']])){
                    $orig_list[$val['orig_id']]['count'] = (isset($orig_list[$val['orig_id']]['count']) ? $orig_list[$val['orig_id']]['count'] : 0) + $val['item_count'];
                }
                //计算一级和二级分类的商品数量
                if(isset($cate_data[$val['cate_id']])){
                    list($p1,$p2) = explode('|', $cate_data[$val['cate_id']]['spid']."||");
                    //计算一级分类的商品数量
                    if($cate_data[$val['cate_id']]['pid']==0){
                        $cate_list['p'][$val['cate_id']]['count'] = (isset($cate_list['p'][$val['cate_id']]['count']) ? $cate_list['p'][$val['cate_id']]['count'] : 0) + $val['item_count'];
                    }else if(isset($cate_list['p'][$p1])){
                        $cate_list['p'][$p1]['count'] = (isset($cate_list['p'][$p1]['count']) ? $cate_list['p'][$p1]['count'] : 0) + $val['item_count'];                        
                        //计算二级分类的商品数量
                        if(isset($cate_list['s'][$p1][$val['cate_id']])){
                            $cate_list['s'][$p1][$val['cate_id']]['count'] = (isset($cate_list['s'][$p1][$val['cate_id']]['count']) ? $cate_list['s'][$p1][$val['cate_id']]['count'] : 0) + $val['item_count'];
                        }else if(isset($cate_list['s'][$p1][$p2])){
                            $cate_list['s'][$p1][$p2]['count'] = (isset($cate_list['s'][$p1][$p2]['count']) ? $cate_list['s'][$p1][$p2]['count'] : 0) + $val['item_count'];
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
                    unset($orig_list[$k]);
                }
            }
        }
        if(count($cate_list) > 0){
            foreach ($cate_list['p'] as $k => $val) {
                if(!isset($val['count'])){
                    unset($cate_list['p'][$k]);
                    unset($cate_list['s'][$k]);
                }
                if(isset($cate_list['s'][$k])){
                    foreach ($cate_list['s'][$k]as $k2 => $val) {
                        if(!isset($val['count'])){
                            unset($cate_list['s'][$k][$k2]);
                        }
                    }
                }
            }
        }
        // print_r($cate_list);exit;


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

        $this->assign('total_count', $total_count);
        $this->assign('filter', $filter);
        $this->assign('cate_list',$cate_list);
        $this->assign('orig_list',$orig_list);
        $this->assign('ismy_list',$ismy_list);
        $this->assign('tag_list',$tag_list);
        $this->assign('origs',$origs);
        $this->assign('list',$list);
        $this->display();
    }

}
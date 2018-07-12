<?php
class tagAction extends newfrontendAction {

   public function index() {
        // $hot_tags = explode(',', C('pin_hot_tags')); //热门标签
        // $page_max = C('pin_book_page_max'); //发现页面最多显示页数
        // $sort = $this->_get('sort', 'trim'); //排序
        // $isnice = $this->_get('isnice','intval');

        $q = $this->_get('q', 'trim'); //当前标签

        //字符串处理，避免URL获取参数出错
        $tag = $this->param_decode($q);

        // if($tag =="9-9包邮"){
        //     $tag ="9.9包邮";
        // }
        // $pos   =   strpos($tag, '-');
        // if($pos !== false){
        //     $tag = str_replace("-"," ", $tag);
        // }

        $where = array();
        $tag_id =  M("tag")->where(array('name'=>$tag))->getField('id'); 
        $tag_id && $tag_items = M("item_tag")->where(array('tag_id'=>$tag_id))->field("item_id")->select();
        if(isset($tag_items) && count($tag_items) > 0){
          foreach ($tag_items as $tag_item_id) {
              if($str==""){
                   $str=$tag_item_id['item_id'];
              }else{
                 $str.=",".$tag_item_id['item_id'];
              }
          }
        }
        if($str){
            $where['id'] = array('in', $str);
        }else{
            $where['id'] = array('in', '-1');
        }

        $info = array();
        $info['name'] = $tag;

        //天猫搜券
        $item_list = $this->search_quan($info['name']);
        $info['recommend']=array_slice($item_list,0,4);

        //过滤筛选及查询结果
        $params = array('q' => urlencode($q));
        $this->filter($params, $where);

        // //排序：最热(hot)，最新(new)
        // switch ($sort) {
        //     case 'hot':
        //         $order = 'hits DESC,id DESC';
        //         break;
        //     case 'new':
        //         $order = 'id DESC';
        //         break;
        //     default:
        //         $order = 'add_time DESC';
        //         break;
        // }
        //  $this->waterfall($where, $order, '', $page_max);

        // $this->assign('hot_tags', $hot_tags);
        $this->assign('info', $info);
        // $this->assign('sort', $sort);
        $this->_config_seo(C('pin_seo_config.book'), array('tag_name' => $tag)); //SEO
        $strpos = ($tag)?"$tag":" 所有商品";
        if(empty($tag)){
        $page_seo['title'] = "海淘专享优惠券|海外购网站优惠劵|网易考拉海购优惠卷|海淘专享优惠券|白菜哦 ";
        $page_seo['keywords'] = "海淘专享优惠券|海外购网站优惠劵|网易考拉海购优惠卷|海淘专享优惠券|白菜哦";
        $page_seo['description'] = "白菜哦提供2018年最新海淘,商品优惠劵,专享优惠卷，20-50元天猫优惠劵，告诉你优惠劵购买技巧";
        
        }
        else{
        $page_seo['title'] = $tag . "最新优惠商品推荐_" . $tag . "怎么选_" . $tag . "品牌_白菜哦";
        $page_seo['keywords'] = $tag . "最新优惠," . $tag . "怎么选," . $tag . "哪个牌子好";
        $page_seo['description'] = "这里是白菜哦(baicaio.com)关于" . $tag . "的优惠汇总页面，特价一网打尽。本站还提供知名品牌排行榜，专属优惠券、独家优惠码，攻略晒单等，想知道" . $tag . "哪个牌子好，" . $tag . "怎么选，" . $tag . "排行榜，就来白菜哦看看吧！";
        }
        $this->assign('page_seo', $page_seo);
        // $this->assign('strpos',$strpos);
        $this->display();
    }

}

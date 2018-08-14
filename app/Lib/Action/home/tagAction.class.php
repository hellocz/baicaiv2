<?php
class tagAction extends frontendAction {

   public function index() {

        $q = $this->_get('q', 'trim'); //当前标签

        //字符串处理，避免URL获取参数出错
        $q = param_decode($q);

        $info = array();
        $info['name'] = $q;

        //天猫搜券
        $item_list = $this->search_quan($info['name']);
        $info['recommend']=array_slice($item_list,0,4);

        //过滤筛选及查询结果
        $params = array('q' => param_encode($q));
        $filters = array('q' => $q);
        $this->search($params, '_tag_', $filters);

        // $this->assign('hot_tags', $hot_tags);
        $this->assign('info', $info);
        // $this->assign('sort', $sort);
        $this->_config_seo(C('pin_seo_config.book'), array('tag_name' => $q)); //SEO
        $strpos = ($q)?"$q":" 所有商品";
        if(empty($q)){
        $page_seo['title'] = "海淘专享优惠券|海外购网站优惠劵|网易考拉海购优惠卷|海淘专享优惠券|白菜哦 ";
        $page_seo['keywords'] = "海淘专享优惠券|海外购网站优惠劵|网易考拉海购优惠卷|海淘专享优惠券|白菜哦";
        $page_seo['description'] = "白菜哦提供2018年最新海淘,商品优惠劵,专享优惠卷，20-50元天猫优惠劵，告诉你优惠劵购买技巧";
        
        }
        else{
        $page_seo['title'] = $q . "最新优惠商品推荐_" . $q . "怎么选_" . $q . "品牌_白菜哦";
        $page_seo['keywords'] = $q . "最新优惠," . $q . "怎么选," . $q . "哪个牌子好";
        $page_seo['description'] = "这里是白菜哦(baicaio.com)关于" . $q . "的优惠汇总页面，特价一网打尽。本站还提供知名品牌排行榜，专属优惠券、独家优惠码，攻略晒单等，想知道" . $q . "哪个牌子好，" . $q . "怎么选，" . $q . "排行榜，就来白菜哦看看吧！";
        }
        $this->assign('page_seo', $page_seo);
        // $this->assign('strpos',$strpos);
        $this->display();
    }

}

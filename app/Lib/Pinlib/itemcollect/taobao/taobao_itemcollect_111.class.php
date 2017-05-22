<?php

/**
 * 淘宝商品获取
 *
 * @author andery
 */
class taobao_itemcollect {

    private $_code = 'taobao';

    public function fetch($url) {
        $text = file_get_contents($url);
		preg_match('/<img[^>]*id="J_ImgBooth"[^r]*rc=\"([^"]*)\"[^>]*>/', $text, $img);
		preg_match('/<title>([^<>]*)<\/title>/', $text, $title);
		preg_match('/<([a-z]+)[^i]*id=\"J_StrPrice\"[^>]*>(.*)<\/\\1>/', $text, $tt);
		if($tt[2]!=''){
			preg_match('/<em[^>]*class="tb-rmb-num">(.*)<\/em>/',$tt[2],$price);
		}
		$title=iconv('GBK','UTF-8',$title[1]);
		$result['key_id']=$this->get_key($url);
		$result['url']=$url;
		$result['img']="http:".$img[1];
		$result['title']=$title;
		$result['price']=$price[1];
		return $result;
    }

    public function get_id($url) {
        $id = 0;
        $parse = parse_url($url);
        if (isset($parse['query'])) {
            parse_str($parse['query'], $params);
            if (isset($params['id'])) {
                $id = $params['id'];
            } elseif (isset($params['item_id'])) {
                $id = $params['item_id'];
            } elseif (isset($params['default_item_id'])) {
                $id = $params['default_item_id'];
            }
        }
        return $id;
    }

    public function get_key($url) {
        $id = $this->get_id($url);
        return 'taobao_' . $id;
    }
}
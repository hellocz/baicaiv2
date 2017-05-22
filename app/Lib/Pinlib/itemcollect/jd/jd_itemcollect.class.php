<?php

/**
 * 淘宝商品获取
 *
 * @author andery
 */
class jd_itemcollect {

    private $_code = 'jd';

    public function fetch($url) {
		$text = file_get_contents($url);
		//获取标题
		preg_match("/<div[^>]*id=\"name\">[^>]*<h1>(.*)<\/h1>/", $text, $match_title);
		if(isset($match_title[1]) && $match_title[1]){
			$title =  iconv('GB2312', 'UTF-8', $match_title[1]);
		}
		//获取图片
		preg_match('/<div[^>]*id=\"spec-n1\"[^>]*>[^<]*<img[^>]*[^r]*rc=\"([^"]*)\"[^>]*>/', $text, $match_img);
		if(isset($match_img[1]) && $match_img[1]){
			$img_url = $match_img[1];
		}
		$result['key_id']=$this->get_key($url);
		$result['url']=$url;
		$result['img']="http:".$img_url;
		$result['price']=$price;
		$result['title']=$title;
		return $result;
    }

    public function get_id($url) {
        $id = 0;
		$sid = substr($url,strrpos($url,'/')+1);
		$sid = explode(".",$sid);
		$id = $sid[0];
        return $id;
    }

    public function get_key($url) {
        $id = $this->get_id($url);
        return 'jd_' . $id;
    }
	
}	
?>
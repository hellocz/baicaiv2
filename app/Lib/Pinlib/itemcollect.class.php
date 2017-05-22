<?php
/**
 * 商品路由
 *
 * @author andery
 */
class itemcollect {

    public function url_parse($url) {
        $html = file_get_contents($url);
        if(empty($html)) $html = getHTTPS($url);
        //获取淘宝代购商品信息
        if (strpos($url, 'daigou.taobao.com')) {
            preg_match('/<span class="price J-price">.*([\d\.]+?).*<\/span>/sU', $html, $price);
            preg_match('/<img[^>]*data-ks-imagezoom-nobig=\"([^"]*)\"[^>]*>/', $html, $img);
            preg_match_all('/<img[^>]*data-ks-imagezoom=\"([^"]*)\"[^>]*>/', $html, $imgs);
            $imgs_value = array();
            for($i=0;$i<count($imgs[1]);$i++){
                if(!strpos($imgs[1][$i], "http:"))
                    $img_url = "http:" . $imgs[1][$i];
                else
                    $img_url = $imgs[1][$i];
                $imgs_array["url"] = $img_url;
                //$imgs_array["id"] = $i+1;
                array_push($imgs_value, $imgs_array);
            }
            preg_match('/<h1 class="title">(.*?)<\/h1>/i', $html, $title);
        }
        //获取淘宝商品信息
        if (strpos($url, 'item.taobao.com')) {
            preg_match('/<em class="tb-rmb-num">(.*?)<\/em>/i', $html, $price);
            preg_match('/<img id="J_ImgBooth" src=\"([^"]*)\"[^>]*>/', $html, $img);
            preg_match_all('/<img[^>]*data-src=\"([^"]*)\"[^>]*>/', $html, $imgs);
            $imgs_value = array();
            for($i=0;$i<count($imgs[1]);$i++){
                if(!strpos($imgs[1][$i], "http:"))
                    $img_url = "http:" . $imgs[1][$i];
                else
                    $img_url = $imgs[1][$i];
                $imgs_array["url"] = str_replace("50x50", "430x430", $img_url);
                //$imgs_array["id"] = $i+1;
                array_push($imgs_value, $imgs_array);
            }
            preg_match('/<h3 class="tb-main-title" data-title=\"(.+?)\".*?>/i', $html, $title);
        }
        if (strpos($url, 'www.amazon.cn')) {
            preg_match('/<span .*? class="a-size-medium a-color-price".*?>(.*?)<\/span>/i', $html, $price);
            preg_match('/<img.*? src=\"(.*?)\"/', $html, $img);
            preg_match_all('/<img[^>]*data-src=\"([^"]*)\"[^>]*>/', $html, $imgs);
            preg_match('/<span id=\"productTitle\" class=\"a-size-large\">(.*?)<\/span>/', $html, $title);
        }
        //获取天猫商品信息
        if (strpos($url, 'detail.tmall.com')) {
            preg_match('/"reservePrice":"(.*?)"/i', $html, $price);
            preg_match('/<img id="J_ImgBooth"[^>]* src="([^"]*)"[^>]*>/', $html, $img);
            preg_match_all('/<img[^>]*src=\"([^"]*)\"[^>]*>/', $html, $imgs);
            $imgs_value = array();
            for($i=0;$i<count($imgs[1]);$i++){
                if(!strpos($imgs[1][$i], "http:"))
                    $img_url = "http:" . $imgs[1][$i];
                else
                    $img_url = $imgs[1][$i];
                $imgs_array["url"] = str_replace("60x60", "430x430", $img_url);
                //$imgs_array["id"] = $i+1;
                array_push($imgs_value, $imgs_array);
            }
            preg_match('/"title":"(.*?)"/i', $html, $title);
        }
        //获取京东商品信息
        if(strpos($url, "item.jd.com")){
            preg_match('/<img data-img="1" width="350" height="350"[^>]* src="([^"]*)"[^>]*>/', $html, $img);
            preg_match_all('/<li><img[^>]* data-url=\'([^\']*)\' data-img=\'1\' width=\'50\' height=\'50\'>/', $html, $imgs);

            $imgs_value = array();
            for($i=0;$i<count($imgs[1]);$i++){
                if(!strpos($imgs[1][$i], "http:"))
                    $img_url = "http://img10.360buyimg.com/n1/" . $imgs[1][$i];
                else
                    $img_url = $imgs[1][$i];
                $imgs_array["url"] = $img_url;
                //$imgs_array["id"] = $i+1;
                array_push($imgs_value, $imgs_array);
            }
            preg_match('/<h1>(.*?)<\/h1>/i', $html, $title);
            $title[1] = mb_convert_encoding($title[1], 'UTF-8', 'GBK,UTF-8,ASCII');
        }

        $r["price"] = $price[1];//获取金额
        if(false !==strpos($img[1], "http:") && false !==strpos($img[1], "https:") &&false !==strpos($img[1], "base64"))
            $img_url = "http:" . $img[1];
        else
            $img_url = $img[1];
        $r["img"] = $img_url;//获取金额
        $r["imgs"] = $imgs_value;//获取金额
        $r["title"] = $title[1];//获取金额
        return $r;
    }

    /**
     * 返回结果为false时采集失败
     */
    public function fetch() {
        if ($this->collect_module) {
            return $this->collect_module->fetch($this->url);
        } else {
            return false;
        }
    }

}
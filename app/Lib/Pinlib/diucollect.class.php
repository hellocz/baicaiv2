<?php
/**
 * 商品路由
 *
 * @author andery
 */
class diucollect {

    public function url_parse() {
        $url ="http://guangdiu.com/";
        $html = file_get_contents($url);
        preg_match_all('/<div class="gooditem withborder">(.*?)<div class="rightmall">/', $html, $items);
       
        $ori_url = "http://guangdiu.com/go.php?id=3962035";

        $r['content'] = $this->get_redirect_url($ori_url);
        // $headers = get_headers($ori_url, 1);
        //$r['content'] =$headers['Location'][count($headers['Location'])-1];
//print_r($headers);

        return $r;
    }

    public function get_jump_url($url) {
    $url = str_replace(' ','',$url);
    do {//do.while循环：先执行一次，判断后再是否循环
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $header = curl_exec($curl);
    var_dump(curl_getinfo($curl,CURLINFO_EFFECTIVE_URL));

    curl_close($curl);
    preg_match('|Location:\s(.*?)\s|',$header,$tdl);
    if(strpos($header,"Location:")){
    $url=$tdl ? $tdl[1] :  null ;
    }
    else{
    return $url.'';
    break;
    }
    }while(true);
    }

    function get_redirect_url($url, $referer=”, $timeout = 20) {
   $redirect_url = false;
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_HEADER, TRUE);
   curl_setopt($ch, CURLOPT_NOBODY, TRUE);//不返回请求体内容
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);//允许请求的链接跳转
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
   curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Accept: */*",
      "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)",
      "Connection: Keep-Alive"));
   if ($referer) {
     curl_setopt($ch, CURLOPT_REFERER, $referer);//设置referer
   }

   $content = curl_exec($ch);
   if(!curl_errno($ch)) {
     $redirect_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);//获取最终请求的url地址
   }

   return $content;
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
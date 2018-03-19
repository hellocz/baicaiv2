<?php


class brandAction extends frontendAction {

    public function _initialize() {
        parent::_initialize();
        //访问者控制
        if (!$this->visitor->is_login && in_array(ACTION_NAME, array('share_item', 'fetch_item', 'publish_item', 'like', 'unlike', 'delete', 'comment','publish','myitems'))) {
            IS_AJAX && $this->ajaxReturn(0, L('login_please'));
            $this->redirect('user/login');
        }
    }
    /**
    * 我的关注
    */

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

    public function fetch_category(){
      $diucollect = new simple_html_dom();
      $diucollect->load(getHTTPS('https://www.qiang100.com/pinpai/'));
      $mains = $diucollect->find(".container2")[0]->find(".main");
     
    // echo count($mains);
      foreach ($mains as $main) {
        $main_name = $main->getElementByTagName("b")->text();

        $main_category['name'] = $main_name;
        $main_category['mpid'] = 0;
        $main_category['pid'] = 0;
        $main_category_id = M('category')->add($main_category);
        $list_dl = $main->find("dl");
        foreach ($list_dl as $dl) {
          # code...
         $pid_category['name'] = $dl->getElementByTagName("h3")->getElementByTagName("a")->text();
         $pid_category['mpid'] = $main_category_id;
         $pid_category['pid'] = 0;
         $pid_category_id = M('category')->add($pid_category);

         $dd_link_list = $dl->getElementByTagName("dd")->find("a");
          foreach ($dd_link_list as $link) {
            # code...
            if(false !== strpos($link->href , '/zhuanti')){
             $child_category['name'] = $link->text();
             $child_category['mpid'] = $main_category_id;
             $child_category['pid'] = $pid_category_id;
             $child_category['cate_html'] = $link->href;
             M('category')->add($child_category);
           }
          }
        }
/*
        $link_list = $main->find("dd")[0]->find("a");
        $i=0;
        foreach ($link_list as $link) {
          # code...
           if(false !== strpos($link->href , '/zhuanti')){
          echo "<a href=https://www.qiang100.com" . $link->href .">" . $link->text() . "</a> ";
          if($i < 3){
       //   $this->fetch_brand("https://www.qiang100.com" . $link->href);
          }
          $i++;
        }
        }
        */
         echo "</br>";
      }

    }

    public function testjd(){
      $jd_url = new simple_html_dom();
      $jd_url->load(getHTTPS("https://union-click.jd.com/jdc?e=&p=AyIHUitaJQMiQwpDBUoyS0IQWhkeHAxbBUYGCllHGAdFBwtaTVIBUkcVBhMPUgQCUF5PNyV%2BC2BabVkQe10SXVFxB1kzEld1VAMXV3sBEwdTB1sWHhIPRBteHgMTDFASaxAHFwZTHVkcByIHVBpaFAUSA1cTayUCEzcUdVsSAxUBZRprFQYSBVIcWRYHGwFRGWsSMhIFURpfEgIbB1UYNVQyIjdlK2sUMhM%3D&t=W1dCFFlQCxxOVwhGRE5XDVULR0VNXUdTHAdbEQMaAEpCHklf"));
      echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
      echo $jd_url->find("body")[0];
    }

    private function fetch_brand($cate_url){
      $brand_web =  new simple_html_dom();
      $brand_web->load(getHTTPS($cate_url));
      $brand_list = $brand_web->find(".brand-list-item");
      $i=0;
      $brand_ids=array();
      foreach ($brand_list as $brand) {
      //  if($i == 0){
       $brand_title = $brand->find(".brand-list-item-intro-title-brandname")[0]->text();
       $brand_name = trim(split("/", $brand_title)[0]);
       $brand_country = trim(split("/", $brand_title)[1]);
       $brand_combine_name = $brand->find(".bq_pf2_scorall")[0]->dpdata;
       $chn_name = split("\|", $brand_combine_name)[1];
       $en_name = split("\|", $brand_combine_name)[0];
       $direct_link = $brand->find(".brand-list-item-intro-detail")[0]->getElementByTagName("a");
       $link = $direct_link->href;
       $detail = $this->brand_detail("https://www.qiang100.com" . $link);
       $detail['name'] = $brand_name;
       $detail['chn_name'] = $chn_name;
       $detail['en_name'] = $en_name;
       $detail['country'] = $brand_country;
       $detail['abstract'] = $direct_link->text();
       $sign = M('brand')->where("name=$brand_name")->find();
       if(empty($sign)){
        $brand_id=M('brand')->add($detail);
        array_push($brand_ids,$brand_id);
       }
       else{
        array_push($brand_ids,$sign['id']);
       }

    //  }
      $i++;
      }
      return $brand_ids;
    }

    private function brand_detail($url){
      $brand_web =  new simple_html_dom();
      $brand_web->load(getHTTPS($url));
      $img_url = $brand_web->find(".brand-detail-info-logo")[0]->getElementByTagName("img")->src;
       if(false !== strpos($img_url , 'http')){
         $detail['img'] = $this->get_photo($img_url,0);
       }
       else{
      $detail['img'] = $this->get_photo("https://www.qiang100.com" . $img_url,0);
      }
      $tb_link = $brand_web->find(".brand-detail-shop-tmall")[0]->href;
      if(false !== strpos($tb_link , 'tmall')){
        $detail['tb'] = $tb_link;
      }
      $detail['content'] = $brand_web->find(".tab-pane")[0]->innertext();
      return $detail;

    }

    public function scan_brand(){
      $id = $this->_get('id', 'intval');
   //   echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
      $child_category = M('category')->where("id=$id")->find();
      if($child_category['mpid'] != 0 and $child_category['pid'] != 0) {
       // echo $child_category['name'];
        $brand_ids = $this->fetch_brand("https://www.qiang100.com" . $child_category['cate_html']);
        $category['id'] = $id;
        $category['top'] = serialize($brand_ids);
        if(count($brand_ids)>2)
        M('category')->save($category);
      //  echo "<br>";
      }
      $id=intval($id);
      $id++;
      $this->assign("category",$child_category['name']);
      $this->assign("id",$id);
     $this->display();

    }

   
    public function fetch_diu(){
        $diucollect = new simple_html_dom();
        $diucollect->load_file('http://guangdiu.com/');
        $items = $diucollect->find('.gooditem');
        echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";

        $exist_item = M("item_diu")->field("max(diu_id) as max_id ")->find();
        $max= 0;
        $exist_item['max_id'] && $max=  $exist_item['max_id'];
       for($i=0 ; $i<30;$i++)
        {
           $diu_item;
            echo ("---------------------<br>");
           unset($diu_item);
           $childs =  $items[$i]->childNodes();
           $imgandbtn = $childs[0];
           $iteminfoarea =  $childs[1];
           $iteminfoarea_childs = $iteminfoarea->childNodes();
           $rightlinks  =  $childs[2];
           $detal_url = $imgandbtn->getElementByTagName('a')->href;
           $id = intval(preg_replace('/.*id=/',"",$detal_url));
            echo ("------id:".$id . "max:".$max."---------------<br>");
           if ($id <=$max){continue;}
           $diu_item['diu_id']= $id ;
           foreach ( $rightlinks->find(".rightmallname") as $e) {
                $diu_item['orig']=trim($e->text());
             }
             if($diu_item['orig']=="亚马逊中国" || $diu_item['orig']=="天猫" || $diu_item['orig'] == "京东商城"){
                if($diu_item['orig']=="天猫"){
                  $diu_item['orig'] = "天猫商城";
                }
                  $where['name'] =  $diu_item['orig'];
                  $orig = M('item_orig')->field('id')->where($where)->find();
                  $diu_item['orig_id']= intval($orig['id']) ;
                  $diu_item['cate_id'] =346;
                  $diu_item['uid'] =193739;
                  $diu_item['uname'] ="baoff";
                  $diu_item['status'] =1;
                  $diu_item['isbao'] =1;
                  $diu_item['zan']=rand(0,5);
                  $diu_item['add_time'] =time();
                     foreach ( $rightlinks->find(".innergototobuybtn") as $e) {
                       if($diu_item['orig'] == "京东商城"){
                          $diucollect =file_get_contents('http://guangdiu.com/' . $e->href);
                          $pattern = '/(\d{6,}).html/';
                          $pattern_num = preg_match($pattern, $diucollect,$pattern_result);
                          $diu_item['url'] = $this->converturl("https://item.jd.com/" . $pattern_result[1] . ".html"); 
                        //  var_dump($pattern_result[1]);
                  }
                  else{
                          $diu_item['url'] = $this->converturl($e->href);
                        }
                          $arr[0]=array('name'=>"直达链接",'link'=>$diu_item['url']);
                          $diu_item['go_link'] =serialize($arr);
                     }

      /*
                   $itemcollect = new itemcollect();
                    echo ("--url--".$diu_item['url']  ."--url--<br>");
                   $info = $itemcollect->url_parse( $diu_item['url'] );
                    echo ("--img_content--".$info['img'] ."--img_content--<br>");
                     echo ("--price--".$info['price'] ."--price--<br>");
                   
                     $html = file_get_contents($diu_item['url']);
                      if(empty($html)) $html = getHTTPS($diu_item['url']);
                    $amazon_detail->load($html);
                   foreach ( $amazon_detail->find("#landingImage") as $e) {
                    
                      $img_content = $e->src;
                        echo ("--img_content--".$img_content ."--img_content--");
                      if(false !== strpos($img_content , 'https')){
                          $diu_item['img'] = $this->get_photo($img_content,0);
                      }
                      else{
                           $diu_item['img'] = $img_content;
                      }
            //           preg_match('/https:.*?.jpg/', $e->outertext(), $imgs);
           //            $img=$imgs[0];
                   } 
                   */
                
                $img = $imgandbtn->getElementByTagName('img')->src;
                $diu_item['img'] = $this->get_photo($img,0);
                $diu_detail = new simple_html_dom();
                $diu_detail->load_file('http://guangdiu.com/' .$detal_url);
                $content;
                  foreach ( $diu_detail->find(".dabstract") as $e) {
                      $content = $e;
                   } 
                  foreach ($content->find ("a") as $e) {
                    $href = $e->href;
                      if(strpos($href, "detail.tmall.com") !== false || strpos($href, "taoquan.taobao.com") !== false){
                        //donothing
                      }
                      elseif(strpos($href, "uland.taobao.com") !== false){
                          $e->href=$this->converturl($href);
                      }
                      elseif(strpos($href, "https://s.click.taobao.com/1D7zLZw") !== false){
                           $e->href="https://s.click.taobao.com/e3rM4Zw";
                      }
                      elseif(strpos($href, "http://mo.m.taobao.com/union/1111yushou") !== false){
                           $e->href="https://s.click.taobao.com/zOyM4Zw";
                      }
                      else{
                        $e->removeAttribute("href");
                      }
                    }
               

                   
                   $diu_item['title']  = $iteminfoarea_childs[0]->firstChild()->text();
                   //    $diu_item['content'] = $content->innertext() . $dimage->innertext();
                   
                  $diu_item['content'] = $content->innertext();
                   $diu_item['content']  =  preg_replace('/<img.*?>/',"",  $diu_item['content'] );
                 $diu_item['content'] = $diu_item['content']  . '<p><img class="img_bao" src="' . $diu_item['img'] . '!watermark"></p>';
                //  echo ("price:" . $iteminfoarea_childs[0]->firstChild()->lastChild(). "<br>");
                   foreach ( $iteminfoarea->find(".abstractcontent") as $e) {
                  $diu_item['intro'] =$e->text();
                  }
                  
                M("item_diu")->add($diu_item);
             }
            

      //  echo($items[$i]->innertext());
        /*
       $url = 'http://guangdiu.com/go.php?id=3962326';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $content = curl_exec($ch);

        preg_match('/var.*\'(.*?)\'/', $content, $matches); 
        Log::record('1111'.$content.'1111','ALERT','WARN');
*/
// 从url中加载
       // $html->load_file('http://guangdiu.com/go.php?id=3958191');
       // $items = $html->find('.gooditem');
      //  echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
      //  echo $r['content'];//.  $items[0]->innertext();

    }
}
      function converturl($url) 
      {
        $parsed_url = parse_url($url);
        $host = $parsed_url['host'];
         $result = array();
         $profile['us_amazon']="show00-20";
         $profile['ch_amazon']="baicaiobl-23";
         $profile['sid']="baoliao";
         $profile['mm_pid']="mm_27883119_3410238_93410083";


        if (empty($host) or substr_count(strtolower($url),'http')>=2){
              $result['convert_url'] =$url;
          }
        if (strcmp($host,'www.amazon.com')==0){
            $pattern = '/product\/(([a-zA-Z]|\d){10})/';
           $pattern_num = preg_match($pattern,$parsed_url['path'],$pattern_result);
             if($pattern_num!=0){
                  $result['convert_url'] = 'https://www.amazon.com/dp/' . $pattern_result[1] . '?t=' .  $profile['us_amazon'] . '&tag=' .  $profile['us_amazon'];
             }
         else{
           $pattern1 = '/dp\/(([a-zA-Z]|\d){10})/';
           $pattern_num1 = preg_match($pattern1,$parsed_url['path'],$pattern_result);
             if($pattern_num1!=0){
                 $result['convert_url'] = 'https://www.amazon.com/dp/' . $pattern_result[1] . '?t=' .  $profile['us_amazon'] . '&tag=' .  $profile['us_amazon'];
             }
             else{
                    $pattern2 = '/creativeASIN=(([a-zA-Z]|\d){10})/';
                    $pattern_num2 = preg_match($pattern2, $url,$pattern_result);

                 if($pattern_num2!=0){
                     $result['convert_url'] = 'https://www.amazon.com/dp/' . $pattern_result[1] . '?t=' . $profile['us_amazon'] . '&tag=' .  $profile['us_amazon'];
                 }
                 else{
                    $result['convert_url'] =$url;
                 }
             }
           }
        }
         elseif (strcmp($host,'www.amazon.cn')==0){
            $pattern = '/product\/(([a-zA-Z]|\d){10})/';
           $pattern_num = preg_match($pattern,$parsed_url['path'],$pattern_result);
             if($pattern_num!=0){
                  $result['convert_url'] = 'https://www.amazon.cn/dp/' . $pattern_result[1] . '?t=' .  $profile['ch_amazon'] . '&tag=' .  $profile['ch_amazon'];
             }
         else{
           $pattern1 = '/dp\/(([a-zA-Z]|\d){10})/';
           $pattern_num1 = preg_match($pattern1,$parsed_url['path'],$pattern_result);
             if($pattern_num1!=0){
                 $result['convert_url'] = 'https://www.amazon.cn/dp/' . $pattern_result[1] . '?t=' .  $profile['ch_amazon'] . '&tag=' .  $profile['ch_amazon'];
             }
             else{
                    $pattern2 = '/creativeASIN=(([a-zA-Z]|\d){10})/';
                    $pattern_num2 = preg_match($pattern2, $url,$pattern_result);

                 if($pattern_num2!=0){
                     $result['convert_url'] = 'https://www.amazon.cn/dp/' . $pattern_result[1] . '?t=' .  $profile['ch_amazon'] . '&tag=' .  $profile['ch_amazon'];
                 }
                 else{
                    $result['convert_url'] =$url;
                 }
             }
           }
           
        }
        elseif (strcmp($host,'www.amazon.co.jp')==0){
            $pattern = '/product\/(([a-zA-Z]|\d){10})/';
           $pattern_num = preg_match($pattern,$parsed_url['path'],$pattern_result);
             if($pattern_num!=0){
                  $result['convert_url'] = 'http://count.chanet.com.cn/click.cgi?a=524082&d=381499&u=' .  $profile['sid'] . '&e=&url=https://www.amazon.co.jp/dp/'. $pattern_result[1] ;
             }
         else{
           $pattern1 = '/dp\/(([a-zA-Z]|\d){10})/';
           $pattern_num1 = preg_match($pattern1,$parsed_url['path'],$pattern_result);
             if($pattern_num1!=0){
                 $result['convert_url'] = 'http://count.chanet.com.cn/click.cgi?a=524082&d=381499&u=' .  $profile['sid'] . '&e=&url=https://www.amazon.co.jp/dp/'. $pattern_result[1] ;
             }
             else{
                    $pattern2 = '/creativeASIN=(([a-zA-Z]|\d){10})/';
                    $pattern_num2 = preg_match($pattern2, $url,$pattern_result);

                 if($pattern_num2!=0){
                     $result['convert_url'] = 'http://count.chanet.com.cn/click.cgi?a=524082&d=381499&u=' .  $profile['sid'] . '&e=&url=https://www.amazon.co.jp/dp/'. $pattern_result[1] ;
                 }
                 else{
                    $result['convert_url'] =$url;
                 }
             }
           }
           
        }elseif (strcmp($host,'uland.taobao.com')==0){

          $result['convert_url']= preg_replace('/mm_\d+_\d+_\d+/',  $profile['mm_pid'], $url);
          /*
            $result['id'] =3;
            $parsed_orig_url = parse_url($url);
             parse_str($parsed_orig_url['query'],$parsed_orig_query);
             if(isset($parsed_orig_query['activityId']) &&isset($parsed_orig_query['itemId']) ){
                 $result['convert_url'] =  "https://uland.taobao.com/coupon/edetail?activityId=" . $parsed_orig_query['activityId'] . "&itemId=" . $parsed_orig_query['itemId'] . "&pid=" . $profile['mm_pid']. "&dx=1";;
             }
             else{
                  $result['convert_url'] =  $url;
             }
             */
        }
        else{
               $origs = M('item_orig')->where("url like '%" . $host . "%'")->Field('url ,id')->select();
                if(count($origs)!=0){
                     $result['id'] =$origs[0]['id'];
                     $orig_url = $origs[0]['url'];
                     $parsed_orig_url = parse_url($orig_url);
                      parse_str($parsed_orig_url['query'],$parsed_orig_query);
                       if(stripos($orig_url, 'sid=SS') !==false){
                             $parsed_orig_query['sid']=$profile['sid'];
                        }
                        elseif(stripos($orig_url, 'sid=lh_m1nyfc__SS') !==false){
                             $parsed_orig_query['sid']='lh_m1nyfc__' . $profile['sid'];
                        }
                         elseif(stripos($orig_url, 'euid=SS') !==false){
                             $parsed_orig_query['euid']=$profile['sid'];
                        }
                        elseif(stripos($orig_url, 'u=SS') !==false){
                             $parsed_orig_query['u']=$profile['sid'];
                        }
                         elseif(stripos($orig_url, 'e=SS') !==false){
                             $parsed_orig_query['e']=$profile['sid'];
                        }
                        elseif(stripos($orig_url, 'sid/SS/') !==false){
                             $parsed_orig_url['path']=str_replace('sid/SS/','sid/' . $profile['sid'] . '/',$parsed_orig_url['path']);
                        }
                        else{
                             $parsed_orig_query['tag']=$profile['sid'];
                        }

                        if(isset($parsed_orig_query['url'])){
                            $parsed_orig_query['url'] = $url;
                        }
                        elseif(isset($parsed_orig_query['new'])){
                            $parsed_orig_query['new'] = $url;
                        }
                        elseif(isset($parsed_orig_query['t'])){
                            $parsed_orig_query['t'] = $url;
                        }
                        $parsed_orig_url['query'] = http_build_query($parsed_orig_query);
                        $parsed_orig_url['query']= urldecode($parsed_orig_url['query']);
                           $result['convert_url'] =   $this->http_build_url($parsed_orig_url);
                }
              
        }
        
        if( count($result)==0){
              $result['convert_url'] =$url;
              $result['id'] =-1;
          }
        
        return $result['convert_url'] ;
    }

    function http_build_url($url_arr){
        $new_url = $url_arr['scheme'] . "://".$url_arr['host'];
        if(!empty($url_arr['port']))
            $new_url = $new_url.":".$url_arr['port'];
        $new_url = $new_url . $url_arr['path'];
        if(!empty($url_arr['query']))
            $new_url = $new_url . "?" . $url_arr['query'];
        if(!empty($url_arr['fragment']))
            $new_url = $new_url . "#" . $url_arr['fragment'];
        return $new_url;
    }

//foler path :ueditor\php\upload\image
function get_photo($url,$file_num,$savefile='ueditor/php/upload/image/')   
{     
    $imgArr = array('gif','bmp','png','ico','jpg','jepg');  

    $url = preg_replace('/\?.*/',"",$url);

    $url = preg_replace('/https/','http',$url);
  
    if(!$url) return false;  
    
    if(!$filename) {     
      $ext=strtolower(end(explode('.',$url)));     
 //     if(!in_array($ext,$imgArr)) return false;  
      $filename=time(). "_" .$file_num . '.'.$ext;     
    } 
    $savefile = $savefile . date("Ymd") . "/";    
  
    if(!is_dir($savefile)) mkdir($savefile, 0777);  
    if(!is_readable($savefile)) chmod($savefile, 0777);  
      
    $filename = $savefile.$filename;  
  
    ob_start();     
    readfile($url);     
    $img = ob_get_contents();     
   
    ob_end_clean(); 

    //  $img=base64_decode($img);
        $str = uniqid(mt_rand(),1);

        $file = 'upload/'.md5($str).'.jpg';
        $art_add_time = date('ym/d');
        $upload_path = '/'.C('pin_attach_path') . 'brand/'. $art_add_time.'/'.md5($str).'.jpg';
        file_put_contents($file, $img);
            $art_add_time = date('ym/d');
            $upyun = new UpYun2('baicaiopic', '528', 'lzw123456');
            $fh = fopen($file, 'rb');
            $rsp = $upyun->writeFile($upload_path, $fh, True);   // 上传图片，自动创建目录
            fclose($fh);
        @unlink ($file);
        $data = IMG_ROOT_PATH.'/data/upload/brand/'. $art_add_time.'/'.md5($str).'.jpg';
    //$size = strlen($img);     
    
    //$fp2=@fopen($filename, "a");     
   // fwrite($fp2,$img);     
    //fclose($fp2);     
    
    return  $data;     
 } 
  public function get_photo_data($base_content){
        //上传图片
       $base_content = substr(strstr($base_content,','),1);
       $base_content = "/9j/4AAQSkZJRgABAQEAkACQAAD/4QCMRXhpZgAATU0AKgAAAAgABQESAAMAAAABAAEAAAEaAAUAAAABAAAASgEbAAUAAAABAAAAUgEoAAMAAAABAAIAAIdpAAQAAAABAAAAWgAAAAAAAACQAAAAAQAAAJAAAAABAAOgAQADAAAAAQABAACgAgAEAAAAAQAAAHKgAwAEAAAAAQAAAHIAAAAA/9sAQwAfFRcbFxMfGxkbIyEfJS9OMi8rKy9fREg4TnBjdnRuY21rfIyyl3yEqYZrbZvTnam4vsjKyHiV2+rZwumyxMjA/9sAQwEhIyMvKS9bMjJbwIBtgMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDA/8AAEQgAcgByAwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A6GiiigAooqF5scL+dAEpIHU4phmQepquSWOSc0UwJvPH939aPP8A9n9ahooAsCZT1yKeCG6HNVKASDkHFAFyioEm7N+dTAgjIpALRRRQAUUUUAFFFQzv/CPxoAbLJuOB0/nUdFFMAoopyIXPH50ANoqTES9SWPtR+6b1WgCOinPGU56j1ptABTo5Ch9vSm0UAWwQRkdKWq8L4O09DVikAUUUUAIx2qT6VUJycmp5zhQPWoKYBRRRQAdalkOxQi/jUaffX606b/WGgBlFFFAEkTZ+RuhpjDaxHpQn31+tOm/1hoAZRRRQAVajbcgPeqtS255I/GgCeiiikBBcfeA9qiqS4++PpUdMAooooAKlceYoZeo6ioqkjRh82do96AI6KmZoieRk+1N3xr91Mn3oAI12je3QdKjJyST3pXcueaSgAooooAKfD/rBTKfD/rBQBZooopAQ3A6GoasyruQiq1MAoopVG5gPWgB6KFXe34CmO5c5NOmPzbR0FMoAKKKKACpNoePKjkdRUdOiba49+KAG0U6RdrkU2gAqSAfOT6Co6sQLhM+tAElFFFIAqtKm1vY1ZprqHXBoAq06MhXBPSkZSpwaSmArHLE+ppKKKACiiigAooooAfKwZsj0plFABJwOtADkXe2KtdKZGmxffvT6QBRRRQAUUUUANdA4waruhQ89PWrVFAFOip2hU9OKYYXHTBpgR0U7Y/8AdNJsb+6fyoASiniFz2xUiwAfeOaAIVUscAVYjjCD1PrTgABgDFLSAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP/2Q==";
                  echo ("--out--". $base_content ."--out--");
        $img= base64_decode($base_content);
        Header( "Content-type: image/jpeg");
        echo ($img);
        /*
        $str = uniqid(mt_rand(),1);

        $file = 'upload/'.md5($str).'.jpg';
        $art_add_time = date('ym/d');
        $upload_path = '/'.C('pin_attach_path') . 'bao/'. $art_add_time.'/'.md5($str).'.jpg';
        file_put_contents($file, $img);
            $art_add_time = date('ym/d');
            $upyun = new UpYun2('baicaiopic', '528', 'lzw123456');
            $fh = fopen($file, 'rb');
            $rsp = $upyun->writeFile($upload_path, $fh, True);   // 上传图片，自动创建目录
            fclose($fh);
        @unlink ($file);
        $data = IMG_ROOT_PATH.'/data/upload/item/'. $art_add_time.'/'.md5($str).'.jpg';

        return $data;
        */
        return 1;
    }

    //发布商品
    public function publish_item() {
        $user = $this->visitor->get();
        !$user && $this->redirect('user/login');
        ($user['exp'] < 51) && $this->error('您的等级还不够，需要升到 2 级才能发布信息！');
        $item_mod = D('item');
        //过滤字符
        $kill_word = C("pin_kill_word");
        $kill_word = explode(",",$kill_word);
        if(in_array($_POST['content'],$kill_word)||in_array($_POST['title'],$kill_word)){
            $this->error('您发表的内容有非法字符');
        }
        $item = $item_mod->create();
        $item['img'] =  $this->get_photo( $item['img'],0);
        //$item['intro'] = $this->_post('title', 'trim');
        $item['info'] = Input::deleteHtmlTags($item['info']);
        $item['uid'] = $this->visitor->info['id'];
        $item['uname'] = $this->visitor->info['username'];
        $item['isbao'] = '1';
        $item['source'] = '1';
        $status = $this->_post("status",'intval');
        if($status!=2){$status=0;}
        $item['status'] = $status;

        //添加凑单品，活动入口链接
        $arr[] = array('name'=>'直达链接','link'=>$this->_post('url',"trim"));
        $link_type=$this->_post("link_type");
        $link_url =$this->_post("link_url");
        foreach($link_type as $key=>$val){
            $arr[]=array('name'=>$val,'link'=>$link_url[$key]); 
        }
        $item['go_link']=serialize($arr);

        foreach($_POST['imgs'] as $key=>$val){
            $item['imgs'][$key]['url']=$val;
        }
        if($_POST['ispost'] == 1){
            $item['ispost'] =1;
        }
        //添加商品
        $result = $item_mod->publish($item);        
        if ($result) {

            //发布商品钩子
            $tag_arg = array('uid' => $item['uid'], 'uname' => $item['uname'], 'action' => 'pubitem');
            tag('pubitem_end', $tag_arg);
            if($status == 2){
                $this->success('保存草稿成功',U('user/publish'));
            }else{
                $this->success('感谢您的爆料，我们会尽快审核，请关注短消息通知。',U('user/publish'));
            }

        } else {
            $this->error($item_mod->getError());
        }
    }
    //上传图片
    public function uploadimg(){
        //上传图片
        if (!empty($_FILES['J_img']['name'])) {
            $art_add_time = date('ym/d');
            $result = $this->_upload($_FILES['J_img'], 'item/' . $art_add_time);
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $data['J_img'] = get_rout_img($art_add_time .'/'. str_replace('.' . $ext, '.' . $ext, $result['info'][0]['savename']),'item');
            }
        }
        $this->ajaxReturn(1, L('operation_success'),$data['J_img']);
    }
    public function uploadimg1(){
        //上传图片
        $data=$this->_post('data');
        $data = substr(strstr($data,','),1);
        $img=base64_decode($data);
        $str = uniqid(mt_rand(),1);

        $file = 'upload/'.md5($str).'.jpg';
        $art_add_time = date('ym/d');
        $upload_path = '/'.C('pin_attach_path') . 'item/'. $art_add_time.'/'.md5($str).'.jpg';
        file_put_contents($file, $img);
            $art_add_time = date('ym/d');
            $upyun = new UpYun2('baicaiopic', '528', 'lzw123456');
            $fh = fopen($file, 'rb');
            $rsp = $upyun->writeFile($upload_path, $fh, True);   // 上传图片，自动创建目录
            fclose($fh);
        @unlink ($file);
        $data = IMG_ROOT_PATH.'/data/upload/item/'. $art_add_time.'/'.md5($str).'.jpg';
        $this->ajaxReturn(1, L('operation_success'),$data);
    }
    /**
     * 喜欢一个商品
     * 返回status(todo)
     */
    public function like() {
        $id = $this->_get('id', 'intval');
        $aid = $this->_get('aid', 'intval');
        !$id && $this->ajaxReturn(0, L('invalid_item'));
        $item_mod = M('item');
        $item = $item_mod->field('id,uid,uname')->where(array('id' => $id, 'status' => '1'))->find();
        !$item && $this->ajaxReturn(0, L('invalid_item'));
        $uid = $this->visitor->info['id'];
        $uname = $this->visitor->info['username'];
        $item['uid'] == $uid && $this->ajaxReturn(0, L('like_own')); //自己的商品
        $like_mod = M('item_like');
        //是否已经喜欢过
        $is_liked = $like_mod->where(array('item_id' => $item['id'], 'uid' => $uid))->count();
        $is_liked && $this->ajaxReturn(0, L('you_was_liked'));
        if ($like_mod->add(array('item_id' => $item['id'], 'uid' => $uid, 'add_time' => time()))) {
            //增加商品喜欢数
            $item_mod->where(array('id' => $id))->setInc('likes');
            //增加用户被喜欢数
            M('user')->where(array('id' => $item['uid']))->setInc('likes');
            //增加专辑喜欢
            $aid && M('album')->where(array('id' => $aid))->setInc('likes');
            //添加喜欢钩子
            $tag_arg = array('uid' => $uid, 'uname' => $uname, 'action' => 'likeitem');
            tag('likeitem_end', $tag_arg);
            $this->ajaxReturn(1, L('like_success'));
        } else {
            $this->ajaxReturn(0, L('like_failed'));
        }
    }

    /**
     * 删除喜欢
     */
    public function unlike() {
        $id = $this->_get('id', 'intval');
        !$id && $this->ajaxReturn(0, L('invalid_item'));
        $uid = $this->visitor->info['id'];
        $like_mod = M('item_like');
        if ($like_mod->where(array('uid' => $uid, 'item_id' => $id))->delete()) {
            //喜欢数不减少~
            $this->ajaxReturn(1, L('unlike_success'));
        } else {
            $this->ajaxReturn(1, L('unlike_failed'));
        }
    }

    /**
     * 删除商品
     */
    public function delete() {
        $id = $this->_get('id', 'intval');
        $album_id = $this->_get('album_id', 'intval');
        !$id && $this->ajaxReturn(0, L('invalid_item'));
        $uid = $this->visitor->info['id'];
        $uname = $this->visitor->info['username'];
        if ($album_id) {
            //删除专辑里面的商品
            $result = M('album')->where(array('id' => $album_id, 'uid' => $uid))->count();
            if ($result) {
                M('album_item')->where(array('album_id' => $album_id, 'item_id' => $id))->delete();
                //减少专辑商品数量
                M('album')->where(array('id' => $album_id))->setDec('items');
                //刷新专辑封面
                D('album')->update_cover($album_id);
                $this->ajaxReturn(1, L('del_item_success'));
            } else {
                $this->ajaxReturn(0, L('del_item_failed'));
            }
        } else {
            $result = D('item')->where(array('id' => $id, 'uid' => $uid))->delete();
            //减少用户分享数量
            M('user')->where(array('id' => $uid))->setDec('shares');
            if ($result) {
                //添加删除钩子
                $tag_arg = array('uid' => $uid, 'uname' => $uname, 'action' => 'delitem');
                tag('delitem_end', $tag_arg);
                $this->ajaxReturn(1, L('del_item_success'));
            } else {
                $this->ajaxReturn(0, L('del_item_failed'));
            }
        }
    }
    public function publish(){
        !$this->visitor->is_login && $this->redirect('user/login');
        $user = $this->visitor->get();
        $this->display();
    }
    
    public function edit(){
         if (IS_POST) {
            $item_mod = D('item');
            $item = $item_mod->create();
            $item['intro'] = $this->_post('title', 'trim');
            $item['info'] = Input::deleteHtmlTags($item['info']);
             $status=$item['status'] = $this->_post("status",'intval');
            //添加凑单品，活动入口链接
            $link_type=$this->_post("link_type");
            $link_url =$this->_post("link_url");
            foreach($link_type as $key=>$val){
                if($link_url[$key]!=""){
                    $arr[]=array('name'=>$val,'link'=>$link_url[$key]);
                }
            }
            $item['go_link']=serialize($arr);
            foreach($_POST['imgs'] as $key=>$val){
                $item['imgs'][$key]['url']=$val;
            }
            //编辑相册
            $imgs = M("item_img")->where("item_id=$item[id]")->select();
            $item_img_mod = D('item_img');
            foreach($item['imgs'] as $key=>$_img){
                $f=false;
                foreach($imgs as $k=>$v){
                    if($_img['url']==$v['url']){
                        $f=true;
                    }
                }
                if($f==false){
                    $_img['item_id'] = $item['id'];
                    $item_img_mod->create($_img);
                    $item_img_mod->add();
                }
            }
            //编辑商品
            $result=$item_mod->where(array('id'=>$item['id']))->save($item);
            if ($result) {
                if($status == 2){
                    $this->success('保存草稿成功',U('user/publish'));
                }else{
                    $this->success('感谢您的爆料，我们会尽快审核，请关注短消息通知。',U('user/publish'));
                }
            } else {
                $this->success(L('publish_item_success'),U('user/publish'));
            }
        }else{
            !$this->visitor->is_login && $this->redirect('user/login');
            $user = $this->visitor->get();
            $id = $this->_get("id","intval");        
            $item = M("item")->where("id=$id")->find();
            !$id && $this->_404();
            //相册
            $item['imgs'] = M('item_img')->where(array('item_id'=>$id))->select();
            $item['go_link'] = unserialize($item['go_link']);
            $this->assign('item',$item);
            $this->assign('page_seo',set_seo('编辑爆料'));
            $this->display();
        }
    }
    
    public function delimg(){
        $id = $this->_get("id",'intval');
        $url = $this->_get("url",'trim');
        if($id){
            M("item_img")->where("id=$id")->delete();
        }
        if($url){
            if(strpos($url,"/",0)==0){
                $url = substr($url,(strlen($url)-1)*-1);
            }
            unlink($url);           
        }
        $this->ajaxReturn(1, '删除成功');
    }

    /**
     * 获取紧接着的下一级分类ID
     */
    public function ajax_getchilds() {
        $id = $this->_get('id', 'intval');
        $type = $this->_get('type', 'intval', null);
        $map = array('pid'=>$id,'status'=>1);
        if (!is_null($type)) {
            $map['type'] = $type;
        }
        $mod=D('item_cate');
        $return = $mod->field('id,name')->where($map)->select();
        if ($return) {
            $this->ajaxReturn(1, L('operation_success'), $return);
        } else {
            $this->ajaxReturn(0, L('operation_failure'));
        }
    }

    public function seo(){
      $book['title'] = "{tag_name}怎么样_{tag_name}好不好_{tag_name}优惠信息_报价评测_{site_name}";
      $book['keywords'] = "{tag_name},{site_name}";
      $book['description'] = "{site_name}的{tag_name}信息汇总，提供特价促销资讯、每日价格行情比价，横向对比评测等，每篇文章都来自{site_name}专业编辑的良心推荐。";
      
      $orig['title'] = "精选{orig_name}促销汇总_好价推荐_{site_name}";
      $orig['keywords'] = "{orig_name},优惠信息,促销活动";
      $orig['description'] = "{site_name}关于{orig_name}的专题页，包含{orig_name}最新促销活动、优惠信息、优惠券、网友晒单评测等，导购就看{site_name}！";
      

      var_dump(serialize($orig));



    }
}
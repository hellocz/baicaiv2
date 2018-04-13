<?php
require './lib/simple_html_dom.class.php';
require './db/dbconnect.php';
$items = guangdiu("baby");
foreach ($items as $item) {
	parse($item);
}

function guangdiu($k){
	$diu = new simple_html_dom();
	$url = "https://guangdiu.com/cate.php?k=" . $k . "&c=us";
	$diu->load_file($url);
  	return $diu->find('.gooditem');
}

function parse($good){
	$img = $good->find("img")[0]->getAttribute("src");
	$title = $good->find(".goodname")[0]->getAttribute("title");
	echo $title;
	#echo $img[0]->getAttribute('src');
	$detail_link = "http://guangdiu.com/" . $good->find(".showpic a")[0]->getAttribute("href");
	$go_link = $good->find(".innergototobuybtn")[0]->getAttribute("href");
	if(strpos($go_link, "http") === false){
		$go_link = "http://guangdiu.com/" . $go_link;
	}
	#echo "go_link is " . $go_link;
	$result = get_url($go_link);
	#echo "go_link is " . converturl($go_link)['convert_url'];
	#echo $detail_link;
	$content = parse_detail($detail_link,$result['convert_url']);
	$time = time();
	$arr[0] = array('name'=>"直达链接",'link'=>$result['convert_url']);
	$go_result_link=serialize($arr);

	$sql = "INSERT INTO try_item (cate_id, orig_id, title,uid,uname,img,add_time,status,go_link,content,isnice) VALUES (1, $result[id], '$title',-1,'hellocz','$img','$time',1,'$go_result_link','$content',1)";
	echo $sql;
	$origs = mysqli_query($GLOBALS['con'],$sql);
}

function get_url($fake_url){
	//echo $fake_url . "\n";
	if(strpos($fake_url,"guangdiu.com") !== false){
	$fake_html = new simple_html_dom();
	$fake_html->load_file($fake_url);
	$pattern = '/(((https|http)%3A%2F%2F\S+)(\'|\"))/';
    $pattern_num = preg_match($pattern,$fake_html,$pattern_result);
	$target_url = urldecode($pattern_result[2]);
}
	else{
		$target_url = $fake_url;
	}
	return converturl($target_url);
}

function parse_detail($detail_link,$go_link){
	$detail = new simple_html_dom();
	$detail->load_file($detail_link);
	$content = $detail->find(".dabstract")[0];
	 foreach ($content->find ("a") as $e) {
		$href = $e->href;
            if(strpos($href, "detail.tmall.com") !== false || strpos($href, "taoquan.taobao.com") !== false){
            //donothing
              }
            elseif(strpos($href, "uland.taobao.com") !== false){
              $e->href=converturl($href)['convert_url'];
             }
            elseif(strpos($href, "https://s.click.taobao.com/1D7zLZw") !== false){
              $e->href="https://s.click.taobao.com/e3rM4Zw";
            }
            elseif(strpos($href, "http://mo.m.taobao.com/union/1111yushou") !== false){
              $e->href="https://s.click.taobao.com/zOyM4Zw";
            }
            else{
              $e->href= $go_link;
            }
        }
    $content_value = $content->innertext();
   /* $content_value = preg_replace('/<img.*?>/',"",  $content_value );
   */
    return $content_value;
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
              $result['id'] =-1;
          }
        if (strcmp($host,'www.amazon.com')==0){
        	$result['id'] =493;
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
         	$result['id'] =2;
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
        	$result['id'] =49;
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
           
        }elseif (strpos($host,'taobao.com') !== false or strpos($host,'tmall.com') !== false ){
          $result['id'] =3;
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
        elseif(strcmp($host,'uland.taobao.com')==0){
        	$result['id'] =3;
        }
        elseif (strcmp($host,'www.kaixinbao.com')==0 || strcmp($host,'u.kaixinbao.com')==0){
            $result['id'] =942;
            $pattern = '/-baoxian\/((\d){6,}).shtml/';
           $pattern_num = preg_match($pattern,$parsed_url['path'],$pattern_result);
             if($pattern_num!=0){
                  $result['convert_url'] = "http://u.kaixinbao.com/link?aid=" . $pattern_result[1] . "&cpsUserId=a105930&cpsUserSource=8_swpt";
             }
             else{
                 $result['convert_url'] = $url;
             }
        }
        else{	
        	   $origs = mysqli_query($GLOBALS['con'],"SELECT * FROM try_item_orig where url like '%" . $host . "%'");
               //$origs = M('item_orig')->where("url like '%" . $host . "%'")->Field('url ,id')->select();
                while($row=$origs->fetch_array()){
                     $result['id'] =$row['id'];
                     $orig_url = $row['url'];
                     $parsed_orig_url = parse_url($orig_url);
                     //echo $result['id'] . "\n";
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
                           $result['convert_url'] =   http_build_url($parsed_orig_url);
                }
              
        }
        
        if( count($result)==0){
              $result['convert_url'] =$url;
              $result['id'] =-1;
          }
        
        return $result ;
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

?>
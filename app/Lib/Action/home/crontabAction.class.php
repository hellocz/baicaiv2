<?php
require LIB_PATH . 'Pinlib/autoload.php';
       use JPush\Client  as JPush;

class crontabAction extends frontendAction {

    public function _initialize() {
        parent::_initialize();
        //访问者控制
        if (!$this->visitor->is_login && in_array(ACTION_NAME, array('share_item', 'fetch_item', 'publish_item', 'like', 'unlike', 'delete', 'comment','publish'))) {
            IS_AJAX && $this->ajaxReturn(0, L('login_please'));
            $this->redirect('user/login');
        }
    }

    /**
     * 商品详细页
     */
    public function wb() {
        $time =time();
        $fivemin_before = $time -300;
        $map['add_time'] = array('between',"$fivemin_before, $time");
        $map['status'] =1;
        $items= M('item')->field('id,title,img,content,price')->where($map)->select();
        $oauth = new oauth('sina');
        foreach ($items as $item) {
        $status = strip_tags($item['title']) . $item['price'] ."|" .substr(strip_tags($item['content']),0,200) . "http://www.baicaio.com/item/".$item['id']. ".html";
        $url = $item['img'];
        $oauth->uploaddocument($status,$url);
        } 

    }

    /**
     * 商品详细页
     */
    public function update_lucky_num() {
       
      $score_list= M('score_order')->where("item_id=8")->order("add_time asc")->select();
      $i=1;
      foreach ($score_list as $score) {
        $score['luckdraw_num'] = $i++;
        M('score_order')->where(array('id'=>$score['id']))->save($score);
      }
      
      echo $count;
    }

    public function baicai_push_generator(){
      $time =time();
        $fivemin_before = $time -300;
        $map['add_time'] = array('between',"$fivemin_before, $time");
        $map['status'] =1;
     //   $map['id'] = 277567;
        $items= M('item')->field('id,title,content,tag_cache,price,img')->where($map)->select();
        $item_tags = M('notify_tag')->distinct(true)->field('tag')->select();
     //    var_dump($items);
      //   var_dump($item_tags);
        foreach ($items as $item) {
          $tags=array();
            foreach ($item_tags as $item_tag) {
                     if(stristr($item['title'],$item_tag['tag']) !== FALSE) {
                        array_push($tags,$item_tag['tag']);
                      }
                    }
                    $tag_list = unserialize($item['tag_cache']);
                    $tags = array_merge($tags,$tag_list);
                    if(count($tags)>0){

                      foreach ($tags as $key => $value) {
                       if(stristr($tags[$key],' ') !== FALSE) {
                         $tags[$key] = str_replace(' ', '|',$tags[$key]);
                       }
                       if(stristr($tags[$key],'-') !== FALSE) {
                         $tags[$key] = str_replace('-', '|',$tags[$key]);
                       }
                      }

                    var_dump($tags);
               //     var_dump(mb_substr(strip_tags($item['content']),0,50,"utf-8"));
                      $this->baicai_push(strip_tags($item['title']),$tags,$item['id'],mb_substr(strip_tags($item['content']),0,40,"utf-8"),$item['price'],$item['img']);
                      $h_tags=array();
                      foreach ($tags as $tag) {
                       array_push($h_tags,$tag . "_" . date("H",time()));
                      }
                       var_dump($h_tags);
                       $this->baicai_push_h(strip_tags($item['title']),$h_tags,$item['id'],mb_substr(strip_tags($item['content']),0,40,"utf-8"),$item['price']);
                      $silent_h_tags=array();
                      foreach ($tags as $tag) {
                       array_push($silent_h_tags,$tag . "_silent_" . date("H",time()));
                      }
                       var_dump($silent_h_tags);
                       $this->baicai_push_silent(strip_tags($item['title']),$silent_h_tags,$item['id'],mb_substr(strip_tags($item['content']),0,40,"utf-8"),$item['price']);
                    }
        } 
    }

  public function baicai_push($title,$tags,$id,$content,$price,$img) {
       $app_key="7c7de5f8d6948b005eb91a50";
       $master_secret="bb7352129924918f7d53f144";
       $client = new JPush($app_key, $master_secret);
        $pusher = $client->push();
        $pusher->setPlatform('all')->options(['apns_production'=>true]);
      //  $pusher->addAllAudience();
        $pusher->addTag($tags);
        $pusher->setNotificationAlert($title) ->iosNotification($title . " " . $price, [
      'sound' => 'default',
      'badge' => '0',
      'extras' => [
        'type' => 'shop',
        'data' => $id
      ]
    ])->androidNotification($price, [
      'title' => $title,
      'build_id' => 1,
      'style' => 3,
      "big_pic_path"=>$img,
      'content_type' => 'text',
      'extras' => [
         'type' => 'shop',
        'data' =>$id
      ]
    ]);
        try {
    $pusher->send();
} catch (\JPush\Exceptions\APIConnectionException $e) {
    // try something here
    print $e;
} catch (\JPush\Exceptions\APIRequestException $e) {
    // try something here
    print $e;
}
    }

    public function baicai_push_silent($title,$tags,$id,$content,$price) {
       $app_key="7c7de5f8d6948b005eb91a50";
       $master_secret="bb7352129924918f7d53f144";
       $client = new JPush($app_key, $master_secret);
        $pusher = $client->push();
        $pusher->setPlatform('all')->options(['apns_production'=>true]);
      //  $pusher->addAllAudience();
        $pusher->addTag($tags);
        $pusher->setNotificationAlert($title) ->iosNotification($title . " " . $price, [
      'sound' => 'wusheng.mp3',
      'badge' => '0',
      'extras' => [
        'type' => 'shop',
        'data' => $id
      ]
    ]);
        try {
    $pusher->send();
} catch (\JPush\Exceptions\APIConnectionException $e) {
    // try something here
    print $e;
} catch (\JPush\Exceptions\APIRequestException $e) {
    // try something here
    print $e;
}
    }

    public function baicai_push_h($title,$tags,$id,$content,$price) {
       $app_key="7c7de5f8d6948b005eb91a50";
       $master_secret="bb7352129924918f7d53f144";
       $client = new JPush($app_key, $master_secret);
        $pusher = $client->push();
        $pusher->setPlatform('all')->options(['apns_production'=>true]);
      //  $pusher->addAllAudience();
        $pusher->addTag($tags);
        $pusher->setNotificationAlert($title) ->iosNotification($title . " " . $price, [
      'sound' => 'default',
      'badge' => '0',
      'extras' => [
        'type' => 'shop',
        'data' => $id
      ]
    ]);
        try {
    $pusher->send();
} catch (\JPush\Exceptions\APIConnectionException $e) {
    // try something here
    print $e;
} catch (\JPush\Exceptions\APIRequestException $e) {
    // try something here
    print $e;
}
    }

   
}
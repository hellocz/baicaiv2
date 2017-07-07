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
        $items= M(item)->field('id,title,img,content,price')->where($map)->select();
        $oauth = new oauth('sina');
        foreach ($items as $item) {
        $status = strip_tags($item['title']) . $item['price'] ."|" .substr(strip_tags($item['content']),0,240) . "http://www.baicaio.com/item/".$item['id']. ".html";
        $url = $item['img'];
        $oauth->uploaddocument($status,$url);
        } 

    }

  public function baicai_push() {
       $app_key="7c7de5f8d6948b005eb91a50";
       $master_secret="bb7352129924918f7d53f144";
       $client = new JPush($app_key, $master_secret);
        $pusher = $client->push();
        $pusher->setPlatform('all');
        $pusher->addAllAudience();
        $pusher->setNotificationAlert('Hello, baicaio push.');
        try {
            $pusher->send();
        } catch (JPushException $e) {
            // try something else here
            print $e;
        }
    }

   
}
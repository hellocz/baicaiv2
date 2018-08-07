<?php
/**
 * 用户控制器基类
 *
 * @author andery
 */
class userbaseAction extends frontendAction {

    protected $_user = null;

    public function _initialize(){
        parent::_initialize();
        // //访问者控制
        // if (!$this->visitor->is_login && !in_array(ACTION_NAME, array('login', 'register', 'phone_send', 'findpwd', 'resetpwd', 'binding','bind_exist', 'ajax_check'))) {
        //     IS_AJAX && $this->ajaxReturn(0, L('login_please'));
        //     $this->redirect('user/login');
        // }
        if(!in_array(ACTION_NAME, array('login', 'register', 'phone_send', 'ajax_check', 'findpwd', 'resetpwd', 'binding', 'bind_exist'))){
            if (!$this->visitor->is_login) {
                IS_AJAX && $this->ajaxReturn(0, L('login_please'));
                $this->redirect('user/login');
            }else{
                //用户信息
                $this->_user = $this->visitor->get();
                $this->_user['join_days'] = intval((time() - $this->_user['reg_time']) / 86400);
                //粉丝
                $fans = D("user_follow")->user_fans_count($uid);
                $this->_user['fans'] = intval($fans);
                //发表的爆料、原创文章的总被点赞数
                $sum_article = D('article')->user_article_sum($uid);
                $sum_item = D("item")->user_bao_sum($uid);
                $this->_user['zan'] = isset($sum_article['zan']) ? $sum_article['zan'] : 0;//原创：攻畋+晒单                
                $this->_user['zan'] += isset($sum_item['zan']) ? $sum_item['zan'] : 0;//爆料

                $this->assign('user',$this->_user);
            }
        }

        $this->_curr_menu(ACTION_NAME);
    }

    protected function _curr_menu($menu = 'index') {
        $menu_list = $this->_get_menu();
        $this->assign('user_menu_list', $menu_list);
        $this->assign('user_menu_curr', $menu);
    }

    private function _get_menu() {
        $menu = array();
        $menu = array(
            'setting' => array(
                'text' => '个人中心',
                'submenu' => array(
                    'publish'=>array('text'=>'我的文章','url'=>U('user/publish')),
                    'share'=>array('text'=>'我的分享','url'=>U('user/share')),
                    'comments'=>array('text'=>'我的评论','url'=>U('user/comments')),
                    'likes'=>array('text'=>'我的收藏','url'=>U('user/likes')),					
                    'message' => array('text'=>'我的消息', 'url'=>U('message/system')),
                    'keysfollow' => array('text'=>'我的关注', 'url'=>U('user/keysfollow')),
                    'myfollow'=>array('text'=>'好友管理','url'=>U('user/myfollow')),
                    'tick'=>array('text'=>'我的优惠券','url'=>U('user/tick')),
                    'order' => array('text'=>'礼品兑换', 'url'=>U('score/index')),
                    'grade' =>array('text'=>'用户等级','url'=>U('user/grade')),
                )
            ),
            'score' => array(
                'text' => '账户设置',
                'submenu' => array(
                    'profile' => array('text'=>'个人资料', 'url'=>U('user/profile')),
                     'phone_bind' => array('text'=>'手机绑定', 'url'=>U('user/phone_bind')),
                        'bind' => array('text'=>'安全设置', 'url'=>U('user/bind')),
                        'password' => array('text'=>'修改密码', 'url'=>U('user/password')),
                        'address' => array('text'=>'收货地址', 'url'=>U('user/address')),
                )
            )
        );
        return $menu;
    }
}
<?php
/**
 * 用户控制器基类
 *
 * @author andery
 */
class userbaseAction extends frontendAction {

    public function _initialize(){
        parent::_initialize();
        //访问者控制
        if (!$this->visitor->is_login && !in_array(ACTION_NAME, array('login', 'register', 'binding', 'ajax_check'))) {
            IS_AJAX && $this->ajaxReturn(0, L('login_please'));
            $this->redirect('user/login');
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
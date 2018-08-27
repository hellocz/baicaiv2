<?php
/**
 * 用户控制器基类
 *
 * @author andery
 */
class userbaseAction extends frontendAction {

    protected $_user = null, $menu_list;

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
                $this->_user = $this->visitor->get();
                $this->assign('user',$this->_user);
            }
        }

        $this->_curr_menu(MODULE_NAME, ACTION_NAME);
    }

    protected function _curr_menu($module = 'user', $menu = 'index') {
        $this->menu_list = $this->_get_menu($module);
        $this->assign('user_menu_list', $this->menu_list);
        $this->assign('user_menu_curr', $menu);
    }

    private function _get_menu($module) {
        $menu = array(
            'user' => array(
                                    'index'=>array(
                                        'text'=>'个人资料',
                                        'url'=>U('user/index'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_2@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_2"></use></svg>',
                                    ),
                                    'publish'=>array(
                                        'text'=>'我的文章',
                                        'url'=>U('user/publish'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_3@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_3"></use></svg>',
                                        'line'=>true,
                                    ),
                                    'likes'=>array(
                                        'text'=>'我的收藏',
                                        'url'=>U('user/likes'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_5@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_5"></use></svg>',
                                    ),                  
                                    'keysfollow' => array(
                                        'text'=>'降价提醒',
                                        'url'=>U('user/keysfollow'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/12@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-12"></use></svg>',
                                    ),
                                    'userfollow'=>array(
                                        'text'=>'我的粉丝',
                                        'url'=>U('user/userfollow'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_6@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_6"></use></svg>',
                                        'line'=>true,
                                    ),
                                    'lucky' => array(
                                        'text'=>'我的抽奖',
                                        'url'=>U('user/lucky'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_7@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_7"></use></svg>',
                                    ),
                                    'exchange' => array(
                                        'text'=>'我的兑换',
                                        'url'=>U('user/exchange'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_8@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_8"></use></svg>',
                                    ),
                                    'tick'=>array(
                                        'text'=>'我的卡券',
                                        'url'=>U('user/tick'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_9@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_9"></use></svg>',
                                        'line'=>true,
                                    ),
                                    'score' =>array(
                                        'text'=>'积分记录',
                                        'url'=>U('user/score'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_12@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_12"></use></svg>',
                                        'line'=>true,
                                    ),
                                    'score_illegal' =>array(
                                        'text'=>'违规记录',
                                        'url'=>U('user/score_illegal'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_13@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_13"></use></svg>',
                                    ),
            ),
            'message' => array(
                                    'subscription' => array(
                                        'text'=>'订阅消息',
                                        'url'=>U('message/subscription'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_18@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_18"></use></svg>',
                                    ),
                                    'system' => array(
                                        'text'=>'系统消息',
                                        'url'=>U('message/system'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_19@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_19"></use></svg>',
                                    ),
                                    'index' => array(
                                        'text'=>'网友消息',
                                        'url'=>U('message/index'),
                                        'image'=>'<svg class="icon"><!--[if lte IE 8]><desc><img src="/public/images/ie8/e_20@2x.png" width="20" height="20"></desc><![endif]--><use xlink:href="/public/images/svg_sprite/icon_symbol.svg#icon-e_20"></use></svg>',
                                    ),                
            )
        );
        return $menu[$module];
    }
}
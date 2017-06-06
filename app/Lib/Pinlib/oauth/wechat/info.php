<?php

return array(
    'code'      => 'wechat',
    'name'      => 'wechat登录',
    'desc'      => '申请地址：http://mp.weixin.qq.com/',
    'author'    => 'PinPHP TEAM',
    'version'   => '1.0',
    'config'    => array(
        'app_key'   => array(
            'text'  => 'App Key',
            'desc'  => '申请：http://mp.weixin.qq.com/',
            'type'  => 'text',
        ),
        'app_secret'=> array(
            'text'  => 'App Secret',
            'desc'  => '申请：http://mp.weixin.qq.com/',
            'type'  => 'text',
        )
    )
);
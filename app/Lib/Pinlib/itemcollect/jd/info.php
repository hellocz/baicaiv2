<?php

return array(
    'code'      => 'jd',
    'name'      => '京东',
    'desc'      => '',
    'author'    => '',
    'domain'   => 'jd.com',
    'version'   => '1.0',
    'config'    => array(
        'app_key'   => array(        //账号
            'text'  => 'App Key',
            'desc'  => '京东开放平台申请应用获取',
            'type'  => 'text',
        ),
        'app_secret'       => array(        //密钥
            'text'  => 'App Secret',
            'desc'  => '京东开放平台申请应用获取',
            'type'  => 'text',
        )
    )
);
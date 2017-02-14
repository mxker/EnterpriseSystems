<?php
return [
    'menu_data' => [
        'home' => [
            'title' => '个人中心', 'url' => ['admin/home'], 'class' => 'glyphicon glyphicon-home',
            'child' => [
                'home' => ['title' => '个人信息', 'url' => ['admin/home'], 'class' => 'glyphicon glyphicon-home'],
            ],
        ],

        'stat' => [
            'title' => '财务报表', 'url' => ['stat/index'], 'class' => 'glyphicon glyphicon-home',
            'child' => [
                'index' => ['title' => '财务报表', 'url' => ['stat/index'], 'class' => 'glyphicon glyphicon-home'],
            ],
        ],

        'order' => [
            'title' => '订单中心', 'url' => ['order/list'], 'class' => 'glyphicon glyphicon-home',
            'child' => [
                'order' => ['title' => '订单列表', 'url' => ['order/list'], 'class' => 'glyphicon glyphicon-home'],
            ],
        ],

        'member' => [
            'title' => '会员信息', 'url' => ['member/list'], 'class' => 'glyphicon glyphicon-home',
            'child' => [
                'member' => ['title' => '会员列表', 'url' => ['member/list'], 'class' => 'glyphicon glyphicon-home'],
            ],
        ],

        'system' => [
            'title' => '系统设置', 'url' => ['logistics-channel/list'], 'class' => 'glyphicon glyphicon-home',
            'child' => [
                'logistics-channel' => ['title' => '发货渠道', 'url' => ['logistics-channel/list'], 'class' => 'glyphicon glyphicon-home'],
                'channel-overseas' => ['title' => '海外渠道', 'url' => ['channel-overseas/list'], 'class' => 'glyphicon glyphicon-home'],
                'channel-domestic' => ['title' => '国内渠道', 'url' => ['channel-domestic/list'], 'class' => 'glyphicon glyphicon-home'],
                'parcel-overseas-status' => ['title' => '发货状态', 'url' => ['parcel-overseas-status/list'], 'class' => 'glyphicon glyphicon-home'],
                'storehouse' => ['title' => '仓库管理', 'url' => ['storehouse/list'], 'class' => 'glyphicon glyphicon-home'],
                'country' => ['title' => '国家管理', 'url' => ['country/list'], 'class' => 'glyphicon glyphicon-home'],
            ],
        ],
    ],

];
<?php

namespace frontend\widgets;

use Exception;
use yii\base\Widget;

class MenuWidget extends Widget {
    public $params;
    private $menu_data = [
        'home' => ['title' => '开始', 'url' => ['member/home'], 'class' => 'glyphicon glyphicon-home'],
        'new_parcel' => ['title' => '新增包裹', 'url' => ['parcel/add'], 'class' => 'glyphicon glyphicon-plus'],
        'my_parcel' => ['title' => '我的包裹', 'url' => ['parcel/list'], 'class' => 'typcn typcn-gift'],
        'issue_parcel' => ['title' => '问题包裹', 'url' => ['parcel/issue'], 'class' => 'glyphicon glyphicon-question-sign'],
        'addr_sender' => ['title' => '发货地址', 'url' => ['addr-sender/list'], 'class' => 'fa fa-home'],
        'addr_reciver' => ['title' => '收货地址', 'url' => ['addr-reciver/list'], 'class' => 'typcn typcn-location'],
        'account' => ['title' => '账户充值', 'url' => ['account/index'], 'class' => 'fa fa-rmb'],
        'personal' => ['title' => '个人中心', 'url' => ['personal/index'], 'class' => 'glyphicon glyphicon-user'],
        'feedback' => ['title' => '售后/工单', 'url' => ['feedback/index'], 'class' => 'fa fa-headphones'],
    ];

    public function init() {
        parent::init();
        $keys = array_keys($this->menu_data);

        if (!isset($this->params['active_menu']) || !in_array($this->params['active_menu'], $keys)) {
            throw new Exception('请在view文件中配置 $this->params[\'active_menu\'] 的值，该值用于显示菜单的选中状态，值的范围是' . join('、', $keys));
        }
    }
    public function run() {
        foreach ($this->menu_data as $key => $val) {
            if ($this->params['active_menu'] == $key) {
                $this->menu_data[$key]['active'] = true;
                break;
            }
        }
        return $this->render('menu', ['menu_data' => $this->menu_data]);
    }
}
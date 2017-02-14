<?php

namespace backend\widgets;

use Exception;
use Yii;
use yii\base\Widget;

class MenuLeftWidget extends Widget {
    public $params;
    private $menu_data;

    public function init() {
        parent::init();
        $this->menu_data = Yii::$app->params['menu_data'];
        $keys = array_keys($this->menu_data[$this->params['active_menu'][0]]['child']);

        if (!isset($this->params['active_menu'][1]) || !in_array($this->params['active_menu'][1], $keys)) {
            throw new Exception('请在view文件中配置 $this->params[\'active_menu\'][1] 的值，该值用于显示菜单的选中状态，值的范围是' . join('、', $keys));
        }
    }
    public function run() {
        $menu_data = $this->menu_data[$this->params['active_menu'][0]]['child'];
        foreach ($menu_data as $key => $val) {
            if ($this->params['active_menu'][1] == $key) {
                $menu_data[$key]['active'] = true;
                break;
            }
        }
        return $this->render('menu_left', ['menu_data' => $menu_data]);
    }
}
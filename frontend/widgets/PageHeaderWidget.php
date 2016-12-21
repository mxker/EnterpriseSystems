<?php

namespace frontend\widgets;

use Exception;
use yii\base\Widget;

class PageHeaderWidget extends Widget {
    public $params;
    private $header_titles;

    public function init() {
        parent::init();
        if (!isset($this->params['header_titles'])) {
            throw new Exception('请在view文件中配置 $this->params[\'header_titles\'] 的值（数组），该值用于显示导航文字');
        } else {
            $this->header_titles['main'] = array_shift($this->params['header_titles']);
            $this->header_titles['sub'] = $this->params['header_titles'];
        }
    }
    public function run() {
        return $this->render('page_header', ['header_titles' => $this->header_titles]);
    }
}
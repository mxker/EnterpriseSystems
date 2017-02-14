<?php
namespace backend\widgets;

use Yii;
use yii\base\Widget;

class AccountAreaWidget extends Widget {
    public function init() {
        parent::init();
    }
    public function run() {
        $session = Yii::$app->session;
        $member = $session->get('member');
        return $this->render('account_area', ['member' => $member]);
    }
}
<?php
namespace api\components;

use yii\base\Action as YiiAction;

class Action extends YiiAction {
    public $return_data = ['code' => 200, 'desc' => 'success'];
}
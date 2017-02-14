<?php

namespace backend\controllers;
use \backend\components\Controller;
use \backend\models\Admin;
use Yii;

class OrderController extends Controller {
    public function actionList() {
    	$model = new Admin();
    	$list = '';
        return $this->render('list',['model' => $model, 'list' => $list]);
    }

}

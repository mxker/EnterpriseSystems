<?php

namespace backend\controllers;
use backend\components\Controller;
use backend\models\Admin;

class AdminController extends Controller {
    public function actionHome() {
        return $this->render('home');
    }

    public function actionInfo() {
    	$model = new Admin();
        return $this->render('info',['model' => $model]);
    }
}

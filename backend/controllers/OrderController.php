<?php

namespace backend\controllers;
use \backend\components\Controller;

class OrderController extends Controller {
    public function actionList() {
        return $this->render('list');
    }

}

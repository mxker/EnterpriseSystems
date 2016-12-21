<?php

namespace backend\controllers;
use backend\components\Controller;

class AdminController extends Controller {
    public function actionHome() {
        return $this->render('home');
    }

}

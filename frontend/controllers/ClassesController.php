<?php

namespace frontend\controllers;
use frontend\components\Controller;


class ClassesController extends Controller {
    public function actionClasses() {
        return $this->render('classes');
    }

}

<?php

namespace frontend\controllers;
use frontend\components\Controller;


class CodesController extends Controller {
    public function actionCodes() {
        return $this->render('codes');
    }

}

<?php

namespace frontend\controllers;
use frontend\components\Controller;


class AboutController extends Controller {
    public function actionAbout() {
        return $this->render('about');
    }

}

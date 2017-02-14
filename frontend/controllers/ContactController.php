<?php

namespace frontend\controllers;
use frontend\components\Controller;


class ContactController extends Controller {
    public function actionContact() {
        return $this->render('contact');
    }

}

<?php

namespace frontend\controllers;
use frontend\components\Controller;


class BlogController extends Controller {
    public function actionBlog() {
        return $this->render('blog');
    }

}

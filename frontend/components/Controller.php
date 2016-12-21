<?php
namespace frontend\components;
use Yii;
use yii\web\Controller as YiiController;

/**
 * 继承该controller将自动进登录验证，以及定义一些公用方法
 *
 */
class Controller extends YiiController {

    public function beforeAction($action) {
        parent::beforeAction($action);

        // 如果没有session，则尝试通过author key 自动登录
        // if (Yii::$app->authMember->isGuest()) {
        //     Yii::$app->authMember->loginByAuthKey();
        // }

        // // 验证用户是否登录用户的action
        // if (!Yii::$app->authMember->checkAuth()) {
        //     return $this->redirect(['site/login']);
        // }
        return true;
    }

    public function goBack($defaultUrl = null) {

        //return Yii::$app->getResponse()->redirect();
    }

}
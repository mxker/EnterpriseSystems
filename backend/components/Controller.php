<?php
namespace backend\components;
use Yii;
use yii\web\Controller as YiiController;

/**
 * 继承该controller将自动进rbac权限验证，以及定义一些公用方法
 *
 */
class Controller extends YiiController {

    protected $only_check_login = [];

    public function beforeAction($action) {
        parent::beforeAction($action);

        // 如果没有session，则尝试通过author key 自动登录
        if (Yii::$app->authAdmin->isGuest()) {
            Yii::$app->authAdmin->loginByAuthKey();
        }

        // 验证用户权限，检查只需验证是登录用户的action
        if (!Yii::$app->authAdmin->isGuest() &&
            is_array($this->only_check_login) &&
            in_array(Yii::$app->controller->action->id, $this->only_check_login)) {
            return true;
        }

        // 从角色权限表中判断当前用户的权限
        if (!Yii::$app->authAdmin->checkAuth()) {
            if (Yii::$app->authAdmin->isGuest()) {
                return $this->redirect(['site/error']);
            } else {
                return $this->redirect(['site/login']);
            }
        }
        return true;
    }

    public function goBack($defaultUrl = null) {

        //return Yii::$app->getResponse()->redirect();
    }

}
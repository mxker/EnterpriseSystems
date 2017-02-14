<?php

namespace backend\components;
use backend\models\Admin;
use Yii;

/**
 * 用户权限验证类
 */
class AuthAdmin {
    private $session;
    private $requestCookie;
    private $responseCookie;

    public function __construct() {
        $this->session = Yii::$app->session;
        $this->requestCookie = Yii::$app->request->cookies;
        $this->responseCookie = Yii::$app->response->cookies;
    }

    public function login($admin, $remeber_time) {
        // 设置管理员信息session
        $this->setAdminSession($admin);
        // 设置记住我
        $auth_key = $remeber_time ? md5(uniqid('l_a_k_')) : '';
        $admin->updateAuthKey($auth_key);
        if ($remeber_time) {
            $this->responseCookie->add(new \yii\web\Cookie([
                'name' => 'l_a_k',
                'value' => $admin['username'] . '_' . $admin['auth_key'],
                'expire' => time() + $remeber_time,
            ]));
        }

        return true;
    }

    /**
     * 检查是否为
     * @return boolean true登录，
     */
    public function isGuest() {
        return !$this->session->has('admin');
    }

    public function loginByAuthKey() {
        if (($cookie = $this->requestCookie->get('l_a_k')) !== null) {
            $data = explode('_', $cookie);
            $username = @trim($data[0]);
            $auth_key = @trim($data[1]);
            if ($username && $auth_key) {
                $admin = Admin::findByUsername($username);
                if ($admin->validateAuthKey($auth_key)) {
                    $this->setAdminSession($admin);
                    return true;
                }
            }
        }
        return false;
    }

    public function logout() {
        $admin = $this->session->get('admin');
        if (isset($admin['id'])) {
            Admin::updateAll(['auth_key' => ''], ['id' => $admin['id']]);
        }
        $this->responseCookie->remove('l_a_k');
        $this->session->removeAll();
        return true;
    }

    /**
     * 检查用户权限
     * @return bool 是否有权限
     */
    public function checkAuth() {
        $allowed = false;

        $module_id = Yii::$app->controller->module->id;
        $controller_id = Yii::$app->controller->id;
        if (isset($this->allowActions) && is_array($this->allowActions) && count($this->allowActions)) {
            foreach ($this->allowActions as $one) {
                $route_arg = explode('/', $one);
                if (count($route_arg) == 2) {
                    if (($route_arg[1] == '*' && $route_arg[0] == $module_id) ||
                        ($route_arg[1] == '*' && $route_arg[0] == $controller_id) ||
                        Yii::$app->requestedRoute == $one) {
                        return true;
                    }
                } else if (count($route_arg) == 3) {
                    if (($route_arg[2] == '*' && $route_arg[1] == $controller_id) ||
                        Yii::$app->requestedRoute == $one) {
                        return true;
                    }
                }
            }
        }

        $admin = $this->session->get('admin');

        if (isset($admin['role_id']) && $admin['role_id'] == -1) {
            $allowed = true;
        } else if (isset($admin['role_id'])) {
            // TODO 对普通管理员进行访问权限检查

        }

        return $allowed;
    }

    private function setAdminSession($admin) {
        $this->session->set('admin', [
            'admin_id' => $admin['admin_id'],
            'username' => $admin['username'],
            'role_id' => $admin['role_id'],
        ]);
    }
}
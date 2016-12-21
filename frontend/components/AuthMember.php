<?php

namespace frontend\components;
use frontend\models\Member;
use Yii;

/**
 * 用户权限验证类
 */
class AuthMember {
    private $session;
    private $requestCookie;
    private $responseCookie;

    public function __construct() {
        $this->session = Yii::$app->session;
        $this->requestCookie = Yii::$app->request->cookies;
        $this->responseCookie = Yii::$app->response->cookies;
    }

    public function login($member, $remeber_time) {
        // 设置管理员信息session
        $this->setMemberSession($member);
        // 设置记住我
        $auth_key = $remeber_time ? $member->generateAuthKey() : '';
        $member->updateAuthKey($auth_key);
        if ($remeber_time) {
            $this->responseCookie->add(new \yii\web\Cookie([
                'name' => 'l_a_k',
                'value' => $member['username'] . '_' . $member['auth_key'],
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
        return !$this->session->has('member');
    }

    public function loginByAuthKey() {
        if (($cookie = $this->requestCookie->get('l_a_k')) !== null) {
            $data = explode('_', $cookie);
            $username = @trim($data[0]);
            $auth_key = @trim($data[1]);
            if ($username && $auth_key) {
                $member = Member::findByUsername($username);
                if ($member->validateAuthKey($auth_key)) {
                    $this->setMemberSession($member);
                    return true;
                }
            }
        }
        return false;
    }

    public function logout() {
        $member = $this->session->get('member');
        if (isset($member['id'])) {
            Member::updateAll(['auth_key' => ''], ['id' => $member['id']]);
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

        if (!$this->isGuest()) {
            $allowed = true;
        }

        return $allowed;
    }

    private function setMemberSession($member) {
        $this->session->set('member', [
            'member_id' => $member['member_id'],
            'username' => $member['username'],
            'email' => $member['email'],
        ]);
    }
}
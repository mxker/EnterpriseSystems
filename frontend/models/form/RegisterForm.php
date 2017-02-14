<?php
namespace frontend\models\form;

use common\models\Member;
use Yii;
use yii\base\Model;

/**
 * Register form
 */
class RegisterForm extends Model {
    public $username;
    public $email;
    public $password;
    public $repassword;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Member'],
            ['username', 'string', 'length' => [4, 25]],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Member'],

            ['password', 'trim'],
            ['password', 'required'],
            ['password', 'string', 'length' => [6, 20]],
            ['repassword', 'compare', 'compareAttribute' => 'password'],

            ['verifyCode', 'required'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => '用户名',
            'password' => '密码',
            'repassword' => '再次输入密码',
            'verifyCode' => '验证码',
        ];
    }

    /**
     * Signs member up.
     *
     * @return Member|null the saved model or null if saving fails
     */
    public function signup() {
        $data = null;
        $member = new Member();
        $member->username = $this->username;
        $member->email = $this->email;
        $member->setPassword($this->password);
        $member->create_at = time();
        $member->update_at = time();

        if ($member->save()) {
            Yii::$app->authMember->login($member, 0);
            $data = $member;
        }

        return $data;
    }
}

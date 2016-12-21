<?php
namespace frontend\models\form;
use frontend\models\Member;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $member This property is read-only.
 *
 */
class LoginForm extends Model {
    public $username;
    public $password;
    public $rememberMe = false;
    public $verifyCode;
    private $_member = false;
    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password', 'verifyCode'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => '用户名',
            'password' => '密码',
            'verifyCode' => '验证码',
            'rememberMe' => '保持登录',
        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $member = $this->getMember();
            if (!$member || !$member->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误.');
            }
        }
    }
    /**
     * Logs in a member using the provided username and password.
     * @return bool whether the member is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->authMember->login($this->getMember(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }
    /**
     * Finds member by [[username]]
     *
     * @return Member Object|null
     */
    public function getMember() {
        if ($this->_member === false) {
            $this->_member = Member::findByUsername($this->username);
        }
        return $this->_member;
    }
}
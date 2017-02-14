<?php
namespace common\models;
use yii\db\ActiveRecord;

class Member extends ActiveRecord {

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;
    private static $members = [];

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => '用户ID',
            'username' => '用户名',
            'password' => '密码',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * Finds member by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $member = NULL;
        $username = trim($username);
        if (count(self::$members)) {
            foreach (self::$members as $one) {
                if ($one['username'] == $username) {
                    $member = $one;
                    break;
                }
            }
        }
        if (!$member) {
            $member = static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
            if ($member) {
                self::$members[] = $member;
            }
        }

        return $member;
    }
    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return trim($authKey) && $this->auth_key === $authKey;
    }

    public function updateAuthKey($authKey) {
        $this->auth_key = $authKey;
        return $this->update(false, ['auth_key']);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = md5(uniqid('l_a_k_'));
        return $this->auth_key;
    }

    public function setPassword($password) {
        $this->salt = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
        $this->password_hash = md5(md5($password) . $this->salt);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return md5(md5($password) . $this->salt) === $this->password_hash;
    }
}
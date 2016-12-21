<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;

class Admin extends ActiveRecord {

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;
    private static $admins = [];

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
     * Finds admin by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $admin = NULL;
        $username = trim($username);
        if (count(self::$admins)) {
            foreach (self::$admins as $one) {
                if ($one['username'] == $username) {
                    $admin = $one;
                    break;
                }
            }
        }
        if (!$admin) {
            $admin = static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
            if ($admin) {
                self::$admins[] = $admin;
            }
        }

        return $admin;
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
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return md5(md5($password) . $this->salt) === $this->password_hash;
    }
}
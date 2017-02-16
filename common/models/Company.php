<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "my_company".
 *
 * @property integer $company_id
 * @property string $company_name
 * @property string $company_logo
 * @property string $company_tel
 * @property string $company_area
 * @property string $culture
 * @property string $description
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'company_tel', 'company_area'], 'required'],
            [['description'], 'string'],
            [['company_name', 'company_tel'], 'string', 'max' => 50],
            [['company_logo'], 'string', 'max' => 255],
            [['company_area', 'culture'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => '公司id',
            'company_name' => '公司名称',
            'company_logo' => '公司logo',
            'company_tel' => '公司电话',
            'company_area' => '公司地址',
            'culture' => '公司文化',
            'description' => '公司介绍',
        ];
    }
}

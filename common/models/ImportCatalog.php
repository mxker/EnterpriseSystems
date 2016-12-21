<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "my_import_catalog".
 *
 * @property integer $ic_id
 * @property integer $parent_id
 * @property string $code
 * @property string $name
 * @property string $unit
 * @property string $minprice
 * @property string $rate
 */
class ImportCatalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_import_catalog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['minprice', 'rate'], 'number'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ic_id' => 'Ic ID',
            'parent_id' => 'Parent ID',
            'code' => 'Code',
            'name' => 'Name',
            'unit' => 'Unit',
            'minprice' => 'Minprice',
            'rate' => 'Rate',
        ];
    }

    public function getFirstCataLog(){
        return $this->find()->where(['parent_id'=>0])->asArray()->all();
    }
}

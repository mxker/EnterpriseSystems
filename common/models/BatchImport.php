<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "my_batch_import".
 *
 * @property integer $ib_id
 * @property string $parcel_ids
 * @property integer $parcel_num
 * @property integer $member_id
 * @property integer $create_at
 */
class BatchImport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_batch_import';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parcel_ids'], 'string'],
            [['parcel_num', 'member_id', 'create_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ib_id' => 'Ib ID',
            'parcel_ids' => 'Parcel Ids',
            'parcel_num' => 'Parcel Num',
            'member_id' => 'Member ID',
            'create_at' => 'Create At',
        ];
    }
}

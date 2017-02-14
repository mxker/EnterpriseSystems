<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "my_logistics_channel".
 *
 * @property integer $lc_id
 * @property string $name
 * @property integer $country_id
 * @property integer $channel_overseas_id
 * @property integer $channel_domestic_id
 * @property integer $is_moyun
 * @property integer $is_include_demestic
 * @property integer $is_idcard
 * @property integer $is_tariff
 * @property string $code
 */
class LogisticsChannel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_logistics_channel';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lc_id' => 'Lc ID',
            'name' => 'Name',
            'country_id' => 'Country ID',
            'channel_overseas_id' => 'Channel Overseas ID',
            'channel_domestic_id' => 'Channel Domestic ID',
            'is_moyun' => 'Is Moyun',
            'is_include_demestic' => 'Is Include Demestic',
            'is_idcard' => 'Is Idcard',
            'is_tariff' => 'Is Tariff',
            'code' => 'Code',
        ];
    }
}

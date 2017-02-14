<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/26
 * Time: 16:07
 */

namespace api\models\form;

use common\models\Express as AExpress;

class ExpressForm extends AExpress
{

    public $id;
    public $e_name;
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '索引ID',
            'e_name' => '公司名称',
            'e_state' => '状态',
            'e_code' => '编号',
            'e_letter' => '首字母',
            'e_order' => '1常用2不常用',
            'e_url' => '公司网址',
            'tel' => '联系电话',
            'api_code' => 'api编码',
            'ickd_api_code' => '爱查快递api编码',
        ];
    }
}
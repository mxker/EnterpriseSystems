<?php
namespace common\assets;
use yii\web\AssetBundle;

class DatePicker extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/datetime/bootstrap-datepicker.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

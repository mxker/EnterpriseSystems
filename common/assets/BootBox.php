<?php
namespace common\assets;
use yii\web\AssetBundle;

class BootBox extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/bootbox/bootbox.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

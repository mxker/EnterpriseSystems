<?php
namespace common\assets;
use yii\web\AssetBundle;

class BootBox extends AssetBundle {
    public $sourcePath = '@common/assets/resourceback';

    public $js = [
        'js/bootbox/bootbox.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

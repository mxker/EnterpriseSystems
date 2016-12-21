<?php
namespace common\assets;
use yii\web\AssetBundle;

class EasingJS extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/easing.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

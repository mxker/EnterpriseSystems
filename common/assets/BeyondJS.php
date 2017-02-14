<?php
namespace common\assets;
use yii\web\AssetBundle;

class BeyondJS extends AssetBundle {
    public $sourcePath = '@common/assets/resourceback';

    public $js = [
        'js/beyond.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

<?php
namespace common\assets;
use yii\web\AssetBundle;

class ResponsiveslidesJS extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/responsiveslides.min.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

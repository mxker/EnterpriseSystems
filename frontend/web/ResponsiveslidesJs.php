<?php
namespace common\assets;
use yii\web\AssetBundle;

class ResponsiveslidesJS extends AssetBundle {
    public $sourcePath = '@common/assets/resourcefront';

    public $js = [
        'js/responsiveslides.min.js',
    ];

    public $depends = [
        'common\assets\FrontCommonAsset',
    ];
}

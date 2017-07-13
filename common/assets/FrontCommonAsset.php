<?php

namespace common\assets;
use yii\web\AssetBundle;

class FrontCommonAsset extends AssetBundle {
    public $sourcePath = '@common/assets/resourcefront';

    public $css = [
        'css/bootstrap.css',
        'css/style.css',
        'css/loginbox.min.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
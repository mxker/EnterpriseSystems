<?php

namespace common\assets;
use yii\web\AssetBundle;

class CommonAsset extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $css = [
        'css/bootstrap.css',
        'css/style.css',
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
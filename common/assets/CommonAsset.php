<?php

namespace common\assets;
use yii\web\AssetBundle;

class CommonAsset extends AssetBundle {
    public $sourcePath = '@common/assets/resourceback';

    public $css = [
        'css/bootstrap.min.css',
    ];
    public $js = [
        'js/jquery-2.0.3.min.js',
        'js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
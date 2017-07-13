<?php

namespace common\assets;
use yii\web\AssetBundle;

class BackendAsset extends AssetBundle {
    public $sourcePath = '@common/assets/resourceback';

    public $css = [
        'css/bootstrap.min.css',
        'css/skins/teal.min.css',
        'css/font-awesome.min.css',
        'css/beyond.min.css',
        'css/demo.min.css',
        'css/typicons.min.css',
        'css/animate.min.css',
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
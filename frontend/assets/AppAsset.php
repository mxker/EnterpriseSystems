<?php

namespace frontend\assets;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];


    public $depends = [
        'common\assets\FrontCommonAsset',
        'common\assets\FrontBeyondJS',
    ];

}
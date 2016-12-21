<?php
namespace frontend\assets;
use yii\web\AssetBundle;

class IndexAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        
    ];
    public $depends = [
        'common\assets\CommonAsset',
    ];

}
<?php
namespace common\assets;
use yii\web\AssetBundle;

class FrontBeyondJS extends AssetBundle {
    public $sourcePath = '@common/assets/resourcefront';

    public $js = [
        
    ];

    public $depends = [
        'common\assets\FrontCommonAsset',
    ];
}

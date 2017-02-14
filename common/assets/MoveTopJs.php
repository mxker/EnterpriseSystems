<?php
namespace common\assets;
use yii\web\AssetBundle;

class MoveTopJS extends AssetBundle {
    public $sourcePath = '@common/assets/resourcefront';

    public $js = [
        'js/move-top.js',
    ];

    public $depends = [
        'common\assets\FrontCommonAsset',
    ];
}

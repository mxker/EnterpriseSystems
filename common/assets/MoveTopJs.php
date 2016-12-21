<?php
namespace common\assets;
use yii\web\AssetBundle;

class MoveTopJS extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/move-top.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

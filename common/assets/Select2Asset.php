<?php
namespace common\assets;
use yii\web\AssetBundle;

class Select2Asset extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/select2/select2.js'
    ];
    public $css = [

    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

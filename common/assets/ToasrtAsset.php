<?php
namespace common\assets;
use yii\web\AssetBundle;

class ToastrAsset extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/toastr/toastr.js',
    ];
    public $css = [

    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

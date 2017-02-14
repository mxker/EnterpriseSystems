<?php
namespace common\assets;
use yii\web\AssetBundle;

class TreeviewAsset extends AssetBundle {
    public $sourcePath = '@common/assets/resourceback';

    public $js = [
        'js/fuelux/treeview/tree-custom.min.js',
        'js/fuelux/treeview/treeview-init.js'
    ];
    public $css = [

    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

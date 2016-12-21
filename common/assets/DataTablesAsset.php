<?php
namespace common\assets;
use yii\web\AssetBundle;

class DataTablesAsset extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
    ];
    public $css = [
        'css/dataTables.bootstrap.css',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

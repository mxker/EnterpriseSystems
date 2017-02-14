<?php
namespace common\assets;
use yii\web\AssetBundle;

class DataTablesMinJs extends AssetBundle {
    public $sourcePath = '@common/assets/resourceback';

    public $js = [
        'js/datatable/jquery.dataTables.min.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

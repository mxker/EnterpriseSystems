<?php
namespace common\assets;
use yii\web\AssetBundle;

class DataTablesMinJs extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/datatable/jquery.dataTables.min.js',
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

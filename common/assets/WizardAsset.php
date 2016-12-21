<?php
namespace common\assets;
use yii\web\AssetBundle;

class WizardAsset extends AssetBundle {
    public $sourcePath = '@common/assets/resource';

    public $js = [
        'js/fuelux/wizard/wizard-custom.js',
    ];
    public $css = [
    ];

    public $depends = [
        'common\assets\CommonAsset',
    ];
}

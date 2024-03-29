<?php
/**
 * @link https://github.com/2amigos/yii2-file-upload-widget
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace common\widgets\upload;

use yii\web\AssetBundle;

/**
 * FileUploadPlusAsset
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 */
class BlueimpLoadImageAsset extends AssetBundle {
    public $sourcePath = '@bower/blueimp-load-image';
    public $js = [
        'js/load-image.all.min.js',
    ];
}

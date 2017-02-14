<?php
namespace common\actions;

use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\helpers\Json;
use yii\web\UploadedFile;

class UploadAction extends Action {

    public $extensions = null;
    public $maxSize = 2 * 1024 * 1024;
    public $minSize = 0;
    public $checkExtensionByMimeType = false;
    public $mimeTypes = null;
    public $savePath = false;

    public function init() {

    }

    /**
     * Runs the action.
     */
    public function run() {
        if ($this->savePath === false) {
            return Json::encode(['error' => '上传路径错误']);
        }

        $model = new DynamicModel(['file']);

        // 设置文件最大限制
        $rules = ['maxSize' => $this->maxSize];
        // 设置文件最小限制
        if ($this->minSize > 0 && $this->minSize < $this->maxSize) {
            $rules = ['minSize' => $this->minSize];
        }
        // 设置文件类型
        if ($this->checkExtensionByMimeType && $this->mimeTypes) {
            $rules['checkExtensionByMimeType'] = true;
            $rules['mimeTypes'] = $this->mimeTypes;
        } else if ($this->extensions) {
            $rules['checkExtensionByMimeType'] = false; // validator default is true
            $rules['extensions'] = $this->extensions;
        }
        $model->addRule('file', 'file', $rules);

        $model->file = UploadedFile::getInstance($model, 'file');
        if (!$model->validate()) {
            return Json::encode(['error' => join(' ', $model->getErrors('file'))]);
        }

        $directory = Yii::getAlias('@data') . $this->getDir();

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $uniqid = uniqid('', true);
        $fileName = $uniqid . '.' . $model->file->extension;
        $filePath = $directory . $fileName;

        if ($model->file->saveAs($filePath)) {
            $path = $this->getDir() . $fileName;
            return Json::encode([
                'files' => [[
                    'name' => $fileName,
                    'size' => $model->file->size,
                    "url" => $path,
                    "thumbnailUrl" => Yii::$app->params['upload_static_url'] . $path,
                    //"deleteUrl" => 'image-delete?name=' . $fileName,
                    //"deleteType" => "POST",
                ]],
            ]);
        }

        return Json::encode(["error" => '上传失败']);
    }

    private function getDir() {

        return DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $this->savePath . DIRECTORY_SEPARATOR;
    }
}
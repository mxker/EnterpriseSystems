<?php
use common\widgets\upload\FileUpload;
use common\widgets\upload\FileUploadUI;
use yii\helpers\Html;
use common\assets\DataTablesAsset;

DataTablesAsset::register($this);
$this->title = '开始';
$this->params['active_menu'] = 'home';
$this->params['header_titles'] = ['首页', '面板'];
?>
<h1>admin/home</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?=__FILE__;?></code>.
    <?=Html::csrfMetaTags()?>


    <?=FileUpload::widget([
        'model' => $model,
        'attribute' => 'file',
        'url' => ['site/uploadImg'], // your url, this is just for demo purposes,
        'buttonClass' => 'btn btn-xs btn-default purple',
        'options' => [
            'accept' => 'image/*',
            'class' => 'abc',
            'id' => 'upload-img-1'
        ],
        'clientOptions' => [
            'maxFileSize' => 2000000,
            'autoUpload' => true,
        ],
        // Also, you can specify jQuery-File-Upload events
        // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                                    console.log(e);
                                        if(data.result.error){
                                            alert(data.result.error);
                                        }
                                    console.log(data);
                                }',
            'fileuploadfail' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
        ],
    ]);?>


   <?=FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'file',
    'url' => ['site/uploadImg'],
    'gallery' => false,
    'options' => [
        'id' => 'upload-img-2'
    ],
    'fieldOptions' => [
        'accept' => 'image/*',
        'class' => 'abcd',
    ],
    'clientOptions' => [
        'maxFileSize' => 2000000,
    ],

    'clientEvents' => [
        'fileuploaddone' => 'function(e, data) {
                                        console.log(data);
                                        if(data.result.error){
                                            alert(data.result.error);
                                        }
                                    }',
        'fileuploadfail' => 'function(e, data) {
                                        console.log(e);
                                        if(data.error){
                                            alert(data.error);
                                        }
                                        console.log(data);
                                    }',
    ],
]);
?>

</p>

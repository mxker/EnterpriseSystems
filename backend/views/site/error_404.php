<?php
use backend\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8" />
    <title>Error 404 - Page Not Found</title>

    <meta name="description" content="Error 404 - Page Not Found" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php $this->head() ?>
</head>
<body class="body-404">
    <?php $this->beginBody() ?>
    <div class="error-header"> </div>
    <div class="container ">
        <section class="error-container text-center">
            <h1>404</h1>
            <div class="error-divider">
                <!--<h2>页面未找到</h2>-->
                <p class="description">访问的页面不存在</p>
            </div>
            <a href="<?= Url::to(['admin/home']) ?>" class="return-btn"><i class="fa fa-home"></i>返回</a>
        </section>
    </div>
    
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

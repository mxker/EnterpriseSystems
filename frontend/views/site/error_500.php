<?php
use frontend\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8" />
    <title>Error 500</title>

    <meta name="description" content="Error 500" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php $this->head() ?>
</head>
<body class="body-500">
    <?php $this->beginBody() ?>
    <div class="error-header"> </div>
    <div class="container ">
        <section class="error-container text-center">
            <h1>500</h1>
            <div class="error-divider">
                <!--<h2>ooops!!</h2>-->
                <p class="description"><?= $exception->getMessage() ?></p>
            </div>
            <a href="<?= Url::to(['member/home']) ?>" class="return-btn"><i class="fa fa-home"></i>返回</a>
        </section>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
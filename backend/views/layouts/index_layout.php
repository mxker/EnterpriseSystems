<?php
use backend\assets\IndexAsset;
use yii\helpers\Html;
IndexAsset::register($this);
/* @var $this yii\web\View */
/* @var $content string 字符串 */
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SuperB-Grace <?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body style="font-family:"Arial","Microsoft YaHei","黑体","宋体",sans-serif; ">
<?php $this->beginBody() ?>
<div class="content">
<header>
    <div class="hmain">
        <div class="buttons">
            <!-- <a href="/site/login"><button style="background-color: #ECAC30">管理后台</button></a> -->
        </div>
    </div>
</header>
<?= $content ?>
<!--<footer>&copy; 2014 by My Company</footer>-->
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

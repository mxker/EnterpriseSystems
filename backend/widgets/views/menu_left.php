<?php
use yii\helpers\Url;
?>

<ul class="nav sidebar-menu">
    <?php foreach($menu_data as $one):?>
        <li <?php if(isset($one['active']) && $one['active']):?>class="active"<?php endif;?>>
            <a href="<?= Url::to($one['url'])?>">
                <i class="menu-icon <?= $one['class'] ?>"></i>
                <span class="menu-text"> <?= $one['title'] ?> </span>
            </a>
        </li>
    <?php endforeach;?>
</ul>
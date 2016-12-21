<?php
use yii\helpers\Url;
?>

<div class="navbar-menu">
    <ul class="navbar-menu-ul">
        <?php foreach ($menu_data as $one): ?>
        <a href="<?=Url::to($one['url'])?>">
            <li class="navbar-menu-li <?php if (isset($one['active']) && $one['active']): ?>active<?php endif;?>">
                <?=$one['title']?>
            </li>
        </a>
        <?php endforeach;?>
    </ul>
</div>

<!--
<div class="navbar-menu">
    <ul class="navbar-menu-ul">
        <li class="navbar-menu-li">个人中心</li>
        <li class="navbar-menu-li active">会员管理</li>
        <li class="navbar-menu-li">运单</li>
        <li class="navbar-menu-li">报表</li>
        <li class="navbar-menu-li">支付</li>
        <li class="navbar-menu-li">工单</li>
        <li class="navbar-menu-li">系统</li>
    </ul>
</div>
-->
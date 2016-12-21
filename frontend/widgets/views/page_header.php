
<div class="page-header position-relative">
    <div class="header-title">
        <h1>
            <?=$header_titles['main']?>
            <?php foreach ($header_titles['sub'] as $one): ?>
                <small>
                    <i class="fa fa-angle-right"></i>
                    <?=$one?>
                </small>
            <?php endforeach;?>
        </h1>
    </div>
    <!--Header Buttons-->
    <div class="header-buttons">
        <a class="sidebar-toggler" href="#">
            <i class="fa fa-arrows-h"></i>
        </a>
        <a class="refresh" id="refresh-toggler" href="">
            <i class="glyphicon glyphicon-refresh"></i>
        </a>
        <a class="fullscreen" id="fullscreen-toggler" href="#">
            <i class="glyphicon glyphicon-fullscreen"></i>
        </a>
    </div>
    <!--Header Buttons End-->
</div>
<?php
use common\assets\DataTablesAsset;
use common\assets;

DataTablesAsset::register($this);
$this->title = '开始';
$this->params['active_menu'] = 'home';
$this->params['header_titles'] = ['首页', '首页'];

$css = <<<EOF
    .row-title{
        margin-top: 0px !important;
        margin-left: -12px !important;
    }
    .col-lg-12{
        width: 1655px;
    }
    .tabbable{
        width: 49%;
    }
    .tabbable-right{
        float:right;
        position: relative;
        margin-right: 0px;
    }
    .tabbable-left{
        float:left;
        position: relative;
    }
    .a-link{
        float:right;
    }
EOF;
$this->registerCss($css);
?>
<div class="profile-container">
        <div class="profile-header row">
            <div class="col-lg-2 col-md-4 col-sm-12 text-center">
                <img src="/img/avatars/avatar.jpg" alt="" class="header-avatar">
            </div>
            <div class="col-lg-5 col-md-8 col-sm-12 profile-info">
                <div class="header-fullname"><?php echo $memberInfo['username']?></div>
                <a href="#" class="btn btn-palegreen btn-sm  btn-follow">
                    <i class="fa fa-check"></i>
                    已认证
                </a>
                <div class="header-information">
                    可用余额：<?php echo '<span style="color: red; font-size: 20px;">'.$memberInfo['available_predeposits'].'</span>元'?><br/>
                    冻结金额：<?php echo '<span style="color: red">'.$memberInfo['freeze_predeposits'].'</span>元'?>
                </div>
            </div>
        </div>
        <div class="profile-body">
            <div  style="position: absolute; padding-right: 20px">
                <div class=" tabbable tabbable-left">
                    <div class="tab-content tabs-flat">
                        <div id="overview" class="tab-pane active">
                            <form role="form">
                                <div class="form-title">
                                    <h5 class="row-title before-themeprimary">基本信息</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span class="form-group input-icon icon-right form-control">用户级别：<span style="color: red;">皇冠用户</span></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="form-group input-icon icon-right form-control">问题包裹：<a href="<?php Yii::$app->homeUrl;?>/parcel/issue"><?php echo $memberInfo['issueNum']?>件</a></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="form-group input-icon icon-right form-control">售后/工单：<a href="<?php Yii::$app->homeUrl;?>/feedback/index"><?php echo $memberInfo['feedback']?>件</a></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="form-group input-icon icon-right form-control">在途包裹：<a href="<?php Yii::$app->homeUrl;?>/parcel/list"><?php echo $memberInfo['normalNum']?>件</a></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tabbable tabbable-right">
                    <div class="tab-content tabs-flat">
                        <div id="overview" class="tab-pane active">
                            <form role="form">
                                <div class="form-title">
                                    <h5 class="row-title before-themeprimary">常用教程</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="form-group input-icon icon-right form-control">提交文件教程<a href="<?php Yii::$app->homeUrl?>" target="_blank" class="a-link">http://www.exp.com/member/home</a></span>
                                    </div>
                                    <div class="col-sm-12">
                                        <span class="form-group input-icon icon-right form-control">贴单教程<a href="<?php Yii::$app->homeUrl?>" target="_blank" class="a-link">http://www.exp.com/member/home</a></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="settings" class="tab-pane">

                        </div>
                    </div>
                </div>
                <div class="tabbable tabbable-left">
                    <div class="tab-content tabs-flat">
                        <div id="overview" class="tab-pane active">
                            <form role="form">
                                <div class="form-title">
                                    <h5 class="row-title before-themeprimary">个人资料</h5>
                                    <a href="<?php Yii::$app->homeUrl;?>/personal/index"><i style="float: right;margin-right: 10px; margin-top: 10px;" class="fa fa-edit"></i></a>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="姓名：<?php echo $memberInfo['username']?>">
                                                    <i class="fa fa-user blue"></i>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="邮箱：<?php echo $memberInfo['email']?>">
                                                    <i class="fa fa-flickr blue"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="手机号码：<?php echo $memberInfo['mob_phone']?>">
                                                    <i class="glyphicon glyphicon-phone palegreen"></i>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="所在地：中华人民共和国">
                                                    <i class="fa fa-globe"></i>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <span class="input-icon icon-right">
                                                    <input type="text" readonly="readonly" class="form-control" placeholder="证件号码：510824199909099999">
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tabbable tabbable-right">
                    <div class="tab-content tabs-flat">
                        <div id="overview" class="tab-pane active">
                            <form role="form">
                                <div class="form-title">
                                    <h5 class="row-title before-themeprimary">常用链接</h5>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="form-group input-icon icon-right form-control"><a target="_blank" href="http://www.dhl.com/en.html">DHL官网查询</a></span>
                                    </div>
                                    <div class="col-sm-12">
                                        <span class="form-group input-icon icon-right form-control"><a target="_blank" href="http://www.ems183.cn">EMS官网查询</a></span>
                                    </div>
                                    <div class="col-sm-12">
                                        <span class="form-group input-icon icon-right form-control"><a target="_blank" href="http://www.kuaidi100.com/">快递100查询</a></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="settings" class="tab-pane">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

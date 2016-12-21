<?php
use yii\helpers\Url;
?>
<div class="navbar-header pull-right">
    <div class="navbar-account">
        <ul class="account-area">
            <li>
                <a class=" dropdown-toggle" data-toggle="dropdown" title="Help" href="#">
                    <i class="icon fa fa-warning"></i>
                </a>
                <!--Notification Dropdown-->
                <ul class="pull-right dropdown-menu dropdown-arrow dropdown-notifications">
                    <li>
                        <a href="#">
                            <div class="clearfix">
                                <div class="notification-icon">
                                    <i class="fa fa-phone bg-themeprimary white"></i>
                                </div>
                                <div class="notification-body">
                                    <span class="title">Skype meeting with Patty</span>
                                    <span class="description">01:00 pm</span>
                                </div>
                                <div class="notification-extra">
                                    <i class="fa fa-clock-o themeprimary"></i>
                                    <span class="description">office</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="clearfix">
                                <div class="notification-icon">
                                    <i class="fa fa-check bg-darkorange white"></i>
                                </div>
                                <div class="notification-body">
                                    <span class="title">Uncharted break</span>
                                    <span class="description">03:30 pm - 05:15 pm</span>
                                </div>
                                <div class="notification-extra">
                                    <i class="fa fa-clock-o darkorange"></i>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="clearfix">
                                <div class="notification-icon">
                                    <i class="fa fa-gift bg-warning white"></i>
                                </div>
                                <div class="notification-body">
                                    <span class="title">Kate birthday party</span>
                                    <span class="description">08:30 pm</span>
                                </div>
                                <div class="notification-extra">
                                    <i class="fa fa-calendar warning"></i>
                                    <i class="fa fa-clock-o warning"></i>
                                    <span class="description">at home</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="clearfix">
                                <div class="notification-icon">
                                    <i class="fa fa-glass bg-success white"></i>
                                </div>
                                <div class="notification-body">
                                    <span class="title">Dinner with friends</span>
                                    <span class="description">10:30 pm</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-footer ">
                        <span>
                            Today, March 28
                        </span>
                        <span class="pull-right">
                            10°c
                            <i class="wi wi-cloudy"></i>
                        </span>
                    </li>
                </ul>
                <!--/Notification Dropdown-->
            </li>
            <li>
                <a class="wave in dropdown-toggle" data-toggle="dropdown" title="Help" href="#">
                    <i class="icon fa fa-envelope"></i>
                    <span class="badge">3</span>
                </a>
                <!--Messages Dropdown-->
                <ul class="pull-right dropdown-menu dropdown-arrow dropdown-messages">
                    <li>
                        <a href="#">
                            <img src="/img/avatars/divyia.jpg" class="message-avatar" alt="Divyia Austin">
                            <div class="message">
                                <span class="message-sender">
                                    Divyia Austin
                                </span>
                                <span class="message-time">
                                    2 minutes ago
                                </span>
                                <span class="message-subject">
                                    Here's the recipe for apple pie
                                </span>
                                <span class="message-body">
                                    to identify the sending application when the senders image is shown for the main icon
                                </span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/img/avatars/bing.png" class="message-avatar" alt="Microsoft Bing">
                            <div class="message">
                                <span class="message-sender">
                                    Bing.com
                                </span>
                                <span class="message-time">
                                    Yesterday
                                </span>
                                <span class="message-subject">
                                    Bing Newsletter: The January Issue‏
                                </span>
                                <span class="message-body">
                                    Discover new music just in time for the Grammy® Awards.
                                </span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/img/avatars/adam-jansen.jpg" class="message-avatar" alt="Divyia Austin">
                            <div class="message">
                                <span class="message-sender">
                                    Nicolas
                                </span>
                                <span class="message-time">
                                    Friday, September 22
                                </span>
                                <span class="message-subject">
                                    New 4K Cameras
                                </span>
                                <span class="message-body">
                                    The 4K revolution has come over the horizon and is reaching the general populous
                                </span>
                            </div>
                        </a>
                    </li>
                </ul>
                <!--/Messages Dropdown-->
            </li>

            <li>
                <a class="dropdown-toggle" data-toggle="dropdown" title="Tasks" href="#">
                    <i class="icon fa fa-tasks"></i>
                    <span class="badge">4</span>
                </a>
                <!--Tasks Dropdown-->
                <ul class="pull-right dropdown-menu dropdown-tasks dropdown-arrow ">
                    <li class="dropdown-header bordered-darkorange">
                        <i class="fa fa-tasks"></i>
                        4 Tasks In Progress
                    </li>

                    <li>
                        <a href="#">
                            <div class="clearfix">
                                <span class="pull-left">Account Creation</span>
                                <span class="pull-right">65%</span>
                            </div>

                            <div class="progress progress-xs">
                                <div style="width:65%" class="progress-bar"></div>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <div class="clearfix">
                                <span class="pull-left">Profile Data</span>
                                <span class="pull-right">35%</span>
                            </div>

                            <div class="progress progress-xs">
                                <div style="width:35%" class="progress-bar progress-bar-success"></div>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <div class="clearfix">
                                <span class="pull-left">Updating Resume</span>
                                <span class="pull-right">75%</span>
                            </div>

                            <div class="progress progress-xs">
                                <div style="width:75%" class="progress-bar progress-bar-darkorange"></div>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <div class="clearfix">
                                <span class="pull-left">Adding Contacts</span>
                                <span class="pull-right">10%</span>
                            </div>

                            <div class="progress progress-xs">
                                <div style="width:10%" class="progress-bar progress-bar-warning"></div>
                            </div>
                        </a>
                    </li>

                    <li class="dropdown-footer">
                        <a href="#">
                            See All Tasks
                        </a>
                        <button class="btn btn-xs btn-default shiny darkorange icon-only pull-right"><i class="fa fa-check"></i></button>
                    </li>
                </ul>
                <!--/Tasks Dropdown-->
            </li>

            <li>
                <a class="login-area dropdown-toggle" data-toggle="dropdown">
                    <div class="avatar" title="View your public profile">
                        <img src="/img/avatars/adam-jansen.jpg">
                    </div>
                    <section>
                        <h2><span class="profile"><span><?=$member['username']?></span></span></h2>
                    </section>
                </a>
                <!--Login Area Dropdown-->
                <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                    <li class="username"><a><?=$member['username']?></a></li>
                    <li class="email"><a><?=$member['email']?></a></li>
                    <!--Avatar Area-->
                    <!--<li>
                        <div class="avatar-area">
                            <img src="/img/avatars/adam-jansen.jpg" class="avatar">
                        </div>
                    </li>-->
                    <!--Avatar Area-->
                    <li class="edit">
                        <a href="profile.html" class="pull-left">Profile</a>
                        <a href="#" class="pull-right">设置</a>
                    </li>
                    <li class="dropdown-footer">
                        <a href="<?=Url::to(['site/logout'])?>">
                            退出登录
                        </a>
                    </li>
                </ul>
                <!--/Login Area Dropdown-->
            </li>
            <!-- /Account Area -->
            <!--Note: notice that setting div must start right after account area list.
            no space must be between these elements-->
        </ul>
    </div>
</div>
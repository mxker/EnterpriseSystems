<?php
use frontend\assets\AppAsset;
use frontend\widgets\AccountAreaWidget;
use frontend\widgets\MenuWidget;
use frontend\widgets\PageHeaderWidget;
use yii\helpers\Html;
use yii\helpers\Url;

\frontend\assets\IndexAsset::register($this);
\common\assets\ResponsiveslidesJs::register($this);
\common\assets\MoveTopJs::register($this);
\common\assets\EasingJs::register($this);

$js = <<<EOF
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); };

$(function () {
      // Slideshow 1
  $("#slider1").responsiveSlides({
   auto: true,
   nav: true,
   speed: 500,
   namespace: "callbacks",
});
});

jQuery(document).ready(function($) {
    $(".scroll").click(function(event){     
        event.preventDefault();
        $('html,body').animate({scrollTop:$(this.hash).offset().top},900);
    });
});
EOF;
$this->registerJs($js, $this::POS_END);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="教育机构 培训机构" />
    <title>edu website<?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<!-- /Head -->
<!-- Body -->
<body>
    <?php $this->beginBody()?>
    <!-- header-section-starts-here -->
    <div class="header">
        <div class="container">
            <div class="header-top">
                <p><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>Phone:+128-546-6853</p>
                <div class="logo">
                    <h1><a href="/site/index">WebSite</a></h1>
                </div>
                <div class="social-icons">
                    <ul>
                        <li><a class="facebook" href="#"></a></li>
                        <li><a class="twitter" href="#"></a></li>
                        <li><a class="google-plus" href="#"></a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- navigation -->
            <div class="navigation">
                    <nav class="navbar navbar-default">
                     
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
                              <ul class="nav navbar-nav">
                                <li><a href="/site/index">Home <span class="sr-only">(current)</span></a></li>
                                <li><a href="/about/about">ABOUT</a></li>
                                <li><a href="/codes/codes">Short codes</a></li>
                                <li><a href="/classes/classes">classes</a></li>
                                <li><a href="/blog/blog">Blog</a></li>
                                <li><a href="/contact/contact">Contact Us</a></li>
                              </ul>
                          <div class="clearfix"></div>
                        </div><!-- /.navbar-collapse -->
                    </nav>
            </div>
            <!-- //navigation -->
        </div>
    </div>
    <!-- header-section-ends-here -->
    <!-- content-section-starts-here -->
    <?= $content ?>
    <!-- //content-section-ends-here -->
    <!-- footer-section-starts-here -->
    <!-- footer-section -->
    <div class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="col-md-4 footer-grid">
                    <h5>NewsLetter</h5>
                    <p>Lorem ipsum dolor sit amet, tristique nec libero. Proin vitae convallis odio. Morbi nec enim nisi. Aliquam erat volutpat. </p>
                    <form>                   
                      <input type="text" class="text" value="Enter Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Enter Email';}">
                     <input type="submit" value="Submit">
                     <div class="clearfix"></div>
                 </form>
                </div>
                <div class="col-md-4 footer-grid">
                    <h5>Twitter Feed</h5>
                    <p>Check out th best designs online in the world <br>at <a href="mail-to:mail@example.com">http://example.com </a></p>
                    <span>1 day ago</span>
                    <p><a href="#">Twitter</a>, may be the more visual platform for education group.</p>
                    <span>4 day ago</span>
                </div>
                <div class="col-md-4 footer-grid">
                    <h5>Follow Us</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in purus nibh. Donec ornare felis neque. Nullam tortor! </p>
                    
            <div class="social-icons footer-social-icons">
                <a class="facebook" href="#"></a>
                <a class="twitter" href="#"></a>
                <a class="google-plus" href="#"></a>
            </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="copyrights text-center">
                    <p>Copyright &copy; 2015.Company name All rights reserved.More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a></p>                   
                </div>
                <div class="footer-nav">
                    <ul>
                        <li><a href="index">Home <span class="sr-only">(current)</span></a></li>
                        <li><a href="about">ABOUT</a></li>
                        <li><a href="typography">Short codes</a></li>
                        <li><a href="gallery">GALLERY</a></li>
                        <li><a href="blog">Blog</a></li>
                        <li><a href="contact">Contact Us</a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php $this->endBody()?>
</body>
<!--  /Body -->
</html>
<?php $this->endPage()?>

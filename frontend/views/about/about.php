<?php

use yii\helpers\Html;
$css=<<<EOF

EOF;
$this->registerCss($css);

$js = <<<EOF
EOF;
$this->registerJs($js, $this::POS_END);

?>
<div class="content">
    <div class="about-section">
        <div class="about">
            <div class="container">
                <div class="about-top heading">
                    <h2 class="heading text-center">ABOUT US</h2>
                </div>
                <div class="about-bottom text-center">
                    <img src="/img/home/abt.jpg" alt="" />
                    <h4>Sed hendrerit dui eget lacus imperdiet lacinia. Sed eleifend, libero ac pellentesque ornare, velit velit tempor nisi, quis cursus dolor velit condimentum elit.</h4>
                    <p>Duis semper sodales dictum. Praesent facilisis dui a viverra fringilla. Cras nisi felis, sollicitudin non bibendum iaculis, tincidunt id erat. Morbi tincidunt erat tellus, ut rhoncus sem malesuada et. Duis vitae auctor arcu. Aenean in tellus ac quam maximus dignissim. Vivamus dapibus eget mi ut consectetur. Donec risus nunc, pulvinar eu viverra vitae, placerat at nisi. Duis a mollis enim. Pellentesque sollicitudin dignissim ex, sit amet ornare dui fringilla eu.</p>
                </div>
            </div>
        </div>
        <div class="about-middle">
            <div class="container">
                <div class="col-lg-4 col-md-6 col-sm-6 testimonials">
                    <h3>Why choose us?</h3>
                    <ul class="list3">
                        <li>
                            <strong>1</strong>
                            <div class="extra">
                                <p>Cras sagittis tempus ante Curabitur pretium tortor non rhoncus eros orci, ac commodo per, et pret.</p>
                            </div>
                        </li>
                        <li>
                            <strong>2</strong>
                            <div class="extra">
                                <p>Nam pulvinar tellus vel Morbi quam enim, elementum leo maximus, vitae fermentum nunc ultricies.</p>
                            </div>
                        </li>
                        <li>
                            <strong>3</strong>
                            <div class="extra">
                                <p>Asety kertya asetli nerafae Proin malesuada porta diam ut ante accumsan, ultricies velit ut, mollis metus.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 testimonials">
                    <h3>Special offers</h3>
                    <h4>veriti vitaesaert asrtya aset aplica</h4>
                    <p>Quisque accumsan nulla et velit ullamcortionem ullam corporis suscipit laboriosam, nisi ut aliquid ex.</p>
                    <ul class="list1-2">
                        <li><a href="#">Proin dictum elementum velit</a></li>
                        <li><a href="#">Euismod conseqat ante</a></li>
                        <li><a href="#">Lorem ipsum dolor sit met con</a></li>
                        <li><a href="#">Adipiscing elitlentesque sed dolor</a></li>
                        <li><a href="#">Aliquam congue fermen tum nisl</a></li>
                        <li><a href="#">Mauris accumsan nulla</a></li>
                        <li><a href="#">Sed in lacus ut enim adipiscing</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 testimonials-box testimonials">
                    <h3>Testimonials</h3>
                    <ul class="list4">
                        <li>
                            <img src="/img/home/quote.png" alt="">
                            <div class="extra">
                                <p>Vestibulum porttitor placerat urna vitae condimentum. Proin consequat Morbi lacinia ipsum ac mi dictum, ac congue odio faucibus. Nam ut pellentesque neque. </p>
                                <a href="#">Maria Brooks, usa</a>
                            </div>
                        </li>
                        <li>
                            <img src="/img/home/quote.png" alt="">
                            <div class="extra">
                                <p>Vestibulum porttitor placerat urna vitae condimentum. Proin consequat Morbi lacinia ipsum ac mi dictum, ac congue odio faucibus. Nam ut pellentesque neque. </p>
                                <a href="#">Steven Donovan, usa</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Our-staff-starts -->
        <div class="our-staff about-staff">
            <div class="container">
                <div class="our-staff-head text-center">
                    <header>
                        <h3>Our Staff</h3>
                        <p>Lorem Ipsum is simply dummy Business industry doloremque laudantium.</p>
                    </header>
                    <div class="our-staff-grids text-center">
                        <div class="col-md-3 our-staff-grid">
                            <div class="view view-seventh">
                                <a href="#"><img class="img-responsive" src="/img/home/s1.jpg" alt=""></a>
                                <div class="mask">
                                    <ul class="staff-social-icons">
                                        <li><a href="#"><span class="facebook"> </span></a></li>
                                        <li><a href="#"><span class="twitter"> </span></a></li>
                                    </ul>
                                </div>
                                <h4>Doris Wilson</h4>
                                <p>Sed ut perspiciatis unde omnis iste natus laudantium.</p>
                            </div>
                        </div>
                        <div class="col-md-3 our-staff-grid">
                            <div class="view view-seventh">
                                <a href="#"><img class="img-responsive" src="/img/home/s2.jpg" alt=""></a>
                                <div class="mask">
                                    <ul class="staff-social-icons">
                                        <li><a href="#"><span class="facebook"> </span></a></li>
                                        <li><a href="#"><span class="twitter"> </span></a></li>
                                    </ul>
                                </div>
                                <h4>Amy Smith</h4>
                                <p>Sed ut perspiciatis unde omnis iste natus error laudantium.</p>
                            </div>
                        </div>
                        <div class="col-md-3 our-staff-grid">
                            <div class="view view-seventh">
                                <a href="#"><img class="img-responsive" src="/img/home/s3.jpg" alt=""></a>
                                <div class="mask">
                                    <ul class="staff-social-icons">
                                        <li><a href="#"><span class="facebook"> </span></a></li>
                                        <li><a href="#"><span class="twitter"> </span></a></li>
                                    </ul>
                                </div>
                                <h4>Edna Francis</h4>
                                <p>Sed ut perspiciatis unde omnis accusantium laudantium.</p>
                            </div>
                        </div>
                        <div class="col-md-3 our-staff-grid">
                            <div class="view view-seventh">
                                <a href="#"><img class="img-responsive" src="/img/home/s4.jpg" alt=""></a>
                                <div class="mask">
                                    <ul class="staff-social-icons">
                                        <li><a href="#"><span class="facebook"> </span></a></li>
                                        <li><a href="#"><span class="twitter"> </span></a></li>
                                    </ul>
                                </div>
                                <h4>Jennie Crigler</h4>
                                <p>Sed ut sit voluptatem accusantium doloremque laudantium.</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- //Our-staff-ends -->
    </div>
</div>
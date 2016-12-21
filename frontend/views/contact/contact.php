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
	<!--contact-->
	<div class="contact-section">
		<div class="container">
			<h2 class="heading text-center">Contact Us</h2>
			<div class="contact-main">
				<div class="col-md-6 contact-grid">
					<form>
						<p class="your-para">Your Name:</p>
						<input type="text" value="" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='';}">
						<p class="your-para">Your Mail:</p>
						<input type="text" value="" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='';}">
						<p class="your-para">Your Message:</p>
						<textarea cols="77" rows="6" onfocus="this.value='';" onblur="if (this.value == '') {this.value = '';}"></textarea>
						<div class="send">
							<input type="submit" value="Send" >
						</div>
					</form>
				</div>
				<div class="col-md-6 contact-in">
					<p class="sed-para"> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolor.</p>
					<p class="para1">Lorem ipsum dolor sit amet. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.  </p>
					<div class="more-address"> 
						<address>
							<strong>Twitter, Inc.</strong><br>
							795 Folsom Ave, Suite 600<br>
							San Francisco, CA 94107<br>
							<abbr title="Phone">P:</abbr> (123) 456-7890
						</address>
						<address>
							<strong>Full Name</strong><br>
							<a href="mailto:info@example.com">mail@example.com</a>
						</address>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<h3 class="text-center find">Find Us Here</h3>
			<div class="map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6632.248000703498!2d151.265683!3d-33.7832959!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12abc7edcbeb07%3A0x5017d681632bfc0!2sManly+Vale+NSW+2093%2C+Australia!5e0!3m2!1sen!2sin!4v1433329298259" style="border:0"></iframe>
			</div>
		</div>
	</div>
	<!--//contact-->

</div>
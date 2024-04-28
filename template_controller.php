<?PHP
// class to handle website template
// Copyrights (c) DCO CONSULTANTS
// By Okechukwu Nnamdi 08058523427...
class template
{
	var $body_id;
	var $title;
	var $dynamicopt, $tab_id;
	var $page_description;
    var $keywords;
	
	function template($body_id = '')
	{
		$this->body_id = $body_id;
		$this->dynamicopt = false;
		$this->tab_func = false;
		
	}
	
	function print_header()
	{
	?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?PHP echo $this->title  ?> - App Heroes </title>
            <!-- Favicon Icon -->
            <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
            <link rel="stylesheet" href="assets/webfonts/clash_display/css/clash-display.css">
			<!-- Bootstrap css -->
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="assets/css/fontAwesome-min.css">
            <!-- Style css -->
            <link rel="stylesheet" href="assets/css/style.css">
            <!-- Responsive Css -->
            <link rel="stylesheet" href="assets/css/responsive.css">

            <script src="assets/js/pristine.min.js"  type="text/javascript"></script>
        </head>
        <body>
        <!-- BEGIN: Header Area -->
        <header class="headerArea">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="headerItem">
                            <div class="headeLogo">
                                <a href="index.html"><img src="assets/images/ah2.png" alt="Heroes"></a>
                            </div>
                            <nav class="mainMenu">
                                <ul>
                                    
                                    <li><a href="ui-ux-design-course.html">App-cademy</a></li>
                                    <li><a href="business-solutions.html">Business Solutions</a></li>
									<li><a href="co-working.html">Co-working</a></li>
                                    <li><a href="about.html">About us</a></li>
                                    <li><a href="sign-up.html" class="appBtn01">Sign-up</a></li>
                                </ul>
                            </nav>
                            <div class="togglerBtn">
                                <button><img src="assets/images/bars.png" alt="Heroes"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile_menu">
                <div class="container">
                    <nav>
                        <ul>
                            <li><a href="co-working.html">Co-working</a></li>
                            <li><a href="programs-ui-ux-design.html">App-cademy</a></li>
                            <li><a href="#">Incubator</a></li>
                            <li><a href="about.html">Vision</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <!-- END: Header Area -->


        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-5HKNTBF5CR"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-5HKNTBF5CR');
        </script>

			
		<?PHP
			
		}

	
	
	function print_footer(){
	?>
        <!-- BEGIN: Footer Area -->
        <footer class="footerArea">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <widget class="footerWidget">
                            <h4 class="widget_title">Products</h4>
                            <ul>
                                <li><a href="co-working.html">Co-working</a></li>
                                <li><a href="ui-ux-design-course.html;">App-cademy</a></li>
                                <li><a href="#">Incubator</a></li>
                            </ul>
                        </widget>
                    </div>
                    <div class="col-lg-2">
                        <widget class="footerWidget">
                            <h4 class="widget_title">Information</h4>
                            <ul>
                                <li><a href="contact-us.html">Contact us</a></li>
                                <li><a href="about.html">About us</a></li>
                            </ul>
                        </widget>
                    </div>
                    <div class="col-lg-5">
                        <widget class="footerWidget">
                            <h4 class="widget_title">Our Location</h4>
                            <p>3rd floor Garnet plaza, km 15 Lekki Epe express way, Beside Igbo-efon  bustop</p>
                        </widget>
						
						<widget class="footerWidget" >
							<div style="font-size: 12px; margin-top:50px">- Payments Secured by Paystack -</div>
							<img src="assets/images/pay-stack-inverted.png" style="width: 250px" />
						</widget>
                    </div>
                    <div class="col-lg-3">
                        <widget class="footerSocial">
                            <div class="widget_title">
                                <img src="assets/images/ah-logo-Inverted.png" >

                            </div>
                            <div class="ab_social">
                                <a href="https://twitter.com/AppHero_es"><i class="fa-brands fa-twitter"></i></a>
                                <a href="javascript:void(0);"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com/appheroes_"><i class="fa-brands fa-instagram"></i></a>
                            </div>
                        </widget>
                    </div>
                </div>
                <div class="copyright">
                    <p>Copyrights &copy; 2022, all rights reserved</p>
                </div>
            </div>
            <div class="footerShap">
                <img class="fShap01" src="assets/images/footer-shap01.png" alt="Heroes">
                <img class="fShap02" src="assets/images/footer-shap02.png" alt="Heroes">
            </div>
        </footer>
        <!-- END: Footer Area -->
        <!-- Js Fils -->
        <script src="assets/js/jquery-3.6.0.js"></script>
        <script src="assets/js/script.js"></script>

        </body>
        </html>
	<?PHP
	}
	
}
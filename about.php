<?php
/**
 * Created by PhpStorm.
 * User: nnamd
 * Date: 30/03/2023
 * Time: 14:33
 */

include 'template_controller.php';

$mytemplate = new template();
$mytemplate->title = "About us ";
$mytemplate->print_header();

?>

    <!-- BEGIN: Banner Section -->
    <section class="bannerSection bannerSection03 bannerSectionAboutus">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bannerContent mtb50">
                        <h4> Our Mantra</h4>
                        <h2>Do Good  with Code</h2>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="bannerImg bannerImg02">
                        <!--<img src="assets/images/banner-img01.png" alt="Heroes">-->
                        <img src="assets/images/control-man.png" alt="Heroes">
                    </div>
                </div>
            </div>
        </div>
        <div class="bannerShape bannerShape02">
            <img class="shape01" src="assets/images/shape/Vector01.png" alt="Heroes">
            <!--<img class="shape02" src="assets/images/shape/vector02.png" alt="Heroes">-->
        </div>
    </section>
    <!-- END: Banner Section -->

    <!-- BEGIN: About Section -->
    <section class="aboutSec02">
        <div class="container">
            <div class="aboutItems02">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="aboutCaption02">
                            <h4 class="subTtle">Our Vision</h4>
                            <h2 class="secTitle">About us</h2>
                            <p>
                            App heroes is a technology innovation center for young Nigerians. Our vision is to provide education in technology and promote collaboration to foster economic growth in Africa.
                            </p>

                            <p>
                            We are building a community of App heroes who are gifted in their specialization, Think of us as the justice league of technology engineering in Africa.</p>

                            <p>We gather the best minds and use our collective powers for good, building solutions / platforms that foster economic success for all.</p>

                           <!-- <a class="appBtn01" href="javascript:void(0);">Learn More</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: About Section -->


<?PHP

$mytemplate->print_footer();

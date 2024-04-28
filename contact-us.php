<?php
/**
 * Created by PhpStorm.
 * User: nnamd
 * Date: 30/03/2023
 * Time: 14:33
 */

include 'template_controller.php';

$mytemplate = new template();
$mytemplate->title = "Contact us ";
$mytemplate->print_header();

?>

    <!-- BEGIN: Banner Section -->
   <!-- <section class="bannerSection bannerSection03 bannerSectionAboutus">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bannerContent mtb50">
                        <h4></h4>
                        <h2>Contact us</h2>
                    </div>
                </div>
                <!--<div class="col-lg-12">
                    <div class="bannerImg bannerImg02">
                        <!--<img src="assets/images/banner-img01.png" alt="Heroes">->
                        <img src="assets/images/control-man.png" alt="Heroes">
                    </div>
                </div>->
            </div>
        </div>
        <div class="bannerShape bannerShape02">
            <img class="shape01" src="assets/images/shape/Vector01.png" alt="Heroes">
            <!--<img class="shape02" src="assets/images/shape/vector02.png" alt="Heroes">->
        </div>
    </section>-->
    <!-- END: Banner Section -->

    <!-- BEGIN: About Section -->
    <section class="contactusSec02">
        <div class="container">
            <div class="aboutItems02">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="aboutCaption02">
                            <h4 class="subTtle">contact us</h4>
                            <h2 class="secTitle">How to find us</h2>

                            <h5>Address</h5>
                            <p>
                                3rd Floor Garnet Plaza, Km 17 Lekki Epe expressway, Lekki, Lagos.

                                <br/> Beside Igboefon bus-stop


                            </p>

                            <h5>Email</h5>
                            <p>Hello@apphero.es<br/>


                            </p>




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

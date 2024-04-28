<?php
/**
 * Created by PhpStorm.
 * User: nnamd
 * Date: 30/03/2023
 * Time: 14:33
 */

include 'template_controller.php';

$mytemplate = new template();

$mytemplate->print_header();

?>

    <!-- BEGIN: Banner Section -->
    <section class="bannerSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bannerImg">
                        <img src="assets/images/banner-img02.png" alt="Heroes">
                    </div>
                </div>
                <div class="col-lg-6 bcOrder">
                    <div class="bannerContent bannerContent02 bannerNopadding">
                        <h4>App-cademy</h4>
                        <h2>Front end Development</h2>
                        <p>An innovation center for young Africans offering co-working, Training and Start-up incubation</p>
                        <div class="banner_btnPrice">
                            <a class="appBtn01" href="javascript:void(0);">Signup Now</a>
                            <div class="bannerNumber">
                                <p>Program Fee</p>
                                <h2>N 240,000</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bannerShape bannerShape02 bs05">
            <img class="shape01" src="assets/images/shape/Vector01.png" alt="Heroes">
            <img class="shape02" src="assets/images/shape/vector02.png" alt="Heroes">
            <img class="shape03" src="assets/images/shape/Vector03.png" alt="Heroes">
        </div>
    </section>
    <!-- END: Banner Section -->

    <!-- BEGIN: Icon Box Sec -->
    <section class="iconBoxSec">
        <div class="container">
            <div class="iconBox_items">
                <div class="iconBox01">
                    <img src="assets/images/icon/stopwatch.png" alt="Heroes">
                    <h4>6 weeks <br> Duration</h4>
                </div>
                <div class="iconBox01">
                    <img src="assets/images/icon/globe-earth.png" alt="Heroes">
                    <h4>Online & <br> Inperson</h4>
                </div>
                <div class="iconBox01">
                    <img src="assets/images/icon/blackboard.png" alt="Heroes">
                    <h4>Experienced <br> Instructors</h4>
                </div>
                <div class="iconBox01">
                    <img src="assets/images/icon/certificate.png" alt="Heroes">
                    <h4>Certificate</h4>
                </div>
                <div class="iconBox01">
                    <img src="assets/images/icon/tie.png" alt="Heroes">
                    <h4>Job Placement</h4>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Icon Box01 -->

    <!-- BEGIN: Feature Section -->
    <section class="featureSection">
        <div class="container">
            <div class="featureItems featureItems02">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="featureContent">
                            <h4 class="subTtle">App-Cademy</h4>
                            <h2 class="secTitle">User Interface <br> Development</h2>
                            <p>This course will help you unleash you inner creative powers to build top notch customer experiences. This 6 weeks course will give you the skills to become a top notch developer</p>
                            <div class="featureItem02">
                                <h3>Benefits / Perks</h3>
                                <div class="featureSingle01">
                                    <h4>Job After Completion</h4>
                                    <p>After course completion, you get an instant job with our partners or get assigned to work on a project in-house. You will be building your CV instantly.</p>
                                </div>
                                <div class="featureSingle01">
                                    <h4>Access to ultra modern co-working space</h4>
                                    <p>After course completion, you get an instant job with our partners or get assigned to work on a project in-house. You will be building your CV instantly.</p>
                                </div>
                                <div class="featureSingle01">
                                    <h4>Hands on training with Experienced Tutors</h4>
                                    <p>After course completion, you get an instant job with our partners or get assigned to work on a project in-house. You will be building your CV instantly.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="featureImg featureNopadding">
                            <img src="assets/images/rectangle.png" alt="Heroes">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Feature Section -->

    <!-- BEGIN: Feature Section -->
    <section class="featureSection featureSection03 fs04">
        <div class="container">
            <div class="featureItems featureItems03">
                <div class="row">
                    <div class="col-md-7">
                        <div class="featureContent">
                            <h4 class="subTtle">Syllabus</h4>
                            <h2 class="secTitle">What you will <br> Learn?</h2>
                            <ul class="featureList">
                                <li>Introduction to UI/UX Design</li>
                                <li>User Research and Personas</li>
                                <li>Vistual Design and UI Elements</li>
                                <li>Information Architecture and Wireframing</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <ul class="featureList featureList03">
                            <li>Introduction to UI/UX Design</li>
                            <li>Usability Testing and User Feedback</li>
                            <li>Final Project</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Feature Section -->


<?PHP

$mytemplate->print_footer();

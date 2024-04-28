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
                        <img style="height:1100px" src="assets/images/banner-img02HD.png" alt="Heroes">
                    </div>
                </div>
                <div class="col-lg-6 bcOrder">
                    <div class="bannerContent bannerContent02 bannerNopadding">
                        <h4>Incubator</h4>
                        <h2>See what we are <br> building</h2>
                        <p>Our Tech Heroes are on a mission to save the world see the products we are building. come back to view </p>
                        <div class="banner_btnPrice">
                            <a class="appBtn01" href="sign-up.php">Signup Now</a>
                            <!--<div class="bannerNumber">
                                <p>Program Fee</p>
                                <h2>N 140,000</h2>
                            </div>-->
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



    <!-- BEGIN: Feature Section -->
    <section class="featureSection">
        <div class="container">
            <div class="featureItems featureItems02">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="featureContent">
                            <h4 class="subTtle">App-Cademy</h4>
                            <h2 class="secTitle">User Interface <br> Development</h2>
                            <p>This course will help you discover creative powers to build top notch customer experiences. This 6 weeks program will equip you with the skills to become employment ready.</p>
                            <div class="featureItem02">
                                <h3>Benefits / Perks</h3>
                                <div class="featureSingle01">
                                    <h4>Job After Completion</h4>
                                    <p>Start building your CV immediately. We will assign you to handle tasks or a job role with our partners..</p>
                                </div>
                                <div class="featureSingle01">
                                    <h4>Access to ultra modern co-working space</h4>
                                    <p>Learn in our modern facility and take advantage of our co-working spaces to do further research / self development.</p>
                                </div>
                                <div class="featureSingle01">
                                    <h4>Hands on training with Experienced Tutors</h4>
                                    <p>Get trained by industry veterans with years experience working with top tech brands.</p>
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

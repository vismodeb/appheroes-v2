<?php
/**
 * Created by PhpStorm.
 * User: nnamd
 * Date: 30/03/2023
 * Time: 14:33
 */

include 'template_controller.php';

$mytemplate = new template();
$mytemplate->title = "User Interface Design Course ";
$mytemplate->print_header();

?>

    <!-- BEGIN: Banner Section -->
    <section class="bannerSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bannerImg">
                        <img style="height:1100px" src="assets/images/female-app-hero.png" alt="Heroes">
                    </div>

                    <div class="bannerImgMob">
                        <img src="assets/images/female-app-hero.png" alt="AppHeroes">
                    </div>

                </div>
                <div class="col-lg-6 bcOrder">
                    <div class="bannerContent bannerContent02 bannerNopadding">
                        <h4>App-cademy</h4>
                        <h2>UI/UX Design and <br> Prototyping</h2>
                        <p>This course will help you discover your creative powers to build top notch customer experiences, and kickstart your career in tech. </p>
                        <div class="banner_btnPrice">
                            <a class="appBtn01" href="sign-up.php">Signup Now</a>
                            <div class="bannerNumber">
                                <p>Starting from <s>N 140,000 </s></p>
                                <h2>N 84,000</h2>
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
                    <h4>8 weeks <br> Duration</h4>
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
                    <h4>Internship</h4>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Icon Box01 -->

    

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
                                <li>Visual Design Basics</li>
                                <li>UI Design Principles & Concepts</li>
                                <li>User Research and Personas</li>
                                <li>Design Documentation</li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <ul class="featureList featureList03">
                            <li>High Fidelity Design with Figma</li>
                            <li>Mobile Design/Web Design</li>
                            <li>Prototyping</li>
                            <li>Launching your UI/UX Career (Portfolio, Social Profile etc.)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Feature Section -->










<?PHP

$mytemplate->print_footer();

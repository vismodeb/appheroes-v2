<?php
/**
 * Created by PhpStorm.
 * User: nnamd
 * Date: 30/03/2023
 * Time: 14:33
 */

include 'template_controller.php';

$mytemplate = new template();
$mytemplate->title = "Coworking Space ";
$mytemplate->print_header();

?>

    <!-- BEGIN: Banner Section -->
    <section class="bannerSection bannerSection03 bannerSection05">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bannerContent">
                        <h4>Co-working</h4>
                        <h2>Work, Relax <br> Launch Product</h2>
                        <p>A Modern office environment that will enable you stay productive and beat those milestones.</p>
                        <div class = "banner_btnPrice">
                        <a class="appBtn01" href="sign-up.html">Signup Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bannerImg">
                        <img class="imgBorder" src="assets/images/co-working-space-lagos-app-heroes-4.jpg" alt="Heroes">
                    </div>
                </div>
            </div>
        </div>
        <div class="bannerShape bannerShape02">
            <img class="shape01" src="assets/images/shape/Vector01.png" alt="Heroes">
            <img class="shape02" src="assets/images/shape/vector02.png" alt="Heroes">
        </div>
    </section>
    <!-- END: Banner Section -->

    <!-- GEGIN: Postes Sec -->
    <section class="postesSec">
        <div class="container">
            <div class="postesItems">
                <div class="postestSingle">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="postestImg">
                                <img src="assets/images/co-working-space-lagos-app-heroes-5.jpg" alt="Heroes">
                            </div>
                        </div>
                        <div class="col-lg-6 postOrder1">
                            <div class="postestContent">
                                <h3>Modern <br> working Space</h3>
                                <p>Fully Air-conditioned Modern working space when you need to put your head down and just work</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="postestSingle reverse">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="postestContent">
                                <h3>Work in a relaxed space</h3>
                                <p>Relax and kick back on our bean bags when you want to work in a chill mode.</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="postestImg">
                                <img src="assets/images/co-working-space-lagos-app-heroes-2.jpg" alt="Heroes">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="postestSingle">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="postestImg">
                                <img src="assets/images/co-working-space-lagos-app-heroes-4.jpg" alt="Heroes">
                            </div>
                        </div>
                        <div class="col-lg-6 postOrder1">
                            <div class="postestContent">
                                <h3>Meetings / Trainings</h3>
                                <p>Take advantage of our functional training / Meeting rooms </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Postes Sec -->

    <!-- BEGIN: Pricing Sec -->
    <section class="pricingSec">
        <div class="container">
            <h3 class="secPrice">Plans</h3>
            <div class="row">
                <div class="col-lg-4">
                    <div class="singlePrice">
                        <h4>Full Access</h4>
                        <p>Get full access to the co-working space, and meeting rooms</p>
                        <h2>N 30,000</h2>
                        <a class="appBtn01" href="sign-up.html">Signup Now</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="singlePrice">
                        <h4>Basic Plan</h4>
                        <p>Access the co-working space 3 times a weeks</p>
                        <h2>N 20,000</h2>
                        <a class="appBtn01" href="sign-up.html">Signup Now</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="singlePrice">
                        <h4>Daily Access</h4>
                        <p>Access the co-working space for a day</p>
                        <h2>N 2,500</h2>
                        <a class="appBtn01" href="sign-up.html">Signup Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Pricing Sec -->


<?PHP

$mytemplate->print_footer();

<?php
/**
 * Created by PhpStorm.
 * User: nnamd
 * Date: 30/03/2023
 * Time: 14:33
 */

include 'template_controller.php';

$mytemplate = new template();
$mytemplate->title = " Innovation Center for young folks in Nigeria ";
$mytemplate->print_header();

?>

    <!-- BEGIN: Banner Section -->
       <section class="bannerSection" id = "bannerSectionIndex">
          <div class="container-fluid">
             <div class="row">
                <div class="col-lg-6">
                   <div class="bannerImg">

                        <!-- <div class = ""> </div> -->
                        <img src="assets/images/male-hero.png" alt="AppHeroes">

                   </div>
                   <div class="bannerImgMob">
                         <img src="assets/images/banner-index-image.png" alt="AppHeroes">
                   </div>
                </div>
                <div class="col-lg-6 bcOrder">
                   <div class="bannerContent">
                      <h4>The power to create</h4>
                      <h2>is Inside you</h2>
                      <p>An innovation center for young Africans offering co-working, Software Training and Start-up incubation</p>
                      <div class = "banner_btnPrice">
                        <a class="appBtn01" href="sign-up.html">Select Program</a>
                      </div>

                   </div>
                </div>
             </div>
          </div>
          <div class="bannerShape">
             <img class="shape01" src="assets/images/shape/Vector01.png" alt="Heroes">
             <img class="shape02" src="assets/images/shape/vector02.png" alt="Heroes">
             <img class="shape03" src="assets/images/shape/Vector03.png" alt="Heroes">
          </div>
       </section>
       <!-- END: Banner Section -->

       <!-- BEGIN: Cta Section -->
       <section class="ctaSection01">
          <div class="container">
             <div class="ctaItem01">
                <div class="row">
                   <div class="col-lg-4">
                      <div class="singleCta01" id = "cowork-banner">
                         <h3>Co-working</h3>
                         <p>Condusive coworking space</p>
                      </div>
                   </div>
                   <div class="col-lg-4">
                      <div class="singleCta01" id = "appcademy-banner">
                         <h3>App-cademy</h3>
                         <p>Code school to train budding app hereos </p>
                      </div>
                   </div>
                   <div class="col-lg-4" >
                      <div class="singleCta01" id = "incubator-banner">
                         <h3>Incubator</h3>
                         <p>Teams saving the world one startup at a time. </p>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </section>
       <!-- END: Cta Section -->

       <!-- BEGIN: Feature Section -->
       <section class="featureSection">
          <div class="container">
             <div class="featureItems">
                <div class="row">
                   <div class="col-lg-7">
                      <div class="featureContent">
                         <h4 class="subTtle">App-cademy</h4>
                         <h2 class="secTitle">Get the Super powers you need to Excel</h2>
                         <p>This course will help you unleash you inner creative powers to build top notch customer experiences. This 8 weeks course will give you the skills to employment ready in 3 months</p>
                         <!--<ul class="featureList">
                            <li>Hand’s on Training</li>
                            <li>Fantastic Learning Enviroment</li>
                            <li>Job after completion of Program</li>
                            <li>Experienced Instructors</li>
                            <li>Final Project</li>
                            
                            <li>Super fast Internet</li>
                            
                         </ul>-->
                         <a class="appBtn01" href="ui-ux-design-course.html">Learn More</a>
                      </div>
                   </div>
                   <div class="col-lg-5">
                      <div class="featureImg">
                         <img src="assets/images/app-heroes-ui-uix-figma-girl.png" alt="Heroes">
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </section>
       <!-- END: Feature Section -->



	<!-- BEGIN: Feature Section -->
       <section class="BSSection">
          <div class="container">
             <div class="featureItems">
                <div class="row">
                   <div class="col-lg-5">
                      <div class="featureImg">
                         <img src="assets/images/ui-ux-tools.png" alt="Heroes">
                      </div>
                   </div>
                   <div class="col-lg-7">
					   <div class="featureContent">
                         <h4 class="subTtle">Business Solutions</h4>
                         <h2 class="secTitle">Technology Products that simply work</h2>
                         <p>This course will help you unleash you inner creative powers to build top notch customer experiences. This 8 weeks course will give you the skills to employment ready in 3 months</p>
                         <!--<ul class="featureList">
                            <li>Hand’s on Training</li>
                            <li>Fantastic Learning Enviroment</li>
                            <li>Job after completion of Program</li>
                            <li>Experienced Instructors</li>
                            <li>Final Project</li>
                            
                            <li>Super fast Internet</li>
                            
                         </ul>-->
                         <a class="appBtn01" href="ui-ux-design-course.html">Learn More</a>
                      </div>
                      
                   </div>
                </div>
             </div>
          </div>
       </section>
       <!-- END: Feature Section -->


		
		<!-- BEGIN: Feature Section -->
       <section class="workPlaceSec">
          <div class="container">
             <div class="featureItems">
                <div class="row">
                   <div class="col-lg-7">
                      <div class="featureContent">
                         <h4 class="subTtle">Work Space</h4>
                   <h2 class="secTitle">Co-working <br> built for tech heroes</h2>
                   <p class="workPera">A Modern office environment that will enable you stay productive and reach those milestones.</p>
                         <!--<ul class="featureList">
                            <li>Hand’s on Training</li>
                            <li>Fantastic Learning Enviroment</li>
                            <li>Job after completion of Program</li>
                            <li>Experienced Instructors</li>
                            <li>Final Project</li>
                            
                            <li>Super fast Internet</li>
                            
                         </ul>-->
                         <a class="appBtn01" href="ui-ux-design-course.html">Learn More</a>
                      </div>
                   </div>
                   <div class="col-lg-5">
                      <div class="featureImg">
                        <div class="container">
						  	<div class="row">
								<img src="assets/images/co-working-space-lagos-app-heroes-4.jpg" alt="Heroes">
							</div>
							<div class="row">
								<div class="col-lg-6"> <img src="assets/images/co-working-space-lagos-app-heroes-2.jpg" alt="Heroes"> </div>
								<div class="col-lg-6"> <img src="assets/images/co-working-space-lagos-app-heroes-3.jpg" alt="Heroes"> </div>
							</div>
							
							<div class="text-center work_leftBtn">
								<a class="appBtn01" href="co-working.html">Learn More</a>
							 </div>
						  
						  </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </section>
       <!-- END: Feature Section -->




<?PHP

$mytemplate->print_footer();

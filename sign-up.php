<?php
/**
 * Created by PhpStorm.
 * User: nnamd
 * Date: 30/03/2023
 * Time: 14:33
 */
session_start();
include 'config.php';
include 'common.php';
include 'lib/dbfunctions.php';
include 'lib/post_controller.php';



if(!empty($_POST['full_name'])){

//    $valid = new post_validator();
//    $valid->table_name = '';
//    $valid->validation_type[7] = 2;
//    $valid->fields = array('name', 'business_desc', 'email', 'phone_number1', 'address', 'city', 'state', 'sbundle', 'agreement'  );
//    $valid->failure_reason = array("Please enter your name",
//        "Please enter a description for your business ",
//        "Please enter your email",
//        "Please enter your phone number",
//        "Please enter your address",
//        "Please enter your City",
//        "Please enter your State",
//        "Please select a bundle to purchase",
//        "You much check the agreement box to proceed"
//    );
//    $valid->validate($_SERVER['HTTP_REFERER']);

    //insert into dB..
    $mypost = new post_controller();
    $mypost->table_name = 'requests';
    //$mypost->debug_post = true;
    $mypost->primary_key = 'id';
    $mypost->table_fields_ext = array( 'date_created' => locTime() );
    $mypost->table_fields =  array('full_name', 'address', 'state', 'email', 'phone', 'sex', 'product_code' , 'date_created' );
    //$mypost->debug_post = true;
    $mypost->post_handler();

    $_SESSION['product_code'] = $_POST['product_code'];
    $_SESSION['full_name'] = $_POST['full_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['request_id'] = $mypost->insert_id();

    if($product_code == 'uio'){
        $product = 'UI/UX Design Course (online)';
        $price = 84000;
    }else if($product_code == 'uii'){
        $product = 'UI/UX Design Course (In-person)';
        $price = 140000;
    }else if($product_code == 'uim'){
        $product = 'UI Design Course (online)';
        $price = 50000;
    }else if($product_code == 'cw1'){
        $product = 'Coworking Full Access ';
        $price = 30000;
    }else if($product_code == 'cw2'){
        $product = 'Coworking  Basic ';
        $price = 30000;
    }else if($product_code == 'cw3'){
        $product = 'Coworking  Daily Access ';
        $price = 2500;
    }

    $price = comma_value($price);

    $msg = "
 
Dear {$_POST['full_name']},

Thank you for applying for the {$product}. Complete payment to secure your position immediately.

If you where unable to complete payment using Paystack make payment into our bank account and reply to this email with payment details.

Amount : {$price}

Account Name : Bamboo Internet Media
Bank : GT bank
Account Number : 0344531913

Appheroes is a Tech community powering collaboration and innovation in the Nigerian ecosystem. Our vision is to empower young Nigerians with the skills to solve economic problems and become financially free.

In other words we give you the super powers to accomplish amazing fits.

Warm Regards.
AppHeroes Team
https://www.apphero.es    
    ";

    mail($_POST['email'], 'Thank you for Signing up for our Service', $msg, 'From: Hello@apphero.es');
	
	
	
	
	//send notification to us..
	mail("hello@apphero.es", 'New Sign-up via online request form', 'New Sign-up via online request form', 'From: Hello@apphero.es');
	

    // 'request_id >> '.$mypost->insert_id();

    header('location:sign-up-complete.html');
    exit;
}

include 'template_controller.php';
$mytemplate = new template();
$mytemplate->print_header();

?>

    <!-- BEGIN: Banner Section ->
    <section class="bannerSection bannerSection03">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bannerContent signupBanner">
                        <h2>Join the  App-cademy</h2>
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

    <!-- BEGIN: Contact Sec -->
    <section class="contactSec">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="formArea">
                        <h4 class="subTtle">Registration Form</h4>
                        <h2>Request our Service</h2>
                        <script type="text/javascript">
                            window.onload = function () {

                                var form = document.getElementById("form1");
                                // create the pristine instance
                                var pristine = new Pristine(form);
                                form.addEventListener('submit', function (e) {
                                    e.preventDefault();
                                    valid = pristine.validate(); // returns true or false
                                    if(valid){
                                        //submit form.
                                        form.submit();
                                    }
                                });


                            };
                        </script>
                        <form action="sign-up.html" method="post" id="form1">

                            <div class="single_form form-group">
                                <label for="product_code">Select Service</label>
                                <select name="product_code" id="product_code" class="form-select select_program" aria-label="Default select example" required class="form-control">
                                    <option value=""> -- Select Program --</option>
                                    <option value="uim">UI Course (online) - NGN 50,000</option>
									<option value="uio">UI/UX Design Course (online) - NGN 84,000</option>
                                    <option value="uii">UI/UX Design Course (In-person) - NGN 140,000 </option>
                                    <option value="cw1">Coworking Full Access - NGN 30,000</option>
                                    <option value="cw2">Coworking  Basic -  NGN 25,000</option>
                                    <option value="cw3">Coworking Daily access - N 2,500</option>
                                    <!--<option value="">Front End Development - coming soon</option>
                                    <option value="">Back End Development - coming soon</option>-->

                                </select>
                            </div>

                            <div class="single_form form-group"  >
                                <label for="name">Full Name</label>
                                <input type="text" id="full_name" name="full_name" class="form-control" required >
                            </div>
                            <div class="single_form form-group">
                                <label for="name">Sex</label>
                                <select name="sex" id="sex" class="form-select" aria-label="Default select example" required class="form-control">
                                    <option value="" selected></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="single_form form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" required class="form-control" >
                            </div>
                            <div class="single_form form-group">
                                <label for="residing">State Residing in</label>
                                <input type="text" id="state" name="state" required class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="single_form form-group" >
                                        <label for="phone">Phone Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_form form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="single_form">
                                <label for="name">Training Type</label>
                                <select name="" id="" class="form-select select_program" aria-label="Default select example">
                                    <option value="">In Person  /   Online    /     Hybrid</option>
                                    <option value="In Person">In Person</option>
                                    <option value="Online">Online</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                            </div>
-->
                            <div class="submitBtn">
                                <input type="submit" class="appBtn01" value="Activate Powers">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="formImg">
                        <img src="assets/images/banner-img01.png" alt="Heroes">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Contact Sec -->


<?PHP

$mytemplate->print_footer();

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
include 'template_controller.php';

$mytemplate = new template();

$mytemplate->print_header();

if(isset($_GET['payment_ref'])){

    $mydb = new db();

    $request_id = $_SESSION['request_id'];
    $ref = $_GET['payment_ref'];
    //Confirm payments and update request record..

    //check if payment ref already validated.
    $sql = "select * from requests where payment_ref = '$ref' and payment_status = '1' ";
    $count = $mydb->num_rows($sql);
    if($count == 0){

        $url = 'https://api.paystack.co/transaction/verify/'.$ref;

        $headers = array( 'bearer: ');

        $response =  curl_get($url, $headers);

        $status = $response->data->status;
        $amount = $response->data->amount;

        if($status == 'success'){

            $sql = "update requests set payment_status = 1, payment_ref = '$ref', and amount = '$amount' where request_id = '$request_id'";
            $mydb->insert_data($sql);
        }

        // payment verified and account status updated..
    }else{
        error_log('Reuse of payment ref encoutered.');
    }

}

//determine product and price
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
                        <h4 class="subTtle">Payment Successful</h4>
                        <p> Thank you for signing up.. your request has been saved.</p>
                        <p>&nbsp;</p>



                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="formImg">
                        <!--<img src="assets/images/banner-img01.png" alt="Heroes">-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Contact Sec -->


<?PHP

$mytemplate->print_footer();

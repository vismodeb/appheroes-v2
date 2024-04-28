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

//determine product and price

$_SESSION['full_name'] = !isset($_SESSION['full_name']) ? 'John Doe' : $_SESSION['full_name'];
$product = 'UI/UX Design Course (online)';
$price = 180000;

@$product_code = $_SESSION['product_code'];
if($product_code == 'uio'){
    $product = 'UI/UX Design Course (online)';
    $price = 84000;
}else if($product_code == 'uii'){
    $product = 'UI/UX Design Course (In-person)';
    $price = 140000;
}else if($product_code == 'uim'){
    $product = 'UI Design Course (Online)';
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

$price_display = comma_value($price);
$price = $price * 100;
$payment_ref = 'APPH'.rand(1000, 9999).time();

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

    <script src="https://js.paystack.co/v1/inline.js"></script>

<script type="text/javascript">
//    var paymentForm = document.getElementById('paymentForm');
//    paymentForm.addEventListener('submit', payWithPaystack, false);
    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: 'pk_live_10d4fa5e8bb6aa0f7683f0e3d99eecabf6248e88', // Replace with your public key
            email: '<?PHP echo $_SESSION['email'] ?>',
            amount: <?PHP echo $price ?>, // the amount value is multiplied by 100 to convert to the lowest currency unit
            currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
            ref: '<?PHP echo $payment_ref ?>', // Replace with a reference you generated
            callback: function(response) {
                //this happens after the payment is completed successfully
                var reference = response.reference;
                //alert('Payment complete! Reference: ' + reference);
                window.location = 'payment_complete.php?payment_ref='+reference;
                // Make an AJAX call to your server with the reference to verify the transaction
            },
            onClose: function() {
                alert('Transaction was aborted');
            },
        });
        handler.openIframe();
    }
</script>
    <section class="contactSec">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="formArea">
                        <h4 class="subTtle">Make Payment</h4>
                        <p> Complete your Service Request by making a payment via Card or bank transfer.</p>
                        <p>&nbsp;</p>


                        <p>Full Name : <?PHP echo $_SESSION['full_name'] ?> </p>
                        <p>Product Requested : <?PHP echo $product ?> </p>
                        <p>Price: <?PHP echo $price_display ?> </p>

                        <div class = "banner_btnPrice">
                            <a class="appBtn01" href="javascript:;" onclick="payWithPaystack();">Pay Now</a>
                        </div>

                        <div style="margin-top: 40px; font-size: 18px">
                            payments powered by paystack <br/>

                            <img style="width:20%" src="assets/images/1200px-Paystack_Logo2.png" />
                        </div>
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

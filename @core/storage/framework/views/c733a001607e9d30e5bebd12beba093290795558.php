<html>
<head>
    <?php echo load_google_fonts(); ?>

    <?php echo render_favicon_by_id(get_static_option('site_favicon')); ?>

    <title> <?php echo e(get_static_option('site_'.get_default_language().'_title')); ?>

        - <?php echo e(get_static_option('site_'.get_default_language().'_tag_line')); ?></title>

    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<div class="stripe-payment-wrapper">
    <div class="srtipe-payment-inner-wrapper">
        <input type="hidden" name="order_id" id="order_id_input" value="<?php echo e($stripe_data['order_id']); ?>"/>
        <div class="btn-wrapper">
            <button id="payment_submit_btn"></button>
        </div>
    </div>
</div>

<script>
    // Create a Stripe client
    var stripe = Stripe("<?php echo e(get_static_option('stripe_publishable_key')); ?>");
    var orderID = document.getElementById('order_id_input').value;
    var submitBtn = document.getElementById('payment_submit_btn');


    document.addEventListener('DOMContentLoaded',function (){
        submitBtn.dispatchEvent(new Event('click'));
    },false);

    submitBtn.addEventListener('click', function () {
        // Create a new Checkout Session using the server-side endpoint you
        submitBtn.innerText = "<?php echo e(__('Redirecting..')); ?>"
        submitBtn.disabled = true;
        // created in step 3.
        fetch("<?php echo e($stripe_data['route']); ?>", {
            headers: {
                "X-CSRF-TOKEN" : "<?php echo e(csrf_token()); ?>",
                'Content-Type': 'application/json'
            },
            method: 'POST',
            body: JSON.stringify({'order_id': orderID })
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (session) {
                return stripe.redirectToCheckout({sessionId: session.id});
            })
            .then(function (result) {
                // If `redirectToCheckout` fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using `error.message`.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
            });
    });
</script>
</body>
</html>
<?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/payment/stripe.blade.php ENDPATH**/ ?>
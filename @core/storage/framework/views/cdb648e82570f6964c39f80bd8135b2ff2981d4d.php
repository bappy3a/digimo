<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Order Confirm')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="error-page-content padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-confirm-area">
                        <h4 class="title"><?php echo e(__('Order Details')); ?></h4>
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.error-msg','data' => []]); ?>
<?php $component->withName('error-msg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                         <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.flash-msg','data' => []]); ?>
<?php $component->withName('flash-msg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                        <form action="<?php echo e(route('frontend.order.payment.form')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php
                            $custom_fields = unserialize( $order_details->custom_fields);
                            $payment_gateway = !empty($custom_fields['selected_payment_gateway']) ? $custom_fields['selected_payment_gateway'] : '';
                            $name = auth()->check() ? auth()->user()->name : '';
                            $email = auth()->check() ? auth()->user()->email :'';
                            ?>
                            <input type="hidden" name="order_id" value="<?php echo e($order_details->id); ?>">
                            <input type="hidden" name="payment_gateway" value="<?php echo e($payment_gateway); ?>">
                             <input type="hidden" name="captcha_token" id="gcaptcha_token">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td><?php echo e(__('Your Name')); ?></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="name" value="<?php echo e($name); ?>" class="form-control" placeholder="<?php echo e(__('Enter Your Name')); ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo e(__('Your Email')); ?></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="email" name="email" value="<?php echo e($email); ?>" class="form-control" placeholder="<?php echo e(__('Enter Your Email')); ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo e(__('Package Name')); ?></td>
                                    <td><?php echo e($order_details->package_name); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo e(__('Package Price')); ?></td>
                                    <td>
                                        <strong><?php echo e(amount_with_currency_symbol($order_details->package_price)); ?></strong>
                                        <?php if(!check_currency_support_by_payment_gateway($payment_gateway)): ?>
                                            <br>
                                            <small><?php echo e(__('You will charge in '.get_charge_currency($payment_gateway).', you have to pay'. ' ')); ?> <strong><?php echo e(get_charge_amount($order_details->package_price,$payment_gateway).get_charge_currency($payment_gateway)); ?></strong></small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo e(__('Payment Gateway')); ?></td>
                                    <td class="text-capitalize">
                                        <?php if($payment_gateway == 'manual_payment'): ?>
                                            <?php echo e(get_static_option('site_manual_payment_name')); ?>

                                        <?php else: ?>
                                            <?php echo e($payment_gateway); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if($payment_gateway == 'manual_payment'): ?>
                                    <tr>
                                        <td><?php echo e(__('Transaction ID')); ?></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="trasaction_id" class="form-control">
                                                <small><?php echo get_manual_payment_description(); ?></small>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                        <div class="btn-wrapper">
                            <button type="submit" class="submit-btn style-01"><?php echo e(__('Pay Now')); ?></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <?php if(!empty(get_static_option('site_google_captcha_v3_site_key'))): ?>
        <script
            src="https://www.google.com/recaptcha/api.js?render=<?php echo e(get_static_option('site_google_captcha_v3_site_key')); ?>"></script>
        <script>
            grecaptcha.ready(function () {
                grecaptcha.execute("<?php echo e(get_static_option('site_google_captcha_v3_site_key')); ?>", {action: 'homepage'}).then(function (token) {
                    document.getElementById('gcaptcha_token').value = token;
                });
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/frontend/payment/order-confirm.blade.php ENDPATH**/ ?>
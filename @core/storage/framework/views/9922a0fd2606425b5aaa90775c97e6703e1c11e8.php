<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('New Order')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/nice-select.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
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
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                       <div class="header-wrapper d-flex justify-content-between">
                           <h4 class="header-title"><?php echo e(__('New Order')); ?></h4>
                           <a href="<?php echo e(route('admin.products.order.logs')); ?>" class="btn btn-primary"><?php echo e(__('All Orders')); ?></a>
                       </div>
                        <form action="<?php echo e(route('admin.product.order.new')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h6 class="group-title"><?php echo e(__('Billing Details Details')); ?></h6>
                                    <div class="form-group">
                                        <label for="billing_name"><?php echo e(__('Billing Name')); ?></label>
                                        <input type="text" class="form-control"  name="billing_name" >
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_email"><?php echo e(__('Billing Email')); ?></label>
                                        <input type="text" class="form-control"  name="billing_email" >
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_phone"><?php echo e(__('Billing Phone')); ?></label>
                                        <input type="text" class="form-control"  name="billing_phone" >
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_country"><?php echo e(__('Billing Country')); ?></label>
                                        <?php echo get_country_field('billing_country','billing_country','form-control'); ?>

                                    </div>
                                    <div class="form-group">
                                        <label for="billing_street_address"><?php echo e(__('Billing Street Address')); ?></label>
                                        <input type="text" class="form-control" name="billing_street_address">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_town"><?php echo e(__('Billing Town/City')); ?></label>
                                        <input type="text" class="form-control" name="billing_town" >
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_district"><?php echo e(__('Billing State')); ?></label>
                                        <input type="text" class="form-control" name="billing_district">
                                    </div>

                                    <div class="form-group">
                                        <label for="different_shipping_address"><strong><?php echo e(__('Use Different Shipping Address Show/Hide')); ?></strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="different_shipping_address" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>

                                    <div class="shipping-wrap">
                                    <h6 class="group-title"><?php echo e(__('Shipping Details')); ?></h6>
                                    <div class="form-group">
                                        <label for="shipping_name"><?php echo e(__('Shipping Name')); ?></label>
                                        <input type="text" class="form-control"  name="shipping_name" >
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_email"><?php echo e(__('Shipping Email')); ?></label>
                                        <input type="text" class="form-control"  name="shipping_email" >
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_phone"><?php echo e(__('Shipping Phone')); ?></label>
                                        <input type="text" class="form-control"  name="shipping_phone" >
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_country"><?php echo e(__('Shipping Country')); ?></label>
                                        <?php echo get_country_field('shipping_country','shipping_country','form-control'); ?>

                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_street_address"><?php echo e(__('Shipping Street Address')); ?></label>
                                        <input type="text" class="form-control" name="shipping_street_address">
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_town"><?php echo e(__('Shipping Town/City')); ?></label>
                                        <input type="text" class="form-control" name="shipping_town" >
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_district"><?php echo e(__('Shipping State')); ?></label>
                                        <input type="text" class="form-control" name="shipping_district">
                                    </div>


                                    </div>
                                    <div class="form-group">
                                        <label for="cart_items"><?php echo e(__('Products')); ?></label>
                                        <select name="cart_items[]" multiple class="form-control nice-select wide">
                                            <option value=""><?php echo e(__('Select Products')); ?></option>
                                            <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->id); ?>"><?php echo e($product->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="stock_status"><?php echo e(__('Shipping Method')); ?></label>
                                        <select name="product_shippings_id" class="form-control" >
                                            <option value=""><?php echo e(__('Select Shipping Method')); ?></option>
                                            <?php $__currentLoopData = $all_shipping; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($shipping->id); ?>" <?php if($shipping->is_default == 1): ?> selected <?php endif; ?>><?php echo e($shipping->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_gateway"><?php echo e(__('Payment Gateway')); ?></label>
                                        <select name="payment_gateway" class="form-control" >
                                            <option value=""><?php echo e(__('Select Shipping Method')); ?></option>
                                            <?php
                                                $all_gateways = ['paypal','manual_payment','mollie','paytm','stripe','razorpay','flutterwave','paystack'];
                                            ?>
                                            <?php $__currentLoopData = $all_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(!empty(get_static_option($gateway.'_gateway'))): ?>
                                                    <option value="<?php echo e($gateway); ?>" <?php if(get_static_option('site_default_payment_gateway') == $gateway): ?> selected <?php endif; ?>><?php echo e(ucwords(str_replace('_',' ',$gateway))); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id"><?php echo e(__('User')); ?></label>
                                        <select name="user_id" class="form-control nice-select wide" >
                                            <option value=""><?php echo e(__('Select User')); ?></option>
                                            <?php $__currentLoopData = $all_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>" ><?php echo e($user->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="status"><?php echo e(__('Status')); ?></label>
                                        <select name="status" id="status"  class="form-control">
                                            <option value="pending"><?php echo e(__('Pending')); ?></option>
                                            <option value="in_progress"><?php echo e(__('In Progress')); ?></option>
                                            <option value="shipped"><?php echo e(__('Shipped')); ?></option>
                                            <option value="cancel"><?php echo e(__('Cancel')); ?></option>
                                            <option value="complete"><?php echo e(__('Complete')); ?></option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Submit')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/backend/js/jquery.nice-select.min.js')); ?>"></script>
    <script>
        $(document).ready(function () {

           /*--------------------------------------
           *  DIFFERENT SHIPPING METHOD CHECK
           * -------------------------------------*/

            $(document).on('change','input[name="different_shipping_address"]',function(){
                var shippingWrap = $('.shipping-wrap');
                if($(this).is(':checked')){
                    shippingWrap.addClass('d-block').removeClass('d-none');
                }else{
                    shippingWrap.removeClass('d-block').addClass('d-none');
                }
            });

            /*---------------------------------
            *   NICE SELECT INITIALIZE
            * -------------------------------*/
            var niceSelect = $('.nice-select');
            if(niceSelect.length > 0){
                niceSelect.niceSelect();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/backend/products/order-new.blade.php ENDPATH**/ ?>
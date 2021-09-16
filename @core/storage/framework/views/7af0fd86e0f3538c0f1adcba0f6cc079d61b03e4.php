<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Payment Success For:')); ?> <?php echo e($enroll_details->course->lang_front->title ?? __('Untitled')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="error-page-content padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-success-area margin-bottom-80">
                        <h1 class="title"><?php echo e(get_static_option('course_success_'.$user_select_lang_slug.'_title' )); ?></h1>
                        <p><?php echo e(get_static_option('course_success_' . $user_select_lang_slug . '_description')); ?></p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <h2 class="billing-title"><?php echo e(__('Payment Details')); ?></h2>
                    <ul class="booking_details_list">
                        <li><strong><?php echo e(__('Enroll Id')); ?></strong> : #<?php echo e($enroll_details->id); ?></li>
                        <li><strong><?php echo e(__('Name')); ?></strong> : <?php echo e($enroll_details->name); ?></li>
                        <li><strong><?php echo e(__('Email')); ?></strong> : <?php echo e($enroll_details->email); ?></li>
                        <li><strong> <?php echo e(get_static_option('courses_page_'.$user_select_lang_slug.'_name')); ?> <?php echo e(__('Name')); ?></strong> : <?php echo e($enroll_details->course->lang_front->title ?? __('Untitled')); ?></li>
                        <li><strong><?php echo e(__('Price')); ?></strong> :
                            <?php echo e(amount_with_currency_symbol(course_discounted_amount($enroll_details->total,$enroll_details->coupon))); ?>

                            <?php if(!empty($enroll_details->coupon)): ?>
                             <del> <?php echo e(amount_with_currency_symbol($enroll_details->total)); ?></del>
                             <?php endif; ?>
                        </li>
                        <?php if(!empty($enroll_details->coupon)): ?>
                        <li><strong><?php echo e(__('Coupon')); ?></strong> : <?php echo e($enroll_details->coupon); ?></li>
                        <?php endif; ?>
                        <?php if(!empty($enroll_details->coupon)): ?>
                        <li><strong><?php echo e(__('Discount')); ?></strong> : <?php echo e(amount_with_currency_symbol($enroll_details->coupon_discounted)); ?></li>
                        <?php endif; ?>
                        <li><strong><?php echo e(__('Payment Gateway')); ?></strong> : <?php echo e($enroll_details->payment_gateway); ?></li>
                        <li><strong><?php echo e(__('Payment Status')); ?></strong> : <?php echo e($enroll_details->payment_status); ?></li>
                        <li><strong><?php echo e(__('Transaction Id')); ?></strong> : <?php echo e($enroll_details->transaction_id); ?></li>
                        <li><strong><?php echo e(__('Enrollment Status')); ?></strong> : <?php echo e($enroll_details->status); ?></li>
                    </ul>
                    <div class="btn-wrapper margin-top-40">
                        <a href="<?php echo e(route('user.home')); ?>" class="boxed-btn"><?php echo e(__('Go To Dashboard')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/frontend/pages/courses/payment-success.blade.php ENDPATH**/ ?>
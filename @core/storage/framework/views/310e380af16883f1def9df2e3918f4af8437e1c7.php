<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Apply To').' '); ?><?php echo e($job->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Apply To').' '); ?><?php echo e($job->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="job-apply-form-wrapper">
                        <?php echo $__env->make('backend.partials.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php if($errors->any()): ?>
                            <ul class="alert alert-danger">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($message); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                        <h2 class="job-apply-title"> <?php echo e(__('Apply To').' '); ?><?php echo e($job->title); ?></h2>
                        <form action="<?php echo e(route('frontend.jobs.apply.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="job_id" value="<?php echo e($job->id); ?>">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="<?php echo e(__('Your Name')); ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="<?php echo e(__('Your Email')); ?>" class="form-control">
                            </div>
                            <?php echo render_form_field_for_frontend(get_static_option('apply_job_page_form_fields')); ?>

                            <?php if(!empty($job->application_fee_status) && $job->application_fee > 0): ?>
                                <input type="hidden" name="application_fee" value="<?php echo e($job->application_fee); ?>">
                            <?php echo render_payment_gateway_for_form(); ?>

                             <?php if(!empty(get_static_option('manual_payment_gateway'))): ?>
                                <div class="form-group manual_payment_transaction_field <?php if( get_static_option('site_default_payment_gateway') === 'manual_payment'): ?> d-block <?php endif; ?> " >
                                    <div class="label"><?php echo e(__('Transaction ID')); ?></div>
                                    <input type="text" name="transaction_id" placeholder="<?php echo e(__('transaction')); ?>" class="form-control">
                                    <span class="help-info"><?php echo get_manual_payment_description(); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php endif; ?>
                           
                            <div class="btn-wrapper text-center">
                                <button class="boxed-btn style-01" type="submit"><?php echo e(__('Apply')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function (){
            "use strict";

            $(document).on('click','.payment-gateway-wrapper > ul > li',function (e) {
                e.preventDefault();
                var gateway = $(this).data('gateway');
                $(this).addClass('selected').siblings().removeClass('selected');
                $('input[name="selected_payment_gateway"]').val(gateway);
                if(gateway === 'manual_payment'){
                    $('.manual_payment_transaction_field').addClass('d-block').removeClass('d-none');
                }else{
                    $('.manual_payment_transaction_field').addClass('d-none').removeClass('d-block');
                }
                $('.payment-gateway-wrapper').find(('input')).val(gateway);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/jobs/jobs-apply.blade.php ENDPATH**/ ?>
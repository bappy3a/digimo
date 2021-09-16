<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Payment Success For:').' '.$job_details->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="error-page-content padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-success-area margin-bottom-50">
                        <h1 class="title"><?php echo e(get_static_option('job_success_page_' . $user_select_lang_slug . '_title')); ?></h1>
                        <p><?php echo e(get_static_option('job_success_page_' . $user_select_lang_slug . '_description')); ?></p>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <h2 class="billing-title"><?php echo e(__('Billing Details')); ?></h2>
                    <ul class="billing-details">
                        <li><strong><?php echo e(__('Applicant ID')); ?>:</strong> #<?php echo e($applicant_details->id); ?></li>
                        <li><strong><?php echo e(__('Name')); ?>:</strong> <?php echo e($applicant_details->name); ?></li>
                        <li><strong><?php echo e(__('Email')); ?>:</strong> <?php echo e($applicant_details->email); ?></li>
                        <li><strong><?php echo e(__('Payment Method')); ?>:</strong> <?php echo e(str_replace('_',' ',$applicant_details->payment_gateway)); ?></li>
                        <li><strong><?php echo e(__('Payment Status')); ?>:</strong> <?php echo e($applicant_details->payment_status); ?></li>
                        <li><strong><?php echo e(__('Transaction id')); ?>:</strong> <?php echo e($applicant_details->transaction_id); ?></li>
                    </ul>
                    <div class="btn-wrapper margin-top-40">
                        <a href="<?php echo e(url('/')); ?>" class="boxed-btn"><?php echo e(__('Back To Home')); ?></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="job-single-wrap">
                        <div class="single-job-list-item">
                            <span class="job_type"><i class="far fa-clock"></i> <?php echo e(str_replace('_',' ',__($job_details->employment_status))); ?></span>
                            <a href="<?php echo e(route('frontend.jobs.single',$job_details->slug)); ?>"><h3 class="title"><?php echo e($job_details->title); ?></h3></a>
                            <span class="company_name"><strong><?php echo e(__('Company:')); ?></strong> <?php echo e($job_details->company_name); ?></span>
                            <span class="deadline"><strong><?php echo e(__('Deadline:')); ?></strong> <?php echo e(date("d M Y", strtotime($job_details->deadline))); ?></span>
                            <ul class="jobs-meta">
                                <li><i class="fas fa-briefcase"></i> <?php echo e($job_details->position); ?></li>
                                <li><i class="fas fa-wallet"></i> <?php echo e($job_details->salary); ?></li>
                                <li><i class="fas fa-map-marker-alt"></i> <?php echo e($job_details->job_location); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/jobs/job-success.blade.php ENDPATH**/ ?>
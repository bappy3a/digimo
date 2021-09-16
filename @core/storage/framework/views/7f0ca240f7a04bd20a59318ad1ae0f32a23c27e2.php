<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Case Single Page Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <?php echo $__env->make('backend/partials/message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-12 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo e(__('Case Study Single Page Settings')); ?></h4>
                        <form action="<?php echo e(route('admin.work.single.page.settings')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <?php $__currentLoopData = get_all_language(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($key == 0): ?> active <?php endif; ?>" data-toggle="tab" href="#tab_<?php echo e($key); ?>" role="tab"  aria-selected="true"><?php echo e($lang->name); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="tab-content margin-top-30" id="myTabContent">
                                <?php $__currentLoopData = get_all_language(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade <?php if($key == 0): ?> show active <?php endif; ?>" id="tab_<?php echo e($key); ?>" role="tabpanel" >
                                        <div class="form-group">
                                            <label for="case_study_<?php echo e($lang->slug); ?>_read_more_text"><?php echo e(__('Case Study Read More Button Text')); ?></label>
                                            <input type="text" name="case_study_<?php echo e($lang->slug); ?>_read_more_text" class="form-control" value="<?php echo e(get_static_option('case_study_'.$lang->slug.'_read_more_text')); ?>" id="case_study_<?php echo e($lang->slug); ?>_read_more_text">
                                        </div>
                                        <div class="form-group">
                                            <label for="case_study_<?php echo e($lang->slug); ?>_related_title"><?php echo e(__('Related Case Study Title')); ?></label>
                                            <input type="text" name="case_study_<?php echo e($lang->slug); ?>_related_title" class="form-control" value="<?php echo e(get_static_option('case_study_'.$lang->slug.'_related_title')); ?>" id="case_study_<?php echo e($lang->slug); ?>_related_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="case_study_<?php echo e($lang->slug); ?>_gallery_title"><?php echo e(__('Case Study Gallery Title')); ?></label>
                                            <input type="text" name="case_study_<?php echo e($lang->slug); ?>_gallery_title" class="form-control" value="<?php echo e(get_static_option('case_study_'.$lang->slug.'_gallery_title')); ?>" id="case_study_<?php echo e($lang->slug); ?>_gallery_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="case_study_<?php echo e($lang->slug); ?>_query_title"><?php echo e(__('Query Title')); ?></label>
                                            <input type="text" name="case_study_<?php echo e($lang->slug); ?>_query_title" class="form-control" value="<?php echo e(get_static_option('case_study_'.$lang->slug.'_query_title')); ?>" id="case_study_<?php echo e($lang->slug); ?>_query_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="case_study_<?php echo e($lang->slug); ?>_query_button_text"><?php echo e(__('Query Button Text')); ?></label>
                                            <input type="text" name="case_study_<?php echo e($lang->slug); ?>_query_button_text" class="form-control" value="<?php echo e(get_static_option('case_study_'.$lang->slug.'_query_button_text')); ?>" id="case_study_<?php echo e($lang->slug); ?>_query_button_text">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-group">
                                <label for="case_study_query_form_mail"><?php echo e(__('Query Form Mail')); ?></label>
                                <input type="text" name="case_study_query_form_mail" class="form-control" value="<?php echo e(get_static_option('case_study_query_form_mail')); ?>" id="case_study_query_form_mail">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Settings')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/pages/works/work-single-settings.blade.php ENDPATH**/ ?>
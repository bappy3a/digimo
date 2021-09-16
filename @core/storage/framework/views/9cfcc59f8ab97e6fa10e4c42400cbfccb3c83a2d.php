<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Courses Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
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
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo e(__("Courses Settings")); ?></h4>
                        <form action="<?php echo e(route('admin.courses.settings')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a class="nav-item nav-link <?php if($lang->slug === get_default_language()): ?> active <?php endif; ?>" id="nav-home-tab" data-toggle="tab" href="#nav-home-<?php echo e($lang->slug); ?>" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo e($lang->name); ?></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade <?php if($lang->slug === get_default_language()): ?> show active <?php endif; ?>" id="nav-home-<?php echo e($lang->slug); ?>" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="form-group">
                                            <label for="course_single_<?php echo e($lang->slug); ?>_overview_tab_title"><?php echo e(__('Single Page Overview Tab Title')); ?></label>
                                            <input type="text" name="course_single_<?php echo e($lang->slug); ?>_overview_tab_title"  class="form-control" value="<?php echo e(get_static_option('course_single_'.$lang->slug.'_overview_tab_title')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_single_<?php echo e($lang->slug); ?>_curriculum_tab_title"><?php echo e(__('Single Page Curriculum Tab Title')); ?></label>
                                            <input type="text" name="course_single_<?php echo e($lang->slug); ?>_curriculum_tab_title"  class="form-control" value="<?php echo e(get_static_option('course_single_'.$lang->slug.'_curriculum_tab_title')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_single_<?php echo e($lang->slug); ?>_instructor_tab_title"><?php echo e(__('Single Page Instructor Tab Title')); ?></label>
                                            <input type="text" name="course_single_<?php echo e($lang->slug); ?>_instructor_tab_title"  class="form-control" value="<?php echo e(get_static_option('course_single_'.$lang->slug.'_instructor_tab_title')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_single_<?php echo e($lang->slug); ?>_reviews_tab_title"><?php echo e(__('Single Page Reviews Tab Title')); ?></label>
                                            <input type="text" name="course_single_<?php echo e($lang->slug); ?>_reviews_tab_title"  class="form-control" value="<?php echo e(get_static_option('course_single_'.$lang->slug.'_reviews_tab_title')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_single_<?php echo e($lang->slug); ?>_enroll_button_text"><?php echo e(__('Single Page Enroll Button Text')); ?></label>
                                            <input type="text" name="course_single_<?php echo e($lang->slug); ?>_enroll_button_text"  class="form-control" value="<?php echo e(get_static_option('course_single_'.$lang->slug.'_enroll_button_text')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_single_<?php echo e($lang->slug); ?>_leave_feedback_title"><?php echo e(__('Single Page Leave Feedback Title')); ?></label>
                                            <input type="text" name="course_single_<?php echo e($lang->slug); ?>_leave_feedback_title"  class="form-control" value="<?php echo e(get_static_option('course_single_'.$lang->slug.'_leave_feedback_title')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_single_<?php echo e($lang->slug); ?>_client_feedback_title"><?php echo e(__('Single Page Feedback Title')); ?></label>
                                            <input type="text" name="course_single_<?php echo e($lang->slug); ?>_client_feedback_title"  class="form-control" value="<?php echo e(get_static_option('course_single_'.$lang->slug.'_client_feedback_title')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_success_<?php echo e($lang->slug); ?>_title"><?php echo e(__('Success Page Title')); ?></label>
                                            <input type="text" name="course_success_<?php echo e($lang->slug); ?>_title"  class="form-control" value="<?php echo e(get_static_option('course_success_'.$lang->slug.'_title')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_success_<?php echo e($lang->slug); ?>_description"><?php echo e(__('Success Page Description')); ?></label>
                                            <textarea name="course_success_<?php echo e($lang->slug); ?>_description"  class="form-control" cols="30" rows="10"><?php echo e(get_static_option('course_success_'.$lang->slug.'_description')); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="course_cancel_<?php echo e($lang->slug); ?>_title"><?php echo e(__('Cancel Page Title')); ?></label>
                                            <input type="text" name="course_cancel_<?php echo e($lang->slug); ?>_title"  class="form-control" value="<?php echo e(get_static_option('course_cancel_'.$lang->slug.'_title')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="course_cancel_<?php echo e($lang->slug); ?>_description"><?php echo e(__('Cancel Page Description')); ?></label>
                                            <textarea name="course_cancel_<?php echo e($lang->slug); ?>_description"  class="form-control" cols="30" rows="10"><?php echo e(get_static_option('course_cancel_'.$lang->slug.'_description')); ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-group">
                                <label for="course_page_items"><?php echo e(__('Course Page Items')); ?></label>
                                <input type="number" name="course_page_items"  class="form-control" value="<?php echo e(get_static_option('course_page_items')); ?>">
                            </div>
                            <div class="form-group">
                                <label for="course_notify_mail"><?php echo e(__('Course Notify Email')); ?></label>
                                <input type="email" name="course_notify_mail"  class="form-control" value="<?php echo e(get_static_option('course_notify_mail')); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Changes')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/courses/course-settings.blade.php ENDPATH**/ ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(get_static_option('appointment_page_'.$user_select_lang_slug.'_name')); ?> <?php echo e(__('Category:')); ?> <?php echo e($cat_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(get_static_option('appointment_page_'.$user_select_lang_slug.'_name')); ?> <?php echo e(__('Category:')); ?> <?php echo e($cat_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('appointment_page_'.$user_select_lang_slug.'_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('appointment_page_'.$user_select_lang_slug.'_meta_tags')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="appointment-content-area padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                        <?php $__empty_1 = true; $__currentLoopData = $all_appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-lg-4">
                            <div class="appointment-single-item">
                                <div class="thumb"
                                <?php echo render_background_image_markup_by_attachment_id($data->image,'','grid'); ?>

                                    >
                                    <div class="cat">
                                        <a href="<?php echo e(route('frontend.appointment.category',['id' => $data->category->id,'any' => Str::slug($data->category->lang_front->title ?? __("Uncategorized"))])); ?>"><?php echo e($data->category->lang_front->title ?? __("Uncategorized")); ?></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <?php if(!empty($data->lang_front->designation)): ?>
                                        <span class="designation"><?php echo e($data->lang_front->designation); ?></span>
                                    <?php endif; ?>
                                    <?php if(count($data->reviews) > 0): ?>
                                        <div class="rating-wrap">
                                            <div class="ratings">
                                                <span class="hide-rating"></span>
                                                <span class="show-rating" style="width: <?php echo e(get_appointment_ratings_avg_by_id($data->id) / 5 * 100); ?>%"></span>
                                            </div>
                                            <p><span class="total-ratings">(<?php echo e(count($data->reviews)); ?>)</span></p>
                                        </div>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('frontend.appointment.single',[$data->lang_front->slug ?? __('untitled'),$data->id])); ?>"><h4 class="title"><?php echo e($data->lang_front->title); ?></h4></a>
                                    <?php if(!empty($data->lang_front->location)): ?>
                                        <span class="location"><i class="fas fa-map-marker-alt"></i><?php echo e($data->lang_front->location); ?></span>
                                    <?php endif; ?>

                                    <p><?php echo e(Str::words(strip_tags($data->lang_front->short_description),10)); ?></p>
                                    <div class="btn-wrapper">
                                        <a href="<?php echo e(route('frontend.appointment.single',[$data->lang_front->slug ?? __('untitled'),$data->id])); ?>" class="boxed-btn"><?php echo e(get_static_option('appointment_page_'.$user_select_lang_slug.'_booking_button_text')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-lg-12 text-center">
                           <div class="alert alert-warning"><?php echo e(__('nothing found')); ?> <strong><?php echo e($search_term); ?></strong></div>
                        </div>
                        <?php endif; ?>
                <div class="col-lg-12 text-center">
                    <nav class="pagination-wrapper " aria-label="Page navigation ">
                        <?php echo e($all_appointment->links()); ?>

                    </nav>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/appointment/appointment-category.blade.php ENDPATH**/ ?>
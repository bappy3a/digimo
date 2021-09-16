<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Category:')); ?> <?php echo e($category->lang_front->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Category:')); ?> <?php echo e($category->lang_front->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="appointment-content-area padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                <?php $__empty_1 = true; $__currentLoopData = $all_courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="course-single-grid-item">
                            <div class="thumb">
                                <a href="<?php echo e(route('frontend.course.single',[$data->lang_front->slug,$data->id])); ?>">
                                    <?php echo render_image_markup_by_attachment_id($data->image); ?>

                                </a>
                                <div class="price-wrap">
                                    <?php echo e(amount_with_currency_symbol($data->price)); ?>

                                    <del><?php echo e(amount_with_currency_symbol($data->sale_price)); ?></del>
                                </div>
                            </div>
                            <div class="content">
                                <?php if(count($data->reviews) > 0): ?>
                                    <div class="rating-wrap">
                                        <div class="ratings">
                                            <span class="hide-rating"></span>
                                            <span class="show-rating" style="width: <?php echo e(get_course_ratings_avg_by_id($data->id) / 5 * 100); ?>%"></span>
                                        </div>
                                        <p><span class="total-ratings">(<?php echo e(count($data->reviews)); ?>)</span></p>
                                    </div>
                                <?php endif; ?>
                                <h3 class="title"><a href="<?php echo e(route('frontend.course.single',[$data->lang_front->slug,$data->id])); ?>"><?php echo e(Str::words($data->lang_front->title,6,'..')); ?></a></h3>
                                <div class="instructor-wrap"><span><?php echo e(__('By')); ?></span> <a href="<?php echo e(route('frontend.course.instructor',[Str::slug($data->instructor->name),$data->instructor->id])); ?>"><?php echo e($data->instructor->name); ?></a></div>
                                <div class="description">
                                    <?php echo Str::words(strip_tags($data->lang_front->description),15); ?>

                                </div>
                                <div class="footer-part">
                                    <span><i class="fas fa-users"></i> <?php echo e($data->enrolled_student); ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo e($data->duration); ?> <?php echo e($data->duration_type); ?></span>
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
                    <?php echo e($all_courses->links()); ?>

                </nav>
            </div>
        </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        (function($) {
            'use strict';
            $(document).on('change','select[name="sorting"]',function (e){
                e.preventDefault();
                $('input[name="sort"]').val($(this).val());
            })
            $(document).on('change','select[name="category"]',function (e){
                e.preventDefault();
                $('input[name="cat"]').val($(this).val());
            })
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/courses/courses-category.blade.php ENDPATH**/ ?>
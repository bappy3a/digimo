<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('instructor:')); ?> <?php echo e($instructor->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('instructor:')); ?> <?php echo e($instructor->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="course-details-content-area padding-top-100 padding-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="instructor-info-wrapper">
                        <div class="img-wrap">
                            <?php echo render_image_markup_by_attachment_id($instructor->image); ?>

                        </div>
                        <div class="content">
                            <h3 class="title"><?php echo e($instructor->name); ?></h3>
                            <span class="designation"><?php echo e($instructor->designation); ?></span>
                            <ul class="social-wrap">
                                <?php $__currentLoopData = $instructor->social_icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($instructor->social_icon_url[$loop->index] ?? '#'); ?>"><i class="<?php echo e($icon); ?>"></i></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="instructor-content-wrapper content-tab-wrapper">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#about_me_tab" role="tab"  aria-selected="true"><?php echo e(__('About Me')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#courses_tab" role="tab" aria-selected="false"><?php echo e(__('Courses')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  data-toggle="tab" href="#reviews-tab" role="tab"  aria-selected="false"><?php echo e(__('Reviews')); ?></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="about_me_tab" role="tabpanel">
                                <div class="tab-inner-area">
                                    <?php echo $instructor->lang_front->description; ?>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="courses_tab" role="tabpanel" >
                                <div class="my-courses-wrap">
                                    <div class="row">
                                    <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <div class="col-lg-6">
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
                                                        <div class="footer-part">
                                                            <span><i class="fas fa-users"></i> <?php echo e($data->enrolled_student); ?></span>
                                                            <span><i class="fas fa-clock"></i> <?php echo e($data->duration); ?> <?php echo e($data->duration_type); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="col-lg-12 text-center">
                                            <div class="alert alert-warning"><?php echo e(__('nothing found')); ?> </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-lg-12 text-center">
                                        <nav class="pagination-wrapper " aria-label="Page navigation ">
                                            <?php echo e($courses->links()); ?>

                                        </nav>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews-tab" role="tabpanel" >
                                <div class="instructor-review-wrapper feedback-comment-list-wrap">
                                    <ul class="feedback-list">
                                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="single-feedback-item">
                                                <div class="content">
                                                    <h4 class="title"><?php echo e($data->user ? $data->user->username : __("Anonymous")); ?></h4>
                                                    <div class="rating-wrap single">
                                                        <?php for( $i =1; $i <= $data->ratings; $i++ ): ?>
                                                            <i class="fas fa-star"></i>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <div class="description"><?php echo e($data->message); ?></div>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <?php echo e($reviews->links()); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/courses/course-instructor.blade.php ENDPATH**/ ?>
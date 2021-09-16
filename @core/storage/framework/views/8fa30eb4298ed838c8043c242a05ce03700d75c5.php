<?php $__env->startSection('site-title'); ?>
    <?php echo e(get_static_option('courses_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(get_static_option('courses_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('courses_page_'.$user_select_lang_slug.'_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('courses_page_'.$user_select_lang_slug.'_meta_tags')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="appointment-content-area padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="top-search-wrapper">
                        <div class="right-part">
                            <select name="category" class="form-control">
                                <option value=""><?php echo e(__("select category")); ?></option>
                                <?php $__currentLoopData = $category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if($category->id == $cat_id): ?> selected <?php endif; ?> value="<?php echo e($category->id); ?>"><?php echo e($category->lang_front->title); ?> (<?php echo e($category->course->count()); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="sorting" class="form-control">
                                <option <?php if($sort === 'latest'): ?> selected <?php endif; ?> value="latest"><?php echo e(__("Latest")); ?></option>
                                <option <?php if($sort === 'oldest'): ?> selected <?php endif; ?> value="oldest"><?php echo e(__("Oldest")); ?></option>
                                <option <?php if($sort === 'top_rated'): ?> selected <?php endif; ?> value="top_rated"><?php echo e(__("Best Rated")); ?></option>
                                <option <?php if($sort === 'low_price'): ?> selected <?php endif; ?> value="low_price"><?php echo e(__("Low Price")); ?></option>
                                <option <?php if($sort === 'high_price'): ?> selected <?php endif; ?> value="high_price"><?php echo e(__("High Price")); ?></option>
                            </select>
                        </div>
                        <div class="left-part">
                            <div class="search-wrapper">
                                <form method="get">
                                    <input type="hidden" name="cat" value="<?php echo e($cat_id); ?>">
                                    <input type="hidden" name="sort" value="<?php echo e($sort); ?>">
                                    <div class="form-group search-box">
                                        <input type="text" class="form-control" name="s" placeholder="<?php echo e(__('Search')); ?>" value="<?php echo e($search_term); ?>">
                                        <button class="submit-btn"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php $a=1; ?>
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
                                <div class="cat">
                                    <a class="bg-<?php echo e($a); ?>" href="<?php echo e(route('frontend.course.category',[Str::slug($data->category->lang_front->title,'-',$data->category->lang_front->lang),$data->category->id])); ?>"><?php echo e($data->category->lang_front->title); ?></a>
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
                                    <span><i class="fas fa-users"></i> <?php echo e($data->enrolled_student); ?> <?php echo e(__('Enrolled')); ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo e($data->duration); ?> <?php echo e($data->duration_type); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($a == 4){ $a=1;}else{$a++;} ?>
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

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/beta/@core/resources/views/frontend/pages/courses/courses.blade.php ENDPATH**/ ?>
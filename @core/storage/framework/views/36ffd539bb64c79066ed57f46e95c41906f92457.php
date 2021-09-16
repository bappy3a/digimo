<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Category:')); ?> <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Category:')); ?> <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('events_page_'.$user_select_lang_slug.'_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('events_page_'.$user_select_lang_slug.'_meta_tags')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <?php $__currentLoopData = $all_events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="single-events-list-item">
                                <div class="thumb">
                                    <?php echo render_image_markup_by_attachment_id($data->image,'','grid'); ?>

                                </div>
                                <div class="content-area">
                                    <div class="top-part">
                                        <div class="time-wrap">
                                            <span class="date"><?php echo e(date('d',strtotime($data->date))); ?></span>
                                            <span class="month"><?php echo e(date('M',strtotime($data->date))); ?></span>
                                        </div>
                                        <div class="title-wrap">
                                            <a href="<?php echo e(route('frontend.events.single',$data->slug)); ?>"><h4 class="title"><?php echo e($data->title); ?></h4></a>
                                            <span class="location"><i class="fas fa-map-marker-alt"></i> <?php echo e($data->venue_location); ?></span>
                                        </div>
                                    </div>
                                    <p><?php echo e(strip_tags(Str::words(strip_tags($data->content),20))); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="col-lg-12">
                        <nav class="pagination-wrapper text-center" aria-label="Page navigation ">
                            <?php echo e($all_events->links()); ?>

                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        <div class="widget widget_search">
                            <form action="<?php echo e(route('frontend.events.search')); ?>" method="get" class="search-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="<?php echo e(__('Search...')); ?>">
                                </div>
                                <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title"><?php echo e(get_static_option('site_events_category_'.get_user_lang().'_title')); ?></h2>
                            <ul>
                                <?php $__currentLoopData = $all_events_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(route('frontend.events.category',['id' => $data->id,'any'=> Str::slug($data->title,'-')])); ?>"><?php echo e(ucfirst($data->title)); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/events/event-category.blade.php ENDPATH**/ ?>
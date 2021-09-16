<?php $__env->startSection('page-title'); ?>
    <?php echo e(get_static_option('service_page_'.$user_select_lang_slug.'_name')); ?> <?php echo e(__('Category:')); ?> <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(get_static_option('service_page_'.$user_select_lang_slug.'_name')); ?> <?php echo e(__('Category:')); ?> <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="blog-content-area padding-100">
        <div class="container">
            <div class="row">
                <?php if(empty($service_items)): ?>
                    <div class="col-lg-12">
                        <div class="alert alert-danger"><?php echo e(__('No Post Available In This Category')); ?></div>
                    </div>
                <?php endif; ?>
                    <?php $a = 1; ?>
                    <?php $__currentLoopData = $service_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-what-we-cover-item-02 margin-bottom-30">
                                <div class="single-what-img">
                                    <?php echo render_image_markup_by_attachment_id($data->image); ?>

                                </div>
                                <?php if($data->icon_type == 'icon' || $data->icon_type == ''): ?>
                                    <div class="icon-02 style-0<?php echo e($a); ?>">
                                        <i class="<?php echo e($data->icon); ?>"></i>
                                    </div>
                                <?php else: ?>
                                    <div class="img-icon style-0<?php echo e($a); ?>">
                                        <?php echo render_image_markup_by_attachment_id($data->img_icon); ?>

                                    </div>
                                <?php endif; ?>
                                <div class="content">
                                    <a href="<?php echo e(route('frontend.services.single',$data->slug)); ?>"><h4 class="title"><?php echo e($data->title); ?></h4></a>
                                    <p><?php echo e($data->excerpt); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php  if($a == 4){ $a = 1;}else{$a++;}; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <nav class="pagination-wrapper" aria-label="Page navigation">
                    <?php echo e($service_items->links()); ?>

                </nav>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/service/service-category.blade.php ENDPATH**/ ?>
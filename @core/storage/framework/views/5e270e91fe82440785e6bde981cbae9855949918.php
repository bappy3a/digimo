<?php $__env->startSection('site-title'); ?>
    <?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_meta_tags')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php $__currentLoopData = $all_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blog-classic-item-01 margin-bottom-60">
                            <div class="thumbnail">
                                <?php echo render_image_markup_by_attachment_id($data->image); ?>

                            </div>
                            <div class="content">
                                <ul class="post-meta">
                                    <li><a href="<?php echo e(route('frontend.blog.single',$data->slug)); ?>"><i class="fa fa-user"></i> <?php echo e($data->author); ?></a></li>
                                    <li><a href="<?php echo e(route('frontend.blog.single',$data->slug)); ?>"><i class="far fa-clock"></i> <?php echo e(date_format($data->created_at,'d M y')); ?></a></li>
                                    <li>
                                        <div class="cats"><i class="fas fa-microchip"></i>
                                            <?php echo get_blog_category_by_id($data->blog_categories_id,'link'); ?>

                                        </div>
                                    </li>
                                </ul>
                                <h4 class="title"><a href="<?php echo e(route('frontend.blog.single',$data->slug)); ?>"><?php echo e($data->title); ?></a></h4>
                                <p><?php echo e($data->excerpt); ?></p>
                                <div class="btn-wrapper">
                                    <a href="<?php echo e(route('frontend.blog.single',$data->slug)); ?>" class="boxed-btn reverse-color"><?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_read_more_btn_text')); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <nav class="pagination-wrapper" aria-label="Page navigation ">
                       <?php echo e($all_blogs->links()); ?>

                    </nav>
                </div>
                <div class="col-lg-4">
                   <?php echo $__env->make('frontend.pages.blog.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/blog/blog.blade.php ENDPATH**/ ?>
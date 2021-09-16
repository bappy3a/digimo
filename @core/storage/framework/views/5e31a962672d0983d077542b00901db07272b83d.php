<section class="breadcrumb-area breadcrumb-bg "
    <?php echo render_background_image_markup_by_attachment_id(get_static_option('site_breadcrumb_bg')); ?>

>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner">
                    <h1 class="page-title"><?php echo $__env->yieldContent('page-title'); ?></h1>
                    <ul class="page-list">
                        <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Home')); ?></a></li>
                        <?php
                        $pages_list = ['blog','work','service','product','career_with_us','events','knowledgebase','donation','appointment','courses'];
                        ?>
                        <?php $__currentLoopData = $pages_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(request()->is(get_static_option($page.'_page_slug').'/*')): ?>
                            <li><a href="<?php echo e(url('/').'/'.get_static_option($page.'_page_slug')); ?>"><?php echo e(get_static_option($page.'_page_' . $user_select_lang_slug . '_name')); ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo $__env->yieldContent('page-title'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/frontend/partials/breadcrumb.blade.php ENDPATH**/ ?>
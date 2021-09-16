<div class="widget-area">
    <div class="widget widget_search">
        <form action="<?php echo e(route('frontend.blog.search')); ?>" method="get" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="<?php echo e(__('Search')); ?>">
            </div>
            <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="widget widget_nav_menu">
        <h2 class="widget-title"><?php echo e(get_static_option('blog_single_page_'.$user_select_lang_slug.'_category_title')); ?></h2>
        <ul>
            <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(route('frontend.blog.category',['id' => $data->id,'any'=> Str::slug($data->name,'-')])); ?>"><?php echo e(ucfirst($data->name)); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <div class="widget widget_recent_posts">
        <h4 class="widget-title"><?php echo e(get_static_option('blog_single_page_'.$user_select_lang_slug.'_recent_post_title')); ?></h4>
        <ul class="recent_post_item">
            <?php $__currentLoopData = $all_recent_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="single-recent-post-item">
                    <div class="thumb">
                        <?php echo render_image_markup_by_attachment_id($data->image,null,'thumb'); ?>

                    </div>
                    <div class="content">
                        <h4 class="title"><a href="<?php echo e(route('frontend.blog.single',$data->slug)); ?>"><?php echo e($data->title); ?></a></h4>
                        <span class="time"><?php echo e(date_format($data->created_at,'d M y')); ?></span>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/frontend/pages/blog/sidebar.blade.php ENDPATH**/ ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e($knowledgebase->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($knowledgebase->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e($knowledgebase->meta_description); ?>">
    <meta name="tags" content="<?php echo e($knowledgebase->meta_tag); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="knowledgebase-details-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-knowledgebase-details">
                        <?php echo $knowledgebase->content; ?>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        <div class="widget widget_search">
                            <form action="<?php echo e(route('frontend.knowledgebase.search')); ?>" method="get" class="search-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="<?php echo e(__('Search...')); ?>">
                                </div>
                                <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title"><?php echo e(get_static_option('site_knowledgebase_category_'.$user_select_lang_slug.'_title')); ?></h2>
                            <ul>
                                <?php $__currentLoopData = $all_knowledgebase_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(route('frontend.knowledgebase.category',['id' => $data->id,'any'=> Str::slug($data->title,'-')])); ?>"><i class="fas fa-folder base-color"></i> <?php echo e(ucfirst($data->title)); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title"><?php echo e(get_static_option('site_knowledgebase_popular_widget_'.$user_select_lang_slug.'_title')); ?></h2>
                            <ul>
                                <?php $__currentLoopData = $popular_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(route('frontend.knowledgebase.single',$data->slug)); ?>"><i class="far fa-file-alt base-color"></i> <?php echo e(ucfirst($data->title)); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/knowledgebase/knowledgebase-single.blade.php ENDPATH**/ ?>
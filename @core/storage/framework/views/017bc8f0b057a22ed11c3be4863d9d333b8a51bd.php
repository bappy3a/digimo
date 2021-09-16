<?php $__env->startSection('site-title'); ?>
    <?php echo e(get_static_option('knowledgebase_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(get_static_option('knowledgebase_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('knowledgebase_page_'.$user_select_lang_slug.'_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('knowledgebase_page_'.$user_select_lang_slug.'_meta_tags')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="knowledgebase-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4 class="main-title"><?php echo e(get_static_option('site_knowledgebase_article_topic_'.$user_select_lang_slug.'_title')); ?></h4>
                    <div class="row">
                        <?php $__currentLoopData = $all_knowledgebase; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic => $articles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-6">
                                <div class="article-with-topic-title-style-01">
                                    <?php if(!empty(get_topic_name_by_id($topic))): ?>
                                    <a href="<?php echo e(route('frontend.knowledgebase.category',['id' => $topic,'any' => Str::slug(get_topic_name_by_id($topic)) ])); ?>"> <h4 class="topic-title"><i class="fas fa-folder"></i> <?php echo e(get_topic_name_by_id($topic)); ?></h4></a>
                                    <?php endif; ?>
                                    <ul class="know-articles-list">
                                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $art): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(route('frontend.knowledgebase.single',$art->slug)); ?>"><i class="far fa-file-alt"></i> <?php echo e($art->title); ?></a></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <h2 class="widget-title"><?php echo e(get_static_option('site_knowledgebase_category_'.get_user_lang().'_title')); ?></h2>
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

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/knowledgebase/knowledgebase.blade.php ENDPATH**/ ?>
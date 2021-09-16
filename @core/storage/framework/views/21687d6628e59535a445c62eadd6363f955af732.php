<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Knowledgebase Page Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <?php echo $__env->make('backend.partials.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo e(__("Knowledgebase Page Settings")); ?></h4>
                        <form action="<?php echo e(route('admin.knowledge.page.settings')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a class="nav-item nav-link <?php if($key == 0): ?> active <?php endif; ?>" id="nav-home-tab" data-toggle="tab" href="#nav-home-<?php echo e($lang->slug); ?>" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo e($lang->name); ?></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade <?php if($key == 0): ?> show active <?php endif; ?>" id="nav-home-<?php echo e($lang->slug); ?>" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="form-group">
                                            <label for="site_knowledgebase_category_<?php echo e($lang->slug); ?>_title"><?php echo e(__('Category Widget Title')); ?></label>
                                            <input type="text" name="site_knowledgebase_category_<?php echo e($lang->slug); ?>_title"  class="form-control" value="<?php echo e(get_static_option('site_knowledgebase_category_'.$lang->slug.'_title')); ?>" id="site_knowledgebase_category_<?php echo e($lang->slug); ?>_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="site_knowledgebase_popular_widget_<?php echo e($lang->slug); ?>_title"><?php echo e(__('Popular Article Widget Title')); ?></label>
                                            <input type="text" name="site_knowledgebase_popular_widget_<?php echo e($lang->slug); ?>_title"  class="form-control" value="<?php echo e(get_static_option('site_knowledgebase_popular_widget_'.$lang->slug.'_title')); ?>" id="site_knowledgebase_popular_widget_<?php echo e($lang->slug); ?>_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="site_knowledgebase_article_topic_<?php echo e($lang->slug); ?>_title"><?php echo e(__('Article Topics Title')); ?></label>
                                            <input type="text" name="site_knowledgebase_article_topic_<?php echo e($lang->slug); ?>_title"  class="form-control" value="<?php echo e(get_static_option('site_knowledgebase_article_topic_'.$lang->slug.'_title')); ?>" id="site_knowledgebase_article_topic_<?php echo e($lang->slug); ?>_title">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-group">
                                <label for="site_knoeledgebase_post_items"><?php echo e(__('Knowledgebase Topics')); ?></label>
                                <input type="text" class="form-control" name="site_knoeledgebase_post_items" id="site_knoeledgebase_post_items" value="<?php echo e(get_static_option('site_knoeledgebase_post_items')); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Changes')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/backend/knowledgebase/knowledgebase-page-settings.blade.php ENDPATH**/ ?>
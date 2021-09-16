<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Edit Words Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <?php echo $__env->make('backend.partials.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <div class="top-part d-flex justify-content-between">
                            <div class="left-item">
                                <h4 class="header-title"><?php echo e(__("Change All Words")); ?></h4>
                                <button
                                        class="btn btn-secondary btn-xs margin-bottom-40"
                                        data-toggle="modal"
                                        data-target="#view_quote_details_modal"
                                ><?php echo e(__('Add New Word')); ?></button>
                            </div>
                            <div class="btn-wrapper">
                                <a href="<?php echo e(route('admin.languages')); ?>" class="btn btn-info"><?php echo e(__('All Languages')); ?></a>
                            </div>
                        </div>
                        <form action="<?php echo e(route('admin.languages.words.update',$lang_slug)); ?>" method="POST" enctype="multipart/form-data">
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Changes')); ?></button>
                            <br>
                            <br>
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="<?php echo e($type); ?>">
                            <div class="row">
                                <?php $__currentLoopData = $all_word; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label for="<?php echo e(Str::slug(($key))); ?>"><?php echo e($key); ?></label>
                                            <input type="text" name="word[<?php echo e($key); ?>]"  class="form-control" value="<?php echo e($value); ?>" id="<?php echo e(Str::slug(($key))); ?>">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Changes')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_quote_details_modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('Add New Translate able String')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="<?php echo e(route('admin.languages.add.new.word')); ?>" id="user_password_change_modal_form" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="lang_slug" id="lang_slug" value="<?php echo e($lang_slug); ?>">
                        <div class="form-group">
                            <label for="new_string"><?php echo e(__('String')); ?></label>
                            <input type="text" class="form-control" name="new_string" placeholder="<?php echo e(__('new string')); ?>">
                        </div>
                        <div class="form-group">
                            <label for="translated_string"><?php echo e(__('Translated String')); ?></label>
                            <input type="text" class="form-control" id="translated_string" name="translated_string" placeholder="<?php echo e(__('Translated String')); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(__('Add New String')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/languages/edit-words.blade.php ENDPATH**/ ?>
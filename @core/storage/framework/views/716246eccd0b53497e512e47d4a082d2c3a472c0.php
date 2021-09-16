<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Featured Products Area')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/nice-select.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.error-msg','data' => []]); ?>
<?php $component->withName('error-msg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.flash-msg','data' => []]); ?>
<?php $component->withName('flash-msg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            </div>
            <div class="col-lg-12 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo e(__('Popular Items Area Settings')); ?></h4>

                        <form action="<?php echo e(route('admin.home18.popular.item')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php $default_lang = get_default_language() ; ?>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a class="nav-item nav-link <?php if($default_lang == $key): ?> active <?php endif; ?> language_tab_btn" data-lang="<?php echo e($lang->slug); ?>" id="nav-home-tab" data-toggle="tab" href="#nav-home-<?php echo e($lang->slug); ?>" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo e($lang->name); ?></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade <?php if($default_lang == $key): ?> show active <?php endif; ?>" id="nav-home-<?php echo e($lang->slug); ?>" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="form-group">
                                            <label for="grocery_home_page_<?php echo e($lang); ?>_featured_product_area_subtitle"><?php echo e(__('Subtitle')); ?></label>
                                            <input type="text" name="grocery_home_page_<?php echo e($lang->slug); ?>_featured_product_area_subtitle" value="<?php echo e(get_static_option('grocery_home_page_'.$lang->slug.'_featured_product_area_subtitle')); ?>" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label for="grocery_home_page_<?php echo e($lang); ?>_featured_product_area_title"><?php echo e(__('Title')); ?></label>
                                            <input type="text" name="grocery_home_page_<?php echo e($lang->slug); ?>_featured_product_area_title" value="<?php echo e(get_static_option('grocery_home_page_'.$lang->slug.'_featured_product_area_title')); ?>" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label for="home_page_15_<?php echo e($lang->slug); ?>_featured_product_area_items"><?php echo e(__('Featured Products')); ?></label>
                                            <select name="home_page_15_<?php echo e($lang->slug); ?>_featured_product_area_items[]" multiple class="form-control nice-select wide">
                                                <option value=""><?php echo e(__('Select Product')); ?></option>
                                                <?php
                                                    $selected_donation = unserialize(get_static_option('home_page_15_'.$lang->slug.'_featured_product_area_items'),['class' => false]);
                                                    $selected_cause = is_array($selected_donation) && count($selected_donation) > 0 ? $selected_donation : [];
                                                ?>
                                                <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($product->id); ?>" <?php if(in_array($product->id,$selected_cause)): ?> selected <?php endif; ?>><?php echo e($product->title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Settings')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/backend/js/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/jquery.nice-select.min.js')); ?>"></script>
    <script>
        $(document).ready(function () {
            if($('.nice-select').length > 0){
                $('.nice-select').niceSelect();
            }

            $(document).on('click','.language_tab_btn',function (){

                var lang = $(this).data('lang');
                var container = $('#nav-home-'+lang).find('.nice-select');
                if( container.has('option').length > 1 ) {
                    return;
                }
                //ajax call
                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('admin.featured.product.by.lang')); ?>",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        lang: lang
                    },
                    success: function (data){
                        var container = $('#nav-home-'+lang).find('.nice-select');
                        container.html('');
                        var output = '<option value="">'+"<?php echo e(__('Select Product')); ?>"+'</option>';
                        $.each(data.product_items,function (index,value){
                            var selected = data.selected_items.includes(value.id.toString()) ? 'selected' : '';
                            output += '<option value="'+value.id+'" '+selected+'>'+value.title+'</option>'
                        });
                        container.html(output);
                        $('.nice-select').niceSelect('update');
                    }
                });

            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/backend/pages/home/grocery/popular-product-area.blade.php ENDPATH**/ ?>
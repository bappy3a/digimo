<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Edit Products')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dropzone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/media-uploader.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/bootstrap-tagsinput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/bootstrap-datepicker.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
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
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title"><?php echo e(__('Edit Product')); ?></h4>
                            <a href="<?php echo e(route('admin.products.all')); ?>" class="btn btn-primary"><?php echo e(__('All Products')); ?></a>
                        </div>

                        <form action="<?php echo e(route('admin.products.update')); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="language"><strong><?php echo e(__('Language')); ?></strong></label>
                                        <select name="lang" id="language" class="form-control">
                                            <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($product->lang === $lang->slug): ?> selected <?php endif; ?> value="<?php echo e($lang->slug); ?>"><?php echo e($lang->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title"><?php echo e(__('Title')); ?></label>
                                        <input type="text" class="form-control"  id="title" name="title" value="<?php echo e($product->title); ?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="slug"><?php echo e(__('Slug')); ?></label>
                                        <input type="text" class="form-control"  id="slug" name="slug" value="<?php echo e($product->slug); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="badge"><?php echo e(__('Badge')); ?></label>
                                        <input type="text" class="form-control"  id="badge" name="badge" value="<?php echo e($product->badge); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="category"><?php echo e(__('Category')); ?></label>
                                        <select name="category_id" class="form-control" id="category">
                                            <option value=""><?php echo e(__("Select Category")); ?></option>
                                            <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($product->category_id == $category->id): ?> selected <?php endif; ?> value="<?php echo e($category->id); ?>"><?php echo e($category->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('Description')); ?></label>
                                        <input type="hidden" name="description" data-content='<?php echo e($product->description); ?>' value="<?php echo e($product->description); ?>">
                                        <div class="summernote"><?php echo $product->description; ?></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description"><?php echo e(__('Short Description')); ?></label>
                                        <textarea name="short_description" id="short_description" class="form-control max-height-120" cols="30" rows="4"><?php echo e($product->short_description); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="regular_price"><?php echo e(__('Regular Price')); ?></label>
                                        <input type="number" class="form-control"  id="regular_price" name="regular_price" value="<?php echo e($product->regular_price); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="sale_price"><?php echo e(__('Sale Price')); ?></label>
                                        <input type="number" class="form-control"  id="sale_price" name="sale_price" value="<?php echo e($product->sale_price); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="sku"><?php echo e(__('SKU')); ?></label>
                                        <input type="text" class="form-control"  id="sku" name="sku" value="<?php echo e($product->sku); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="stock_status"><?php echo e(__('Stock')); ?></label>
                                        <select name="stock_status" class="form-control" id="stock_status">
                                            <option <?php if($product->stock_status == 'in_stock'): ?> selected <?php endif; ?> value="in_stock"><?php echo e(__('In Stock')); ?></option>
                                            <option <?php if($product->stock_status == 'out_stock'): ?> selected <?php endif; ?> value="out_stock"><?php echo e(__('Out Of Stock')); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group attributes-field">
                                        <label for="attributes"><?php echo e(__('Attributes')); ?></label>
                                        <?php
                                            $att_title = unserialize($product->attributes_title);
                                            $att_descr = unserialize($product->attributes_description);
                                        ?>
                                        <?php if(!empty($att_title)): ?>
                                        <?php $__currentLoopData = $att_title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $att_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="attribute-field-wrapper">
                                               <input type="text" class="form-control"  id="attributes" name="attributes_title[]" value="<?php echo e($att_title); ?>">
                                               <textarea name="attributes_description[]"  class="form-control" rows="5"><?php echo e($att_descr[$key]); ?></textarea>
                                              <div class="icon-wrapper">
                                                  <span class="add_attributes"><i class="ti-plus"></i></span>
                                                  <?php if($key > 0): ?> <span class="remove_attributes"><i class="ti-minus"></i></span> <?php endif; ?>
                                              </div>
                                           </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <div class="attribute-field-wrapper">
                                                <input type="text" class="form-control"  id="attributes" name="attributes_title[]" placeholder="<?php echo e(__('Title')); ?>">
                                                <textarea name="attributes_description[]"  class="form-control" rows="5" placeholder="<?php echo e(__('Value')); ?>"></textarea>
                                                <div class="icon-wrapper">
                                                    <span class="add_attributes"><i class="ti-plus"></i></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_downloadable"><strong><?php echo e(__('Is Downloadable')); ?></strong></label>
                                        <label class="switch">
                                            <input type="checkbox"  <?php if($product->is_downloadable): ?> checked <?php endif; ?> name="is_downloadable" id="is_downloadable">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label for="downloadable_file"><?php echo e(__('Downloadable File')); ?></label>
                                        <p class="info-text">
                                            <?php if(file_exists('assets/uploads/downloadable/'.$product->downloadable_file)): ?>
                                                <a href="<?php echo e(route('admin.products.file.download',$product->id)); ?>" target="_blank"><?php echo e($product->downloadable_file); ?></a>
                                            <?php endif; ?>
                                        </p>
                                        <input type="file" name="downloadable_file"  class="form-control" id="downloadable_file">
                                        <span class="info-text"><?php echo e(__('only zip file is allowed')); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags"><?php echo e(__('Meta Tags')); ?></label>
                                        <input type="text" name="meta_tags"  class="form-control" value="<?php echo e($product->meta_tags); ?>" data-role="tagsinput" id="meta_tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description"><?php echo e(__('Meta Description')); ?></label>
                                        <textarea name="meta_description"  class="form-control" rows="5" id="meta_description"><?php echo e($product->meta_description); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image"><?php echo e(__('Image')); ?></label>
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap">
                                                <?php
                                                    $work_section_img = get_attachment_image_by_id($product->image,null,true);
                                                ?>
                                                <?php if(!empty($work_section_img)): ?>
                                                    <div class="attachment-preview">
                                                        <div class="thumbnail">
                                                            <div class="centered">
                                                                <img class="avatar user-thumb" src="<?php echo e($work_section_img['img_url']); ?>" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <input type="hidden" name="image" value="<?php echo e($product->image); ?>">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="<?php echo e(__('Select Product Image')); ?>" data-modaltitle="<?php echo e(__('Upload Product Image')); ?>" data-toggle="modal" data-target="#media_upload_modal">
                                                <?php echo e(__('Upload Image')); ?>

                                            </button>
                                        </div>
                                        <small><?php echo e(__('Recommended image size 1920x1280')); ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="image"><?php echo e(__('Gallery')); ?></label>
                                        <?php
                                            $gallery_images = !empty( $product->gallery) ? explode('|', $product->gallery) : [];
                                        ?>
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap">
                                                <?php $__currentLoopData = $gallery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gl_img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $work_section_img = get_attachment_image_by_id($gl_img,null,true);
                                                    ?>
                                                    <?php if(!empty($work_section_img)): ?>
                                                        <div class="attachment-preview">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img class="avatar user-thumb" src="<?php echo e($work_section_img['img_url']); ?>" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <input type="hidden" name="gallery" value="<?php echo e($product->gallery); ?>">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-mulitple="true" data-btntitle="<?php echo e(__('Select Image')); ?>" data-modaltitle="<?php echo e(__('Upload Image')); ?>" data-toggle="modal" data-target="#media_upload_modal">
                                                <?php echo e(__('Upload Image')); ?>

                                            </button>
                                        </div>
                                        <small><?php echo e(__('Recommended image size 1920x1280')); ?></small>
                                    </div>
                                    <?php if(get_static_option('product_tax_type') == 'individual'): ?>
                                    <div class="form-group">
                                        <label for="tax_percentage"><?php echo e(__('Tax Percentage')); ?></label>
                                        <input type="number" class="form-control"  id="tax_percentage" name="tax_percentage" value="<?php echo e($product->tax_percentage); ?>">
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="status"><?php echo e(__('Status')); ?></label>
                                        <select name="status" id="status"  class="form-control">
                                            <option <?php if($product->status == 'publish'): ?> selected <?php endif; ?> value="publish"><?php echo e(__('Publish')); ?></option>
                                            <option <?php if($product->status == 'draft'): ?> selected <?php endif; ?>  value="draft"><?php echo e(__('Draft')); ?></option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Save Changes')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('backend.partials.media-upload.media-upload-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-datepicker.min.js')); ?>"></script>
    <script>
        $(document).ready(function () {

            $(document).on('change','#language',function(e){
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url: "<?php echo e(route('admin.products.category.by.lang')); ?>",
                    type: "POST",
                    data: {
                        _token : "<?php echo e(csrf_token()); ?>",
                        lang : selectedLang
                    },
                    success:function (data) {
                        $('#category').html('<option value="">Select Category</option>');
                        $.each(data,function(index,value){
                            $('#category').append('<option value="'+value.id+'">'+value.title+'</option>')
                        });
                    }
                });
            });
            $('.summernote').summernote({
                height: 400,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });
            $(document).on('change','#is_downloadable',function (e) {
                e.preventDefault();
                isDownloadableCheck('#is_downloadable');
            });

            $(document).on('click','.attribute-field-wrapper .add_attributes',function (e) {
               e.preventDefault();
                $(this).parent().parent().parent().append(' <div class="attribute-field-wrapper">\n' +
                    '<input type="text" class="form-control"  id="attributes" name="attributes_title[]" placeholder="<?php echo e(__('Title')); ?>">\n' +
                    '<textarea name="attributes_description[]"  class="form-control" rows="5" placeholder="<?php echo e(__('Value')); ?>"></textarea>\n' +
                    '<div class="icon-wrapper">\n' +
                    '<span class="add_attributes"><i class="ti-plus"></i></span>\n' +
                    '<span class="remove_attributes"><i class="ti-minus"></i></span>\n' +
                    '</div>\n' +
                    '</div>');

            });
            isDownloadableCheck('#is_downloadable');
            $(document).on('click','.attribute-field-wrapper .remove_attributes',function (e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            function isDownloadableCheck($selector) {
                var dnFile = $('#downloadable_file');
                var dnFileUrl = $('#downloadable_file_link');
                if($($selector).is(':checked')){
                    dnFile.parent().show();
                    dnFileUrl.parent().show();
                }else{
                    dnFile.parent().hide();
                    dnFileUrl.parent().hide();
                }
            }
        });
    </script>
    <script src="<?php echo e(asset('assets/backend/js/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/dropzone.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-tagsinput.js')); ?>"></script>
    <?php echo $__env->make('backend.partials.media-upload.media-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/products/edit-product.blade.php ENDPATH**/ ?>
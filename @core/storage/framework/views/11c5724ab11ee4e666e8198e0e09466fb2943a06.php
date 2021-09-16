<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('New Appointment')); ?>

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
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title"><?php echo e(__('Add New Appointment')); ?></h4>
                            <a href="<?php echo e(route('admin.appointment.all')); ?>" class="btn btn-info"><?php echo e(__('All Appointments')); ?></a>
                        </div>
                        <form action="<?php echo e(route('admin.appointment.new')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <ul class="nav nav-tabs" role="tablist">
                                <?php $default_lang = get_default_language(); ?>
                                <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if($lang->slug == $default_lang): ?> active <?php endif; ?>"  data-toggle="tab" href="#slider_tab_<?php echo e($lang->slug); ?>" role="tab" aria-controls="home" aria-selected="true"><?php echo e($lang->name); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="tab-content margin-top-40" >
                                <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab-pane fade <?php if($lang->slug == $default_lang): ?> show active <?php endif; ?>" id="slider_tab_<?php echo e($lang->slug); ?>" role="tabpanel" >
                                        <div class="form-group">
                                            <label for="title"><?php echo e(__('Title')); ?></label>
                                            <input type="text" class="form-control" name="title[<?php echo e($lang->slug); ?>]" placeholder="<?php echo e(__('Title')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="slug"><?php echo e(__('Slug')); ?></label>
                                            <input type="text" class="form-control" name="slug[<?php echo e($lang->slug); ?>]" placeholder="<?php echo e(__('Slug')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="designation"><?php echo e(__('Designation')); ?></label>
                                            <input type="text" class="form-control"  name="designation[<?php echo e($lang->slug); ?>]" placeholder="<?php echo e(__('designation')); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('Description')); ?></label>
                                            <input type="hidden" name="description[<?php echo e($lang->slug); ?>]" >
                                            <div class="summernote"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="location"><?php echo e(__('Location')); ?></label>
                                            <input type="text" name="location[<?php echo e($lang->slug); ?>]" class="form-control" placeholder="<?php echo e(__('Location')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="short_description"><?php echo e(__('Short Description')); ?></label>
                                            <textarea name="short_description[<?php echo e($lang->slug); ?>]" cols="30" rows="5" class="form-control" placeholder="<?php echo e(__('Short Description')); ?>"></textarea>
                                        </div>

                                        <div class="iconbox-repeater-wrapper dynamic-repeater">
                                            <label for="additional_info" class="d-block"><?php echo e(__('Additional Info')); ?></label>
                                            <div class="all-field-wrap">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="additional_info[<?php echo e($lang->slug); ?>][]"  placeholder="<?php echo e(__('additional info')); ?>">
                                                </div>
                                                <div class="action-wrap">
                                                    <span class="add"><i class="ti-plus"></i></span>
                                                    <span class="remove"><i class="ti-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="iconbox-repeater-wrapper  dynamic-repeater">
                                            <label for="experience_info" class="d-block"><?php echo e(__('Experience Info')); ?></label>
                                            <div class="all-field-wrap">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="experience_info[<?php echo e($lang->slug); ?>][]" placeholder="<?php echo e(__('Experience Info')); ?>">
                                                </div>
                                                <div class="action-wrap">
                                                    <span class="add"><i class="ti-plus"></i></span>
                                                    <span class="remove"><i class="ti-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="iconbox-repeater-wrapper  dynamic-repeater">
                                            <label for="specialized_info" class="d-block"><?php echo e(__('Specialized Info')); ?></label>
                                            <div class="all-field-wrap">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="specialized_info[<?php echo e($lang->slug); ?>][]" placeholder="<?php echo e(__('Specialized Info')); ?>">
                                                </div>
                                                <div class="action-wrap">
                                                    <span class="add"><i class="ti-plus"></i></span>
                                                    <span class="remove"><i class="ti-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_title"><?php echo e(__('Meta title')); ?></label>
                                            <input type="text" class="form-control" name="meta_title[<?php echo e($lang->slug); ?>]" placeholder="<?php echo e(__('Meta title')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description"><?php echo e(__('Meta Description')); ?></label>
                                            <textarea  class="form-control max-height-120" name="meta_description[<?php echo e($lang->slug); ?>]"cols="30" rows="10" placeholder="<?php echo e(__('Meta Description')); ?>"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_tags"><?php echo e(__('Meta Tags')); ?></label>
                                            <input type="text" name="meta_tags[<?php echo e($lang->slug); ?>]"  class="form-control" data-role="tagsinput" >
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="category"><?php echo e(__('Category')); ?></label>
                                        <select name="category_id" class="form-control" id="category">
                                            <option value=""><?php echo e(__("Select Category")); ?></option>
                                            <?php $__currentLoopData = $all_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->lang_front->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="booking_time_ids"><?php echo e(__('Booking Time')); ?></label>
                                        <input type="hidden" name="booking_time_ids">
                                        <ul class="time_slot">
                                            <?php $__empty_1 = true; $__currentLoopData = $all_booking_time; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <li data-id="<?php echo e($data->id); ?>"><?php echo e($data->time); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <li><?php echo e(__('add appointment time first')); ?></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <label for="max_appointment"><?php echo e(__('Max Appointment')); ?></label>
                                        <input type="number" name="max_appointment" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="price"><?php echo e(__('Price')); ?></label>
                                        <input type="number" name="price" class="form-control">
                                    </div>

                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.media-upload','data' => ['name' => 'image','title' => __('Image'),'dimentions' => '350x500']]); ?>
<?php $component->withName('media-upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('image'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Image')),'dimentions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('350x500')]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    <div class="form-group">
                                        <label for="appointment_status"><strong><?php echo e(__('Available For Appointment')); ?></strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="appointment_status">
                                            <span class="slider onff"></span>
                                        </label>
                                    </div>

                                     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.backend.status-field','data' => ['name' => 'status','title' => __('Status')]]); ?>
<?php $component->withName('backend.status-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('status'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Status'))]); ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
                                    <button type="submit"
                                            class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Submit')); ?></button>
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
    <?php echo $__env->make('backend.partials.repeater.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        $(document).ready(function () {
            $(document).on('click','ul.time_slot li',function (e){
                e.preventDefault();
                //prent selector
                var parent = $(this).parent().parent();
                //append input field value by this id
                var ids = parent.find('input[name="booking_time_ids"]');
                var oldValue = ids.val()
                //assign new value =
                var id = $(this).data('id');
                if(oldValue != ''){
                    var oldValAr = oldValue.split(',');
                    if($(this).hasClass('selected')){
                        var oldValAr = oldValAr.filter(function (item){return item != id;});
                    }else{
                        oldValAr.push(id);
                    }
                    ids.val(oldValAr.toString());
                }else{
                    ids.val(id);
                }
                //add class for this li
                $(this).toggleClass('selected');
            });
            $(document).on('change', '#language', function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url: "<?php echo e(route('admin.appointment.category.by.lang')); ?>",
                    type: "POST",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        lang: selectedLang
                    },
                    success: function (data) {
                        $('#category').html('<option value=""><?php echo e(__("Select Category")); ?></option>');
                        $.each(data, function (index, value) {
                            $('#category').append('<option value="' + value.id + '">' + value.title + '</option>')
                        });
                    }
                });
            });
            $('.summernote').summernote({
                height: 250,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function (contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });
        });
    </script>
    <script src="<?php echo e(asset('assets/backend/js/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/dropzone.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-tagsinput.js')); ?>"></script>
    <?php echo $__env->make('backend.partials.media-upload.media-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/appointment/appointment-new.blade.php ENDPATH**/ ?>
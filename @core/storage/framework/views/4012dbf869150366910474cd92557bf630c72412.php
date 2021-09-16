<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('New Events Post')); ?>

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
                            <h4 class="header-title"><?php echo e(__('Add New Event Post')); ?></h4>
                            <a href="<?php echo e(route('admin.events.all')); ?>" class="btn btn-primary"><?php echo e(__('All Events')); ?></a>
                        </div>

                        <form action="<?php echo e(route('admin.events.new')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="language"><strong><?php echo e(__('Language')); ?></strong></label>
                                        <select name="lang" id="language" class="form-control">
                                            <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($lang->slug); ?>"><?php echo e($lang->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title"><?php echo e(__('Title')); ?></label>
                                        <input type="text" class="form-control"  id="title" name="title" value="<?php echo e(old('title')); ?>" placeholder="<?php echo e(__('Title')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug"><?php echo e(__('Slug')); ?></label>
                                        <input type="text" class="form-control"  id="slug" name="slug" value="<?php echo e(old('slug')); ?>" placeholder="<?php echo e(__('slug')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="category"><?php echo e(__('Category')); ?></label>
                                        <select name="category_id" class="form-control" id="category">
                                            <option value=""><?php echo e(__("Select Category")); ?></option>
                                            <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->title); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('Content')); ?></label>
                                        <input type="hidden" name="event_content" >
                                        <div class="summernote"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date"><?php echo e(__('Date')); ?></label>
                                        <input type="date" class="form-control datepicker"  id="date" name="date" placeholder="<?php echo e(__('Date')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="time"><?php echo e(__('Time')); ?></label>
                                        <input type="text" class="form-control"  id="time" name="time" placeholder="<?php echo e(__('time')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cost"><?php echo e(__('Cost')); ?></label>
                                        <input type="text" class="form-control"  id="cost" name="cost" placeholder="<?php echo e(__('cost')); ?>">
                                        <span class="info-text"><?php echo e(__('enter zero (0) to make this event free of cost')); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="available_tickets"><?php echo e(__('Available Tickets')); ?></label>
                                        <input type="text" class="form-control"  id="available_tickets" name="available_tickets" placeholder="<?php echo e(__('available tickets')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="organizer"><?php echo e(__('Organizer')); ?></label>
                                        <input type="text" class="form-control"  id="organizer" name="organizer" value="<?php echo e(old('organizer')); ?>" placeholder="<?php echo e(__('Event Organizer')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="organizer_email"><?php echo e(__('Organizer Email')); ?></label>
                                        <input type="text" class="form-control"  id="organizer_email" name="organizer_email" value="<?php echo e(old('organizer_email')); ?>" placeholder="<?php echo e(__('Organizer Email')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="organizer_phone"><?php echo e(__('Organizer Phone')); ?></label>
                                        <input type="text" class="form-control"  id="organizer_phone" name="organizer_phone" value="<?php echo e(old('organizer_phone')); ?>" placeholder="<?php echo e(__('Organizer Phone')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="organizer_website"><?php echo e(__('Organizer Website')); ?></label>
                                        <input type="text" class="form-control"  id="organizer_website" name="organizer_website" value="<?php echo e(old('organizer_website')); ?>" placeholder="<?php echo e(__('Organizer Website')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="venue"><?php echo e(__('Venue')); ?></label>
                                        <input type="text" class="form-control"  id="venue" name="venue" value="<?php echo e(old('venue')); ?>" placeholder="<?php echo e(__('Event Venue')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="venue_location"><?php echo e(__('Venue Location')); ?></label>
                                        <input type="text" class="form-control"  id="venue_location" name="venue_location" value="<?php echo e(old('venue_location')); ?>" placeholder="<?php echo e(__('Venue Location')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="venue_phone"><?php echo e(__('Venue Phone')); ?></label>
                                        <input type="text" class="form-control"  id="venue_phone" name="venue_phone" value="<?php echo e(old('venue_phone')); ?>" placeholder="<?php echo e(__('Venue Phone')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags"><?php echo e(__('Meta Tags')); ?></label>
                                        <input type="text" name="meta_tags"  class="form-control" data-role="tagsinput" id="meta_tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description"><?php echo e(__('Meta Description')); ?></label>
                                        <textarea name="meta_description"  class="form-control" rows="5" id="meta_description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image"><?php echo e(__('Image')); ?></label>
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap"></div>
                                            <input type="hidden" name="image">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="<?php echo e(__('Select Event Image')); ?>" data-modaltitle="<?php echo e(__('Upload Event Image')); ?>" data-toggle="modal" data-target="#media_upload_modal">
                                                <?php echo e(__('Upload Image')); ?>

                                            </button>
                                        </div>
                                        <small><?php echo e(__('Recommended image size 1920x1280')); ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="status"><?php echo e(__('Status')); ?></label>
                                        <select name="status" id="status"  class="form-control">
                                            <option value="publish"><?php echo e(__('Publish')); ?></option>
                                            <option value="draft"><?php echo e(__('Draft')); ?></option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Add New Event')); ?></button>
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
                    url: "<?php echo e(route('admin.events.category.by.lang')); ?>",
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
        });
    </script>
    <script src="<?php echo e(asset('assets/backend/js/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/dropzone.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-tagsinput.js')); ?>"></script>
    <?php echo $__env->make('backend.partials.media-upload.media-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/events/new-event.blade.php ENDPATH**/ ?>
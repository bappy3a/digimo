<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/toastr.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/frontend/js/toastr.min.js')); ?>"></script>
    <script>
        (function () {
            "use strict";

            $(document).on('click','.ajax_add_to_cart',function (e) {
                e.preventDefault();
                var allData = $(this).data();
                var el = $(this);
                $.ajax({
                    url : "<?php echo e(route('frontend.products.add.to.cart.ajax')); ?>",
                    type: "POST",
                    data: {
                        _token : "<?php echo e(csrf_token()); ?>",
                        'product_id' : allData.product_id,
                        'quantity' : allData.product_quantity,
                    },
                    beforeSend: function(){
                        el.text("<?php echo e(__('Adding')); ?>");
                    },
                    success: function (data) {
                        el.html('<i class="fa fa-shopping-bag" aria-hidden="true"></i>'+"<?php echo e(get_static_option('product_add_to_cart_button_'.$user_select_lang_slug.'_text')); ?>");
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "2000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.success(data.msg);
                        $('.navbar-area .nav-container .nav-right-content ul li.cart .pcount').text(data.total_cart_item);
                    }
                });
            });

        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/partials/ajax-addtocart.blade.php ENDPATH**/ ?>
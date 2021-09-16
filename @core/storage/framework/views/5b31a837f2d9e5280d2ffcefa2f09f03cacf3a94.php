<?php $__env->startSection('site-title'); ?>
    <?php echo e($product->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/toastr.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($product->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e($product->meta_tags); ?>">
    <meta name="tags" content="<?php echo e($product->meta_description); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('og-meta'); ?>
    <meta property="og:url" content="<?php echo e(route('frontend.products.single',$product->slug)); ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="<?php echo e($product->title); ?>"/>
    <?php echo render_og_meta_image_by_attachment_id($product->image); ?>

    <?php
        $post_img = null;
        $blog_image = get_attachment_image_by_id($product->image,"full",false);
        $post_img = !empty($blog_image) ? $blog_image['img_url'] : '';
    ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="product-content-area padding-top-120 padding-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $__env->make('backend.partials.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="single-product-details">
                        <div class="top-content">
                            <?php if(!empty($product->gallery)): ?>
                                <?php
                                    $product_gllery_images = !empty( $product->gallery) ? explode('|', $product->gallery) : [];
                                ?>
                                <div class="product-gallery">
                                    <div class="slider-gallery-slider">
                                        <?php $__currentLoopData = $product_gllery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gl_img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="single-gallery-slider-item">
                                                <?php echo render_image_markup_by_attachment_id($gl_img,'','large'); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="slider-gallery-nav">
                                        <?php $__currentLoopData = $product_gllery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gl_img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="single-gallery-slider-nav-item">
                                                <?php echo render_image_markup_by_attachment_id($gl_img,'','thumb'); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="thumb">
                                    <?php echo render_image_markup_by_attachment_id($product->image,'','large'); ?>

                                </div>
                            <?php endif; ?>
                            <div class="product-summery">
                                <?php if(count($product->ratings) > 0): ?>
                                    <div class="rating-wrap">
                                        <div class="ratings">
                                            <span class="hide-rating"></span>
                                            <span class="show-rating"
                                                  style="width: <?php echo e($average_ratings / 5 * 100); ?>%"></span>
                                        </div>
                                        <p><span class="total-ratings">(<?php echo e(count($product->ratings)); ?>)</span></p>
                                    </div>
                                <?php endif; ?>
                                <?php if(!get_static_option('display_price_only_for_logged_user')): ?>
                                <div class="price-wrap">
                                    <span class="price"><?php echo e($product->sale_price == 0 ? __('Free') : amount_with_currency_symbol($product->sale_price)); ?></span>
                                    <?php if(!empty($product->regular_price)): ?>
                                        <del class="del-price"><?php echo e(amount_with_currency_symbol($product->regular_price)); ?></del>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <div class="short-description">
                                    <p><?php echo e($product->short_description); ?></p>
                                </div>
                                <div class="single-add-to-card-wrapper">
                                    <?php if($product->stock_status == 'out_stock'): ?>
                                        <div class="out_of_stock"><?php echo e(__('Out Of Stock')); ?></div>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('frontend.products.add.to.cart')); ?>" method="post">
                                            <?php echo csrf_field(); ?>
                                            <input type="number" class="quantity" name="quantity" min="1" value="1">
                                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                            <button type="submit"
                                                    class="addtocart"><?php echo e(get_static_option('product_single_'.$user_select_lang_slug.'_add_to_cart_text')); ?></button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <div class="cat-sku-content-wrapper">
                                    <div class="category-wrap">
                                        <span class="title"><?php echo e(get_static_option('product_single_'.$user_select_lang_slug.'_category_text')); ?></span>
                                        <?php echo get_product_category_by_id($product->category_id,'link'); ?>

                                    </div>
                                    <?php if(!empty($product->sku)): ?>
                                        <div class="sku-wrap"><span
                                                class="title"><?php echo e(get_static_option('product_single_'.$user_select_lang_slug.'_sku_text')); ?></span>
                                            <span class="sku_"><?php echo e($product->sku); ?></span></div>
                                    <?php endif; ?>
                                    <div class="share-wrap">
                                       <ul class="social-icons">
                                           <li class="title"><?php echo e(__('Share')); ?>:</li>
                                           <?php echo single_post_share(route('frontend.blog.single',$product->slug),$product->title,$post_img); ?>

                                       </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bottom-content">
                            <div class="extra-content-wrap">
                                <nav>
                                    <div class="nav nav-tabs" role="tablist">
                                        <a class="nav-item nav-link active" data-toggle="tab" href="#nav-description"
                                           role="tab"
                                           aria-selected="true"><?php echo e(get_static_option('product_single_'.$user_select_lang_slug.'_description_text')); ?></a>
                                        <?php
                                        $product_attributes_title = unserialize($product->attributes_title);
                                        ?>
                                        <?php if(!empty($product_attributes_title[0]) ): ?>
                                            <a class="nav-item nav-link" data-toggle="tab" href="#nav-attributes"
                                               role="tab"
                                               aria-selected="false"><?php echo e(get_static_option('product_single_'.$user_select_lang_slug.'_attributes_text')); ?></a>
                                        <?php endif; ?>
                                        <?php if(!empty(get_static_option('product_single_related_products_status'))): ?>
                                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-ratings" role="tab"
                                           aria-selected="false"><?php echo e(get_static_option('product_single_'.$user_select_lang_slug.'_ratings_text')); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </nav>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel">
                                        <div class="product-description">
                                            <?php echo $product->description; ?>

                                        </div>
                                    </div>
                                    <?php if(!empty($product_attributes_title[0])): ?>
                                        <div class="tab-pane fade" id="nav-attributes" role="tabpanel">
                                            <?php
                                                $att_title = unserialize($product->attributes_title);
                                                $att_descr = unserialize($product->attributes_description);
                                            ?>
                                            <?php if(!empty($att_title)): ?>
                                                <div class="table-wrap table-responsive">
                                                    <table class="table table-bordered">
                                                        <?php $__currentLoopData = $att_title; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $att_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <th><?php echo e($att_title); ?></th>
                                                                <td><?php echo e($att_descr[$key]); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </table>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty(get_static_option('product_single_related_products_status'))): ?>
                                    <div class="tab-pane fade" id="nav-ratings" role="tabpanel">
                                        <div class="product-rating">
                                            <div class="rating-wrap">
                                                <div class="ratings">
                                                    <span class="hide-rating"></span>
                                                    <span class="show-rating"
                                                          style="width: <?php echo e($average_ratings / 5 * 100); ?>%"></span>
                                                </div>
                                                <p><span class="total-ratings">(<?php echo e(count($product->ratings)); ?>)</span></p>
                                            </div>
                                            <?php if(count($product->ratings) > 0): ?>
                                                <ul class="product-rating-list">
                                                    <?php $__currentLoopData = $product->ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <div class="single-product-rating-item">
                                                                <div class="content">
                                                                    <h4 class="title"><?php echo e(get_user_name_by_id($rating->user_id) ? get_user_name_by_id($rating->user_id)->name : __('anonymous')); ?></h4>
                                                                    <div class="ratings text-warning">
                                                                        <?php echo render_ratings($rating->ratings); ?>

                                                                    </div>
                                                                    <p><?php echo e($rating->message); ?></p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                            <div class="product-ratings-form">
                                                <?php if(auth()->check()): ?>
                                                    <h4 class="title"><?php echo e(__('Leave A Review')); ?></h4>
                                                    <?php if($errors->any()): ?>
                                                        <ul class="alert alert-danger">
                                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li><?php echo e($error); ?></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                    <form action="<?php echo e(route('product.ratings.store')); ?>" method="post"
                                                          enctype="multipart/form-data">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                                        <div class="form-group">
                                                            <label
                                                                for="rating-empty-clearable2"><?php echo e(__('Ratings')); ?></label>
                                                            <input type="number" name="ratings"
                                                                   id="rating-empty-clearable2"
                                                                   class="rating text-warning"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ratings_message"><?php echo e(__('Message')); ?></label>
                                                            <textarea name="ratings_message" class="form-control"
                                                                      id="ratings_message" cols="30" rows="5"
                                                                      placeholder="<?php echo e(__('Message')); ?>"></textarea>
                                                        </div>
                                                        <div class="btn-wrapper">
                                                            <button type="submit"
                                                                    class="btn-boxed style-01"><?php echo e(__('Submit')); ?></button>
                                                        </div>
                                                    </form>
                                                <?php else: ?>
                                                  <?php echo $__env->make('frontend.partials.ajax-login-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(count($related_products) > 0 && !empty(get_static_option('product_single_related_products_status'))): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="related-product-area">
                            <h3 class="title"><?php echo e(get_static_option('product_single_'.$user_select_lang_slug.'_related_product_text')); ?></h3>
                            <div class="related-product-wrapper">
                                <div class="row">
                                    <?php $__currentLoopData = $related_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-lg-3">
                                            <div class="single-product-item-3 margin-bottom-30">
                                                <div class="thumb">
                                                    <a href="<?php echo e(route('frontend.products.single',$data->slug)); ?>">
                                                        <div class="img-wrapper">
                                                            <?php echo render_image_markup_by_attachment_id($data->image,'','grid'); ?>

                                                        </div>
                                                    </a>
                                                    <?php if(!empty($data->badge)): ?>
                                                        <span class="tag"><?php echo e($data->badge); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="content">
                                                    <a href="<?php echo e(route('frontend.products.single',$data->slug)); ?>">
                                                        <h4 class="title"><?php echo e($data->title); ?></h4>
                                                    </a>
                                                    <?php if(count($data->ratings) > 0): ?>
                                                        <div class="rating-wrap">
                                                            <div class="ratings">
                                                                <span class="hide-rating"></span>
                                                                <span class="show-rating"
                                                                      style="width: <?php echo e(get_product_ratings_avg_by_id($data->id) / 5 * 100); ?>%"></span>
                                                            </div>
                                                            <p><span
                                                                    class="total-ratings">(<?php echo e(count($data->ratings)); ?>)</span>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="price-wrap">
                                                        <span
                                                            class="price"><?php echo e(amount_with_currency_symbol($data->sale_price)); ?></span>
                                                        <?php if(!empty($data->regular_price)): ?>
                                                            <del class="del-price"><?php echo e(amount_with_currency_symbol($data->regular_price)); ?></del><?php endif; ?>
                                                    </div>
                                                    <?php if($data->stock_status == 'out_stock'): ?>
                                                        <div class="out_of_stock"><?php echo e(__('Out Of Stock')); ?></div>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('frontend.products.add.to.cart')); ?>"
                                                           class="addtocart ajax_add_to_cart"
                                                           data-product_id="<?php echo e($data->id); ?>"
                                                           data-product_title="<?php echo e($data->title); ?>"
                                                           data-product_quantity="1"><i class="fa fa-shopping-bag"
                                                                                        aria-hidden="true"></i>
                                                            <?php echo e(get_static_option('product_add_to_cart_button_'.$user_select_lang_slug.'_text')); ?>

                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="//use.fontawesome.com/5ac93d4ca8.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/frontend/js/bootstrap4-rating-input.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/toastr.min.js')); ?>"></script>
    <?php echo $__env->make('frontend.partials.ajax-login-form-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        (function ($) {
            "use strict";

            var rtlEnable = $('html').attr('dir');
            var sliderRtlValue = typeof rtlEnable === 'undefined' ||  rtlEnable === 'ltr' ? false : true ;

            $(document).ready(function () {

                $('.slider-gallery-slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.slider-gallery-nav',
                    rtl: sliderRtlValue
                });
                $('.slider-gallery-nav').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.slider-gallery-slider',
                    dots: false,
                    arrows: false,
                    centerMode: false,
                    focusOnSelect: true,
                    rtl: sliderRtlValue
                });

                $(document).on('click', '.ajax_add_to_cart', function (e) {
                    e.preventDefault();
                    var allData = $(this).data();
                    var el = $(this);
                    $.ajax({
                        url: "<?php echo e(route('frontend.products.add.to.cart.ajax')); ?>",
                        type: "POST",
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>",
                            'product_id': allData.product_id,
                            'quantity': allData.product_quantity,
                        },
                        beforeSend: function () {
                            el.text("<?php echo e(__('Adding')); ?>");
                        },
                        success: function (data) {
                            el.html('<i class="fa fa-shopping-bag" aria-hidden="true"></i>' + "<?php echo e(get_static_option('product_add_to_cart_button_'.$user_select_lang_slug.'_text')); ?>");
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
            });

        })(jQuery)
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/products/product-single.blade.php ENDPATH**/ ?>
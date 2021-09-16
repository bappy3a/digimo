<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Category:')); ?> <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Category:')); ?> <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('product_page_'.$user_select_lang_slug.'_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('product_page_'.$user_select_lang_slug.'_meta_tags')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-6">
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
                                            <span class="show-rating" style="width: <?php echo e(get_product_ratings_avg_by_id($data->id) / 5 * 100); ?>%"></span>
                                        </div>
                                        <p><span class="total-ratings">(<?php echo e(count($data->ratings)); ?>)</span></p>
                                    </div>
                                <?php endif; ?>
                                <?php if(!get_static_option('display_price_only_for_logged_user')): ?>
                                <div class="price-wrap">
                                    <span class="price"><?php echo e(amount_with_currency_symbol($data->sale_price)); ?></span>
                                    <?php if(!empty($data->regular_price)): ?><del class="del-price"><?php echo e(amount_with_currency_symbol($data->regular_price)); ?></del><?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php if($data->stock_status == 'out_stock'): ?>
                                    <div class="out_of_stock"><?php echo e(__('Out Of Stock')); ?></div>
                                <?php else: ?>
                                    <a href="<?php echo e(route('frontend.products.add.to.cart')); ?>" class="addtocart ajax_add_to_cart" data-product_id="<?php echo e($data->id); ?>" data-product_title="<?php echo e($data->title); ?>" data-product_quantity="1"><i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        <?php echo e(get_static_option('product_add_to_cart_button_'.$user_select_lang_slug.'_text')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-12 text-center">
                    <nav class="pagination-wrapper " aria-label="Page navigation ">
                        <?php echo e($all_products->links()); ?>

                    </nav>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.partials.ajax-addtocart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/frontend/pages/products/product-category.blade.php ENDPATH**/ ?>
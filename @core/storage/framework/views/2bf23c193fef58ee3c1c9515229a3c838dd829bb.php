<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <title><?php echo e(get_static_option('site_'.get_default_language().'_title')); ?> <?php echo e(__('Mail')); ?></title>

    <style>
        *{
            font-family: 'Open Sans', sans-serif;
        }
        .mail-container {
            max-width: 650px;
            margin: 0 auto;
            text-align: center;
        }

        .mail-container .logo-wrapper {
            background-color: <?php echo e(get_static_option('site_main_color_two')); ?>;
            padding: 20px 0 20px;
        }
        table {
            margin: 0 auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even){background-color: #f2f2f2;}

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #f2f2f2;
            color: #333;
            text-transform: capitalize;
        }
        footer {
            margin: 20px 0;
            font-size: 14px;
        }
        .product-thumbnail img {
            max-width: 150px;
        }
        .product-title {
            text-align: left;
            font-weight: 500;
        }
        .billing-wrap,
        .shipping-wrap{
            text-align: left;
        }
        .subtitle {
            font-size: 20px;
            line-height: 30px;
            font-weight: 600;
        }
        .billing-wrap ul,
        .shipping-wrap ul{
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .billing-wrap ul li,
        .shipping-wrap ul li{
            margin: 5px 0;
        }
        .billing-wrap ul li strong,
        .shipping-wrap ul li strong{
            min-width: 100px;
            display: inline-block;
            position: relative;
        }

        .billing-wrap ul li strong:after ,
        .shipping-wrap ul li strong:after {
            position: absolute;
            right: 0;
            top: 0;
            content: ":";
        }
        .order-summery{
            margin-top: 40px;
            background-color: #f6f8ff;
            padding: 30px;
            text-align: left;
        }
        .order-summery table{
            text-align: left;
        }
        .extra-data {
            text-align: left;
            margin-bottom: 40px;
        }

        .extra-data ul {
            padding: 0;
            list-style: none;
            margin: 20px 0;
        }

        .extra-data ul li {
            margin-top: 14px;
        }
        .description h4 {
            font-size: 24px;
            margin-bottom: 5px;
            line-height: 34px;
        }

        .description p {
            margin: 0;
            margin-bottom: 40px;
            color: #f36d2e;
        }
        .brief-wrapper p {
            margin: 0;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: 500;
            line-height: 26px;
        }

        .brief-wrapper {
            background-color: #f6f8ff;
            padding: 30px;
            text-align: left;
            margin-bottom: 40px;
        }
        .customer-data .subtitle {
            margin-top: 0;
        }
        .customer-data {
            display: flex;
            justify-content: space-between;
            background-color: #f6f8ff;
            padding: 30px;
            margin-bottom: 50px;
        }
        .product-info-wrap {
            text-align: left;
            padding: 20px;
            padding-top: 0;
        }

        .product-info-wrap h4 {
            font-size: 18px;
            line-height: 20px;
            margin-bottom: 20px;
        }

        .product-info-wrap .pdetails {
            font-size: 14px;
            display: block;
            line-height: 20px;
            margin-bottom: 2px;
        }
        .product-info-wrap h4 a {
            color: #333;
        }
        .order-summery h2 {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="mail-container">
    <div class="logo-wrapper">
        <a href="<?php echo e(url('/')); ?>">
            <?php echo render_image_markup_by_attachment_id(get_static_option('site_white_logo')); ?>

        </a>
    </div>
    <?php if($type == 'customer'): ?>
        <div class="description">
            <h4><?php echo e(__('Your Order has been Placed')); ?></h4>
            <p><?php echo e(__('Order')); ?> #<?php echo e($data->id); ?></p>
        </div>
        <div class="brief-wrapper">
            <p> <?php echo e(__('Hey')); ?> <?php echo e($data->billing_name); ?></p>
            <p><?php echo e(__('Your order')); ?> #<?php echo e($data->id); ?> <?php echo e(__('has been placed on')); ?> <?php echo e(date_format($data->created_at,'d F Y H:m:s')); ?> <?php echo e(__('via')); ?> <?php echo e(ucwords(str_replace('_',' ',$data->payment_gateway))); ?>. <?php echo e(__('You will be updated with another email after your item(s) has been shipped.')); ?></p>
        </div>
    <?php else: ?>
        <div class="description">
            <h4><?php echo e(__('Your have a new order')); ?></h4>
            <p><?php echo e(__('Order')); ?> #<?php echo e($data->id); ?></p>
        </div>
        <div class="brief-wrapper">
            <p> <?php echo e(__('Hey')); ?> </p>
            <p><?php echo e(__('Your have an order')); ?> #<?php echo e($data->id); ?> <?php echo e($data->billing_name); ?> <?php echo e(__('has been placed it on')); ?> <?php echo e(date_format($data->created_at,'d F Y H:m:s')); ?> <?php echo e(__('via')); ?> <?php echo e(ucwords(str_replace('_',' ',$data->payment_gateway))); ?>.</p>
        </div>
    <?php endif; ?>
    <div class="customer-data">
        <div class="billing-wrap">
            <h2 class="subtitle"><?php echo e(__('Billing Details')); ?></h2>
            <ul>
                <li><strong><?php echo e(__('Name')); ?></strong> <?php echo e($data->billing_name); ?></li>
                <li><strong><?php echo e(__('Email')); ?></strong> <?php echo e($data->billing_email); ?></li>
                <li><strong><?php echo e(__('Phone')); ?></strong> <?php echo e($data->billing_phone); ?></li>
                <li><strong><?php echo e(__('Country')); ?></strong> <?php echo e($data->billing_country); ?></li>
                <li><strong><?php echo e(__('Address')); ?></strong> <?php echo e($data->billing_street_address); ?></li>
                <li><strong><?php echo e(__('Town')); ?></strong> <?php echo e($data->billing_town); ?></li>
                <li><strong><?php echo e(__('District')); ?></strong>  <?php echo e($data->billing_district); ?></li>
            </ul>
        </div>
        <?php if($data->different_shipping_address == 'yes'): ?>
            <div class="shipping-wrap">
                <h2 class="subtitle"><?php echo e(__('Shipping Details')); ?></h2>
                <ul>
                    <li><strong><?php echo e(__('Name')); ?></strong> <?php echo e($data->shipping_name); ?></li>
                    <li><strong><?php echo e(__('Email')); ?></strong> <?php echo e($data->shipping_email); ?></li>
                    <li><strong><?php echo e(__('Phone')); ?></strong> <?php echo e($data->shipping_phone); ?></li>
                    <li><strong><?php echo e(__('Country')); ?></strong> <?php echo e($data->shipping_country); ?></li>
                    <li><strong><?php echo e(__('Address')); ?></strong> <?php echo e($data->shipping_street_address); ?></li>
                    <li><strong><?php echo e(__('Town')); ?></strong> <?php echo e($data->shipping_town); ?></li>
                    <li><strong><?php echo e(__('District')); ?></strong> <?php echo e($data->shipping_district); ?></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <table>
        <thead>
        <th><?php echo e(__('thumbnail')); ?></th>
        <th><?php echo e(__('Product Info')); ?></th>
        </thead>
        <tbody>
        <?php $cart_items = unserialize($data->cart_items); ?>
        <?php $__currentLoopData = $cart_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $product_info = \App\Products::find($item['id']);?>
            <tr>
                <td>
                    <div class="product-thumbnail">
                        <?php echo render_image_markup_by_attachment_id($product_info->image,'','thumb'); ?>

                    </div>
                </td>
                <td>
                    <div class="product-info-wrap">
                        <h4 class="product-title"><a href="<?php echo e(route('frontend.products.single',$product_info->slug)); ?>"><?php echo e($product_info->title); ?></a></h4>
                        <span class="pdetails"><strong><?php echo e(__('Price :')); ?></strong> <?php echo e(amount_with_currency_symbol($product_info->sale_price)); ?></span>
                        <span class="pdetails"><strong><?php echo e(__('Quantity :')); ?></strong> <?php echo e($item['quantity']); ?></span>
                        <?php $tax_amount = 0;?>
                        <?php if(get_static_option('product_tax_type') == 'individual' && is_tax_enable()): ?>
                            <?php
                                $percentage = !empty($product_info->tax_percentage) ? $product_info->tax_percentage : 0;
                                $tax_amount = ($product_info->sale_price * $item['quantity']) / 100 * $product_info->tax_percentage;
                            ?>
                            <span class="pdetails" style="color: red"><strong><?php echo e(__('Tax')); ?> <?php echo e(($percentage.'% :')); ?></strong> +<?php echo e(amount_with_currency_symbol($tax_amount)); ?></span>
                        <?php endif; ?>
                        <span class="pdetails"><strong><?php echo e(__('Subtotal :')); ?></strong> <?php echo e(amount_with_currency_symbol($product_info->sale_price * $item['quantity'] + $tax_amount )); ?></span>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="order-summery">
        <h2 class="title"><?php echo e(__('Order Summery')); ?></h2>
        <div class="extra-data">
            <ul>
                <li><strong><?php echo e(__('Shipping Method:')); ?></strong> <?php echo e(ucwords(get_shipping_name_by_id($data->product_shippings_id))); ?></li>
                <li><strong><?php echo e(__('Payment Method:')); ?></strong> <?php echo e(str_replace('_',' ', ucfirst($data->payment_gateway))); ?></li>
                <li><strong><?php echo e(__('Payment Status:')); ?></strong> <?php echo e(ucfirst($data->payment_status)); ?></li>
            </ul>
        </div>
        <table>
            <tr>
                <td><strong><?php echo e(__('Subtotal')); ?></strong></td>
                <td><?php echo e(amount_with_currency_symbol($data->subtotal)); ?></td>
            </tr>
            <tr>
                <td><strong><?php echo e(__('Coupon Discount')); ?></strong></td>
                <td>- <?php echo e(amount_with_currency_symbol($data->coupon_discount)); ?></td>
            </tr>
            <tr>
                <td><strong><?php echo e(__('Shipping Cost')); ?></strong></td>
                <td>+ <?php echo e(amount_with_currency_symbol($data->shipping_cost)); ?></td>
            </tr>
            <?php if(is_tax_enable()): ?>
                <?php $tax_percentage = get_static_option('product_tax_type') == 'total' ? '('.get_static_option('product_tax_percentage').')' : '';  ?>
                <tr>
                    <td><strong><?php echo e(__('Tax')); ?> <?php echo e($tax_percentage); ?></strong></td>
                    <td>+ <?php echo e(amount_with_currency_symbol(cart_tax_for_mail_template($cart_items))); ?></td>
                </tr>
            <?php endif; ?>

            <tr>
                <td><strong><?php echo e(__('Total')); ?></strong></td>
                <td><?php echo e(amount_with_currency_symbol($data->total)); ?></td>
            </tr>
        </table>
        <?php if(get_static_option('product_tax') && get_static_option('product_tax_system') == 'inclusive'): ?>
            <p><?php echo e(__('Inclusive of custom duties and taxes where applicable')); ?></p>
        <?php endif; ?>
    </div>

    <footer>
        <p> <?php echo get_footer_copyright_text(); ?></p>
    </footer>
</div>
</body>
</html>
<?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/mail/product-order.blade.php ENDPATH**/ ?>
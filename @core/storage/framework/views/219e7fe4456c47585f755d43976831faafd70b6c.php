<?php
    $site_color = get_static_option('site_color');
    $secondary_color = get_static_option('site_secondary_color');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title><?php echo e(get_static_option('site_'.get_default_language().'_title')); ?> - <?php echo e(get_static_option('site_'.get_default_language().'_tag_line')); ?></title>
    <style>
        *{
            font-family: 'Montserrat', sans-serif;
        }

        .billing-details {
            text-align: left;
            padding-left: 15px;
            margin-bottom: 50px;
        }

        .billing-details li {
            line-height: 30px;
        }
        .mail-container {
            max-width: 650px;
            margin: 0 auto;
            text-align: center;
        }
        .logo-inner-wrapper {
            padding: 10px;
            background-color: <?php echo e($secondary_color); ?>;
            margin: 0 auto;
            width: 250px;
            height: 50px;
            line-height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-inner-wrapper img {
            max-width: 200px;
        }

        .logo-inner-wrapper a {
            display: flex;
        }
        .mail-container .logo-wrapper {
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

        table tr:hover {background-color: #ddd;}

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #111d5c;
            color: white;
        }
        footer {
            margin: 20px 0;
            font-size: 14px;
        }
        .message-wrap {
            text-align: left;
            font-size: 16px;
            line-height: 26px;
            margin-bottom: 40px;
        }

        .message-wrap p {
            margin: 0;
        }

        .single-price-plan-01 {
            text-align: center;
            -webkit-transition: 0.3s ease-in;
            -o-transition: 0.3s ease-in;
            transition: 0.3s ease-in;
            position: relative;
            z-index: 0;
            overflow: hidden;
            background-color: <?php echo e($site_color); ?>;
            padding: 40px 0 60px;
            -webkit-box-shadow: 0px 0px 7px 0px rgba(48, 55, 63, 0.35);
            box-shadow: 0px 0px 7px 0px rgba(48, 55, 63, 0.35);
            color: #fff;
        }

        .single-price-plan-01 .price-header {
            position: relative;
        }

        .single-price-plan-01 .price-header .name-box .name {
            font-weight: 700;
            font-size: 24px;
            -webkit-transition: 0.3s ease-in;
            -o-transition: 0.3s ease-in;
            transition: 0.3s ease-in;
            margin: 0;
        }

        .single-price-plan-01 .price-header .title {
            color: #fff;
            font-size: 24px;
            line-height: 36px;
            font-weight: 600;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        .single-price-plan-01 .price-header .price-wrap {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .single-price-plan-01 .price-header .price-wrap .price {
            font-size: 72px;
            line-height: 60px;
            font-weight: 700;
            -webkit-transition: 0.3s ease-in;
            -o-transition: 0.3s ease-in;
            transition: 0.3s ease-in;
            text-align: center;
            position: relative;
            z-index: 0;
            margin-top: 20px;
        }

        .single-price-plan-01 .price-header .price-wrap .price .dollar {
            font-size: 33px;
            line-height: 33px;
            position: relative;
            top: -12px;
        }

        .single-price-plan-01 .price-header .price-wrap .month {
            font-size: 18px;
            line-height: 20px;
            -webkit-transition: 0.3s ease-in;
            -o-transition: 0.3s ease-in;
            transition: 0.3s ease-in;
        }

        .single-price-plan-01 .price-body ul {
            margin: 0;
            padding: 0;
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .single-price-plan-01 .price-body ul li {
            list-style: none;
            display: block;
            margin: 15px 0;
            font-size: 16px;
            font-weight: 500;
            -webkit-transition: 0.3s ease-in;
            -o-transition: 0.3s ease-in;
            transition: 0.3s ease-in;
            opacity: .7;
        }

        .single-price-plan-01 .price-body ul li:first-child {
            margin-top: 0;
        }

        .single-price-plan-01 .price-body ul li:last-child {
            margin-bottom: 0;
        }
        .content-wrapper {
            padding: 30px;
            background-color: #f2f2f2;
            border-top: 5px solid <?php echo e($site_color); ?>;
        }
    </style>
</head>
<body>
<div class="mail-container">
    <div class="logo-wrapper">
       <div class="logo-inner-wrapper">
           <a href="<?php echo e(url('/')); ?>">
               <?php echo render_image_markup_by_attachment_id(get_static_option('site_white_logo')); ?>

           </a>
       </div>
    </div>
    <div class="content-wrapper">
       <div class="message-wrap">
           <span class="hello"><?php echo e(__('Hello')); ?>,</span>
           <p class="message"><?php echo e($data_message); ?></p>
       </div>
        <div class="bottom-wrap">
            <div class="billing-wrap">
                <ul class="billing-details">
                    <li><strong><?php echo e(__('Order ID')); ?>:</strong> #<?php echo e($data->id); ?></li>
                    <li><strong><?php echo e(__('Name')); ?>:</strong> <?php echo e($payment_log->name); ?></li>
                    <li><strong><?php echo e(__('Email')); ?>:</strong> <?php echo e($payment_log->email); ?></li>
                    <li><strong><?php echo e(__('Payment Method')); ?>:</strong>  <?php echo e(str_replace('_',' ',$payment_log->package_gateway)); ?></li>
                    <li><strong><?php echo e(__('Payment Status')); ?>:</strong> <?php echo e($payment_log->status); ?></li>
                    <li><strong><?php echo e(__('Transaction id')); ?>:</strong> <?php echo e($payment_log->transaction_id); ?></li>
                </ul>
            </div>
            <div class="price-plan-wrap">
                <div class="single-price-plan-01 style-02 active">
                    <div class="price-header">
                        <div class="name-box">
                            <h4 class="name"><?php echo e($package->title); ?></h4>
                        </div>
                        <div class="price-wrap">
                            <span class="price"><?php echo e(amount_with_currency_symbol($package->price)); ?></span><span class="month"><?php echo e($package->type); ?></span>
                        </div>
                    </div>
                    <div class="price-body">
                        <ul>
                            <?php
                                $features = explode("\n",$package->features);
                            ?>
                            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($item); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?php echo get_footer_copyright_text(); ?>

    </footer>
</div>
</body>
</html>
<?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/mail/order.blade.php ENDPATH**/ ?>
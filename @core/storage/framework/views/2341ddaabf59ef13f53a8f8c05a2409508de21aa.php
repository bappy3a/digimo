<?php if(request()->path() == '/'): ?>
    <meta property="og:title"  content="<?php echo e(filter_static_option_value('site_'.$user_select_lang_slug.'_title',$global_static_field_data)); ?>" />
    <?php echo render_og_meta_image_by_attachment_id(filter_static_option_value('og_meta_image_for_site',$global_static_field_data)); ?>

<?php else: ?>
    <?php echo $__env->yieldContent('page-meta-data'); ?>
<?php endif; ?>

<?php if(request()->is([
    filter_static_option_value('testimonial_page_slug',$global_static_field_data),
            filter_static_option_value('quote_page_slug',$global_static_field_data),
            filter_static_option_value('donor_page_slug',$global_static_field_data),
            filter_static_option_value('team_page_slug',$global_static_field_data),
            filter_static_option_value('image_gallery_page_slug',$global_static_field_data),
            filter_static_option_value('clients_feedback_page_slug',$global_static_field_data),
            filter_static_option_value('feedback_page_slug',$global_static_field_data),
            filter_static_option_value('support_ticket_page_slug',$global_static_field_data),
            filter_static_option_value('about_page_slug',$global_static_field_data),
            filter_static_option_value('team_page_slug',$global_static_field_data),
            filter_static_option_value('faq_page_slug',$global_static_field_data),
            filter_static_option_value('contact_page_slug',$global_static_field_data),
            filter_static_option_value('price_plan_page_slug',$global_static_field_data),
            filter_static_option_value('price_plan_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('product_page_slug',$global_static_field_data),
            filter_static_option_value('product_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('donation_page_slug',$global_static_field_data),
            filter_static_option_value('donation_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('service_page_slug',$global_static_field_data),
            filter_static_option_value('service_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('blog_page_slug',$global_static_field_data),
            filter_static_option_value('blog_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('career_with_us_page_slug',$global_static_field_data),
            filter_static_option_value('career_with_us_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('events_page_slug',$global_static_field_data),
            filter_static_option_value('events_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('knowledgebase_page_slug',$global_static_field_data),
            filter_static_option_value('knowledgebase_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('work_page_slug',$global_static_field_data),
            filter_static_option_value('work_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('appointment_page_slug',$global_static_field_data),
            filter_static_option_value('appointment_page_slug',$global_static_field_data).'/*',
            filter_static_option_value('courses_page_slug',$global_static_field_data),
            filter_static_option_value('courses_page_slug',$global_static_field_data).'/*',
filter_static_option_value('blog_page_slug',$global_static_field_data).'/*',
])): ?>
    <?php echo $__env->yieldContent('og-meta'); ?>
    <title><?php echo $__env->yieldContent('site-title'); ?> - <?php echo e(filter_static_option_value('site_'.$user_select_lang_slug.'_title',$global_static_field_data)); ?> </title>
<?php else: ?>
    <title><?php echo e(filter_static_option_value('site_'.$user_select_lang_slug.'_title',$global_static_field_data)); ?> - <?php echo e(filter_static_option_value('site_'.$user_select_lang_slug.'_tag_line',$global_static_field_data)); ?></title>
    <meta name="description" content="<?php echo e(filter_static_option_value('site_meta_'.$user_select_lang_slug.'_description',$global_static_field_data)); ?>">
    <meta name="tags" content="<?php echo e(filter_static_option_value('site_meta_'.$user_select_lang_slug.'_tags',$global_static_field_data)); ?>">
<?php endif; ?><?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/frontend/partials/og-meta.blade.php ENDPATH**/ ?>
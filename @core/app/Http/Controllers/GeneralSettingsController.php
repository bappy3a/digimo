<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\AppointmentLang;
use App\Helpers\NexelitHelpers;
use App\Language;
use App\Mail\BasicMail;
use App\MediaUpload;
use App\PopupBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\Sitemap\SitemapGenerator;
use Symfony\Component\Process\Process;

class GeneralSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function color_settings()
    {
        return view('backend.general-settings.color-settings');
    }

    public function update_color_settings(Request $request)
    {
        $this->validate($request, [
            'site_color' => 'required|string',
            'site_main_color_two' => 'required|string',
            'site_paragraph_color' => 'nullable|string',
            'site_heading_color' => 'nullable|string',
            'site_secondary_color' => 'nullable|string',
            'construction_home_color' => 'nullable|string',
        ]);


        $all_fields = [
            'site_color',
            'site_secondary_color',
            'site_main_color_two',
            'site_heading_color',
            'site_paragraph_color',
            'portfolio_home_color',
            'logistics_home_color',
            'industry_home_color',
            'construction_home_color',
            'grocery_home_two_color',
            'grocery_home_color',
            'course_home_two_color',
            'course_home_color',
            'cleaning_home_two_color',
            'cleaning_home_color',
            'dagency_home_color',
            'charity_home_color',
            'portfolio_home_dark_two_color',
            'portfolio_home_dark_color',
            'fruits_home_heading_color',
            'fruits_home_color',
            'medical_home_color_two',
            'medical_home_color',
            'political_home_color',
            'lawyer_home_color',
        ];

        foreach ($all_fields as $field){
            update_static_option($field,$request->$field);
        }

        return back()->with(NexelitHelpers::settings_update());
    }

    public function smtp_settings()
    {
        return view('backend.general-settings.smtp-settings');
    }

    public function update_smtp_settings(Request $request)
    {
        $this->validate($request, [
            'site_smtp_mail_host' => 'required|string',
            'site_smtp_mail_port' => 'required|string',
            'site_smtp_mail_username' => 'required|string',
            'site_smtp_mail_password' => 'required|string',
            'site_smtp_mail_encryption' => 'required|string'
        ]);

        update_static_option('site_smtp_mail_mailer', $request->site_smtp_mail_mailer);
        update_static_option('site_smtp_mail_host', $request->site_smtp_mail_host);
        update_static_option('site_smtp_mail_port', $request->site_smtp_mail_port);
        update_static_option('site_smtp_mail_username', $request->site_smtp_mail_username);
        update_static_option('site_smtp_mail_password', $request->site_smtp_mail_password);
        update_static_option('site_smtp_mail_encryption', $request->site_smtp_mail_encryption);

        $env_val['MAIL_DRIVER'] =  $request->site_smtp_mail_mailer ?? 'MAIL_DRIVER';
        $env_val['MAIL_HOST'] = $request->site_smtp_mail_host ?? 'YOUR_SMTP_MAIL_HOST';
        $env_val['MAIL_PORT'] =  $request->site_smtp_mail_port ?? 'YOUR_SMTP_MAIL_POST';
        $env_val['MAIL_USERNAME'] = $request->site_smtp_mail_username ?? 'YOUR_SMTP_MAIL_USERNAME';
        $env_val['MAIL_PASSWORD'] =  $request->site_smtp_mail_password ? '"'.$request->site_smtp_mail_password.'"' : 'YOUR_SMTP_MAIL_USERNAME_PASSWORD';
        $env_val['MAIL_ENCRYPTION'] =  $request->site_smtp_mail_encryption ?? 'YOUR_SMTP_MAIL_ENCRYPTION';

        setEnvValue($env_val);

        return redirect()->back()->with(['msg' => __('SMTP Settings Updated...'), 'type' => 'success']);
    }

    public function regenerate_image_settings()
    {
        return view('backend.general-settings.regenerate-image');
    }

    public function update_regenerate_image_settings(Request $request)
    {
        $all_media_file = MediaUpload::all();
        foreach ($all_media_file as $img) {

            if (!file_exists('assets/uploads/media-uploader/' . $img->path)) {
                continue;
            }
            $image = 'assets/uploads/media-uploader/' . $img->path;
            $image_dimension = getimagesize($image);;
            $image_width = $image_dimension[0];
            $image_height = $image_dimension[1];

            $image_db = $img->path;
            $image_grid = 'grid-' . $image_db;
            $image_large = 'large-' . $image_db;
            $image_thumb = 'thumb-' . $image_db;

            $folder_path = 'assets/uploads/media-uploader/';
            $resize_grid_image = Image::make($image)->resize(350, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_large_image = Image::make($image)->resize(740, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resize_thumb_image = Image::make($image)->resize(150, 150);

            if ($image_width > 150) {
                $resize_thumb_image->save($folder_path . $image_thumb);
                $resize_grid_image->save($folder_path . $image_grid);
                $resize_large_image->save($folder_path . $image_large);
            }

        }

        return redirect()->back()->with(['msg' => __('Image Regenerate Success...'), 'type' => 'success']);
    }

    public function custom_js_settings()
    {
        $custom_js = '/* Write Custom js Here */';
        if (file_exists('assets/frontend/js/dynamic-script.js')) {
            $custom_js = file_get_contents('assets/frontend/js/dynamic-script.js');
        }
        return view('backend.general-settings.custom-js')->with(['custom_js' => $custom_js]);
    }

    public function update_custom_js_settings(Request $request)
    {
        file_put_contents('assets/frontend/js/dynamic-script.js', $request->custom_js_area);

        return redirect()->back()->with(['msg' => __('Custom Script Added Success...'), 'type' => 'success']);
    }

    public function gdpr_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.gdpr')->with(['all_languages' => $all_languages]);
    }

    public function update_gdpr_cookie_settings(Request $request)
    {

        $this->validate($request, [
            'site_gdpr_cookie_enabled' => 'nullable|string|max:191',
            'site_gdpr_cookie_expire' => 'required|string|max:191',
            'site_gdpr_cookie_delay' => 'required|string|max:191',
        ]);

        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                "site_gdpr_cookie_" . $lang->slug . "_title" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_message" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_more_info_label" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_more_info_link" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_accept_button_label" => 'nullable|string',
                "site_gdpr_cookie_" . $lang->slug . "_decline_button_label" => 'nullable|string',
            ]);
            $_title = "site_gdpr_cookie_" . $lang->slug . "_title";
            $_message = "site_gdpr_cookie_" . $lang->slug . "_message";
            $_more_info_label = "site_gdpr_cookie_" . $lang->slug . "_more_info_label";
            $_more_info_link = "site_gdpr_cookie_" . $lang->slug . "_more_info_link";
            $_accept_button_label = "site_gdpr_cookie_" . $lang->slug . "_accept_button_label";
            $decline_button_label = "site_gdpr_cookie_" . $lang->slug . "_decline_button_label";

            update_static_option($_title, $request->$_title);
            update_static_option($_message, $request->$_message);
            update_static_option($_more_info_label, $request->$_more_info_label);
            update_static_option($_more_info_link, $request->$_more_info_link);
            update_static_option($_accept_button_label, $request->$_accept_button_label);
            update_static_option($decline_button_label, $request->$decline_button_label);
        }

        update_static_option('site_gdpr_cookie_delay', $request->site_gdpr_cookie_delay);
        update_static_option('site_gdpr_cookie_enabled', $request->site_gdpr_cookie_enabled);
        update_static_option('site_gdpr_cookie_expire', $request->site_gdpr_cookie_expire);

        return redirect()->back()->with(['msg' => __('GDPR Cookie Settings Updated..'), 'type' => 'success']);
    }

    public function cache_settings()
    {
        return view('backend.general-settings.cache-settings');
    }

    public function update_cache_settings(Request $request)
    {

        $this->validate($request, [
            'cache_type' => 'required|string'
        ]);

        Artisan::call($request->cache_type . ':clear');

        return redirect()->back()->with(['msg' => __('Cache Cleaned...'), 'type' => 'success']);
    }

    public function license_settings()
    {
        return view('backend.general-settings.license-settings');
    }

    public function update_license_settings(Request $request)
    {
        $this->validate($request, [
            'item_purchase_key' => 'required|string|max:191'
        ]);
        $response = Http::post('https://xgenious.com/api/v2/license/new', [
            'purchase_code' => $request->item_purchase_key,
            'site_url' => url('/'),
            'item_unique_key' => 'NB2GLtODUjYOc9bFkPq2pKI8uma3G6WX',
        ]);
        $result = $response->json();

        update_static_option('item_purchase_key', $request->item_purchase_key);
        update_static_option('item_license_status', $result['license_status']);
        update_static_option('item_license_msg', $result['msg']);

        $type = 'verified' == $result['license_status'] ? 'success' : 'danger';
        setcookie("site_license_check", "", time() - 3600,'/');
        $license_info = [
            "item_license_status" => $result['license_status'],
            "last_check" => time(),
            "purchase_code" => get_static_option('item_purchase_key'),
            "xgenious_app_key" => env('XGENIOUS_API_KEY'),
            "author" => env('XGENIOUS_API_AUTHOR'),
            "message" => $result['msg']
        ];
        file_put_contents('@core/license.json', json_encode($license_info));

        return redirect()->back()->with(['msg' => $result['msg'], 'type' => $type]);
    }

    public function custom_css_settings()
    {
        $custom_css = '/* Write Custom Css Here */';
        if (file_exists('assets/frontend/css/dynamic-style.css')) {
            $custom_css = file_get_contents('assets/frontend/css/dynamic-style.css');
        }
        return view('backend.general-settings.custom-css')->with(['custom_css' => $custom_css]);
    }

    public function update_custom_css_settings(Request $request)
    {
        file_put_contents('assets/frontend/css/dynamic-style.css', $request->custom_css_area);

        return redirect()->back()->with(['msg' => __('Custom Style Added Success...'), 'type' => 'success']);
    }

    public function typography_settings()
    {
        $all_google_fonts = file_get_contents('assets/frontend/webfonts/google-fonts.json');
        return view('backend.general-settings.typograhpy')->with(['google_fonts' => json_decode($all_google_fonts)]);
    }

    public function get_single_font_variant(Request $request)
    {
        $all_google_fonts = file_get_contents('assets/frontend/webfonts/google-fonts.json');
        $decoded_fonts = json_decode($all_google_fonts, true);
        return response()->json($decoded_fonts[$request->font_family]);
    }

    public function update_typography_settings(Request $request)
    {
        $this->validate($request, [
            'body_font_family' => 'required|string|max:191',
            'body_font_variant' => 'required',
            'heading_font' => 'nullable|string',
            'heading_font_family' => 'nullable|string|max:191',
            'heading_font_variant' => 'nullable',
        ]);

        $save_data = [
            'body_font_family',
            'heading_font_family',
        ];
        foreach ($save_data as $item) {
            update_static_option($item, $request->$item);
        }
        $body_font_variant = !empty($request->body_font_variant) ?  $request->body_font_variant: ['regular'];
        $heading_font_variant = !empty($request->heading_font_variant) ?  $request->heading_font_variant: ['regular'];

        update_static_option('heading_font', $request->heading_font);
        update_static_option('body_font_variant', serialize($body_font_variant));
        update_static_option('heading_font_variant', serialize($heading_font_variant));

        return redirect()->back()->with(['msg' => __('Typography Settings Updated..'), 'type' => 'success']);
    }

    public function email_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.email-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_email_settings(Request $request)
    {
        $all_languages = Language::all();
        foreach ($all_languages as $lang) {
            $this->validate($request, [
                'service_query_' . $lang->slug . '_success_message' => 'nullable|string',
                'case_study_query_' . $lang->slug . '_success_message' => 'nullable|string',
                'quote_mail_' . $lang->slug . '_success_message' => 'nullable|string',
                'contact_mail_' . $lang->slug . '_success_message' => 'nullable|string',
                'get_in_touch_mail_' . $lang->slug . '_success_message' => 'nullable|string',
                'apply_job_' . $lang->slug . '_success_message' => 'nullable|string',
                'order_mail_' . $lang->slug . '_success_message' => 'nullable|string',
                'event_attendance_mail_' . $lang->slug . '_success_message' => 'nullable|string',
                'feedback_form_mail_' . $lang->slug . '_success_message' => 'nullable|string',
            ]);

            $fields = [
                'service_query_' . $lang->slug . '_success_message',
                'case_study_query_' . $lang->slug . '_success_message',
                'quote_mail_' . $lang->slug . '_success_message',
                'contact_mail_' . $lang->slug . '_success_message',
                'get_in_touch_mail_' . $lang->slug . '_success_message',
                'apply_job_' . $lang->slug . '_success_message',
                'order_mail_' . $lang->slug . '_success_message',
                'event_attendance_mail_' . $lang->slug . '_success_message',
                'feedback_form_mail_' . $lang->slug . '_success_message',
                'appointment_form_mail_' . $lang->slug . '_success_message',
                'estimate_form_mail_' . $lang->slug . '_success_message',
                'enroll_form_mail_' . $lang->slug . '_success_message',
            ];
            foreach ($fields as $field) {
                update_static_option($field, $request->$field);
            }
        }
        return redirect()->back()->with(['msg' => __('Email Settings Updated..'), 'type' => 'success']);
    }

    public function page_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_page_settings(Request $request)
    {
        $this->validate($request, [
            'about_page_slug' => 'required|string|max:191',
            'service_page_slug' => 'required|string|max:191',
            'work_page_slug' => 'required|string|max:191',
            'team_page_slug' => 'required|string|max:191',
            'faq_page_slug' => 'required|string|max:191',
            'price_plan_page_slug' => 'required|string|max:191',
            'blog_page_slug' => 'required|string|max:191',
            'contact_page_slug' => 'required|string|max:191',
            'career_with_us_page_slug' => 'required|string|max:191',
            'events_page_slug' => 'required|string|max:191',
            'knowledgebase_page_slug' => 'required|string|max:191',
            'quote_page_slug' => 'required|string|max:191',
            'donation_page_slug' => 'required|string|max:191',
            'product_page_slug' => 'required|string|max:191',
            'testimonial_page_slug' => 'required|string|max:191',
            'feedback_page_slug' => 'required|string|max:191',
            'clients_feedback_page_slug' => 'required|string|max:191',
            'image_gallery_page_slug' => 'required|string|max:191',
            'donor_page_slug' => 'required|string|max:191',
        ]);
        $slug_list = ['about','service','work','team','faq','price_plan','blog','contact','career_with_us','events','knowledgebase','donation','product','testimonial','feedback','clients_feedback','image_gallery','donor','appointment','quote','courses','support_ticket'];

        foreach ($slug_list as $slug_field){
            $field = $slug_field.'_page_slug';
            update_static_option($field, Str::slug($request->$field));
        }

        $all_languages = Language::all();
        foreach ($all_languages as $lang) {
            $this->validate($request, [
                'about_page_' . $lang->slug . '_name' => 'nullable|string',
                'service_page_' . $lang->slug . '_name' => 'nullable|string',
                'work_page_' . $lang->slug . '_name' => 'nullable|string',
                'team_page_' . $lang->slug . '_name' => 'nullable|string',
                'faq_page_' . $lang->slug . '_name' => 'nullable|string',
                'blog_page_' . $lang->slug . '_name' => 'nullable|string',
                'contact_page_' . $lang->slug . '_name' => 'nullable|string',
                'career_with_us_page_' . $lang->slug . '_name' => 'nullable|string',
                'events_page_' . $lang->slug . '_name' => 'nullable|string',
                'knowledgebase_page_' . $lang->slug . '_name' => 'nullable|string',
                'donation_page_' . $lang->slug . '_name' => 'nullable|string',
                'product_page_' . $lang->slug . '_name' => 'nullable|string',
                'donor_page_' . $lang->slug . '_name' => 'nullable|string',
            ]);
            foreach ($slug_list as $field) {
                $meta_tags =  $field.'_page_' . $lang->slug . '_meta_tags';
                $meta_description = $field.'_page_' . $lang->slug . '_meta_description';
                $page_title = $field.'_page_' . $lang->slug . '_name';
                update_static_option($meta_tags, $request->$meta_tags);
                update_static_option($meta_description, $request->$meta_description);
                update_static_option($page_title, $request->$page_title);
            }
        }

        return redirect()->back()->with(['msg' => __('Page Settings Updated..'), 'type' => 'success']);
    }

    public function basic_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.basic')->with(['all_languages' => $all_languages]);
    }

    public function update_basic_settings(Request $request)
    {
        $this->validate($request, [
            'site_rtl_enabled' => 'nullable|string',
            'site_admin_dark_mode' => 'nullable|string',
            'language_select_option' => 'nullable|string',
            'site_sticky_navbar_enabled' => 'nullable|string',
            'disable_backend_preloader' => 'nullable|string',
            'disable_user_email_verify' => 'nullable|string',
            'og_meta_image_for_site' => 'nullable|string',
            'site_admin_panel_nav_sticky' => 'nullable|string',
            'site_force_ssl_redirection' => 'nullable|string',
        ]);

        $all_language = Language::all();

        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_' . $lang->slug . '_title' => 'nullable|string',
                'site_' . $lang->slug . '_tag_line' => 'nullable|string',
                'site_' . $lang->slug . '_footer_copyright' => 'nullable|string',
            ]);
            $_title = 'site_' . $lang->slug . '_title';
            $_tag_line = 'site_' . $lang->slug . '_tag_line';
            $_footer_copyright = 'site_' . $lang->slug . '_footer_copyright';

            update_static_option($_title, $request->$_title);
            update_static_option($_tag_line, $request->$_tag_line);
            update_static_option($_footer_copyright, $request->$_footer_copyright);
        }

        $all_fields = [
          'site_admin_panel_nav_sticky',
          'site_frontend_nav_sticky',
          'og_meta_image_for_site',
          'site_rtl_enabled',
          'site_admin_dark_mode',
          'site_maintenance_mode',
          'site_payment_gateway',
          'language_select_option',
          'site_sticky_navbar_enabled',
          'disable_backend_preloader',
          'disable_user_email_verify',
          'site_force_ssl_redirection',
        ];

        foreach ($all_fields as $field){
            update_static_option($field,$request->$field);
        }

        return redirect()->back()->with(['msg' => __('Basic Settings Update Success'), 'type' => 'success']);
    }

    public function seo_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.seo')->with(['all_languages' => $all_languages]);
    }

    public function update_seo_settings(Request $request)
    {
        $all_languages = Language::all();

        foreach ($all_languages as $lang) {
            $this->validate($request, [
                'site_meta_' . $lang->slug . '_tags' => 'required|string',
                'site_meta_' . $lang->slug . '_description' => 'required|string'
            ]);

            $site_tags = 'site_meta_' . $lang->slug . '_tags';
            $site_description = 'site_meta_' . $lang->slug . '_description';

            update_static_option($site_tags, $request->$site_tags);
            update_static_option($site_description, $request->$site_description);
        }

        return redirect()->back()->with(['msg' => __('SEO Settings Update Success'), 'type' => 'success']);
    }

    public function scripts_settings()
    {
        return view('backend.general-settings.thid-party');
    }

    public function update_scripts_settings(Request $request)
    {

        $this->validate($request, [
            'site_disqus_key' => 'nullable|string',
            'tawk_api_key' => 'nullable|string',
            'site_third_party_tracking_code' => 'nullable|string',
            'site_google_analytics' => 'nullable|string',
            'site_google_captcha_v3_secret_key' => 'nullable|string',
            'site_google_captcha_v3_site_key' => 'nullable|string',
        ]);

        update_static_option('site_disqus_key', $request->site_disqus_key);
        update_static_option('site_google_analytics', $request->site_google_analytics);
        update_static_option('tawk_api_key', $request->tawk_api_key);
        update_static_option('site_third_party_tracking_code', $request->site_third_party_tracking_code);
        update_static_option('site_google_captcha_v3_site_key', $request->site_google_captcha_v3_site_key);
        update_static_option('site_google_captcha_v3_secret_key', $request->site_google_captcha_v3_secret_key);

        return redirect()->back()->with(['msg' => __('Third Party Scripts Settings Updated..'), 'type' => 'success']);
    }

    public function email_template_settings()
    {
        return view('backend.general-settings.email-template');
    }

    public function update_email_template_settings(Request $request)
    {

        $this->validate($request, [
            'site_global_email' => 'required|string',
            'site_global_email_template' => 'required|string',
        ]);

        update_static_option('site_global_email', $request->site_global_email);
        update_static_option('site_global_email_template', $request->site_global_email_template);

        return redirect()->back()->with(['msg' => __('Email Settings Updated..'), 'type' => 'success']);
    }

    public function site_identity()
    {
        return view('backend.general-settings.site-identity');
    }

    public function update_site_identity(Request $request)
    {
        $this->validate($request, [
            'site_logo' => 'nullable|string|max:191',
            'site_favicon' => 'nullable|string|max:191',
            'site_breadcrumb_bg' => 'nullable|string|max:191',
            'site_white_logo' => 'nullable|string|max:191',
        ]);
        update_static_option('site_logo', $request->site_logo);
        update_static_option('site_favicon', $request->site_favicon);
        update_static_option('site_breadcrumb_bg', $request->site_breadcrumb_bg);
        update_static_option('site_white_logo', $request->site_white_logo);

        return redirect()->back()->with([
            'msg' => __('Site Identity Has Been Updated..'),
            'type' => 'success'
        ]);
    }

    public function payment_settings()
    {
        return view('backend.general-settings.payment-gateway');
    }

    public function update_payment_settings(Request $request)
    {
        $this->validate($request, [
            'razorpay_preview_logo' => 'nullable|string|max:191',
            'stripe_preview_logo' => 'nullable|string|max:191',
            'paypal_gateway' => 'nullable|string|max:191',
            'paypal_preview_logo' => 'nullable|string|max:191',
            'paypal_business_email' => 'nullable|string|max:191',
            'paytm_gateway' => 'nullable|string|max:191',
            'paytm_preview_logo' => 'nullable|string|max:191',
            'paytm_merchant_key' => 'nullable|string|max:191',
            'paytm_merchant_mid' => 'nullable|string|max:191',
            'paytm_merchant_website' => 'nullable|string|max:191',
            'site_global_currency' => 'nullable|string|max:191',
            'site_manual_payment_name' => 'nullable|string|max:191',
            'manual_payment_preview_logo' => 'nullable|string|max:191',
            'site_manual_payment_description' => 'nullable|string|max:191',
            'razorpay_key' => 'nullable|string|max:191',
            'razorpay_secret' => 'nullable|string|max:191',
            'stripe_publishable_key' => 'nullable|string|max:191',
            'stripe_secret_key' => 'nullable|string|max:191',
            'site_global_payment_gateway' => 'nullable|string|max:191',
            'paystack_merchant_email' => 'nullable|string|max:191',
            'paystack_preview_logo' => 'nullable|string|max:191',
            'paystack_public_key' => 'nullable|string|max:191',
            'paystack_secret_key' => 'nullable|string|max:191',
            'cash_on_delivery_gateway' => 'nullable|string|max:191',
            'cash_on_delivery_preview_logo' => 'nullable|string|max:191',
            'mollie_preview_logo' => 'nullable|string|max:191',
            'mollie_public_key' => 'nullable|string|max:191',
        ]);
        $save_data = [
            'cash_on_delivery_preview_logo',
            'stripe_preview_logo',
            'paystack_preview_logo',
            'paystack_public_key',
            'paystack_secret_key',
            'paystack_merchant_email',
            'razorpay_preview_logo',
            'paypal_preview_logo',
            'paypal_app_client_id',
            'paypal_app_secret',
            'paytm_channel',
            'paytm_industry_type',
            'paytm_preview_logo',
            'paytm_merchant_key',
            'paytm_merchant_mid',
            'paytm_merchant_website',
            'site_global_currency',
            'manual_payment_preview_logo',
            'site_manual_payment_name',
            'site_manual_payment_description',
            'razorpay_key',
            'razorpay_secret',
            'stripe_publishable_key',
            'stripe_secret_key',
            'site_global_payment_gateway',
            'site_usd_to_ngn_exchange_rate',
            'site_euro_to_ngn_exchange_rate',
            'mollie_public_key',
            'mollie_preview_logo',
            'flutterwave_preview_logo',
            'flutterwave_secret_key',
            'flutterwave_public_key',
            'site_currency_symbol_position',
            'site_default_payment_gateway',
        ];
        foreach ($save_data as $item) {
            update_static_option($item, $request->$item);
        }

        update_static_option('manual_payment_gateway', $request->manual_payment_gateway);
        update_static_option('paypal_gateway', $request->paypal_gateway);
        update_static_option('paytm_test_mode', $request->paytm_test_mode);
        update_static_option('paypal_test_mode', $request->paypal_test_mode);
        update_static_option('paytm_gateway', $request->paytm_gateway);
        update_static_option('razorpay_gateway', $request->razorpay_gateway);
        update_static_option('stripe_gateway', $request->stripe_gateway);
        update_static_option('paystack_gateway', $request->paystack_gateway);
        update_static_option('mollie_gateway', $request->mollie_gateway);
        update_static_option('cash_on_delivery_gateway', $request->cash_on_delivery_gateway);
        update_static_option('flutterwave_gateway', $request->flutterwave_gateway);

        $env_val['PAYSTACK_PUBLIC_KEY'] = $request->paystack_public_key ?: 'pk_test_081a8fcd9423dede2de7b4c3143375b5e5415290';
        $env_val['PAYSTACK_SECRET_KEY'] = $request->paystack_secret_key ?: 'sk_test_c874d38f8d08760efc517fc83d8cd574b906374f';
        $env_val['MERCHANT_EMAIL'] = $request->paystack_merchant_email ?: 'example@gmail.com';
        $env_val['MOLLIE_KEY'] = $request->mollie_public_key ?: 'test_SMWtwR6W48QN2UwFQBUqRDKWhaQEvw';
        $env_val['PAYPAL_MODE'] =  !empty($request->paypal_test_mode) ? 'sandbox' : 'live';
        $env_val['PAYPAL_CLIENT_ID'] = $request->paypal_app_client_id ?: 'ATx-SYQyPtXHw1bZaBDhJUZabxbutIqAqqZORgvgEoK_-9MrAkUzYkbt8pSnUyKNEdNN3aJt8tcpcY1I';
        $env_val['PAYPAL_SECRET'] = $request->paypal_app_secret ?: 'ELJCWPUabUnnMamfw5-ZxaUsvir3KAJrPnAcSeS11znsroi45HP0p7y7vGZcYsBsAAi7Ou6kelCpj69K';
        $env_val['PAYTM_ENVIRONMENT'] = !empty($request->paytm_test_mode) ? 'local' : 'production';
        $env_val['PAYTM_MERCHANT_ID'] = $request->paytm_merchant_mid ?: 'Digita57697814558795';
        $env_val['PAYTM_MERCHANT_KEY'] = '"'.$request->paytm_merchant_key .'"'?: 'dv0XtmsPYpewNag&';
        $env_val['PAYTM_MERCHANT_WEBSITE'] = '"'.$request->paytm_merchant_website .'"'?: 'WEBSTAGING';
        $env_val['PAYTM_CHANNEL'] = '"'.$request->paytm_channel .'"'?: 'WEB';
        $env_val['PAYTM_INDUSTRY_TYPE'] = '"'.$request->paytm_industry_type .'"'?: 'Retail';
        $env_val['FLW_PUBLIC_KEY'] = $request->flutterwave_public_key ?: 'FLWPUBK-d981d2a182ba72915b699603c2db82e0-X';
        $env_val['FLW_SECRET_KEY'] = $request->flutterwave_secret_key ?: 'FLWSECK-e33b022937c2a64446dca55dbb7ceb08-X';

        setEnvValue($env_val);

        $global_currency = get_static_option('site_global_currency');
        $currency_filed_name = 'site_'.strtolower($global_currency).'_to_usd_exchange_rate';
        $inr_currency_filed_name = 'site_'.strtolower($global_currency).'_to_inr_exchange_rate';
        $ngn_currency_filed_name = 'site_'.strtolower($global_currency).'_to_ngn_exchange_rate';

        update_static_option('site_'.strtolower($global_currency).'_to_usd_exchange_rate',$request->$currency_filed_name);
        update_static_option('site_'.strtolower($global_currency).'_to_inr_exchange_rate',$request->$inr_currency_filed_name);
        update_static_option('site_'.strtolower($global_currency).'_to_ngn_exchange_rate',$request->$ngn_currency_filed_name);

        return redirect()->back()->with([
            'msg' => __('Payment Settings Updated..'),
            'type' => 'success'
        ]);
    }

    public function preloader_settings()
    {
        return view('backend.general-settings.preloader-settings');
    }

    public function update_preloader_settings(Request $request)
    {
        $this->validate($request, [
            'preloader_default' => 'nullable|string|max:191',
            'preloader_custom' => 'nullable|string|max:191',
            'preloader_custom_image' => 'nullable|string|max:191',
            'preloader_status' => 'nullable|string|max:191',
            'preloader_cacncel_button' => 'nullable|string|max:191',
        ]);

        update_static_option('preloader_default', $request->preloader_default);
        update_static_option('preloader_status', $request->preloader_status);
        update_static_option('preloader_custom', $request->preloader_custom);
        update_static_option('preloader_custom_image', $request->preloader_custom_image);
        update_static_option('preloader_cacncel_button', $request->preloader_cacncel_button);

        return redirect()->back()->with([
            'msg' => __('Settings Updated..'),
            'type' => 'success'
        ]);
    }


    public function sitemap_settings()
    {
        $all_sitemap = glob('sitemap/*');
        return view('backend.general-settings.sitemap-settings')->with(['all_sitemap' => $all_sitemap]);
    }

    public function update_sitemap_settings(Request $request)
    {
        $this->validate($request, [
            'site_url' => 'required|url',
            'title' => 'nullable|string',
        ]);
        $title = $request->title ? $request->title : time();
        SitemapGenerator::create($request->site_url)->writeToFile('sitemap/sitemap-' . $title . '.xml');
        return redirect()->back()->with([
            'msg' => __('Sitemap Generated..'),
            'type' => 'success'
        ]);
    }

    public function delete_sitemap_settings(Request $request)
    {
        if (file_exists($request->sitemap_name)) {
            @unlink($request->sitemap_name);
        }
        return redirect()->back()->with(['msg' => __('Sitemap Deleted...'), 'type' => 'danger']);
    }

    public function rss_feed_settings()
    {
        return view('backend.general-settings.rss-feed-settings');
    }

    public function update_rss_feed_settings(Request $request)
    {
        $this->validate($request, [
            'site_rss_feed_url' => 'required|string',
            'site_rss_feed_title' => 'required|string',
            'site_rss_feed_description' => 'required|string',
        ]);
        update_static_option('site_rss_feed_description', $request->site_rss_feed_description);
        update_static_option('site_rss_feed_title', $request->site_rss_feed_title);
        update_static_option('site_rss_feed_url', $request->site_rss_feed_url);

        $env_val['RSS_FEED_URL'] = $request->site_rss_feed_url ? '"' . $request->site_rss_feed_url . '"' : '"rss-feeds"' ;
        $env_val['RSS_FEED_TITLE'] = $request->site_rss_feed_title ? '"' . $request->site_rss_feed_title . '"' : '"' . get_static_option('site_'.get_default_language().'_title') . '"';
        $env_val['RSS_FEED_DESCRIPTION'] = $request->site_rss_feed_description ? '"' . $request->site_rss_feed_description . '"' : '"'.get_static_option('site_'.get_default_language().'_tag_line').'"';

        setEnvValue(array(
            'RSS_FEED_URL' => $env_val['RSS_FEED_URL'],
            'RSS_FEED_TITLE' => $env_val['RSS_FEED_TITLE'],
            'RSS_FEED_DESCRIPTION' => $env_val['RSS_FEED_DESCRIPTION'],
            'RSS_FEED_LANGUAGE' => get_default_language()
        ));

        return redirect()->back()->with([
            'msg' => __('RSS Settings Update..'),
            'type' => 'success'
        ]);
    }

    public function popup_settings()
    {
        $all_languages = Language::all();
        $all_popup = PopupBuilder::all()->groupBy('lang');
        return view('backend.general-settings.popup-settings')->with(['all_popup' => $all_popup, 'all_languages' => $all_languages]);
    }

    public function update_popup_settings(Request $request)
    {
        $this->validate($request, [
            'popup_enable_status' => 'nullable|string',
            'popup_delay_time' => 'nullable|string',
        ]);
        update_static_option('popup_enable_status', $request->popup_enable_status);
        update_static_option('popup_delay_time', $request->popup_delay_time);
        $all_languages = Language::all();
        foreach ($all_languages as $lang) {
            $this->validate($request, [
                'popup_selected_' . $lang->slug . '_id' => 'nullable|string'
            ]);
            $field = 'popup_selected_' . $lang->slug . '_id';
            update_static_option($field, $request->$field);
        }

        return redirect()->back()->with(['msg' => __('Settings Updated'), 'type' => 'success']);
    }

    public function update_script_settings(){
        return view('backend.general-settings.update-script');
    }

    public function module_settings(){
        return view('backend.general-settings.module-settings');
    }

    public function store_module_settings(Request $request){
        $this->validate($request,[
            'job_module_status' => 'nullable|string',
            'events_module_status' => 'nullable|string',
            'product_module_status' => 'nullable|string',
            'donations_module_status' => 'nullable|string',
            'knowledgebase_module_status' => 'nullable|string',
            'appointment_module_status' => 'nullable|string',
            'course_module_status' => 'nullable|string',
        ]);

        $all_fields = [
            'job_module_status',
            'events_module_status',
            'product_module_status' ,
            'donations_module_status',
            'knowledgebase_module_status',
            'appointment_module_status',
            'course_module_status',
            'support_ticket_module_status',
        ];
        foreach ($all_fields as $field){
            update_static_option($field,$request->$field);
        }

        return redirect()->back()->with(['msg' => __('Settings Updated'), 'type' => 'success']);
    }

    public function test_smtp_settings(Request $request){
        $this->validate($request,[
           'subject' => 'required|string|max:191',
           'email' => 'required|email|max:191',
           'message' => 'required|string',
        ]);
        $res_data = [
            'msg' => __('Mail Send Success'),
            'type' => 'success'
        ];
        Mail::to($request->email)->send(new BasicMail([
            'subject' => $request->subject,
            'message' => $request->message
        ]));

        if (Mail::failures()){
            $res_data = [
                'msg' => __('Mail Send Failed'),
                'type' => 'danger'
            ];
        }
        return redirect()->back()->with($res_data);
    }

    //database upgrade
    public function database_upgrade(){
        return view('backend.general-settings.database-upgrade');
    }
    public function database_upgrade_post(Request $request){
        setEnvValue(['APP_ENV' => 'local']);
        Artisan::call('migrate', ['--force' => true ]);
        if (class_exists('StaticOptionUpgrade')){
            Artisan::call('db:seed', ['--force' => true ,'--class' => 'StaticOptionUpgrade']);
        }
        setEnvValue(['APP_ENV' => 'production']);
        return back()->with(NexelitHelpers::database_upgrade());
    }
}

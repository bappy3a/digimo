@if(!empty(get_static_option('site_gdpr_cookie_enabled')))
    <script src="{{asset('assets/frontend/js/jquery.ihavecookies.min.js')}}"></script>
    @php $gdpr_cookie_link = str_replace('{url}',url('/'),get_static_option('site_gdpr_cookie_'.$user_select_lang_slug.'_more_info_link')) @endphp
    <script>
        $(document).ready(function () {
            var delayTime = "{{get_static_option('site_gdpr_cookie_delay')}}";
            delayTime = delayTime ? delayTime : 4000;

            $('body').ihavecookies({
                title: "{{get_static_option('site_gdpr_cookie_' . $user_select_lang_slug . '_title')}}",
                message: "{{get_static_option('site_gdpr_cookie_'.$user_select_lang_slug.'_message')}}",
                expires: "{{get_static_option('site_gdpr_cookie_expire')}}",
                link: "{{$gdpr_cookie_link}}",
                delay: delayTime,
                moreInfoLabel: "{{get_static_option('site_gdpr_cookie_'.$user_select_lang_slug.'_more_info_label')}}",
                acceptBtnLabel: "{{get_static_option('site_gdpr_cookie_'.$user_select_lang_slug.'_accept_button_label')}}",
                advancedBtnLabel: "{{get_static_option('site_gdpr_cookie_'.$user_select_lang_slug.'_decline_button_label')}}"
            });
            $('body').on('click', '#gdpr-cookie-close', function (e) {
                e.preventDefault();
                $(this).parent().remove();
            });
        });
    </script>
@endif
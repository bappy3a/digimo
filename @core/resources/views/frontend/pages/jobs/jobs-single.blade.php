@extends('frontend.frontend-page-master')
@section('site-title')
    {{$job->title}}
@endsection
@section('page-title')
    {{$job->title}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{$job->meta_description}}">
    <meta name="tags" content="{{$job->meta_tags}}">
@endsection
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.jobs.single',$job->slug)}}" />
    <meta property="og:type"  content="job" />
    <meta property="og:title"  content="{{$job->title}}" />
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-job-details">
                        <ul class="job-meta-list">
                            @if(!empty($job->job_context))
                            <li>
                                <div class="single-job-meta-block">
                                    <h4 class="title"> {{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_context_label')}}</h4>
                                    <p>{!!  $job->job_context !!}</p>
                                </div>
                            </li>
                            @endif
                            @if(!empty($job->job_responsibility))
                            <li>
                                <div class="single-job-meta-block">
                                    <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_responsibility_label')}}</h4>
                                    <p>{!! $job->job_responsibility !!}</p>
                                </div>
                            </li>
                            @endif
                            @if(!empty($job->education_requirement))
                                <li>
                                    <div class="single-job-meta-block">
                                        <h4 class="title">  {{get_static_option('job_single_page_'.$user_select_lang_slug.'_education_requirement_label')}}</h4>
                                        <p>{!! $job->education_requirement !!}</p>
                                    </div>
                                </li>
                            @endif
                            @if(!empty($job->experience_requirement))
                                <li>
                                    <div class="single-job-meta-block">
                                        <h4 class="title"> {{get_static_option('job_single_page_'.$user_select_lang_slug.'_experience_requirement_label')}}</h4>
                                        <p>{!! $job->experience_requirement !!}</p>
                                    </div>
                                </li>
                            @endif
                            @if(!empty($job->additional_requirement))
                            <li>
                                <div class="single-job-meta-block">
                                    <h4 class="title"> {{get_static_option('job_single_page_'.$user_select_lang_slug.'_additional_requirement_label')}}</h4>
                                    <p>{!! $job->additional_requirement !!}</p>
                                </div>
                            </li>
                            @endif
                            @if(!empty($job->other_benefits))
                                <li>
                                    <div class="single-job-meta-block">
                                        <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_others_benefits_label')}}</h4>
                                        <p>{!! $job->other_benefits !!}</p>
                                    </div>
                                </li>
                            @endif
                            @if(!empty($job->application_fee_status) && $job->application_fee > 0)
                                <li>
                                    <div class="single-job-meta-block">
                                        <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_application_fee_text')}}</h4>
                                        <p>{{amount_with_currency_symbol($job->application_fee )}}</p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                        <div class="apply-procedure">
                             @if(time() >= strtotime($job->deadline))
                                <div class="alert alert-danger margin-top-30">{{__('Dead Line Expired')}}</div>
                            @else
                                @if(!empty(get_static_option('job_single_page_apply_form')))
                                    <a class="btn-boxed style-01 margin-top-30" href="{{route('frontend.jobs.apply',$job->id)}}">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_apply_button_text')}}</a>
                                @else
                                    <p>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_apply_button_text')}}: <span>{{$job->email}}</span></p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                            <div class="widget job_information">
                                <h2 class="widget-title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_info_text')}}</h2>
                                <ul class="job-information-list">
                                    <li>
                                        <div class="single-job-info">
                                            <div class="icon">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_company_name_text')}}</h4>
                                                <span class="details">{{$job->company_name}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="single-job-info">
                                            <div class="icon">
                                                <i class="fas fa-tags"></i>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_category_text')}}</h4>
                                                <span class="details">{!! get_jobs_category_by_id($job->category_id,'link') !!}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="single-job-info">
                                            <div class="icon">
                                                <i class="far fa-user"></i>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_position_text')}}</h4>
                                                <span class="details">{{$job->position}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="single-job-info">
                                            <div class="icon">
                                                <i class="far fa-folder"></i>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_type_text')}}</h4>
                                                <span class="details">{{str_replace('_',' ',$job->employment_status)}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="single-job-info">
                                            <div class="icon">
                                                <i class="fas fa-wallet"></i>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_salary_text')}}</h4>
                                                <span class="details">{{$job->salary}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="single-job-info">
                                            <div class="icon">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_location_text')}}</h4>
                                                <span class="details">{{$job->job_location}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="single-job-info">
                                            <div class="icon">
                                                <i class="far fa-calendar-alt"></i>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_deadline_text')}}</h4>
                                                <span class="details">{{date('d M Y',strtotime($job->deadline))}}</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title">{{get_static_option('site_jobs_category_'.$user_select_lang_slug.'_title')}}</h2>
                            <ul>
                                @foreach($all_job_category as $data)
                                    <li><a href="{{route('frontend.jobs.category',['id' => $data->id,'any'=> Str::slug($data->title,'-')])}}">{{ucfirst($data->title)}}</a></li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
 @if(!empty(get_static_option('site_google_captcha_v3_site_key')))
        <script
            src="https://www.google.com/recaptcha/api.js?render={{get_static_option('site_google_captcha_v3_site_key')}}"></script>
        <script>
            grecaptcha.ready(function () {
                grecaptcha.execute("{{get_static_option('site_google_captcha_v3_site_key')}}", {action: 'homepage'}).then(function (token) {
                    document.getElementById('gcaptcha_token').value = token;
                });
            });
        </script>
    @endif
@endsection

@extends('frontend.frontend-page-master')

@section('page-meta-data')
    <meta name="description" content="{{$work_item->meta_description}}">
    <meta name="tags" content="{{$work_item->meta_tag}}">
@endsection
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.work.single',$work_item->slug)}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$work_item->title}}" />
    {!! render_og_meta_image_by_attachment_id($work_item->image) !!}
@endsection
@section('site-title')
    {{$work_item->title}} - {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
     {{$work_item->title}}
@endsection
@section('content')
    <div class="work-details-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="portfolio-details-item">
                        <div class="thumb">
                          {!! render_image_markup_by_attachment_id($work_item->image) !!}
                        </div>
                        <div class="post-description">
                            {!! $work_item->description !!}
                        </div>

                        @php $gallery_item = $work_item->gallery ? explode('|',$work_item->gallery) : []; @endphp
                        @if(!empty($gallery_item))
                        
                        <div class="case-study-gallery-wrapper">
                            <h2 class="main-title">{{get_static_option('case_study_'.$user_select_lang_slug.'_gallery_title')}}</h2>
                            <div class="case-study-gallery-carousel global-carousel-init"
                                 data-loop="true"
                                 data-desktopitem="1"
                                 data-mobileitem="1"
                                 data-tabletitem="1"
                                 data-nav="true"
                                 data-autoplay="true"
                                 data-margin="0"
                            >
                                @foreach($gallery_item as $gall)
                                <div class="single-gallery-item">
                                    {!! render_image_markup_by_attachment_id($gall) !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="project-widget">
                        <div class="widget-nav-menu margin-bottom-30">
                            <ul>
                                <li>
                                    <div class="service-widget">
                                        <div class="service-icon style-01">
                                            <i class="far fa-user"></i>
                                        </div>
                                        <div class="service-title">
                                        <span>{{__('Client')}}</span>
                                            <h6 class="title">{{$work_item->clients}}</h6>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="service-widget">
                                        <div class="service-icon style-02">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <div class="service-title">
                                            <span>{{__('Budget')}}</span>
                                            <h6 class="title">{{$work_item->budget}}</h6>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="service-widget border-bottom">
                                        <div class="service-icon style-04">
                                            <i class="far fa-clock"></i>
                                        </div>
                                        <div class="service-title">
                                            <span>{{__('Duration')}}</span>
                                            <h6 class="title">{{$work_item->duration}}</h6>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="attorney-contact-form-wrap">
                            <h3 class="title">{{get_static_option('case_study_'.$user_select_lang_slug.'_query_title')}}</h3>
                            @include('backend.partials.message')
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="attorney-contact-form">
                                <div role="form" class="wpcf7" id="wpcf7-f265-p270-o1" lang="en-US" dir="ltr">
                                    <div class="screen-reader-response"></div>
                                    <form action="{{route('frontend.case.study.quote')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        {!! render_form_field_for_frontend(get_static_option('case_study_query_form_fields')) !!}
                                        <div class="form-group">
                                            <input type="submit" value="{{get_static_option('case_study_'.$user_select_lang_slug.'_query_button_text')}}" class="submit-btn">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="related-work-area padding-top-100">
                        <div class="section-title margin-bottom-30">
                            <h2 class="title">{{get_static_option('case_study_'.$user_select_lang_slug.'_related_title')}}</h2>
                        </div>
                            <div class="related-case-study-carousel global-carousel-init"
                                 data-loop="true"
                                 data-desktopitem="3"
                                 data-mobileitem="1"
                                 data-tabletitem="1"
                                 data-nav="true"
                                 data-autoplay="true"
                                 data-margin="40"
                            >
                            @foreach($related_works as $data)
                                <div class="single-related-case-study-item">
                                    <div class="thumb">
                                        {!! render_image_markup_by_attachment_id($data->image) !!}
                                    </div>
                                    <div class="content">
                                        <h4 class="title"><a href="{{route('frontend.work.single',$data->slug)}}"> {{$data->title}}</a></h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


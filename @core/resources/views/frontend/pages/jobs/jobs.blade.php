@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('career_with_us_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('career_with_us_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('career_with_us_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('career_with_us_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($all_jobs as $data)
                            <div class="col-lg-12">
                                <div class="single-job-list-item">
                                    <span class="job_type"><i class="far fa-clock"></i> {{__(str_replace('_',' ',$data->employment_status))}}</span>
                                    <a href="{{route('frontend.jobs.single',$data->slug)}}"><h3 class="title">{{$data->title}}</h3></a>
                                    <span class="company_name"><strong>{{__('Company:')}}</strong> {{$data->company_name}}</span>
                                    <span class="deadline"><strong>{{__('Deadline:')}}</strong> {{date("d M Y", strtotime($data->deadline))}}</span>
                                    <ul class="jobs-meta">
                                        <li><i class="fas fa-briefcase"></i> {{$data->position}}</li>
                                        <li><i class="fas fa-wallet"></i> {{$data->salary}}</li>
                                        <li><i class="fas fa-map-marker-alt"></i> {{$data->job_location}}</li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-12 text-center">
                        <nav class="pagination-wrapper " aria-label="Page navigation ">
                            {{$all_jobs->links()}}
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        <div class="widget widget_search">
                            <form action="{{route('frontend.jobs.search')}}" method="get" class="search-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="{{__('Search...')}}">
                                </div>
                                <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
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

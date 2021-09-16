@extends('backend.admin-master')
@section('site-title')
    {{__('Call To Action Area')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-flash-msg/>
                <x-error-msg/>
            </div>
            <div class="col-lg-12 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Call To Action Area Settings')}}</h4>
                        <form action="{{route('admin.home17.all.cta.area')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach($all_languages as $key => $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#tab_{{$key}}" role="tab"  aria-selected="true">{{$lang->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content margin-top-30" >
                                @foreach($all_languages as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="tab_{{$key}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="course_home_page_{{$lang->slug}}_cta_area_title">{{__('Title')}}</label>
                                        <input type="text" name="course_home_page_{{$lang->slug}}_cta_area_title" class="form-control" value="{{get_static_option('course_home_page_'.$lang->slug.'_cta_area_title')}}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="course_home_page_{{$lang->slug}}_cta_area_button_status"><strong>{{__('Button Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="course_home_page_{{$lang->slug}}_cta_area_button_status"  @if(!empty(get_static_option('course_home_page_'.$lang->slug.'_cta_area_button_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="course_home_page_{{$lang->slug}}_cta_area_button_title">{{__('Button Title')}}</label>
                                        <input type="text" name="course_home_page_{{$lang->slug}}_cta_area_button_title" class="form-control" value="{{get_static_option('course_home_page_'.$lang->slug.'_cta_area_button_title')}}" >
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="course_home_page_cta_area_button_url">{{__('Button URL')}}</label>
                                <input type="text" name="course_home_page_cta_area_button_url" class="form-control" value="{{get_static_option('course_home_page_cta_area_button_url')}}" >
                            </div>
                            <x-backend.icon-field :title="__('Button Icon')" :name="'course_home_page_cta_section_button_icon'"/>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    <script>
        $('.icp-dd').iconpicker();
        $('body').on('iconpickerSelected','.icp-dd', function (e) {
            var selectedIcon = e.iconpickerValue;
            $(this).parent().parent().children('input').val(selectedIcon);
            $('body .dropdown-menu.iconpicker-container').removeClass('show');
        });
    </script>
@endsection

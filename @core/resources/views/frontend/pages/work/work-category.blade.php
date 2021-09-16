@extends('frontend.frontend-page-master')
@php
    $page_name = get_static_option('work_page_'.$user_select_lang_slug.'_name')
@endphp
@section('site-title')
    {{$page_name}} : {{$category_name}}
@endsection
@section('page-title')
    {{$page_name}} : {{$category_name}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('work_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('work_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')
    <div class="page-content portfolio padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                @forelse($all_work as $data)
                    <div class="col-lg-6 col-md-6 margin-bottom-40">
                        <div class="single-case-studies-item">
                            <div class="thumb">
                                {!! render_image_markup_by_attachment_id($data->image) !!}
                            </div>
                            <div class="cart-icon">
                                <h4 class="title"><a href="{{route('frontend.work.single',$data->slug)}}"> {{$data->title}}</a></h4>
                            </div>
                        </div>
                    </div>
                @empty
                      <div class="col-lg-12">
                          <div class="alert alert-warning">{{__('No ')}} {{$page_name}} {{__('Found')}} {{__('In')}} {{$category_name}}</div>
                      </div>
                @endforelse
                <div class="col-lg-12">
                    <div class="post-pagination-wrapper">
                        {{$all_work->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

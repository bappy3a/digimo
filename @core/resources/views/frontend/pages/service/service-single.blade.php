@extends('frontend.frontend-page-master')
@section('og-meta')
    <meta property="og:url" content="{{route('frontend.services.single',$service_item->slug)}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$service_item->title}}"/>
    {!! render_og_meta_image_by_attachment_id($service_item->image) !!}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{$service_item->meta_description}}">
    <meta name="tags" content="{{$service_item->meta_tag}}">
    {!! render_og_meta_image_by_attachment_id($service_item->image) !!}
@endsection
@section('site-title')
    {{$service_item->title}} -  {{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{$service_item->title}}
@endsection
@section('content')

    <div class="page-content service-details padding-top-120 padding-bottom-115">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="service-details-item">
                        <div class="thumb margin-bottom-40">
                            {!! render_image_markup_by_attachment_id($service_item->image) !!}
                        </div>
                        <div class="service-description">
                            {!! $service_item->description !!}
                        </div>
                        @if(!empty($price_plan))
                        <div class="price-plan-wrapper margin-top-40">
                            <div class="row">
                                @foreach($price_plan as $data)
                                <div class="col-lg-6">
                                    <div class="single-price-plan-01 margin-bottom-20">
                                        <div class="price-header">
                                            <div class="name-box">
                                                <h4 class="name">{{$data->title}}</h4>
                                            </div>
                                            <div class="price-wrap">
                                                <span class="price">{{amount_with_currency_symbol($data->price)}}</span><span
                                                        class="month">{{$data->type}}</span>
                                            </div>
                                        </div>
                                        <div class="price-body">
                                            <ul>
                                                @php
                                                    $features = explode("\n",$data->features);
                                                @endphp
                                                @foreach($features as $item)
                                                    <li>{{$item}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="btn-wrapper">
                                            @php
                                                $url = !empty($data->url_status) ? route('frontend.plan.order',['id' => $data->id]) : $data->btn_url;
                                            @endphp
                                            <a href="{{$url}}" class="boxed-btn">{{$data->btn_text}}</a>
                                        </div>
                                    </div>
                                </div>
                                    @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-nav-menu margin-bottom-30 service-category">
                        <ul>
                            @foreach($service_category as $data)
                                <li>
                                    @php
                                    $service_cat_id = !empty($service_item->category) ? $service_item->category->id : '';
                                    @endphp
                                    <a href="{{route('frontend.services.category', ['id' => $data->id , 'any' => Str::slug($data->name)])}}"
                                       class="service-widget @if($data->id == $service_cat_id ) active @endif">
                                        <div class="service-title">
                                            <h6 class="title">{{$data->name}}</h6>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="attorney-contact-form-wrap">
                        <h3 class="title">{{get_static_option('service_single_page_' . $user_select_lang_slug . '_query_form_title')}}</h3>
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
                            <form action="{{route('frontend.service.quote')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                {!! render_form_field_for_frontend(get_static_option('service_query_form_fields')) !!}
                                <div class="form-group">
                                    <input type="submit" value="{{__('Submit Request')}}" class="submit-btn">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

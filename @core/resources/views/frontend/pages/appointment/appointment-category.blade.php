@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('appointment_page_'.$user_select_lang_slug.'_name')}} {{__('Category:')}} {{$cat_name}}
@endsection
@section('page-title')
    {{get_static_option('appointment_page_'.$user_select_lang_slug.'_name')}} {{__('Category:')}} {{$cat_name}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('appointment_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('appointment_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')
    <section class="appointment-content-area padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                        @forelse($all_appointment as $data)
                        <div class="col-lg-4">
                            <div class="appointment-single-item">
                                <div class="thumb"
                                {!! render_background_image_markup_by_attachment_id($data->image,'','grid') !!}
                                    >
                                    <div class="cat">
                                        <a href="{{route('frontend.appointment.category',['id' => $data->category->id,'any' => Str::slug($data->category->lang_front->title ?? __("Uncategorized"))])}}">{{$data->category->lang_front->title ?? __("Uncategorized")}}</a>
                                    </div>
                                </div>
                                <div class="content">
                                    @if(!empty($data->lang_front->designation))
                                        <span class="designation">{{$data->lang_front->designation}}</span>
                                    @endif
                                    @if(count($data->reviews) > 0)
                                        <div class="rating-wrap">
                                            <div class="ratings">
                                                <span class="hide-rating"></span>
                                                <span class="show-rating" style="width: {{{get_appointment_ratings_avg_by_id($data->id) / 5 * 100}}}%"></span>
                                            </div>
                                            <p><span class="total-ratings">({{count($data->reviews)}})</span></p>
                                        </div>
                                    @endif
                                    <a href="{{route('frontend.appointment.single',[$data->lang_front->slug ?? __('untitled'),$data->id])}}"><h4 class="title">{{$data->lang_front->title}}</h4></a>
                                    @if(!empty($data->lang_front->location))
                                        <span class="location"><i class="fas fa-map-marker-alt"></i>{{$data->lang_front->location}}</span>
                                    @endif

                                    <p>{{Str::words(strip_tags($data->lang_front->short_description),10)}}</p>
                                    <div class="btn-wrapper">
                                        <a href="{{route('frontend.appointment.single',[$data->lang_front->slug ?? __('untitled'),$data->id])}}" class="boxed-btn">{{get_static_option('appointment_page_'.$user_select_lang_slug.'_booking_button_text')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-lg-12 text-center">
                           <div class="alert alert-warning">{{__('nothing found')}} <strong>{{$search_term}}</strong></div>
                        </div>
                        @endforelse
                <div class="col-lg-12 text-center">
                    <nav class="pagination-wrapper " aria-label="Page navigation ">
                        {{$all_appointment->links()}}
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Category:')}} {{$category->lang_front->title}}
@endsection
@section('page-title')
    {{__('Category:')}} {{$category->lang_front->title}}
@endsection
@section('content')
    <section class="appointment-content-area padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                @forelse($all_courses as $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="course-single-grid-item">
                            <div class="thumb">
                                <a href="{{route('frontend.course.single',[$data->lang_front->slug,$data->id])}}">
                                    {!! render_image_markup_by_attachment_id($data->image) !!}
                                </a>
                                <div class="price-wrap">
                                    {{amount_with_currency_symbol($data->price)}}
                                    <del>{{amount_with_currency_symbol($data->sale_price)}}</del>
                                </div>
                            </div>
                            <div class="content">
                                @if(count($data->reviews) > 0)
                                    <div class="rating-wrap">
                                        <div class="ratings">
                                            <span class="hide-rating"></span>
                                            <span class="show-rating" style="width: {{{get_course_ratings_avg_by_id($data->id) / 5 * 100}}}%"></span>
                                        </div>
                                        <p><span class="total-ratings">({{count($data->reviews)}})</span></p>
                                    </div>
                                @endif
                                <h3 class="title"><a href="{{route('frontend.course.single',[$data->lang_front->slug,$data->id])}}">{{Str::words($data->lang_front->title,6,'..')}}</a></h3>
                                <div class="instructor-wrap"><span>{{__('By')}}</span> <a href="{{route('frontend.course.instructor',[Str::slug($data->instructor->name),$data->instructor->id])}}">{{$data->instructor->name}}</a></div>
                                <div class="description">
                                    {!! Str::words(strip_tags($data->lang_front->description),15) !!}
                                </div>
                                <div class="footer-part">
                                    <span><i class="fas fa-users"></i> {{$data->enrolled_student}}</span>
                                    <span><i class="fas fa-clock"></i> {{$data->duration}} {{$data->duration_type}}</span>
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
                    {{$all_courses->links()}}
                </nav>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        (function($) {
            'use strict';
            $(document).on('change','select[name="sorting"]',function (e){
                e.preventDefault();
                $('input[name="sort"]').val($(this).val());
            })
            $(document).on('change','select[name="category"]',function (e){
                e.preventDefault();
                $('input[name="cat"]').val($(this).val());
            })
        })(jQuery);
    </script>
@endsection

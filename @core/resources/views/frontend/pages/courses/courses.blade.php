@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('courses_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('courses_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('courses_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('courses_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')
    <section class="appointment-content-area padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="top-search-wrapper">
                        <div class="right-part">
                            <select name="category" class="form-control">
                                <option value="">{{__("select category")}}</option>
                                @foreach($category_list as $category)
                                    <option @if($category->id == $cat_id) selected @endif value="{{$category->id}}">{{$category->lang_front->title}} ({{$category->course->count()}})</option>
                                @endforeach
                            </select>
                            <select name="sorting" class="form-control">
                                <option @if($sort === 'latest') selected @endif value="latest">{{__("Latest")}}</option>
                                <option @if($sort === 'oldest') selected @endif value="oldest">{{__("Oldest")}}</option>
                                <option @if($sort === 'top_rated') selected @endif value="top_rated">{{__("Best Rated")}}</option>
                                <option @if($sort === 'low_price') selected @endif value="low_price">{{__("Low Price")}}</option>
                                <option @if($sort === 'high_price') selected @endif value="high_price">{{__("High Price")}}</option>
                            </select>
                        </div>
                        <div class="left-part">
                            <div class="search-wrapper">
                                <form method="get">
                                    <input type="hidden" name="cat" value="{{$cat_id}}">
                                    <input type="hidden" name="sort" value="{{$sort}}">
                                    <div class="form-group search-box">
                                        <input type="text" class="form-control" name="s" placeholder="{{__('Search')}}" value="{{$search_term}}">
                                        <button class="submit-btn"><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @php $a=1; @endphp
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
                                <div class="cat">
                                    <a class="bg-{{$a}}" href="{{route('frontend.course.category',[Str::slug($data->category->lang_front->title,'-',$data->category->lang_front->lang),$data->category->id])}}">{{$data->category->lang_front->title}}</a>
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
                                    <span><i class="fas fa-users"></i> {{$data->enrolled_student}} {{__('Enrolled')}}</span>
                                    <span><i class="fas fa-clock"></i> {{$data->duration}} {{$data->duration_type}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php if($a == 4){ $a=1;}else{$a++;} @endphp
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

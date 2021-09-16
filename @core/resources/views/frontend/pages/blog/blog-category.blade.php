@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Category:')}} {{' '.$category_name}}
@endsection
@section('site-title')
    {{__('Category:')}} {{' '.$category_name}}
@endsection

@section('content')

    <section class="blog-content-area padding-top-100 padding-bottom-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if(count($all_blogs) < 1)
                        <div class="alert alert-danger">
                            {{__('No Post Available In ').$category_name.__(' Category')}}
                        </div>
                    @endif
                        @foreach($all_blogs as $data)
                            <div class="blog-classic-item-01 margin-bottom-60">
                                <div class="thumbnail">
                                    {!! render_image_markup_by_attachment_id($data->image,'','large') !!}
                                </div>
                                <div class="content">
                                    <ul class="post-meta">
                                        <li><a href="{{route('frontend.blog.single',$data->slug)}}"><i class="fas fa-calendar-alt"></i> {{date_format($data->created_at,'d M y')}}</a></li>
                                        <li><a href="{{route('frontend.blog.single',$data->slug)}}"><i class="fas fa-user"></i> {{$data->author}}</a></li>
                                        <li><div class="cats"><i class="fas fa-folder"></i>{!! get_blog_category_by_id($data->blog_categories_id,'link') !!}</div></li>
                                    </ul>
                                    <h4 class="title"><a href="{{route('frontend.blog.single',$data->slug)}}">{{$data->title}}</a></h4>
                                    <p>{{$data->excerpt}}</p>
                                    <div class="btn-wrapper">
                                        <a href="{{route('frontend.blog.single',$data->slug)}}" class="boxed-btn reverse-color">{{get_static_option('blog_page_'.$user_select_lang_slug.'_read_more_btn_text')}}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    <div class="pagination-wrapper" aria-label="Page navigation">
                       {{$all_blogs->links()}}
                    </div>
                </div>
                <div class="col-lg-4">
                   @include('frontend.pages.blog.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

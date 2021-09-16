@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Search For:')}} {{$search_term}}
@endsection
@section('site-title')
    {{__('Search For:')}} {{$search_term}}
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @if(count($all_knowledgebase) > 0)
                            @foreach($all_knowledgebase as $data)
                                <div class="single-knowledgebase-list-item">
                                    <h4 class="title"><a href="{{route('frontend.knowledgebase.single',$data->slug)}}"><i class="fas fa-folder"></i> {{$data->title}}</a></h4>
                                    <div class="short-content">
                                        {!! Str::words(strip_tags($data->content),50) !!}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-12">
                                <div class="alert alert-warning d-block">{{__('No Article Found')}}</div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <nav class="pagination-wrapper text-center" aria-label="Page navigation ">
                            {{$all_knowledgebase->links()}}
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        <div class="widget widget_search">
                            <form action="{{route('frontend.knowledgebase.search')}}" method="get" class="search-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="{{__('Search...')}}">
                                </div>
                                <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title">{{get_static_option('site_knowledgebase_category_'.$user_select_lang_slug.'_title')}}</h2>
                            <ul>
                                @foreach($all_knowledgebase_category as $data)
                                    <li><a href="{{route('frontend.knowledgebase.category',['id' => $data->id,'any'=> Str::slug($data->title,'-')])}}"><i class="fas fa-folder base-color"></i> {{ucfirst($data->title)}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title">{{get_static_option('site_knowledgebase_popular_widget_'.$user_select_lang_slug.'_title')}}</h2>
                            <ul>
                                @foreach($popular_articles as $data)
                                    <li><a href="{{route('frontend.knowledgebase.single',$data->slug)}}"><i class="far fa-file-alt base-color"></i> {{ucfirst($data->title)}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

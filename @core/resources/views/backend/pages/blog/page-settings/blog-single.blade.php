@extends('backend.admin-master')
@section('site-title')
    {{__('Blog Single Page Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Blog Single Page Settings')}}</h4>
                        <form action="{{route('admin.blog.single.settings')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_languages as $key => $lang)
                                    <a class="nav-item nav-link @if($key == 0) active @endif"  data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @foreach($all_languages as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="blog_single_page_{{$lang->slug}}_related_post_title">{{__('Related Post Title')}}</label>
                                        <input type="text" class="form-control"  id="blog_single_page_{{$lang->slug}}_related_post_title" value="{{get_static_option('blog_single_page_'.$lang->slug.'_related_post_title')}}" name="blog_single_page_{{$lang->slug}}_related_post_title" placeholder="{{__('Related Post Title')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_single_page_{{$lang->slug}}_tags_title">{{__('Tags Title')}}</label>
                                        <input type="text" class="form-control"  id="blog_single_page_{{$lang->slug}}_tags_title" value="{{get_static_option('blog_single_page_'.$lang->slug.'_tags_title')}}" name="blog_single_page_{{$lang->slug}}_tags_title" placeholder="{{__('Tags Title')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_single_page_{{$lang->slug}}_share_title">{{__('Share Title')}}</label>
                                        <input type="text" class="form-control"  id="blog_single_page_{{$lang->slug}}_share_title" value="{{get_static_option('blog_single_page_'.$lang->slug.'_share_title')}}" name="blog_single_page_{{$lang->slug}}_share_title" placeholder="{{__('Share Title')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_single_page_{{$lang->slug}}_category_title">{{__('Category Title')}}</label>
                                        <input type="text" class="form-control"  id="blog_single_page_{{$lang->slug}}_category_title" value="{{get_static_option('blog_single_page_'.$lang->slug.'_category_title')}}" name="blog_single_page_{{$lang->slug}}_category_title" placeholder="{{__('Category Title')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_single_page_{{$lang->slug}}_recent_post_title">{{__('Recent Post Title')}}</label>
                                        <input type="text" class="form-control"  id="blog_single_page_{{$lang->slug}}_recent_post_title" value="{{get_static_option('blog_single_page_'.$lang->slug.'_recent_post_title')}}" name="blog_single_page_{{$lang->slug}}_recent_post_title" placeholder="{{__('Recent Post Title')}}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="blog_single_page_recent_post_item">{{__('Recent Post Items')}}</label>
                                <input type="text" class="form-control"  id="blog_single_page_recent_post_item" value="{{get_static_option('blog_single_page_recent_post_item')}}" name="blog_single_page_recent_post_item" placeholder="{{__('Recent Post Item')}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Blog Page Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

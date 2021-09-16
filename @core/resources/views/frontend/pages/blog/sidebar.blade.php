<div class="widget-area">
    <div class="widget widget_search">
        <form action="{{route('frontend.blog.search')}}" method="get" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="{{__('Search')}}">
            </div>
            <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="widget widget_nav_menu">
        <h2 class="widget-title">{{get_static_option('blog_single_page_'.$user_select_lang_slug.'_category_title')}}</h2>
        <ul>
            @foreach($all_categories as $data)
                <li><a href="{{route('frontend.blog.category',['id' => $data->id,'any'=> Str::slug($data->name,'-')])}}">{{ucfirst($data->name)}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="widget widget_recent_posts">
        <h4 class="widget-title">{{get_static_option('blog_single_page_'.$user_select_lang_slug.'_recent_post_title')}}</h4>
        <ul class="recent_post_item">
            @foreach($all_recent_blogs as $data)
                <li class="single-recent-post-item">
                    <div class="thumb">
                        {!! render_image_markup_by_attachment_id($data->image,null,'thumb') !!}
                    </div>
                    <div class="content">
                        <h4 class="title"><a href="{{route('frontend.blog.single',$data->slug)}}">{{$data->title}}</a></h4>
                        <span class="time">{{date_format($data->created_at,'d M y')}}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

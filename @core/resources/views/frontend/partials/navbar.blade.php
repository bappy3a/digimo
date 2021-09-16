<div class="header-style-01  header-variant-{{get_static_option('home_page_variant')}}">
    <nav class="navbar navbar-area nav-absolute navbar-expand-lg nav-style-01">
        <div class="container nav-container">
            <div class="responsive-mobile-menu">
                <div class="logo-wrapper">
                    <a href="{{url('/')}}" class="logo">
                        @if(!empty(filter_static_option_value('site_white_logo',$global_static_field_data)))
                            {!! render_image_markup_by_attachment_id(filter_static_option_value('site_white_logo',$global_static_field_data)) !!}
                        @else
                            <h2 class="site-title">{{filter_static_option_value('site_'.$user_select_lang_slug.'_title',$global_static_field_data)}}</h2>
                        @endif
                    </a>
                </div>
               @if(!empty(get_static_option('product_module_status')))
                    <div class="mobile-cart"><a href="{{route('frontend.products.cart')}}"><i class="flaticon-shopping-cart"></i> <span class="pcount">{{cart_total_items()}}</span></a></div>
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bizcoxx_main_menu"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bizcoxx_main_menu">
                <ul class="navbar-nav">
                    {!! render_frontend_menu($primary_menu) !!}
                </ul>
            </div>
            <div class="nav-right-content">
                <div class="icon-part">
                    <ul>
                        <li id="search"><a href="#"><i class="flaticon-search-1"></i></a></li>
                        @if(!empty(get_static_option('product_module_status')))
                        <li class="cart"><a href="{{route('frontend.products.cart')}}"><i class="flaticon-shopping-cart"></i> <span class="pcount">{{cart_total_items()}}</span></a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>

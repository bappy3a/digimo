@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('product_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('product_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('product_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('product_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection

@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product-archive-top-content-area">
                                <div class="search-form">
                                    <input type="text" class="form-control" id="search_term" placeholder="{{__('Search..')}}" value="{{$search_term}}">
                                    <button type="button" id="product_search_btn"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="product-sorting">
                                    <select id="product_sorting_select">
                                        <option value="default" @if($selected_order == '' || $selected_order == 'default') selected @endif >{{__('Newest Product')}}</option>
                                        <option value="old" @if($selected_order == 'old') selected @endif >{{__('Oldest Product')}}</option>
                                        <option value="high_low" @if($selected_order == 'high_low') selected @endif >{{__('Highest To Lowest')}}</option>
                                        <option value="low_high" @if($selected_order == 'low_high') selected @endif >{{__('Lowest To Highest')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if(count($all_products) > 0)
                        @foreach($all_products as $data)
                            <div class="col-lg-4 col-md-6">
                                <div class="single-product-item-3 margin-bottom-30">
                                    <div class="thumb">
                                        <a href="{{route('frontend.products.single',$data->slug)}}">
                                            <div class="img-wrapper">
                                                {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                                            </div>
                                        </a>
                                        @if(!empty($data->badge))
                                            <span class="tag">{{$data->badge}}</span>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <a href="{{route('frontend.products.single',$data->slug)}}">
                                            <h4 class="title">{{$data->title}}</h4>
                                        </a>
                                        @if(count($data->ratings) > 0)
                                            <div class="rating-wrap">
                                                <div class="ratings">
                                                    <span class="hide-rating"></span>
                                                    <span class="show-rating" style="width: {{get_product_ratings_avg_by_id($data->id) / 5 * 100}}%"></span>
                                                </div>
                                                <p><span class="total-ratings">({{count($data->ratings)}})</span></p>
                                            </div>
                                        @endif
                                        @if(!get_static_option('display_price_only_for_logged_user'))
                                        <div class="price-wrap">
                                            <span class="price">{{$data->sale_price == 0 ? __('Free') :amount_with_currency_symbol($data->sale_price)}}</span>
                                            @if(!empty($data->regular_price))<del class="del-price">{{amount_with_currency_symbol($data->regular_price)}}</del>@endif
                                        </div>
                                        @endif
                                        @if($data->stock_status == 'out_stock')
                                            <div class="out_of_stock">{{__('Out Of Stock')}}</div>
                                        @else
                                            <a href="{{route('frontend.products.add.to.cart')}}" class="addtocart ajax_add_to_cart" data-product_id="{{$data->id}}" data-product_title="{{$data->title}}" data-product_quantity="1"><i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                                {{get_static_option('product_add_to_cart_button_'.$user_select_lang_slug.'_text')}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                            <div class="col-lg-12">
                                <div class="alert alert-warning">{{__('No Products Found')}}</div>
                            </div>
                        @endif
                        <div class="col-lg-12 text-center">
                            <nav class="pagination-wrapper product-page-pagination" aria-label="Page navigation ">
                                {{$all_products->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 order-lg-1">
                    <div class="product-widget-area">
                        <div class="widget widget_nav_menu">
                            <h4 class="widget-title">{{get_static_option('product_category_'.$user_select_lang_slug.'_text')}}</h4>
                            <ul class="product_category_list">
                                @foreach($all_category as $data)
                                    <li><a data-catid="{{$data->id}}" href="{{route('frontend.products.category',['id' => $data->id,'any' => Str::slug($data->title)])}}" @if($data->id == $selected_category) class="active" @endif>{{$data->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="widget widget_price_filter">
                            <h4 class="widget-title">{{get_static_option('product_price_filter_'.$user_select_lang_slug.'_text')}}</h4>
                            <div id="slider-range"></div>
                            <p><span class="min_filter_price">{{amount_with_currency_symbol($min_price)}}</span> <span class="max_filter_price">{{amount_with_currency_symbol($max_price)}}</span></p>
                            <button type="button" class="btn-boxed style-01" id="submit_price_filter_btn">{{__("Apply Filter")}}</button>
                        </div>
                        <div class="widget widget_rating_filter">
                            <h4 class="widget-title">{{get_static_option('product_rating_filter_'.$user_select_lang_slug.'_text')}}</h4>
                            <ul class="ratings_filter_list">
                                <li>
                                    <div class="single-rating-filter-wrap">
                                        <input type="radio" id="rating_bal_all" @if(empty($selected_rating)) checked @endif  name="ratings_val" value="">
                                        <label class="filter-text" for="rating_bal_all">{{__('Show All')}}</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-rating-filter-wrap">
                                        <input type="radio" id="rating_bal_04" @if($selected_rating == '4') checked @endif name="ratings_val" value="4">
                                        <label class="filter-text" for="rating_bal_04">{{__('Upto 4 star')}}</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-rating-filter-wrap">
                                        <input type="radio" id="rating_bal_03" @if($selected_rating == '3') checked @endif name="ratings_val" value="3">
                                        <label class="filter-text" for="rating_bal_03">{{__('Upto 3 star')}}</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-rating-filter-wrap">
                                        <input type="radio" name="ratings_val" @if($selected_rating == '2') checked @endif id="rating_bal_02" value="2">
                                        <label for="rating_bal_02" class="filter-text">{{__('Upto 2 star')}}</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-rating-filter-wrap">
                                        <input type="radio" name="ratings_val" @if($selected_rating == '1') checked @endif id="rating_bal_01" value="1">
                                        <label class="filter-text" for="rating_bal_01">{{__('Upto 1star')}}</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form id="product_search_form" class="d-none"  action="{{route('frontend.products')}}" method="get">
        <input type="hidden" id="search_query" name="q" value="{{$search_term}}">
        <input type="hidden" id="min_price" name="min_price" value="{{$min_price}}">
        <input type="hidden" id="max_price" name="max_price" value="{{$max_price}}">
        <input type="hidden" name="cat_id" id="category_id" value="{{$selected_category}}">
        <input type="hidden" name="orderby" id="orderby" value="{{$selected_order ? $selected_order : 'default'}}">
        <input type="hidden" name="rating" id="review" value="{{$selected_rating}}">
        <input type="hidden" name="page" value="{{$pages ?? 1}}">
        <button id="product_hidden_form_submit_button" type="submit"></button>
    </form>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/frontend/css/toastr.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('assets/frontend/js/toastr.min.js')}}"></script>
    <script>
        (function () {
            "use strict";

            //search form trigger
            $(document).on('click','#product_search_btn',function (e) {
                e.preventDefault();
                var searchTerms = $('#search_term').val();
                $('#search_query').val(searchTerms)
                $('#product_hidden_form_submit_button').trigger('click');
            });
            $(document).on('change','#product_sorting_select',function (e) {
                var sortVal = $('#product_sorting_select').val();
                $('#orderby').val(sortVal);
                $('#product_hidden_form_submit_button').trigger('click');
            });
            $(document).on('click','.product_category_list > li a',function (e) {
                e.preventDefault();
                var catID = $(this).data('catid');
                $('#category_id').val(catID);
                $('#product_hidden_form_submit_button').trigger('click');
            });
            $(document).on('change','input[name="ratings_val"]',function (e) {
                e.preventDefault();
                $('#review').val($(this).val());
                $('#product_hidden_form_submit_button').trigger('click');
            });
            $(document).on('click','#submit_price_filter_btn',function (e) {
                e.preventDefault();
                $('#product_hidden_form_submit_button').trigger('click');
            });
            $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: "{{$maximum_available_price}}",
                values: [ "{{$min_price}}", "{{$max_price}}" ],
                slide: function( event, ui ) {
                    var min_price = ui.values[ 0 ];
                    var max_price = ui.values[ 1 ];
                    var siteGlobalCurrency = "{{site_currency_symbol()}}";
                    $('.min_filter_price').text(siteGlobalCurrency+min_price);
                    $('.max_filter_price').text(siteGlobalCurrency+max_price);
                    $('#min_price').val(min_price);
                    $('#max_price').val(max_price);
                }
            });

            $(document).on('click','.ajax_add_to_cart',function (e) {
                e.preventDefault();
                var allData = $(this).data();
                var el = $(this);
                $.ajax({
                    url : "{{route('frontend.products.add.to.cart.ajax')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        'product_id' : allData.product_id,
                        'quantity' : allData.product_quantity,
                    },
                    beforeSend: function(){
                        el.text("{{__('Adding')}}");
                    },
                    success: function (data) {
                        el.html('<i class="fa fa-shopping-bag" aria-hidden="true"></i>'+"{{get_static_option('product_add_to_cart_button_'.$user_select_lang_slug.'_text')}}");
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "2000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.success(data.msg);
                        $('.navbar-area .nav-container .nav-right-content ul li.cart .pcount,.mobile-cart a .pcount').text(data.total_cart_item);
                    }
                });
            });

            /* product page pagination */
            $(document).on('click','.product-page-pagination .page-link',function (e){
                e.preventDefault();
                $('input[name="page"]').val($(this).text());
                $('#product_hidden_form_submit_button').trigger('click');
            });

        })(jQuery);
    </script>
@endsection



@extends('frontend.frontend-page-master')
@section('site-title')
    {{$product->title}}
@endsection
@section('style')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/toastr.css')}}">
@endsection
@section('page-title')
    {{$product->title}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{$product->meta_tags}}">
    <meta name="tags" content="{{$product->meta_description}}">
@endsection

@section('og-meta')
    <meta property="og:url" content="{{route('frontend.products.single',$product->slug)}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$product->title}}"/>
    {!! render_og_meta_image_by_attachment_id($product->image) !!}
    @php
        $post_img = null;
        $blog_image = get_attachment_image_by_id($product->image,"full",false);
        $post_img = !empty($blog_image) ? $blog_image['img_url'] : '';
    @endphp
@endsection
@section('content')
    <section class="product-content-area padding-top-120 padding-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @include('backend.partials.message')
                    <div class="single-product-details">
                        <div class="top-content">
                            @if(!empty($product->gallery))
                                @php
                                    $product_gllery_images = !empty( $product->gallery) ? explode('|', $product->gallery) : [];
                                @endphp
                                <div class="product-gallery">
                                    <div class="slider-gallery-slider">
                                        @foreach($product_gllery_images as $gl_img)
                                            <div class="single-gallery-slider-item">
                                                {!! render_image_markup_by_attachment_id($gl_img,'','large') !!}
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="slider-gallery-nav">
                                        @foreach($product_gllery_images as $gl_img)
                                            <div class="single-gallery-slider-nav-item">
                                                {!! render_image_markup_by_attachment_id($gl_img,'','thumb') !!}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="thumb">
                                    {!! render_image_markup_by_attachment_id($product->image,'','large') !!}
                                </div>
                            @endif
                            <div class="product-summery">
                                @if(count($product->ratings) > 0)
                                    <div class="rating-wrap">
                                        <div class="ratings">
                                            <span class="hide-rating"></span>
                                            <span class="show-rating"
                                                  style="width: {{$average_ratings / 5 * 100}}%"></span>
                                        </div>
                                        <p><span class="total-ratings">({{count($product->ratings)}})</span></p>
                                    </div>
                                @endif
                                @if(!get_static_option('display_price_only_for_logged_user'))
                                <div class="price-wrap">
                                    <span class="price">{{$product->sale_price == 0 ? __('Free') : amount_with_currency_symbol($product->sale_price)}}</span>
                                    @if(!empty($product->regular_price))
                                        <del class="del-price">{{amount_with_currency_symbol($product->regular_price)}}</del>
                                    @endif
                                </div>
                                @endif
                                <div class="short-description">
                                    <p>{{$product->short_description}}</p>
                                </div>
                                <div class="single-add-to-card-wrapper">
                                    @if($product->stock_status == 'out_stock')
                                        <div class="out_of_stock">{{__('Out Of Stock')}}</div>
                                    @else
                                        <form action="{{route('frontend.products.add.to.cart')}}" method="post">
                                            @csrf
                                            <input type="number" class="quantity" name="quantity" min="1" value="1">
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <button type="submit"
                                                    class="addtocart">{{get_static_option('product_single_'.$user_select_lang_slug.'_add_to_cart_text')}}</button>
                                        </form>
                                    @endif
                                </div>
                                <div class="cat-sku-content-wrapper">
                                    <div class="category-wrap">
                                        <span class="title">{{get_static_option('product_single_'.$user_select_lang_slug.'_category_text')}}</span>
                                        {!! get_product_category_by_id($product->category_id,'link') !!}
                                    </div>
                                    @if(!empty($product->sku))
                                        <div class="sku-wrap"><span
                                                class="title">{{get_static_option('product_single_'.$user_select_lang_slug.'_sku_text')}}</span>
                                            <span class="sku_">{{$product->sku}}</span></div>
                                    @endif
                                    <div class="share-wrap">
                                       <ul class="social-icons">
                                           <li class="title">{{__('Share')}}:</li>
                                           {!! single_post_share(route('frontend.blog.single',$product->slug),$product->title,$post_img) !!}
                                       </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bottom-content">
                            <div class="extra-content-wrap">
                                <nav>
                                    <div class="nav nav-tabs" role="tablist">
                                        <a class="nav-item nav-link active" data-toggle="tab" href="#nav-description"
                                           role="tab"
                                           aria-selected="true">{{get_static_option('product_single_'.$user_select_lang_slug.'_description_text')}}</a>
                                        @php
                                        $product_attributes_title = unserialize($product->attributes_title);
                                        @endphp
                                        @if(!empty($product_attributes_title[0]) )
                                            <a class="nav-item nav-link" data-toggle="tab" href="#nav-attributes"
                                               role="tab"
                                               aria-selected="false">{{get_static_option('product_single_'.$user_select_lang_slug.'_attributes_text')}}</a>
                                        @endif
                                        @if(!empty(get_static_option('product_single_related_products_status')))
                                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-ratings" role="tab"
                                           aria-selected="false">{{get_static_option('product_single_'.$user_select_lang_slug.'_ratings_text')}}</a>
                                        @endif
                                    </div>
                                </nav>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel">
                                        <div class="product-description">
                                            {!! $product->description !!}
                                        </div>
                                    </div>
                                    @if(!empty($product_attributes_title[0]))
                                        <div class="tab-pane fade" id="nav-attributes" role="tabpanel">
                                            @php
                                                $att_title = unserialize($product->attributes_title);
                                                $att_descr = unserialize($product->attributes_description);
                                            @endphp
                                            @if(!empty($att_title))
                                                <div class="table-wrap table-responsive">
                                                    <table class="table table-bordered">
                                                        @foreach($att_title as $key => $att_title)
                                                            <tr>
                                                                <th>{{$att_title}}</th>
                                                                <td>{{$att_descr[$key]}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if(!empty(get_static_option('product_single_related_products_status')))
                                    <div class="tab-pane fade" id="nav-ratings" role="tabpanel">
                                        <div class="product-rating">
                                            <div class="rating-wrap">
                                                <div class="ratings">
                                                    <span class="hide-rating"></span>
                                                    <span class="show-rating"
                                                          style="width: {{$average_ratings / 5 * 100}}%"></span>
                                                </div>
                                                <p><span class="total-ratings">({{count($product->ratings)}})</span></p>
                                            </div>
                                            @if(count($product->ratings) > 0)
                                                <ul class="product-rating-list">
                                                    @foreach($product->ratings as $rating)
                                                        <li>
                                                            <div class="single-product-rating-item">
                                                                <div class="content">
                                                                    <h4 class="title">{{get_user_name_by_id($rating->user_id) ? get_user_name_by_id($rating->user_id)->name : __('anonymous')}}</h4>
                                                                    <div class="ratings text-warning">
                                                                        {!! render_ratings($rating->ratings) !!}
                                                                    </div>
                                                                    <p>{{$rating->message}}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            <div class="product-ratings-form">
                                                @if(auth()->check())
                                                    <h4 class="title">{{__('Leave A Review')}}</h4>
                                                    @if($errors->any())
                                                        <ul class="alert alert-danger">
                                                            @foreach($errors->all() as $error)
                                                                <li>{{$error}}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    <form action="{{route('product.ratings.store')}}" method="post"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                                        <div class="form-group">
                                                            <label
                                                                for="rating-empty-clearable2">{{__('Ratings')}}</label>
                                                            <input type="number" name="ratings"
                                                                   id="rating-empty-clearable2"
                                                                   class="rating text-warning"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ratings_message">{{__('Message')}}</label>
                                                            <textarea name="ratings_message" class="form-control"
                                                                      id="ratings_message" cols="30" rows="5"
                                                                      placeholder="{{__('Message')}}"></textarea>
                                                        </div>
                                                        <div class="btn-wrapper">
                                                            <button type="submit"
                                                                    class="btn-boxed style-01">{{__('Submit')}}</button>
                                                        </div>
                                                    </form>
                                                @else
                                                  @include('frontend.partials.ajax-login-form')
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($related_products) > 0 && !empty(get_static_option('product_single_related_products_status')))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="related-product-area">
                            <h3 class="title">{{get_static_option('product_single_'.$user_select_lang_slug.'_related_product_text')}}</h3>
                            <div class="related-product-wrapper">
                                <div class="row">
                                    @foreach($related_products as $data)
                                        <div class="col-lg-3">
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
                                                                <span class="show-rating"
                                                                      style="width: {{get_product_ratings_avg_by_id($data->id) / 5 * 100}}%"></span>
                                                            </div>
                                                            <p><span
                                                                    class="total-ratings">({{count($data->ratings)}})</span>
                                                            </p>
                                                        </div>
                                                    @endif
                                                    <div class="price-wrap">
                                                        <span
                                                            class="price">{{amount_with_currency_symbol($data->sale_price)}}</span>
                                                        @if(!empty($data->regular_price))
                                                            <del class="del-price">{{amount_with_currency_symbol($data->regular_price)}}</del>@endif
                                                    </div>
                                                    @if($data->stock_status == 'out_stock')
                                                        <div class="out_of_stock">{{__('Out Of Stock')}}</div>
                                                    @else
                                                        <a href="{{route('frontend.products.add.to.cart')}}"
                                                           class="addtocart ajax_add_to_cart"
                                                           data-product_id="{{$data->id}}"
                                                           data-product_title="{{$data->title}}"
                                                           data-product_quantity="1"><i class="fa fa-shopping-bag"
                                                                                        aria-hidden="true"></i>
                                                            {{get_static_option('product_add_to_cart_button_'.$user_select_lang_slug.'_text')}}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="//use.fontawesome.com/5ac93d4ca8.js"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/js/bootstrap4-rating-input.js')}}"></script>
    <script src="{{asset('assets/frontend/js/toastr.min.js')}}"></script>
    @include('frontend.partials.ajax-login-form-js')
    <script>
        (function ($) {
            "use strict";

            var rtlEnable = $('html').attr('dir');
            var sliderRtlValue = typeof rtlEnable === 'undefined' ||  rtlEnable === 'ltr' ? false : true ;

            $(document).ready(function () {

                $('.slider-gallery-slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.slider-gallery-nav',
                    rtl: sliderRtlValue
                });
                $('.slider-gallery-nav').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.slider-gallery-slider',
                    dots: false,
                    arrows: false,
                    centerMode: false,
                    focusOnSelect: true,
                    rtl: sliderRtlValue
                });

                $(document).on('click', '.ajax_add_to_cart', function (e) {
                    e.preventDefault();
                    var allData = $(this).data();
                    var el = $(this);
                    $.ajax({
                        url: "{{route('frontend.products.add.to.cart.ajax')}}",
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            'product_id': allData.product_id,
                            'quantity': allData.product_quantity,
                        },
                        beforeSend: function () {
                            el.text("{{__('Adding')}}");
                        },
                        success: function (data) {
                            el.html('<i class="fa fa-shopping-bag" aria-hidden="true"></i>' + "{{get_static_option('product_add_to_cart_button_'.$user_select_lang_slug.'_text')}}");
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
                            $('.navbar-area .nav-container .nav-right-content ul li.cart .pcount').text(data.total_cart_item);
                        }
                    });
                });
            });

        })(jQuery)
    </script>
@endsection

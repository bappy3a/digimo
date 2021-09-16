@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Category:')}} {{$category_name}}
@endsection
@section('site-title')
    {{__('Category:')}} {{$category_name}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('product_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('product_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                @foreach($all_products as $data)
                    <div class="col-lg-3 col-md-6">
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
                                    <span class="price">{{amount_with_currency_symbol($data->sale_price)}}</span>
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
                <div class="col-lg-12 text-center">
                    <nav class="pagination-wrapper " aria-label="Page navigation ">
                        {{$all_products->links()}}
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('frontend.partials.ajax-addtocart')

@extends('backend.admin-master')
@section('site-title')
    {{__('New Order')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
               <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                       <div class="header-wrapper d-flex justify-content-between">
                           <h4 class="header-title">{{__('New Order')}}</h4>
                           <a href="{{route('admin.products.order.logs')}}" class="btn btn-primary">{{__('All Orders')}}</a>
                       </div>
                        <form action="{{route('admin.product.order.new')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <h6 class="group-title">{{__('Billing Details Details')}}</h6>
                                    <div class="form-group">
                                        <label for="billing_name">{{__('Billing Name')}}</label>
                                        <input type="text" class="form-control"  name="billing_name" >
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_email">{{__('Billing Email')}}</label>
                                        <input type="text" class="form-control"  name="billing_email" >
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_phone">{{__('Billing Phone')}}</label>
                                        <input type="text" class="form-control"  name="billing_phone" >
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_country">{{__('Billing Country')}}</label>
                                        {!! get_country_field('billing_country','billing_country','form-control') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_street_address">{{__('Billing Street Address')}}</label>
                                        <input type="text" class="form-control" name="billing_street_address">
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_town">{{__('Billing Town/City')}}</label>
                                        <input type="text" class="form-control" name="billing_town" >
                                    </div>
                                    <div class="form-group">
                                        <label for="billing_district">{{__('Billing State')}}</label>
                                        <input type="text" class="form-control" name="billing_district">
                                    </div>

                                    <div class="form-group">
                                        <label for="different_shipping_address"><strong>{{__('Use Different Shipping Address Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="different_shipping_address" checked>
                                            <span class="slider"></span>
                                        </label>
                                    </div>

                                    <div class="shipping-wrap">
                                    <h6 class="group-title">{{__('Shipping Details')}}</h6>
                                    <div class="form-group">
                                        <label for="shipping_name">{{__('Shipping Name')}}</label>
                                        <input type="text" class="form-control"  name="shipping_name" >
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_email">{{__('Shipping Email')}}</label>
                                        <input type="text" class="form-control"  name="shipping_email" >
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_phone">{{__('Shipping Phone')}}</label>
                                        <input type="text" class="form-control"  name="shipping_phone" >
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_country">{{__('Shipping Country')}}</label>
                                        {!! get_country_field('shipping_country','shipping_country','form-control') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_street_address">{{__('Shipping Street Address')}}</label>
                                        <input type="text" class="form-control" name="shipping_street_address">
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_town">{{__('Shipping Town/City')}}</label>
                                        <input type="text" class="form-control" name="shipping_town" >
                                    </div>
                                    <div class="form-group">
                                        <label for="shipping_district">{{__('Shipping State')}}</label>
                                        <input type="text" class="form-control" name="shipping_district">
                                    </div>


                                    </div>
                                    <div class="form-group">
                                        <label for="cart_items">{{__('Products')}}</label>
                                        <select name="cart_items[]" multiple class="form-control nice-select wide">
                                            <option value="">{{__('Select Products')}}</option>
                                            @foreach($all_products as $product)
                                                <option value="{{$product->id}}">{{$product->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="stock_status">{{__('Shipping Method')}}</label>
                                        <select name="product_shippings_id" class="form-control" >
                                            <option value="">{{__('Select Shipping Method')}}</option>
                                            @foreach($all_shipping as $shipping)
                                            <option value="{{$shipping->id}}" @if($shipping->is_default == 1) selected @endif>{{$shipping->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_gateway">{{__('Payment Gateway')}}</label>
                                        <select name="payment_gateway" class="form-control" >
                                            <option value="">{{__('Select Shipping Method')}}</option>
                                            @php
                                                $all_gateways = ['paypal','manual_payment','mollie','paytm','stripe','razorpay','flutterwave','paystack'];
                                            @endphp
                                            @foreach($all_gateways as $gateway)
                                                @if(!empty(get_static_option($gateway.'_gateway')))
                                                    <option value="{{$gateway}}" @if(get_static_option('site_default_payment_gateway') == $gateway) selected @endif>{{ucwords(str_replace('_',' ',$gateway))}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id">{{__('User')}}</label>
                                        <select name="user_id" class="form-control nice-select wide" >
                                            <option value="">{{__('Select User')}}</option>
                                            @foreach($all_users as $user)
                                                <option value="{{$user->id}}" >{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="status">{{__('Status')}}</label>
                                        <select name="status" id="status"  class="form-control">
                                            <option value="pending">{{__('Pending')}}</option>
                                            <option value="in_progress">{{__('In Progress')}}</option>
                                            <option value="shipped">{{__('Shipped')}}</option>
                                            <option value="cancel">{{__('Cancel')}}</option>
                                            <option value="complete">{{__('Complete')}}</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Submit')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    <script>
        $(document).ready(function () {

           /*--------------------------------------
           *  DIFFERENT SHIPPING METHOD CHECK
           * -------------------------------------*/

            $(document).on('change','input[name="different_shipping_address"]',function(){
                var shippingWrap = $('.shipping-wrap');
                if($(this).is(':checked')){
                    shippingWrap.addClass('d-block').removeClass('d-none');
                }else{
                    shippingWrap.removeClass('d-block').addClass('d-none');
                }
            });

            /*---------------------------------
            *   NICE SELECT INITIALIZE
            * -------------------------------*/
            var niceSelect = $('.nice-select');
            if(niceSelect.length > 0){
                niceSelect.niceSelect();
            }
        });
    </script>
@endsection

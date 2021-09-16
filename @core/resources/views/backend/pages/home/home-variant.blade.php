@extends('backend.admin-master')
@section('site-title')
    {{__('Home Variant Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <!-- basic form start -->
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
                        <h4 class="header-title">{{__('Home Variant')}}</h4>
                        <form action="{{route('admin.home.variant')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control"  id="home_page_variant" value="{{get_static_option('home_page_variant')}}" name="home_page_variant">
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select selected">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-01.jpg')}}" data-home_id="01" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-02.jpg')}}" data-home_id="02" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-03.jpg')}}" data-home_id="03" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-04.jpg')}}" data-home_id="04" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-05.jpg')}}" data-home_id="05" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-06.jpg')}}" data-home_id="06" alt="">
                                        </div>
                                    </div>
                                </div>
                               <div class="col-lg-3 col-md-6">
                                   <div class="img-select">
                                       <div class="img-wrap">
                                           <img src="{{asset('assets/frontend/home-variant/home-07.jpg')}}" data-home_id="07" alt="">
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-3 col-md-6">
                                   <div class="img-select">
                                       <div class="img-wrap">
                                           <img src="{{asset('assets/frontend/home-variant/home-08.jpg')}}" data-home_id="08" alt="">
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-3 col-md-6">
                                   <div class="img-select">
                                       <div class="img-wrap">
                                           <img src="{{asset('assets/frontend/home-variant/home-09.jpg')}}" data-home_id="09" alt="">
                                        </div>
                                   </div>
                               </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-10.png')}}" data-home_id="10" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-11.png')}}" data-home_id="11" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-12.png')}}" data-home_id="12" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-13.png')}}" data-home_id="13" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-14.png')}}" data-home_id="14" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-15.png')}}" data-home_id="15" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-16.png')}}" data-home_id="16" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-17.png')}}" data-home_id="17" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="img-select">
                                        <div class="img-wrap">
                                            <img src="{{asset('assets/frontend/home-variant/home-18.png')}}" data-home_id="18" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Home Variant')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function($){
            "use strict";

            $(document).ready(function () {

                var imgSelect = $('.img-select');
                var id = $('#home_page_variant').val();
                imgSelect.removeClass('selected');
                $('img[data-home_id="'+id+'"]').parent().parent().addClass('selected');
                $(document).on('click','.img-select img',function (e) {
                    e.preventDefault();
                    imgSelect.removeClass('selected');
                    $(this).parent().parent().addClass('selected').siblings();
                    $('#home_page_variant').val($(this).data('home_id'));
                })
            })

        })(jQuery);
    </script>
@endsection
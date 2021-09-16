@extends('frontend.frontend-master')

@section('content')
@include('frontend.home-pages.home-'.get_static_option('home_page_variant'))
@endsection

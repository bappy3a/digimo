@extends('backend.admin-master')
@section('site-title')
    {{__('Regenerate Image Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Regenerate Image Settings")}}</h4>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                             @endforeach
                        @endif
                        <form action="{{route('admin.general.regenerate.thumbnail')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Regenerate Images')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

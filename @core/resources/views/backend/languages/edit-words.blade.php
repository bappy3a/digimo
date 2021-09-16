@extends('backend.admin-master')
@section('site-title')
    {{__('Edit Words Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="top-part d-flex justify-content-between">
                            <div class="left-item">
                                <h4 class="header-title">{{__("Change All Words")}}</h4>
                                <button
                                        class="btn btn-secondary btn-xs margin-bottom-40"
                                        data-toggle="modal"
                                        data-target="#view_quote_details_modal"
                                >{{__('Add New Word')}}</button>
                            </div>
                            <div class="btn-wrapper">
                                <a href="{{route('admin.languages')}}" class="btn btn-info">{{__('All Languages')}}</a>
                            </div>
                        </div>
                        <form action="{{route('admin.languages.words.update',$lang_slug)}}" method="POST" enctype="multipart/form-data">
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                            <br>
                            <br>
                            @csrf
                            <input type="hidden" name="type" value="{{$type}}">
                            <div class="row">
                                @foreach($all_word as $key => $value)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label for="{{Str::slug(($key))}}">{{$key}}</label>
                                            <input type="text" name="word[{{$key}}]"  class="form-control" value="{{$value}}" id="{{Str::slug(($key))}}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_quote_details_modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add New Translate able String')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.languages.add.new.word')}}" id="user_password_change_modal_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="lang_slug" id="lang_slug" value="{{$lang_slug}}">
                        <div class="form-group">
                            <label for="new_string">{{__('String')}}</label>
                            <input type="text" class="form-control" name="new_string" placeholder="{{__('new string')}}">
                        </div>
                        <div class="form-group">
                            <label for="translated_string">{{__('Translated String')}}</label>
                            <input type="text" class="form-control" id="translated_string" name="translated_string" placeholder="{{__('Translated String')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Add New String')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

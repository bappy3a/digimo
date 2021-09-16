@extends('backend.admin-master')
@section('style')
    @include('backend.partials.datatable.style-enqueue')
@endsection
@section('site-title')
    {{__('All Email Templates')}}
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
                        <h4 class="header-title">{{__('All Email Templates')}}</h4>
                         <div class="table-wrap table-responsive">
                            <table class="table table-default" >
                                <thead>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Action')}}</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{__('Admin reset password')}}</td>
                                        <td>
                                            <x-edit-icon :url="route('admin.email.template.admin.password.reset')"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__('User reset password')}}</td>
                                        <td>
                                            <x-edit-icon :url="route('admin.email.template.user.password.reset')"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('backend.partials.datatable.script-enqueue')
@endsection

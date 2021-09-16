@extends('backend.admin-master')
@section('site-title')
    {{__('Language Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <!-- basic form start -->
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-flash-msg/>
                <x-error-msg/>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('All Languages')}}</h4>
                        <table class="table table-default">
                            <thead>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Direction')}}</th>
                            <th>{{__('Slug')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Default')}}</th>
                            <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                            @foreach($all_lang as $data)
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{strtoupper($data->direction)}}</td>
                                    <td>{{$data->slug}}</td>
                                    <td>{{$data->status}}</td>
                                    <td>
                                        @if($data->default == 1)
                                            <a href="javascript:void(0)" class="btn btn-lg btn-success btn-xs mb-3 mr-1">{{__("Default")}}</a>
                                        @else
                                            <a tabindex="0" class="btn btn-warning btn-sm mb-3 mr-1"
                                               role="button"
                                               data-toggle="popover"
                                               data-trigger="focus"
                                               data-html="true"
                                               title=""
                                               data-content="
                                               <h6>{{__('Are you sure to make this language as a default language?')}}</h6>
                                               <form method='post' action='{{route('admin.languages.default',$data->id)}}'>
                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                               <br>
                                                <input type='submit' class='btn btn-primary btn-sm' value='{{__('yes, Please')}}'>
                                                </form>
                                                ">
                                                {{__("Make Default")}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->default == 0)
                                            <x-delete-popover :url="route('admin.languages.delete',$data->id)"/>
                                        @endif
                                        <a href="{{route('admin.languages.words.edit',$data->slug)}}" class="btn btn-info btn-xs mb-3 mr-1" style="color: #fff;">
                                            <i class="ti-pencil"></i> {{__("Edit Words")}}
                                        </a>
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#language_item_edit_modal"
                                           class="btn btn-lg btn-primary btn-xs mb-3 mr-1 lang_edit_btn"
                                           data-id="{{$data->id}}"
                                           data-name="{{$data->name}}"
                                           data-slug="{{$data->slug}}"
                                           data-status="{{$data->status}}"
                                           data-direction="{{$data->direction}}"
                                        >
                                            <i class="ti-pencil"></i>
                                        </a>
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#language_item_clone_modal"
                                           class="btn btn-secondary btn-xs mb-3 mr-1 lang_clone_btn"
                                           data-id="{{$data->id}}"
                                        >
                                            <i class="fas fa-copy"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Add New Language')}}</h4>
                        <form action="{{route('admin.languages.new')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{__('Name')}}</label>
                                <input type="text" class="form-control"  id="name"  name="name" placeholder="{{__('Name')}}">
                            </div>
                            <div class="form-group">
                                <label for="direction">{{__('Direction')}}</label>
                                <select name="direction" id="direction" class="form-control">
                                    <option value="ltr">{{__('LTR')}}</option>
                                    <option value="rtl">{{__("RTL")}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="publish">{{__('Publish')}}</option>
                                    <option value="draft">{{__("Draft")}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="slug">{{__('Slug')}}</label>
                                <input type="text" class="form-control"  id="slug"  name="slug" placeholder="{{__('Example: en')}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="language_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Language')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.languages.update')}}" id="contact_info_edit_modal_form"  method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="lang_id" value="">
                        <div class="form-group">
                            <label for="edit_name">{{__('Name')}}</label>
                            <input type="text" class="form-control"  id="edit_name"  name="name" placeholder="{{__('Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="direction">{{__('Direction')}}</label>
                            <select name="direction" id="edit_direction" class="form-control">
                                <option value="ltr">{{__('LTR')}}</option>
                                <option value="rtl">{{__("RTL")}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">{{__('Status')}}</label>
                            <select name="status" id="edit_status" class="form-control">
                                <option value="publish">{{__('Publish')}}</option>
                                <option value="draft">{{__("Draft")}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_slug">{{__('Slug')}}</label>
                            <input type="text" class="form-control"  id="edit_slug"  name="slug" placeholder="{{__('Example: en')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="language_item_clone_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Clone To New Languages')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <p class="alert alert-info">{{__('it will copy all content of all static sections, header slider, key features, contact info, support info, pages, menus')}}</p>
                <form action="{{route('admin.languages.clone')}}" id="contact_info_edit_modal_form"  method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="edit_name">{{__('Name')}}</label>
                            <input type="text" class="form-control" name="name" placeholder="{{__('Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="direction">{{__('Direction')}}</label>
                            <select name="direction" class="form-control">
                                <option value="ltr">{{__('LTR')}}</option>
                                <option value="rtl">{{__("RTL")}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">{{__('Status')}}</label>
                            <select name="status"  class="form-control">
                                <option value="publish">{{__('Publish')}}</option>
                                <option value="draft">{{__("Draft")}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_slug">{{__('Slug')}}</label>
                            <input type="text" class="form-control"  name="slug" placeholder="{{__('Example: en')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function () {
            $(document).on('click','.lang_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var name = el.data('name');
                var slug = el.data('slug');
                var form = $('#language_item_edit_modal');
                form.find('#lang_id').val(id);
                form.find('#edit_name').val(name);
                form.find('#edit_slug').val(slug);
                form.find('#edit_direction option[value="'+ el.data('direction')+'"]').prop('selected',true);
                form.find('#edit_status option[value="'+ el.data('status')+'"]').prop('selected',true);
            });
            $(document).on('click','.lang_clone_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var form = $('#language_item_clone_modal');
                form.find('input[name="id"]').val(id);
            });
        });
    </script>
@endsection

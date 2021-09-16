@extends('backend.admin-master')
@section('site-title')
    {{__('All Widgets')}}
@endsection
@section('style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/codemirror.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
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
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('All Widgets')}}</h4>
                        <ul id="sortable_02" class="available-form-field all-widgets">
                            @php
                                $widget_list = [
                                'about_us' => ['about_us_widget','render_about_us_widget'],
                                'recent_post' => ['recent_post_widget','render_recent_post_widget'],
                                'contact_info' => ['contact_info_widget','render_contact_info_widget'],
                                'recent_case_study' => ['recent_case_study_widget','render_recent_case_study_widget'],
                                'recent_services' => ['recent_service_widget','render_recent_service_widget'],
                                'newsletter' => ['newsletter_widget','render_newsletter_widget'],
                                'raw_html' => ['raw_html_widget','render_raw_html_widget'],
                                'navigation_menu' => ['navigation_menu_widget','render_navigation_menu_widget'],
                                'image' => ['single_image_widget','render_single_image_widget'],
                                ];
                            @endphp
                            @foreach($widget_list as $name => $widget)
                                <li class="ui-state-default widget-handler" widgetName="{{ucfirst(str_replace('_',' ',$name))}}" FrontendFunc="{{$widget[1]}}" AdminFunc="{{$widget[0]}}">
                                    <h4 class="top-part"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Widget: '.ucfirst(str_replace('_',' ',$name)))}}</h4>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-header widget-area-header">
                        <h4 class="header-title">{{__('Footer Widgets')}}</h4>
                        <span class="widget-area-expand"><i class="ti-angle-down"></i></span>
                    </div>
                    <div class="card-body widget-area-body hide">
                        <ul id="sortable" class="sortable available-form-field main-fields">
                            @if(count($all_widgets) > 0)
                            @foreach($all_widgets as $data)
                                @php $widget_data = unserialize($data->widget_content);@endphp
                                <li class="ui-state-default widget-handler" widgetName="{{$data->widget_name}}" FrontendFunc="{{$widget_data['frontend_render_function']}}" AdminFunc="{{$widget_data['admin_render_function']}}">
                                    <h4 class="top-part"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Widget: {{$data->widget_name}}</h4>
                                    <span class="expand"><i class="ti-angle-down"></i></span>
                                    <span class="remove-widget"><i class="ti-close"></i></span>
                                    <div class="content-part">
                                        {!! call_user_func_array($data->admin_render_function,['type' => 'update', 'id' => $data->id ]) !!}
                                    </div>
                                </li>
                             @endforeach
                            @else
                                <li class="ui-state-default widget-handler">
                                    <h4 class="top-part"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Widget: Placeholder')}}</h4>
                                    <span class="remove-widget"><i class="ti-close"></i></span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{asset('assets/backend/js/codemirror.js')}}"></script>
    <script src="{{asset('assets/backend/js/show-hint.js')}}"></script>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                $(".sortable").sortable({
                    axis: "y",
                    placeholder: "sortable-placeholder",
                    receive : function(event,ui){
                        resetOrder();
                    },
                    stop: function( event, ui ){
                        resetOrder();
                    }
                }).disableSelection();

                $("#sortable_02").sortable({
                    connectWith: '#sortable',
                    helper: "clone",
                    remove: function (e, li) {
                        var funcName = li.item.context.attributes.adminfunc.value;
                        var markup = '<span class="expand"><i class="ti-angle-down"></i></span>\n <span class="remove-widget"><i class="ti-close"></i></span> \n <div class="content-part show">\n';

                        $.ajax({
                           'url' : "{{route('admin.widgets.markup')}}",
                            'type' : "POST",
                            'data' : {
                                '_token' : "{!! csrf_token() !!}",
                                'func_name' : funcName
                            },
                            async: false,
                            success: function (data) {
                                markup += data;
                            }
                        });

                         markup += '</div>'; //end content div

                        li.item.clone()
                            .append(markup)
                            .insertAfter(li.item);
                        $(this).sortable('cancel');
                        return li.item.clone();
                    }
                }).disableSelection();

                $('body').on('click', '.remove-widget', function (e) {
                    $(this).parent().remove();
                    $( "#sortable_02" ).sortable( "refreshPositions" );
                    var parent =  $(this).parent();
                    var widgetType = parent.find('input[name="widget_type"]').val();
                    resetOrder();

                    if(widgetType == 'update'){
                        var widget_id = parent.find('input[name="id"]').val();
                        $.ajax({
                            'url' : "{{route('admin.widgets.delete')}}",
                            'type' : "POST",
                            'data' : {
                                '_token' : "{!! csrf_token() !!}",
                                'id' : widget_id
                            },
                            success: function (data) {
                            }
                        });
                    }
                });
                $('body').on('click', '.expand', function (e) {
                    $(this).parent().find('.content-part').toggleClass('show');
                    var expand = $(this).children('i');
                    if(expand.hasClass('ti-angle-down')){
                        expand.attr('class', 'ti-angle-up');
                    }else{
                        expand.attr('class', 'ti-angle-down');
                    }
                });

                $('body').on('click', '.widget_save_change_button', function (e) {
                    e.preventDefault();
                    var parent = $(this).parent().find('.widget_save_change_button');
                    parent.text('Saving...').attr('disabled',true);
                    var formClass =  $(this).parent();
                    var formData = formClass.serializeArray();
                    var widgetType = $(this).parent().find('input[name="widget_type"]').val();
                    var formAction = $(this).parent().attr('action');
                    var udpateId = '';
                    var formContainer = $(this).parent();

                    $.ajax({
                        type: "POST",
                        url:  formAction,
                        data: formClass.serializeArray() ,
                       success:function (data) {
                           udpateId = data.id;
                           if(widgetType == 'new'){
                               formContainer.attr('action',"{{route('admin.widgets.update')}}")
                               formContainer.find('input[name="widget_type"]').val('update');
                               formContainer.prepend('<input type="hidden" name="id" value="'+udpateId+'">');
                           }
                       }
                    });
                    parent.text('saved..');
                   setTimeout(function () {
                       parent.text('Save Changes').attr('disabled',false);
                   },1000);
                });

                /**
                * reset order function
                * */
                function resetOrder() {
                    var allItems = $('#sortable li');
                    $.each(allItems,function (index,value) {
                        $(this).find('input[name="widget_order"]').val(index+1);
                        var id = $(this).find('input[name="id"]').val();
                        var widget_order = index+1;
                        if(typeof id != 'undefined'){
                            reset_db_order(id,widget_order);
                        }
                    });
                }

                /**
                * reorder funciton
                * */
                function reset_db_order(id,widget_order){
                    $.ajax({
                        type: "POST",
                        url:  "{{route('admin.widgets.update.order')}}",
                        data: {
                            _token: "{{csrf_token()}}",
                            id : id,
                            widget_order: widget_order
                        },
                        success:function (data) {
                            //response ok if it saved success
                        }
                    });
                }
            });
            $(document).on('click','.widget-area-expand',function (e) {
                e.preventDefault();
                $(this).parent().parent().find('.widget-area-body').toggleClass('hide');
                var expand = $(this).children('i');
                if(expand.hasClass('ti-angle-down')){
                    expand.attr('class', 'ti-angle-up');
                }else{
                    expand.attr('class', 'ti-angle-down');
                }
            });
        }(jQuery));
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')

@endsection

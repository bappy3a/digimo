@extends('backend.admin-master')
@section('site-title')
    {{__('Edit Products')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-datepicker.min.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-flash-msg/>
                <x-error-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title">{{__('Edit Product')}}</h4>
                            <a href="{{route('admin.products.all')}}" class="btn btn-primary">{{__('All Products')}}</a>
                        </div>

                        <form action="{{route('admin.products.update')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="language"><strong>{{__('Language')}}</strong></label>
                                        <select name="lang" id="language" class="form-control">
                                            @foreach($all_languages as $lang)
                                                <option @if($product->lang === $lang->slug) selected @endif value="{{$lang->slug}}">{{$lang->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{__('Title')}}</label>
                                        <input type="text" class="form-control"  id="title" name="title" value="{{$product->title}}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">{{__('Slug')}}</label>
                                        <input type="text" class="form-control"  id="slug" name="slug" value="{{$product->slug}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="badge">{{__('Badge')}}</label>
                                        <input type="text" class="form-control"  id="badge" name="badge" value="{{$product->badge}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="category">{{__('Category')}}</label>
                                        <select name="category_id" class="form-control" id="category">
                                            <option value="">{{__("Select Category")}}</option>
                                            @foreach($all_categories as $category)
                                                <option @if($product->category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Description')}}</label>
                                        <input type="hidden" name="description" data-content='{{$product->description}}' value="{{$product->description}}">
                                        <div class="summernote">{!! $product->description !!}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_description">{{__('Short Description')}}</label>
                                        <textarea name="short_description" id="short_description" class="form-control max-height-120" cols="30" rows="4">{{$product->short_description}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="regular_price">{{__('Regular Price')}}</label>
                                        <input type="number" class="form-control"  id="regular_price" name="regular_price" value="{{$product->regular_price}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="sale_price">{{__('Sale Price')}}</label>
                                        <input type="number" class="form-control"  id="sale_price" name="sale_price" value="{{$product->sale_price}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="sku">{{__('SKU')}}</label>
                                        <input type="text" class="form-control"  id="sku" name="sku" value="{{$product->sku}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="stock_status">{{__('Stock')}}</label>
                                        <select name="stock_status" class="form-control" id="stock_status">
                                            <option @if($product->stock_status == 'in_stock') selected @endif value="in_stock">{{__('In Stock')}}</option>
                                            <option @if($product->stock_status == 'out_stock') selected @endif value="out_stock">{{__('Out Of Stock')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group attributes-field">
                                        <label for="attributes">{{__('Attributes')}}</label>
                                        @php
                                            $att_title = unserialize($product->attributes_title);
                                            $att_descr = unserialize($product->attributes_description);
                                        @endphp
                                        @if(!empty($att_title))
                                        @foreach($att_title as $key => $att_title)
                                            <div class="attribute-field-wrapper">
                                               <input type="text" class="form-control"  id="attributes" name="attributes_title[]" value="{{$att_title}}">
                                               <textarea name="attributes_description[]"  class="form-control" rows="5">{{$att_descr[$key]}}</textarea>
                                              <div class="icon-wrapper">
                                                  <span class="add_attributes"><i class="ti-plus"></i></span>
                                                  @if($key > 0) <span class="remove_attributes"><i class="ti-minus"></i></span> @endif
                                              </div>
                                           </div>
                                        @endforeach
                                        @else
                                            <div class="attribute-field-wrapper">
                                                <input type="text" class="form-control"  id="attributes" name="attributes_title[]" placeholder="{{__('Title')}}">
                                                <textarea name="attributes_description[]"  class="form-control" rows="5" placeholder="{{__('Value')}}"></textarea>
                                                <div class="icon-wrapper">
                                                    <span class="add_attributes"><i class="ti-plus"></i></span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="is_downloadable"><strong>{{__('Is Downloadable')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox"  @if($product->is_downloadable) checked @endif name="is_downloadable" id="is_downloadable">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label for="downloadable_file">{{__('Downloadable File')}}</label>
                                        <p class="info-text">
                                            @if(file_exists('assets/uploads/downloadable/'.$product->downloadable_file))
                                                <a href="{{route('admin.products.file.download',$product->id)}}" target="_blank">{{$product->downloadable_file}}</a>
                                            @endif
                                        </p>
                                        <input type="file" name="downloadable_file"  class="form-control" id="downloadable_file">
                                        <span class="info-text">{{__('only zip file is allowed')}}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags">{{__('Meta Tags')}}</label>
                                        <input type="text" name="meta_tags"  class="form-control" value="{{$product->meta_tags}}" data-role="tagsinput" id="meta_tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">{{__('Meta Description')}}</label>
                                        <textarea name="meta_description"  class="form-control" rows="5" id="meta_description">{{$product->meta_description}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">{{__('Image')}}</label>
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap">
                                                @php
                                                    $work_section_img = get_attachment_image_by_id($product->image,null,true);
                                                @endphp
                                                @if (!empty($work_section_img))
                                                    <div class="attachment-preview">
                                                        <div class="thumbnail">
                                                            <div class="centered">
                                                                <img class="avatar user-thumb" src="{{$work_section_img['img_url']}}" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="hidden" name="image" value="{{$product->image}}">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="{{__('Select Product Image')}}" data-modaltitle="{{__('Upload Product Image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                                {{__('Upload Image')}}
                                            </button>
                                        </div>
                                        <small>{{__('Recommended image size 1920x1280')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">{{__('Gallery')}}</label>
                                        @php
                                            $gallery_images = !empty( $product->gallery) ? explode('|', $product->gallery) : [];
                                        @endphp
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap">
                                                @foreach($gallery_images as $gl_img)
                                                    @php
                                                        $work_section_img = get_attachment_image_by_id($gl_img,null,true);
                                                    @endphp
                                                    @if (!empty($work_section_img))
                                                        <div class="attachment-preview">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img class="avatar user-thumb" src="{{$work_section_img['img_url']}}" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="gallery" value="{{$product->gallery}}">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-mulitple="true" data-btntitle="{{__('Select Image')}}" data-modaltitle="{{__('Upload Image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                                {{__('Upload Image')}}
                                            </button>
                                        </div>
                                        <small>{{__('Recommended image size 1920x1280')}}</small>
                                    </div>
                                    @if(get_static_option('product_tax_type') == 'individual')
                                    <div class="form-group">
                                        <label for="tax_percentage">{{__('Tax Percentage')}}</label>
                                        <input type="number" class="form-control"  id="tax_percentage" name="tax_percentage" value="{{$product->tax_percentage}}">
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="status">{{__('Status')}}</label>
                                        <select name="status" id="status"  class="form-control">
                                            <option @if($product->status == 'publish') selected @endif value="publish">{{__('Publish')}}</option>
                                            <option @if($product->status == 'draft') selected @endif  value="draft">{{__('Draft')}}</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Save Changes')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('change','#language',function(e){
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url: "{{route('admin.products.category.by.lang')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang : selectedLang
                    },
                    success:function (data) {
                        $('#category').html('<option value="">Select Category</option>');
                        $.each(data,function(index,value){
                            $('#category').append('<option value="'+value.id+'">'+value.title+'</option>')
                        });
                    }
                });
            });
            $('.summernote').summernote({
                height: 400,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });
            $(document).on('change','#is_downloadable',function (e) {
                e.preventDefault();
                isDownloadableCheck('#is_downloadable');
            });

            $(document).on('click','.attribute-field-wrapper .add_attributes',function (e) {
               e.preventDefault();
                $(this).parent().parent().parent().append(' <div class="attribute-field-wrapper">\n' +
                    '<input type="text" class="form-control"  id="attributes" name="attributes_title[]" placeholder="{{__('Title')}}">\n' +
                    '<textarea name="attributes_description[]"  class="form-control" rows="5" placeholder="{{__('Value')}}"></textarea>\n' +
                    '<div class="icon-wrapper">\n' +
                    '<span class="add_attributes"><i class="ti-plus"></i></span>\n' +
                    '<span class="remove_attributes"><i class="ti-minus"></i></span>\n' +
                    '</div>\n' +
                    '</div>');

            });
            isDownloadableCheck('#is_downloadable');
            $(document).on('click','.attribute-field-wrapper .remove_attributes',function (e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            function isDownloadableCheck($selector) {
                var dnFile = $('#downloadable_file');
                var dnFileUrl = $('#downloadable_file_link');
                if($($selector).is(':checked')){
                    dnFile.parent().show();
                    dnFileUrl.parent().show();
                }else{
                    dnFile.parent().hide();
                    dnFileUrl.parent().hide();
                }
            }
        });
    </script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection

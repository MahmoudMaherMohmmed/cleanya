@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
    <!---Internal Fancy uploader css-->
    <link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.application') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $cloth!=null ? __('dashboard.edit_cloth') : __('dashboard.create_cloth') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{$cloth!=null ? route('clothes.update', $cloth->id) : route('clothes.store')}}" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if($cloth!=null) @method('PUT') @endif
                        <div class="row row-sm">

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.title') }} <span class="tx-danger">*</span></label>
                                    <div class="example">
										<div class="panel panel-primary tabs-style-1">
                                            <div class=" tab-menu-heading">
                                                <div class="tabs-menu1">
                                                    <!-- Tabs -->
                                                    <ul class="nav panel-tabs main-nav-line">
                                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <li class="nav-item"><a href="#tab-title-{{ $localeCode }}" class="nav-link {{$loop->first ? 'active' : ''}}" data-toggle="tab">{{ $properties['native'] }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                                <div class="tab-content">
                                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                        <div class="tab-pane {{$loop->first ? 'active' : ''}}" id="tab-title-{{ $localeCode }}">
                                                            <input class="form-control" name="title[{{ $localeCode }}]" placeholder="{{ __('dashboard.title_placeholder') }}" value="{{$cloth!=null ? $cloth->getTranslation('title', $localeCode) : old('title[$localeCode]')}}" type="text" required>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.description') }}</label>
                                    <div class="example">
										<div class="panel panel-primary tabs-style-1">
                                            <div class=" tab-menu-heading">
                                                <div class="tabs-menu1">
                                                    <!-- Tabs -->
                                                    <ul class="nav panel-tabs main-nav-line">
                                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <li class="nav-item"><a href="#tab-description-{{ $localeCode }}" class="nav-link {{$loop->first ? 'active' : ''}}" data-toggle="tab">{{ $properties['native'] }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                                <div class="tab-content">
                                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                        <div class="tab-pane {{$loop->first ? 'active' : ''}}" id="tab-description-{{ $localeCode }}">
                                                            <textarea class="form-control" name="description[{{ $localeCode }}]" placeholder="{{ __('dashboard.description_placeholder') }}"
                                                            rows="5">{{$cloth!=null ? $cloth->getTranslation('description', $localeCode) : old('description[$localeCode]')}}</textarea>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.service_cost') }} <span class="tx-danger">*</span></label>
                                    <div class="example">
										<div class="panel panel-primary tabs-style-1">
                                            @if(isset($cloth) && $cloth!=null && $cloth->services()->count()>0)
                                                @foreach($cloth->services as $cloth_service)
                                                    <div class="row" id="cloth_service">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('dashboard.service') }} <span class="tx-danger">*</span></label>
                                                                <select class="form-control" name="service_id[]" required="">
                                                                    @foreach($services as $service)
                                                                        <option value="{{$service->id}}" {{$cloth_service->pivot->service_id==$service->id ? 'selected' : '' }}>{{$service->getTranslation('title', app()->getLocale())}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('dashboard.service_cost') }} <span class="tx-danger">*</span></label>
                                                                <input class="form-control" name="cost[]" placeholder="{{ __('dashboard.service_cost_placeholder') }}" value="{{$cloth_service->pivot->cost}}" type="number" step="any">
                                                            </div>
                                                        </div>

                                                        <div class="col-1" id="cloth_service_action" style="margin-top: 1.70rem">
                                                            @if($loop->last)
                                                                <a href="javascript:void(0)" id="add_new_cloth_service" class="btn btn-primary">
                                                                    <i class="mdi mdi-plus"></i>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0)" onclick="remove_product_unit(this)" class="btn btn-danger">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row" id="cloth_service">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ __('dashboard.service') }} <span class="tx-danger">*</span></label>
                                                            <select class="form-control" name="service_id[]" required="">
                                                                @foreach($services as $service)
                                                                    <option value="{{$service->id}}">{{$service->getTranslation('title', app()->getLocale())}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ __('dashboard.service_cost') }} <span class="tx-danger">*</span></label>
                                                            <input class="form-control" name="cost[]" placeholder="{{ __('dashboard.service_cost_placeholder') }}" value="{{$cloth!=null ? $cloth->unit_price : old('unit_price')}}" type="number" step="any">
                                                        </div>
                                                    </div>

                                                    <div class="col-1" id="cloth_service_action" style="margin-top: 1.70rem">
                                                        <a href="javascript:void(0)" id="add_new_cloth_service" class="btn btn-primary">
                                                            <i class="mdi mdi-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.image') }}</label>
                                    <input type="file" name="image" class="dropify" data-default-file="{{$cloth!=null && $cloth->image!=null ? url($cloth->image) : ''}}" data-height="200" />
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.status') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2-no-search" name="status" require="">
                                        <option value="1" {{$cloth!=null && $cloth->status==1 ? 'selected' : ''}}> {{ __('dashboard.activate') }} </option>
                                        <option value="0" {{$cloth!=null && $cloth->status==0 ? 'selected' : ''}}> {{ __('dashboard.deactivate') }} </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ $cloth!=null ? __('dashboard.edit') : __('dashboard.save') }}</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
@endsection
@section('js')
    <!--Internal  Select2 js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
    <!-- Internal Input tags js-->
    <script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>

    <script>
        $(function(){
            $("#add_new_cloth_service").on('click', function(){
                var ele = $(this).closest('#cloth_service').clone(true);
                $(this).closest('#cloth_service').after(ele);

                //add new delete button
                $(this).closest('#cloth_service').find('#cloth_service_action').append('<a href="javascript:void(0)" onclick="remove_product_unit(this)" class="btn btn-danger"><i class="mdi mdi-delete"></i></a>');

                //remove the add new button
                $(this).closest('#add_new_cloth_service').remove();
            });
        });

        function remove_product_unit(ele){
            $(ele).parent().parent().remove();
        }
    </script>
@endsection
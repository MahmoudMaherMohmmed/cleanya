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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $service!=null ? __('dashboard.edit_service') : __('dashboard.create_service') }}</span>
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
                    <form method="post" action="{{$service!=null ? route('services.update', $service->id) : route('services.store')}}" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if($service!=null) @method('PUT') @endif
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
                                                            <input class="form-control" name="title[{{ $localeCode }}]" placeholder="{{ __('dashboard.title_placeholder') }}" value="{{$service!=null ? $service->getTranslation('title', $localeCode) : old('title[$localeCode]')}}" type="text" required>
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
                                                            rows="5">{{$service!=null ? $service->getTranslation('description', $localeCode) : old('description[$localeCode]')}}</textarea>
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
                                    <label class="form-label">{{ __('dashboard.image') }}</label>
                                    <input type="file" name="image" class="dropify" data-default-file="{{$service!=null && $service->image!=null ? url($service->image) : ''}}" data-height="200" />
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.status') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2-no-search" name="status" require="">
                                        <option value="1" {{$service!=null && $service->status==1 ? 'selected' : ''}}> {{ __('dashboard.activate') }} </option>
                                        <option value="0" {{$service!=null && $service->status==0 ? 'selected' : ''}}> {{ __('dashboard.deactivate') }} </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ $service!=null ? __('dashboard.edit') : __('dashboard.save') }}</button></div>
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
@endsection
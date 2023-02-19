@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
    <!---Internal Fancy uploader css-->
    <link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $representative!=null ? __('dashboard.edit_representative') : __('dashboard.create_representative') }}</span>
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
                    <form method="post" action="{{$representative!=null ? route('representatives.update', $representative->id) : route('representatives.store')}}" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if($representative!=null) @method('patch') @endif
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.representativename') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="username" placeholder="{{ __('dashboard.representativename_placeholder') }}" value="{{$representative!=null ? $representative->username : old('username')}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.email') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="email" placeholder="{{ __('dashboard.email_placeholder') }}" value="{{$representative!=null ? $representative->email : old('email')}}" required="" type="email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.phone') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="phone" placeholder="{{ __('dashboard.phone_placeholder') }}" value="{{$representative!=null ? $representative->phone : old('phone')}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.password') }} @if($representative==null)<span class="tx-danger">*</span>@endif</label>
                                    <input class="form-control" name="password" placeholder="{{ __('dashboard.password_placeholder') }}" {{$representative== null ? 'required' : ''}} type="password">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.password_confirmation') }} @if($representative==null)<span class="tx-danger">*</span>@endif</label>
                                    <input class="form-control" name="password_confirmation" placeholder="{{ __('dashboard.password_confirmation_placeholder') }}" {{$representative== null ? 'required' : ''}} type="password">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.image') }} <span class="tx-danger">*</span></label>
                                    <input type="file" name="image" class="dropify" data-default-file="{{$representative!=null && $representative->image!=null ? url($representative->image) : ''}}" data-height="200" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.status') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2-no-search" name="status" require="">
                                        <option value="1" {{$representative!=null && $representative->status==1 ? 'selected' : ''}}> {{ __('dashboard.activate') }} </option>
                                        <option value="0" {{$representative!=null && $representative->status==0 ? 'selected' : ''}}> {{ __('dashboard.deactivate') }} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ $representative!=null ? __('dashboard.edit') : __('dashboard.save') }}</button></div>
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
@endsection
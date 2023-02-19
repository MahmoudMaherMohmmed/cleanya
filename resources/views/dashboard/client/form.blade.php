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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $client!=null ? __('dashboard.edit_client') : __('dashboard.create_client') }}</span>
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
                    <form method="post" action="{{$client!=null ? route('clients.update', $client->id) : route('clients.store')}}" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if($client!=null) @method('PUT') @endif
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.clientname') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="username" placeholder="{{ __('dashboard.clientname_placeholder') }}" value="{{$client!=null ? $client->username : old('username')}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.phone') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="phone" placeholder="{{ __('dashboard.phone_placeholder') }}" value="{{$client!=null ? $client->phone : old('phone')}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.email') }} </label>
                                    <input class="form-control" name="email" placeholder="{{ __('dashboard.email_placeholder') }}" value="{{$client!=null ? $client->email : old('email')}}" type="email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.password') }} @if($client==null)<span class="tx-danger">*</span>@endif</label>
                                    <input class="form-control" name="password" placeholder="{{ __('dashboard.password_placeholder') }}" {{$client== null ? 'required' : ''}} type="password">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.password_confirmation') }} @if($client==null)<span class="tx-danger">*</span>@endif</label>
                                    <input class="form-control" name="password_confirmation" placeholder="{{ __('dashboard.password_confirmation_placeholder') }}" {{$client== null ? 'required' : ''}} type="password">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.lat') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="lat" value="{{$client!=null ? $client->lat : '25.60417611097951'}}" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.lng') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="lng" value="{{$client!=null ? $client->lng : '43.86444002590798'}}" type="text">
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="map" style="margin-bottom: 10px; height: 400px; width: 100%;"> </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.image') }} </label>
                                    <input type="file" name="image" class="dropify" data-default-file="{{$client!=null && $client->image!=null ? url($client->image) : ''}}" data-height="200" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.status') }}</label>
                                    <select class="form-control select2-no-search" name="status">
                                        <option value="1" {{$client!=null && $client->status==1 ? 'selected' : ''}}> {{ __('dashboard.activate') }} </option>
                                        <option value="0" {{$client!=null && $client->status==0 ? 'selected' : ''}}> {{ __('dashboard.deactivate') }} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ $client!=null ? __('dashboard.edit') : __('dashboard.save') }}</button></div>
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

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&v=weekly&channel=2"
      async></script>

    <script>
        function initMap() {
            const myLatlng = { lat: {{$client!=null ? $client->lat : '25.60417611097951'}}, lng: {{$client!=null ? $client->lng : '43.86444002590798'}} };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: myLatlng,
            });
           
            map.addListener("click", (mapsMouseEvent) => {
                var latLng = mapsMouseEvent.latLng.toJSON();
                $('input[name="lat"]').val( JSON.parse( latLng.lat ) );
                $('input[name="lng"]').val( JSON.parse( latLng.lng ) );
            });
        }
    </script>
@endsection
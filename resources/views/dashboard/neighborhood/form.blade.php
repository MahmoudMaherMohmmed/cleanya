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
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $neighborhood!=null ? __('dashboard.edit_neighborhood') : __('dashboard.create_neighborhood') }}</span>
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
                    <form method="post" action="{{$neighborhood!=null ? route('neighborhoods.update', $neighborhood->id) : route('neighborhoods.store')}}" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if($neighborhood!=null) @method('PUT') @endif
                        <div class="row row-sm">

                            <div class="col-12 {{Config::get('app.locale')=='en' ? 'd-none' : '' }}">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.title') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="name[ar]" id="name_ar"type="text">
                                </div>
                            </div>

                            <div class="col-12 {{Config::get('app.locale')=='ar' ? 'd-none' : '' }}">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.title') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="name[en]" id="name_en" type="text">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.lat') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="lat" value="{{$neighborhood!=null ? $neighborhood->lat : '24.722313034049158'}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.lng') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="lng" value="{{$neighborhood!=null ? $neighborhood->lng : '46.76635328624388'}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="map" style="margin-bottom: 10px; height: 400px; width: 100%;"> </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.status') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2-no-search" name="status" require="">
                                        <option value="1" {{$neighborhood!=null && $neighborhood->status==1 ? 'selected' : ''}}> {{ __('dashboard.activate') }} </option>
                                        <option value="0" {{$neighborhood!=null && $neighborhood->status==0 ? 'selected' : ''}}> {{ __('dashboard.deactivate') }} </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ $neighborhood!=null ? __('dashboard.edit') : __('dashboard.save') }}</button></div>
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

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&v=weekly&channel=2&language={{Config::get('app.locale')}}"
      async></script>

    <script>
        $( document ).ready(function() {
            @if($neighborhood!=null)
                lat = {{$neighborhood->lat}};
                lng = {{$neighborhood->lng}};
            @else
                lat = 24.722313034049158;
                lng = 46.76635328624388;
            @endif

            updateName(lat,lng);
        });

        function initMap() {
            const myLatlng = { lat: {{$neighborhood!=null ? $neighborhood->lat : '24.722313034049158'}}, lng: {{$neighborhood!=null ? $neighborhood->lng : '46.76635328624388'}} };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 11,
                center: myLatlng,
                mapTypeId: "roadmap",
                zoomControl: false,
                scrollwheel: false,
                disableDoubleClickZoom: true
            });

            new google.maps.Marker({
                position: myLatlng,
                map,
            });
           
            map.addListener("click", (mapsMouseEvent) => {
                var latLng = mapsMouseEvent.latLng.toJSON();
                $('input[name="lat"]').val( JSON.parse( latLng.lat ) );
                $('input[name="lng"]').val( JSON.parse( latLng.lng ) );

                updateName(JSON.parse( latLng.lat ), JSON.parse( latLng.lng ));
            });
        }

        function updateName(lat,lng) {
            var geocoder = new google.maps.Geocoder;
            var latlng = {lat: lat, lng: lng};
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0].address_components[2].long_name) {
                        $('#name_{{Config::get('app.locale')}}').val(results[0].address_components[2].long_name);
                    } 
                }
            });
        }
    </script>
@endsection
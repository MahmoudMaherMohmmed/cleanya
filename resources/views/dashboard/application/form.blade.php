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
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $application!=null ? __('dashboard.edit_application') : __('dashboard.create_application') }}</span>
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
                    <form method="post" action="{{$application!=null ? route('application.update', $application->id) : route('application.store')}}" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if($application!=null) @method('PUT') @endif
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
                                                            <input class="form-control" name="title[{{ $localeCode }}]" placeholder="{{ __('dashboard.title_placeholder') }}" value="{{$application!=null ? $application->getTranslation('title', $localeCode) : old('title[$localeCode]')}}" required="" type="text">
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
                                    <label class="form-label">{{ __('dashboard.description') }} <span class="tx-danger">*</span></label>
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
                                                            <textarea class="form-control" name="description[{{ $localeCode }}]" placeholder="{{ __('dashboard.description_placeholder') }}" required=""
                                                            rows="5">{{$application!=null ? $application->getTranslation('description', $localeCode) : old('description[$localeCode]')}}</textarea>
                                                        </div>
                                                    @endforeach 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.phone') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="phone_1" placeholder="{{ __('dashboard.phone_placeholder') }}" value="{{$application!=null ? $application->phone_1 : old('phone_1')}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.phone') }} </label>
                                    <input class="form-control" name="phone_2" placeholder="{{ __('dashboard.phone_placeholder') }}" value="{{$application!=null ? $application->phone_2 : old('phone_2')}}" type="text">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.email') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="email_1" placeholder="{{ __('dashboard.email_placeholder') }}" value="{{$application!=null ? $application->email_1 : old('email_1')}}" required="" type="email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.email') }} </label>
                                    <input class="form-control" name="email_2" placeholder="{{ __('dashboard.email_placeholder') }}" value="{{$application!=null ? $application->email_2 : old('email_2')}}" type="email">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.working_days') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="working_days[]" required="" multiple>
                                        @include('dashboard.partials.days')
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.from') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="from" required="">
                                        @include('dashboard.partials.hours_from')
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.to') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="to" required="">
                                        @include('dashboard.partials.hours_to')
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.tax') }} (%) <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="tax" placeholder="{{ __('dashboard.tax_placeholder') }} (%)" value="{{$application!=null ? $application->tax : old('tax')}}" type="number" step="any">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.facebook_link') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="facebook_link" placeholder="{{ __('dashboard.facebook_link') }}" value="{{$application!=null ? $application->facebook_link : old('facebook_link')}}" required="" type="url">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.whatsapp_link') }} </label>
                                    <input class="form-control" name="whatsapp_link" placeholder="{{ __('dashboard.whatsapp_link') }}" value="{{$application!=null ? $application->whatsapp_link : old('whatsapp_link')}}" required="" type="url">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.twitter_link') }} </label>
                                    <input class="form-control" name="twitter_link" placeholder="{{ __('dashboard.twitter_link') }}" value="{{$application!=null ? $application->twitter_link : old('twitter_link')}}" required="" type="url">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.instagram_link') }} </label>
                                    <input class="form-control" name="instagram_link" placeholder="{{ __('dashboard.instagram_link') }}" value="{{$application!=null ? $application->instagram_link : old('instagram_link')}}" required="" type="url">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.snapchat_link') }} </label>
                                    <input class="form-control" name="snapchat_link" placeholder="{{ __('dashboard.snapchat_link') }}" value="{{$application!=null ? $application->snapchat_link : old('snapchat_link')}}" required="" type="url">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.youtube_link') }} </label>
                                    <input class="form-control" name="youtube_link" placeholder="{{ __('dashboard.youtube_link') }}" value="{{$application!=null ? $application->youtube_link : old('youtube_link')}}" required="" type="url">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.linkedin_link') }} </label>
                                    <input class="form-control" name="linkedin_link" placeholder="{{ __('dashboard.linkedin_link') }}" value="{{$application!=null ? $application->linkedin_link : old('linkedin_link')}}" type="url">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.tiktok_link') }} </label>
                                    <input class="form-control" name="tiktok_link" placeholder="{{ __('dashboard.tiktok_link') }}" value="{{$application!=null ? $application->tiktok_link : old('tiktok_link')}}" type="url">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.api_url') }} </label>
                                    <input class="form-control" name="api_url" placeholder="{{ __('dashboard.api_url') }}" value="{{$application!=null ? $application->api_url : old('api_url')}}" required="" type="url">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.api_key') }} </label>
                                    <input class="form-control" name="api_key" placeholder="{{ __('dashboard.api_key') }}" value="{{$application!=null ? $application->api_key : old('api_key')}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.api_username') }} </label>
                                    <input class="form-control" name="api_username" placeholder="{{ __('dashboard.api_username') }}" value="{{$application!=null ? $application->api_username : old('api_username')}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.api_password') }} </label>
                                    <input class="form-control" name="api_password" placeholder="{{ __('dashboard.api_password') }}" value="{{$application!=null ? $application->api_password : old('api_password')}}" required="" type="text">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.soft_opening') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2-no-search" name="soft_opening" require="">
                                        <option value="1" {{$application!=null && $application->soft_opening==1 ? 'selected' : ''}}> {{ __('dashboard.activate') }} </option>
                                        <option value="0" {{$application!=null && $application->soft_opening==0 ? 'selected' : ''}}> {{ __('dashboard.deactivate') }} </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.lat') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="lat" value="{{$application!=null ? $application->lat : '25.60417611097951'}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.lng') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="lng" value="{{$application!=null ? $application->lng : '43.86444002590798'}}" required="" type="text">
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="map" style="margin-bottom: 10px; height: 400px; width: 100%;"> </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.image') }} <span class="tx-danger">*</span></label>
                                    <input type="file" name="logo" class="dropify" data-default-file="{{$application!=null && $application->logo!=null ? url($application->logo) : ''}}" data-height="200" />
                                </div>
                            </div>

                            <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ $application!=null ? __('dashboard.edit') : __('dashboard.save') }}</button></div>
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
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4lIndWVJTXYLEgRwBQ4g3BXmAEHQup44&callback=initMap&v=weekly&channel=2"
      async></script>

    <script>
        function initMap() {
            const myLatlng = { lat: 25.60417611097951, lng: 43.86444002590798 };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: myLatlng,
            });

            new google.maps.Marker({
                position: myLatlng,
                map,
            });
           
            map.addListener("click", (mapsMouseEvent) => {
                var latLng = mapsMouseEvent.latLng.toJSON();
                $('input[name="lat"]').val( JSON.parse( latLng.lat ) );
                $('input[name="lng"]').val( JSON.parse( latLng.lng ) );
            });
        }
    </script>
@endsection
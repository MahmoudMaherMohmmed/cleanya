@extends('layouts.master')
@section('css')
<!--- Internal Select2 css-->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $notification!=null ? __('dashboard.edit_notification') :
                __('dashboard.create_notification') }}</span>
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
                <form method="post"
                    action="{{$notification!=null ? route('notifications.update', $notification->id) : route('notifications.store')}}"
                    enctype="multipart/form-data" data-parsley-validate="">
                    @csrf
                    @if($notification!=null) @method('PUT') @endif
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">{{ __('dashboard.clientname') }} <span
                                    class="tx-danger">*</span></label>
                            <select class="form-control select2" name="client_ids[]" multiple="multiple" required=""
                                id="clients_id">
                                <option value="0"> {{ __('dashboard.all_clients') }} </option>
                                @foreach($clients as $client)
                                <option value="{{$client->id}}"> {{ $client->username }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">{{ __('dashboard.notification_title') }} <span
                                        class="tx-danger">*</span></label>
                                <input class="form-control" name="title"
                                    placeholder="{{ __('dashboard.notification_title') }}"
                                    value="{{$notification!=null ? $notification->title : old('title')}}" required=""
                                    type="text">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">{{ __('dashboard.notification_body') }} <span
                                        class="tx-danger">*</span></label>
                                <textarea class="form-control" name="body"
                                    placeholder="{{ __('dashboard.notification_body') }}" rows="5"
                                    required="">{{$notification!=null ? $notification->body : old('body')}}</textarea>
                            </div>
                        </div>

                        <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{
                                $notification!=null ? __('dashboard.edit') : __('dashboard.save') }}</button></div>
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

<script>
    (function ($) {
        $('.select2').select2();

        $('.select2').on('select2:selecting', function (e) {
            if (e.params.args.data.id == 0) {
                $('#clients_id').val(null).trigger('change');
                // $('#clients_id').select2("enable", false);
                $('#clients_id').val("0").trigger("change");

                //$("#clients_id option").each(function (index) {
                //   if ($(this).not(':selected')) {
                //        $(this).prop('disabled', true);
                //    }
                //});
            }
        });

        $('.select2').on('select2:unselecting', function (e) {
            if (e.params.args.data.id == 0) {
                $('#clients_id').val(null).trigger('change');
            }
        });
    })(jQuery);
</script>
@endsection
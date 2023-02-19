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
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.application') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ $reservation!=null ? __('dashboard.edit_reservation') : __('dashboard.create_reservation') }}</span>
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
                    <form method="post" action="{{$reservation!=null ? route('reservations.update', $reservation->id) : route('reservations.store')}}" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if($reservation!=null) @method('PUT') @endif
                        <div class="row row-sm">

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.clientname') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="client_id" required="">
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}" {{$reservation!=null && $reservation->client_id==$client->id ? 'selected' : ''}}> {{ $client->username }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.representativename') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="representative_id" required="">
                                        @foreach($representatives as $representative)
                                            <option value="{{$representative->id}}" {{$reservation!=null && $reservation->representative_id==$representative->id ? 'selected' : ''}}> {{ $representative->username }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.reception_address') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="reception_address_id" required="">
                                        @foreach($addresses as $address)
                                            <option value="{{$address->id}}" {{$reservation!=null && $reservation->reception_address_id==$address->id ? 'selected' : ''}}> {{ $address->details }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.reception_date') }} <span class="tx-danger">*</span></label>
                                    <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
											</div>
										</div><input class="form-control fc-datepicker" placeholder="YYYY-MM-DD" name="reception_date" value="{{$reservation!=null ? $reservation->reception_date : old('reception_date')}}" required="" type="text">
									</div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.reception_time') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control chosen-rtl" name="reception_time" required="">
                                        @include('dashboard.partials.reception_time')
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.sending_address') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="sending_address_id" required="">
                                        @foreach($addresses as $address)
                                            <option value="{{$address->id}}" {{$reservation!=null && $reservation->sending_address_id==$address->id ? 'selected' : ''}}> {{ $address->details }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.sending_date') }} <span class="tx-danger">*</span></label>
                                    <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
											</div>
										</div><input class="form-control fc-datepicker" placeholder="YYYY-MM-DD" name="sending_date" value="{{$reservation!=null ? $reservation->sending_date : old('sending_date')}}" required="" type="text">
									</div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.sending_time') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control chosen-rtl" name="sending_time" required="">
                                        @include('dashboard.partials.sending_time')
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.delivery_cost') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="delivery_cost" placeholder="{{ __('dashboard.delivery_cost_placeholder') }}" value="{{$reservation!=null ? $reservation->delivery_cost : old('delivery_cost')}}" type="number" step="any">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.clothes') }} <span class="tx-danger">*</span></label>
                                    <div class="example">
										<div class="panel panel-primary tabs-style-1">
                                            @if(isset($reservation) && $reservation!=null && $reservation->items()->count()>0)
                                                @foreach($reservation->items as $item)
                                                    <div class="row" id="item">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('dashboard.service') }} <span class="tx-danger">*</span></label>
                                                                <select class="form-control" name="service_ids[]" required="">
                                                                    @foreach($services as $service)
                                                                        <option value="{{$service->id}}" {{$item->service_id==$service->id ? 'selected' : '' }}>{{$service->getTranslation('title', app()->getLocale())}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('dashboard.clothes') }} <span class="tx-danger">*</span></label>
                                                                <select class="form-control" name="cloth_ids[]" required="">
                                                                    @foreach($clothes as $cloth)
                                                                        <option value="{{$cloth->id}}" {{$item->cloth_id==$cloth->id ? 'selected' : '' }}>{{$cloth->getTranslation('title', app()->getLocale())}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('dashboard.pieces_number') }} <span class="tx-danger">*</span></label>
                                                                <input class="form-control" name="pieces_numbers[]" placeholder="{{ __('dashboard.pieces_number_placeholder') }}" value="{{$item->pieces_number}}" type="number" step="any">
                                                            </div>
                                                        </div>

                                                        <div class="col-1" id="item_action" style="margin-top: 1.70rem">
                                                            @if($loop->last)
                                                                <a href="javascript:void(0)" id="add_new_item" class="btn btn-primary">
                                                                    <i class="mdi mdi-plus"></i>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0)" onclick="remove_item(this)" class="btn btn-danger">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row" id="item">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ __('dashboard.service') }} <span class="tx-danger">*</span></label>
                                                            <select class="form-control" name="service_ids[]" required="">
                                                                @foreach($services as $service)
                                                                    <option value="{{$service->id}}">{{$service->getTranslation('title', app()->getLocale())}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ __('dashboard.clothes') }} <span class="tx-danger">*</span></label>
                                                            <select class="form-control" name="cloth_ids[]" required="">
                                                                @foreach($clothes as $cloth)
                                                                    <option value="{{$cloth->id}}">{{$cloth->getTranslation('title', app()->getLocale())}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ __('dashboard.pieces_number') }} <span class="tx-danger">*</span></label>
                                                            <input class="form-control" name="pieces_numbers[]" placeholder="{{ __('dashboard.pieces_number_placeholder') }}" type="number" step="any">
                                                        </div>
                                                    </div>

                                                    <div class="col-1" id="item_action" style="margin-top: 1.70rem">
                                                        <a href="javascript:void(0)" id="add_new_item" class="btn btn-primary">
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
                                    <label class="form-label">{{ __('dashboard.status') }}</label>
                                    <select class="form-control select2" name="status">
                                        <option value="0" {{$reservation!=null && $reservation->status==0 ?  'selected' : ''}}> {{ __('dashboard.reservation_status.cancelled') }} </option>
                                        <option value="1" {{$reservation!=null && $reservation->status==1 ?  'selected' : ''}}> {{ __('dashboard.reservation_status.pending') }} </option>
                                        <option value="2" {{$reservation!=null && $reservation->status==2 ?  'selected' : ''}}> {{ __('dashboard.reservation_status.in_receive') }} </option>
                                        <option value="3" {{$reservation!=null && $reservation->status==3 ?  'selected' : ''}}> {{ __('dashboard.reservation_status.received') }} </option>
                                        <option value="4" {{$reservation!=null && $reservation->status==4 ?  'selected' : ''}}> {{ __('dashboard.reservation_status.washing') }} </option>
                                        <option value="5" {{$reservation!=null && $reservation->status==5 ?  'selected' : ''}}> {{ __('dashboard.reservation_status.in_delivery') }} </option>
                                        <option value="6" {{$reservation!=null && $reservation->status==6 ?  'selected' : ''}}> {{ __('dashboard.reservation_status.delivered') }} </option> 
                                    </select>
                                </div>
                            </div>

                            <div class="col-12"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ $reservation!=null ? __('dashboard.edit') : __('dashboard.save') }}</button></div>
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

    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{URL::asset('assets/plugins/pickerjs/picker.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

    <!-- Internal Input tags js-->
    <script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>

    <script>
        $(function(){
            $("#add_new_item").on('click', function(){
                var ele = $(this).closest('#item').clone(true);
                $(this).closest('#item').after(ele);

                //add new delete button
                $(this).closest('#item').find('#item_action').append('<a href="javascript:void(0)" onclick="remove_item(this)" class="btn btn-danger"><i class="mdi mdi-delete"></i></a>');

                //remove the add new button
                $(this).closest('#add_new_item').remove();
            });
        });

        function remove_item(ele){
            $(ele).parent().parent().remove();
        }
    </script>
@endsection
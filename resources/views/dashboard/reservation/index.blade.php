@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.application') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.reservations') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example2">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.order_id') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.clientname') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.phone') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.representativename') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.reception_date') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.reception_time') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.sending_date') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.sending_time') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.payment_type') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.status') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($reservations) && $reservations!=null)
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>{{$reservation->id}}</td>
                                            <td>{{isset($reservation->client)&&$reservation->client!=null ? $reservation->client->username : '---'}}</td>
                                            <td>{{isset($reservation->client)&&$reservation->client!=null ? $reservation->client->phone : '---'}}</td>
                                            <td>{{$reservation->representative!=null ? $reservation->representative->username : '---'}}</td>
                                            <td>{{$reservation->reception_date}}</td>
                                            <td>{{$reservation->reception_time}}</td>
                                            <td>{{$reservation->sending_date}}</td>
                                            <td>{{$reservation->sending_time}}</td>
                                            <td>
                                                @if($reservation->payment_type == 0)
                                                    {{ __('dashboard.cash') }}
                                                @elseif($reservation->payment_type == 1)
                                                    {{ __('dashboard.balance') }}
                                                @elseif($reservation->payment_type == 2)
                                                    {{ __('dashboard.bank_transfer') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($reservation->status == 0)
                                                    {{ __('dashboard.reservation_status.cancelled') }}
                                                @elseif($reservation->status == 1)
                                                    {{ __('dashboard.reservation_status.pending') }}
                                                @elseif($reservation->status == 2)
                                                    {{ __('dashboard.reservation_status.in_receive') }}
                                                @elseif($reservation->status == 3)
                                                    {{ __('dashboard.reservation_status.received') }}
                                                @elseif($reservation->status == 4)
                                                    {{ __('dashboard.reservation_status.washing') }}
                                                @elseif($reservation->status == 5)
                                                    {{ __('dashboard.reservation_status.in_delivery') }}
                                                @else
                                                    {{ __('dashboard.reservation_status.delivered') }}
                                                @endif
                                            </td>
                                            <td> 
                                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-primary"> <i class="las la-eye"></i> </a> 
                                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-sm btn-info btn-b"> <i class="las la-pen"></i> </a> 
                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{$reservation->id}}').submit();"> <i class="las la-trash"></i> </a> 
                                                <form id="delete-form-{{$reservation->id}}" action="{{ route('reservations.destroy', $reservation->id) }}" method="POST">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
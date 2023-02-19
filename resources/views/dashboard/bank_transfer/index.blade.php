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
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.bank_transfers') }}</span>
            </div>
        </div>
        <!-- <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('bank-transfers.create') }}" class="btn btn-primary">
                {{ __('dashboard.create_bank_transfer') }} <i class="mdi mdi-plus"></i>
                </a>
            </div>
        </div> -->
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
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.id') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.clientname') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.bank_name') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.account_name') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.account_number') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.IBAN') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.status') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.created_at') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($bank_transfers) && $bank_transfers!=null)
                                    @foreach($bank_transfers as $bank_transfer)
                                        <tr>
                                            <td>{{$bank_transfer->id}}</td>
                                            <td>{{isset($bank_transfer->client) && $bank_transfer->client!=null ? $bank_transfer->client->username : '---'}}</td>
                                            <td>{{$bank_transfer->bank_name}}</td>
                                            <td>{{$bank_transfer->bank_account_name}}</td>
                                            <td>{{$bank_transfer->bank_account_number}}</td>
                                            <td>{{$bank_transfer->IBAN}}</td>
                                            <td>
                                                @if($bank_transfer->status == 0)
                                                    <span class="badge badge-danger">{{ __('dashboard.unacceptable') }}</span>
                                                @elseif($bank_transfer->status == 1)
                                                    <span class="badge badge-warning">{{ __('dashboard.pending') }}</span>
                                                @elseif($bank_transfer->status == 2)
                                                    <span class="badge badge-success">{{ __('dashboard.approved') }}</span>
                                                @endif
                                            </td>
                                            <td>{{$bank_transfer->created_at->diffForHumans()}}</td>
                                            <td> 
                                                <a href="{{ route('bank-transfers.show', $bank_transfer->id) }}" class="btn btn-sm btn-primary"> <i class="las la-eye"></i> </a> 
                                                <!-- <a href="{{ route('bank-transfers.edit', $bank_transfer->id) }}" class="btn btn-sm btn-info btn-b"> <i class="las la-pen"></i> </a>  -->
                                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{$bank_transfer->id}}').submit();"> <i class="las la-trash"></i> </a> 
                                                <form id="delete-form-{{$bank_transfer->id}}" action="{{ route('bank-transfers.destroy', $bank_transfer->id) }}" method="POST">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                </form> -->
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
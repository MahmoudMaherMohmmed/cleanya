@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.bank_transfer_details') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- row opened-->
    @if($bank_transfer->status == 1)
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{route('bank-transfers.update.status', $bank_transfer->id)}}" enctype="multipart/form-data" data-parsley-validate="">
                            @csrf
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.status') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control select2" name="status" id="bank_transfer_status" required="">
                                        <option value="0" {{$bank_transfer!=null && $bank_transfer->status==0 ?  'selected' : ''}}> {{ __('dashboard.unacceptable') }} </option>
                                        <option value="1" {{$bank_transfer!=null && $bank_transfer->status==1 ?  'selected' : ''}}> {{ __('dashboard.pending') }} </option>
                                        <option value="2" {{$bank_transfer!=null && $bank_transfer->status==2 ?  'selected' : ''}}> {{ __('dashboard.approved') }} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12" id="bank_transfer_amount">
                                <div class="form-group">
                                    <label class="form-label">{{ __('dashboard.amount') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="amount" placeholder="{{ __('dashboard.amount_placeholder') }}" type="number" value="0" min="0" required>
                                </div>
                            </div>
                            <div class="col-2"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ __('dashboard.change_status') }}</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- /row -->

    <!-- row opened -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap">
                            <tbody>
                                <tr>
                                    <th scope="row">{{ __('dashboard.id') }}</th>
                                    <td>{{$bank_transfer->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.clientname') }}</th>
                                    <td>{{isset($bank_transfer->client) && $bank_transfer->client!=null ? $bank_transfer->client->username : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.bank_name') }}</th>
                                    <td>{{$bank_transfer->bank_name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.account_number') }}</th>
                                    <td>{{$bank_transfer->bank_account_number}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.account_name') }}</th>
                                    <td>{{$bank_transfer->bank_account_name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.IBAN') }}</th>
                                    <td>{{$bank_transfer->IBAN}}</td>
                                </tr>
                                @if($bank_transfer->status == 2)
                                    <tr>
                                        <th scope="row">{{ __('dashboard.amount') }}</th>
                                        <td>{{$bank_transfer->transaction->amount}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th scope="row">{{ __('dashboard.image') }}</th>
                                    <td>
                                        <img src="{{url($bank_transfer->image)}}" alt="{{$bank_transfer->title}}" width="100px" height="100px">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$bank_transfer->created_at->diffForHumans()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.status') }}</th>
                                    <td>
                                        @if($bank_transfer->status == 0)
                                            {{ __('dashboard.unacceptable') }}
                                        @elseif($bank_transfer->status == 1)
                                            {{ __('dashboard.pending') }}
                                        @elseif($bank_transfer->status == 2)
                                            {{ __('dashboard.approved') }}
                                        @endif
                                    </td>
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $("#bank_transfer_amount").hide();

            $('#bank_transfer_status').on('change', function(){
                if($(this).val() == 2){
                    $("#bank_transfer_amount").show();
                }else{
                    $("#bank_transfer_amount").hide();
                }
            });
        });
    </script> 
@endsection
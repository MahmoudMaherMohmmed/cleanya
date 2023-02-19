@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.bank_account_details') }}</span>
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
                        <table class="table table-striped mg-b-0 text-md-nowrap">
                            <tbody>
                                <tr>
                                    <th scope="row">{{ __('dashboard.id') }}</th>
                                    <td>{{$bank_account->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.title') }}</th>
                                    <td>{{$bank_account->getTranslation('bank_name', app()->getLocale())}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.account_name') }}</th>
                                    <td>{{$bank_account->account_name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.account_number') }}</th>
                                    <td>{{$bank_account->account_number}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.IBAN') }}</th>
                                    <td>{{$bank_account->IBAN}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.status') }}</th>
                                    <td>{{$bank_account->status==1 ? __('dashboard.active') : __('dashboard.notactive')}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$bank_account->created_at->diffForHumans()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.image') }}</th>
                                    <td> <img class="brround" height="200px" width="200px" src="{{$bank_account->image!=null ? url($bank_account->image) : create_avater( $bank_account->getTranslation('name', app()->getLocale()) )}}"> </td>
                                </tr>
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
@endsection
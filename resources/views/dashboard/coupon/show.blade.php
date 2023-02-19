@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.application') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.coupon_details') }}</span>
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
                                    <td>{{$coupon->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.code') }}</th>
                                    <td>{{$coupon->code}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.discount') }}</th>
                                    <td>% {{$coupon->discount}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.active_from') }}</th>
                                    <td>{{ $coupon->active_from!=null ? $coupon->active_from : '---' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.active_to') }}</th>
                                    <td>{{ $coupon->active_to!=null ? $coupon->active_to : '---' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.description') }}</th>
                                    <td>{{$coupon->getTranslation('description', app()->getLocale())}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.available_use_count') }}</th>
                                    <td>{{$coupon->available_use_count}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.use_count') }}</th>
                                    <td>{{\App\Models\Reservation::where('coupon', $coupon->code)->count()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.status') }}</th>
                                    <td>{{$coupon->status==1 ? __('dashboard.active') : __('dashboard.notactive')}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$coupon->created_at->diffForHumans()}}</td>
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
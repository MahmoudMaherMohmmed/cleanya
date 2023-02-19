@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.representative_details') }}</span>
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
                                    <td>{{$representative->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.representativename') }}</th>
                                    <td>{{$representative->username}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.email') }}</th>
                                    <td>{{$representative->email}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.phone') }}</th>
                                    <td>{{$representative->phone}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.status') }}</th>
                                    <td>{{$representative->status==1 ? __('dashboard.active') : __('dashboard.notactive')}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$representative->created_at->diffForHumans()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.image') }}</th>
                                    <td> <img class="brround" height="200px" width="200px" src="{{$representative->image!=null ? url($representative->image) : create_avater($representative->username)}}"> </td>
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
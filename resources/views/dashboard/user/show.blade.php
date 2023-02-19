@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.manager_details') }}</span>
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
                                    <td>{{$user->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.managername') }}</th>
                                    <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.email') }}</th>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.phone') }}</th>
                                    <td>{{$user->phone}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.status') }}</th>
                                    <td>{{$user->status==1 ? __('dashboard.active') : __('dashboard.notactive')}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$user->created_at->diffForHumans()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.image') }}</th>
                                    <td> <img class="brround" height="200px" width="200px" src="{{$user->image!=null ? url($user->image) : create_avater($user->name)}}"> </td>
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
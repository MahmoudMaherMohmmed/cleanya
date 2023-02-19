@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.application') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.service_details') }}</span>
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
                                    <td>{{$service->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.title') }}</th>
                                    <td>{{$service->getTranslation('title', app()->getLocale())}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.description') }}</th>
                                    <td>{{$service->getTranslation('description', app()->getLocale())}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.status') }}</th>
                                    <td>{{$service->status==1 ? __('dashboard.active') : __('dashboard.notactive')}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$service->created_at->diffForHumans()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.image') }}</th>
                                    <td> <img class="brround" height="200px" width="200px" src="{{$service->image!=null ? url($service->image) : create_avater( $service->getTranslation('title', app()->getLocale()) )}}"> </td>
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
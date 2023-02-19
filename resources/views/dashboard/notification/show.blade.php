@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.notification_details') }}</span>
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
                                    <td>{{$notification->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.clientname') }}</th>
                                    <td>{{isset($notification->client)&&$notification->client!=null ? $notification->client->username : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.notification_title') }}</th>
                                    <td>{{$notification->title}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.notification_body') }}</th>
                                    <td>{{$notification->body}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$notification->created_at->diffForHumans()}}</td>
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
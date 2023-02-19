@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.contact_message_details') }}</span>
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
                                    <td>{{$contact_message->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.username') }}</th>
                                    <td>{{$contact_message->username}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.email') }}</th>
                                    <td>{{$contact_message->email}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.subject') }}</th>
                                    <td>{{$contact_message->subject}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.message') }}</th>
                                    <td>{{$contact_message->message}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$contact_message->created_at->diffForHumans()}}</td>
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
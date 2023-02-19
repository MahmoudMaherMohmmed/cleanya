@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.application_details') }}</span>
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
                                    <td>{{$application->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.title') }}</th>
                                    <td>{{$application->getTranslation('title', app()->getLocale())}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.description') }}</th>
                                    <td>{{$application->getTranslation('description', app()->getLocale())}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.tax') }}</th>
                                    <td>{{$application->tax}} %</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.email') }}</th>
                                    <td>{{$application->email_1}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.email') }}</th>
                                    <td>{{$application->email_2}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.phone') }}</th>
                                    <td>{{$application->phone_1}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.phone') }}</th>
                                    <td>{{$application->phone_2}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.facebook_link') }}</th>
                                    <td>{{$application->facebook_link!=null ? $application->facebook_link : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.whatsapp_link') }}</th>
                                    <td>{{$application->whatsapp_link!=null ? $application->whatsapp_link : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.twitter_link') }}</th>
                                    <td>{{$application->twitter_link!=null ? $application->twitter_link : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.instagram_link') }}</th>
                                    <td>{{$application->instagram_link!=null ? $application->instagram_link : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.snapchat_link') }}</th>
                                    <td>{{$application->snapchat_link!=null ? $application->snapchat_link : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.youtube_link') }}</th>
                                    <td>{{$application->youtube_link!=null ? $application->youtube_link : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.linkedin_link') }}</th>
                                    <td>{{$application->linkedin_link!=null ? $application->linkedin_link : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.tiktok_link') }}</th>
                                    <td>{{$application->tiktok_link!=null ? $application->tiktok_link : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.api_url') }}</th>
                                    <td>{{$application->api_url!=null ? $application->api_url : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.api_key') }}</th>
                                    <td>{{$application->api_key!=null ? $application->api_key : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.api_username') }}</th>
                                    <td>{{$application->api_username!=null ? $application->api_username : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.api_password') }}</th>
                                    <td>{{$application->api_password!=null ? $application->api_password : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.soft_opening') }}</th>
                                    <td>{{$application->soft_opening==1 ? __('dashboard.active') : __('dashboard.notactive')}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$application->created_at->diffForHumans()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.image') }}</th>
                                    <td> <img class="brround" height="200px" width="200px" src="{{$application->logo!=null ? url($application->logo) : create_avater( $application->getTranslation('title', app()->getLocale()) )}}"> </td>
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
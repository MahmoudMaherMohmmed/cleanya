@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.client_details') }}</span>
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
                                    <td>{{$client->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.clientname') }}</th>
                                    <td>{{$client->username}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.email') }}</th>
                                    <td>{{$client->email}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.phone') }}</th>
                                    <td>{{$client->phone}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.location') }}</th>
                                    <td>
                                        <div id="map" style="height: 300px"> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.status') }}</th>
                                    <td>{{$client->status==1 ? __('dashboard.active') : __('dashboard.notactive')}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$client->created_at->diffForHumans()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.image') }}</th>
                                    <td> <img class="brround" height="200px" width="200px" src="{{$client->image!=null ? url($client->image) : create_avater($client->username)}}"> </td>
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
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&v=weekly&channel=2"
    async></script>

<script>
    function initMap() {
        const myLatlng = { lat: {{$client->lat}}, lng: {{$client->lng}} };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: myLatlng,
        });
    }
</script>
@endsection
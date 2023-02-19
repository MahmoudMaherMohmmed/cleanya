@extends('layouts.master')
@section('css')
<style>
    .modal-content-demo .modal-body h6 {
        margin-bottom: 5px !important;
    }
</style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.application') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.reservation_details') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a class="btn ripple btn-info" data-target="#modaldemo3" data-toggle="modal" href="">{{__('dashboard.print_invoice')}} <i class="mdi mdi-printer ml-1"></i></a>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if($reservation->representative_id == null)
    <!-- row opened-->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('reservations.update.representative', $reservation->id)}}" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">{{ __('dashboard.representativename') }} <span class="tx-danger">*</span></label>
                                <select class="form-control select2" name="representative_id" required="">
                                    @foreach($representatives as $representative)
                                        <option value="{{$representative->id}}" {{$reservation!=null && $reservation->representative_id==$representative->id ? 'selected' : ''}}> {{ $representative->username }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="date" value="{{$reservation->date}}">
                        <input type="hidden" name="from" value="{{$reservation->from}}">
                        <div class="col-2"><button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">{{ __('dashboard.select_representative') }}</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    @endif

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
                                    <th scope="row">{{ __('dashboard.order_id') }}</th>
                                    <td>{{$reservation->id}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.clientname') }}</th>
                                    <td>{{isset($reservation->client)&&$reservation->client!=null ? $reservation->client->username : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.phone') }}</th>
                                    <td>{{isset($reservation->client)&&$reservation->client!=null ? $reservation->client->phone : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.representativename') }}</th>
                                    <td>{{$reservation->representative!=null ? $reservation->representative->username : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.reception_date') }}</th>
                                    <td>{{$reservation->reception_date}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.reception_time') }}</th>
                                    <td>{{$reservation->reception_time}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.sending_date') }}</th>
                                    <td>{{$reservation->sending_date}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.sending_time') }}</th>
                                    <td>{{$reservation->sending_time}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.delivery_cost') }}</th>
                                    <td>{{$reservation->delivery_cost}} {{ __('dashboard.sar') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.coupon') }}</th>
                                    <td>{{$reservation->coupon!=null ? $reservation->coupon : '---'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.discount') }}</th>
                                    <td>{{$reservation->discount!=null ? '% '.$reservation->discount : 0}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.total_price_after_discount') }}</th>
                                    <td>{{$reservation->price_after_discount!=null ? sprintf("%1.2f", $reservation->price_after_discount) : $reservation->total_price}} {{ __('dashboard.sar') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.tax') }}</th>
                                    <td>{{$reservation->tax}} %</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.price') }}</th>
                                    <td>{{$reservation->total_price}} {{ __('dashboard.sar') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.payment_type') }}</th>
                                    <td>
                                        @if($reservation->payment_type == 0)
                                            {{ __('dashboard.cash') }}
                                        @elseif($reservation->payment_type == 1)
                                            {{ __('dashboard.balance') }}
                                        @elseif($reservation->payment_type == 2)
                                            {{ __('dashboard.bank_transfer') }}
                                        @endif
                                    </td>
                                </tr>
                                @if($reservation->payment_type == 1)
                                    <tr>
                                        <th scope="row">{{ __('dashboard.transaction_id') }}</th>
                                        <td>
                                            {{ $reservation->transaction_id }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th scope="row">{{ __('dashboard.client_approve') }}</th>
                                    <td>
                                        @if($reservation->client_approve == 0)
                                            {{ __('dashboard.no') }}
                                        @elseif($reservation->client_approve == 1)
                                            {{ __('dashboard.yes') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.status') }}</th>
                                    <td>
                                        @if($reservation->status == 0)
                                            {{ __('dashboard.reservation_status.cancelled') }}
                                        @elseif($reservation->status == 1)
                                            {{ __('dashboard.reservation_status.pending') }}
                                        @elseif($reservation->status == 2)
                                            {{ __('dashboard.reservation_status.in_receive') }}
                                        @elseif($reservation->status == 3)
                                            {{ __('dashboard.reservation_status.received') }}
                                        @elseif($reservation->status == 4)
                                            {{ __('dashboard.reservation_status.washing') }}
                                        @elseif($reservation->status == 5)
                                            {{ __('dashboard.reservation_status.in_delivery') }}
                                        @else
                                            {{ __('dashboard.reservation_status.delivered') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('dashboard.created_at') }}</th>
                                    <td>{{$reservation->created_at->diffForHumans()}}</td>
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

    {{--@include('dashboard.partials.invoice')--}}
@endsection
@section('js')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&v=weekly&channel=2"
    async></script>

<script>
    function initMap() {
        const myLatlng = { lat: {{$reservation->lat}}, lng: {{$reservation->lng}} };
        const options = { zoom: 4, center: myLatlng };
        const map = new google.maps.Map(document.getElementById("map"), options);
        var map_marker = new google.maps.Marker({
            position: myLatlng,
            map,
        });

        google.maps.event.addListener(map_marker, 'click', function() {
            window.location.href = this.url;
        });
    
        const invoice_map = new google.maps.Map(document.getElementById("invoice_map"), options);
        new google.maps.Marker({
            position: myLatlng,
            invoice_map,
        });
    }
</script>
@endsection
<div class="modal" id="modaldemo3">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body">
                <div class=" main-content-body-invoice" id="invoice">
                    <div class="card card-invoice">
                        <div class="card-body">
                            <div class="invoice-header">
                                <h1 class="invoice-title">{{ __('dashboard.invoice') }}</h1>
                                @php $app = App\Models\Application::first(); @endphp
                                <div class="billed-from">
                                    <h6>{{$app->getTranslation('title', app()->getLocale())}}</h6>
                                    <p>{{ __('dashboard.email') }}: {{$app->email_1}} <br> {{ __('dashboard.invoice_tel') }}: {{$app->phone_1}}</p>
                                </div><!-- billed-from -->
                            </div><!-- invoice-header -->
                            <div class="row mg-t-20">
                                <div class="col-md">
                                    <label class="tx-gray-600">{{ __('dashboard.client_information') }}</label>
                                    <div class="billed-to">
                                        <h6>{{$reservation->client->username}}</h6>
                                        <p>{{ __('dashboard.email') }}: {{isset($reservation->client)&&$reservation->client!=null ? $reservation->client->email : '---'}}<br>
                                        {{ __('dashboard.invoice_tel') }}: {{isset($reservation->client)&&$reservation->client!=null ? $reservation->client->phone : '---'}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <label class="tx-gray-600">{{ __('dashboard.invoice_information') }}</label>
                                    <p class="invoice-info-row"><span>{{ __('dashboard.invoice_no') }}</span> <span>{{ '#' . $reservation->id}}</span></p>
                                    <p class="invoice-info-row"><span>{{ __('dashboard.order_date') }}</span> <span>{{$reservation->created_at->format('M d, Y')}}</span></p>
                                    <p class="invoice-info-row"><span>{{ __('dashboard.issue_date') }}</span> <span>{{date('M d, Y')}}</span></p>
                                </div>
                            </div>
                            <div class="table-responsive mg-t-40">
                                <table class="table table-invoice table-striped border text-md-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.representativename') }}</th>
                                            <td>{{$reservation->representative!=null ? $reservation->representative->username : ''}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.car_size') }}</th>
                                            <td>{{$reservation->car_size->getTranslation('title', app()->getLocale())}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.car_number') }}</th>
                                            <td>{{$reservation->car_number!=null ? $reservation->car_number : '---'}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.date') }}</th>
                                            <td>{{$reservation->date}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.time') }}</th>
                                            <td>{{$reservation->from}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.price') }}</th>
                                            <td>{{$reservation->total_price}} {{ __('dashboard.sar') }}</td>
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
                                        @if($services_price != 0)
                                            <tr>
                                                <th scope="row">{{ __('dashboard.services_price') }}</th>
                                                <td>{{$services_price}} {{ __('dashboard.sar') }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="row">{{ __('dashboard.total_price') }}</th>
                                            <td>{{$reservation->price_after_discount!=null ? ( sprintf("%1.2f", $reservation->price_after_discount) + $services_price) : ($reservation->total_price + $services_price)}} {{ __('dashboard.sar') }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.payment_type') }}</th>
                                            <td>
                                                @if($reservation->payment_type == 0)
                                                    {{ __('dashboard.cash') }}
                                                @elseif($reservation->payment_type == 1)
                                                    {{ __('dashboard.bank_transfer') }}
                                                @elseif($reservation->payment_type == 2)
                                                    {{ __('dashboard.balance') }}
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
                                            <th scope="row">{{ __('dashboard.location') }}</th>
                                            <td>
                                                <div id="invoice_map" style="height: 300px"> </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.status') }}</th>
                                            <td>
                                                @if($reservation->status == 0)
                                                    {{ __('dashboard.unacceptable') }}
                                                @elseif($reservation->status == 1 && Carbon\Carbon::parse($reservation->date)->format('Y-m-d') < Carbon\Carbon::now()->format('Y-m-d'))
                                                    {{ __('dashboard.expired') }}
                                                @elseif($reservation->status == 1)
                                                    {{ __('dashboard.pending') }}
                                                @elseif($reservation->status == 2)
                                                    {{ __('dashboard.approved') }}
                                                @else
                                                    {{ __('dashboard.done') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('dashboard.created_at') }}</th>
                                            <td>{{$reservation->created_at->diffForHumans()}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn ripple btn-primary" href="{{route('reservations.invoice', $reservation->id)}}" target="_blank"> <i class="mdi mdi-printer ml-1"></i> {{ __('dashboard.print') }} </a>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ __('dashboard.close') }}</button>
            </div>
        </div>
    </div>
</div>
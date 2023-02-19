<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>
		<!-- Favicon -->
        <link rel="icon" href="{{URL::asset('assets/img/brand/favicon.png')}}" type="image/x-icon"/>
        <!-- Icons css -->
        <link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet" media="all">
        <!--  Custom Scroll bar-->
        <link href="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" media="all"/>
        <!--  Sidebar css -->
        <link href="{{URL::asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet" media="all">
        @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
            <!-- Sidemenu css -->
            <link rel="stylesheet" href="{{URL::asset('assets/css-rtl/sidemenu.css')}}" media="all">
        @else
            <!-- Sidemenu css -->
            <link rel="stylesheet" href="{{URL::asset('assets/css/sidemenu.css')}}" media="all">
        @endif

        @yield('css')

        @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
            <!--- Style css -->
            <link href="{{URL::asset('assets/css-rtl/style.css')}}" rel="stylesheet" media="all">
            <!--- Dark-mode css -->
            <link href="{{URL::asset('assets/css-rtl/style-dark.css')}}" rel="stylesheet" media="all">
            <!---Skinmodes css-->
            <link href="{{URL::asset('assets/css-rtl/skin-modes.css')}}" rel="stylesheet" media="all">
        @else
            <!--- Style css -->
            <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" media="all">
            <!--- Dark-mode css -->
            <link href="{{URL::asset('assets/css/style-dark.css')}}" rel="stylesheet" media="all">
            <!---Skinmodes css-->
            <link href="{{URL::asset('assets/css/skin-modes.css')}}" rel="stylesheet" media="all">
        @endif
	</head>

	<body class="main-body app sidebar-mini">	
		<!-- main-content -->
		<div>		
			<!-- container -->
			<div class="container-fluid" style="margin-top: 15px;">
                <div class=" main-content-body-invoice">
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
                <a class="btn btn-primary btn-block mb-4" onclick="window.print()" href="javascrip:void(0)"> <i class="mdi mdi-printer ml-1"></i> {{ __('dashboard.print') }} </a>
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->

        <!-- JQuery min js -->
        <script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap Bundle js -->
        <script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Ionicons js -->
        <script src="{{URL::asset('assets/plugins/ionicons/ionicons.js')}}"></script>
        <!-- Moment js -->
        <script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

        <!-- Rating js-->
        <script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>

        <!--Internal  Perfect-scrollbar js -->
        <script src="{{URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
        <!--Internal Sparkline js -->
        <script src="{{URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
        <!-- Custom Scroll bar Js-->
        <script src="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
        <!-- sidebar js -->
        @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
            <script src="{{URL::asset('assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
        @else
            <script src="{{URL::asset('assets/plugins/sidebar/sidebar.js')}}"></script>
        @endif
        <script src="{{URL::asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
        <!-- Eva-icons js -->
        <script src="{{URL::asset('assets/js/eva-icons.min.js')}}"></script>
        @yield('js')
        <!-- Sticky js -->
        <script src="{{URL::asset('assets/js/sticky.js')}}"></script>
        <!-- custom js -->
        <script src="{{URL::asset('assets/js/custom.js')}}"></script><!-- Left-menu js-->
        <script src="{{URL::asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
	</body>
</html>
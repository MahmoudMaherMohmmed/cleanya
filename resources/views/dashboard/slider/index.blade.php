@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.sliders') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="mb-3 mb-xl-0">
                <a href="{{ route('sliders.create') }}" class="btn btn-primary">
                {{ __('dashboard.create_slider') }} <i class="mdi mdi-plus"></i>
                </a>
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
                        <table class="table text-md-nowrap" id="example2">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.id') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.title') }}</th>
                                    <th class="wd-20p border-bottom-0">{{ __('dashboard.status') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.created_at') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('dashboard.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($sliders) && $sliders!=null)
                                    @foreach($sliders as $slider)
                                        <tr>
                                            <td>{{$slider->id}}</td>
                                            <td>{{$slider->getTranslation('title', app()->getLocale())}}</td>
                                            <td>{{$slider->status==1 ? __('dashboard.active') : __('dashboard.notactive')}}</td>
                                            <td>{{$slider->created_at->diffForHumans()}}</td>
                                            <td> 
                                                <a href="{{ route('sliders.show', $slider->id) }}" class="btn btn-sm btn-primary"> <i class="las la-eye"></i> </a> 
                                                <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-info btn-b"> <i class="las la-pen"></i> </a> 
                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{$slider->id}}').submit();"> <i class="las la-trash"></i> </a> 
                                                <form id="delete-form-{{$slider->id}}" action="{{ route('sliders.destroy', $slider->id) }}" method="POST">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
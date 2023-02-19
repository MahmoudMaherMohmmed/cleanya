<div class="modal" id="reservation_{{$reservation->id}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('dashboard.services') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- row opened -->
                <div class="row row-sm">
                    <!--div-->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped text-md-nowrap">
                                        <thead>
                                            <tr> 
                                                <th class="wd-15p border-bottom-0">{{ __('dashboard.id') }}</th>
                                                <th class="wd-15p border-bottom-0">{{ __('dashboard.title') }}</th>
                                                <th class="wd-15p border-bottom-0">{{ __('dashboard.cost') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($reservation->services) && $reservation->services!=null)
                                                @foreach($reservation->services as $service)
                                                    <tr>
                                                        <td>{{$service->id}}</td>
                                                        <td>{{$service->getTranslation('title', app()->getLocale())}}</td>
                                                        <td>{{$service->pivot->cost}} {{ __('dashboard.sar') }}</td>
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
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ __('dashboard.close') }}</button>
            </div>
        </div>
    </div>
</div>
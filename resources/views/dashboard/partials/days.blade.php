@php $days = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri']; @endphp

@foreach($days as $day)
  <option value="{{ $day }}" {{$application && str_contains($application->working_days, $day) ? 'selected' : '' }}>{{ trans("dashboard.week.$day")}}</option>;
@endforeach
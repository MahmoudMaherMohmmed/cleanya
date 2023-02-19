<?php
$application = App\Models\Application::first();
$tStart = strtotime(substr($application->from, 0, strpos($application->from, " ")));
$tEnd = strtotime(substr($application->to, 0, strpos($application->to, " ")));
$tNow = $tStart;
?>

@while($tNow <= $tEnd)
  @php $time = date('H:i A', $tNow) .' - '.date('H:i A', strtotime('+239 minutes', $tNow)); @endphp
  <option value="{{$time}}" {{$reservation && $reservation->reception_time==$time ? 'selected' : '' }} style="direction: ltr;">{{$time}}</option>
  @php $tNow = strtotime('+240 minutes',$tNow); @endphp
@endwhile
<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AppointmentController extends Controller
{
    /**
     * List of appointments
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $days = [];

        foreach ($this->days() as $day) {
            array_push($days, [
                'day_string' => trans('dashboard.week.'.strtolower($day->format('D')), [], app()->getLocale()),
                'day' => $day->format('d'),
                'month' => trans('dashboard.months.'.$day->format('M'), [], app()->getLocale()),
                'date' => $day->format('Y-m-d'),
                'appointments' => $this->dayAppointments($day->format('D'))
            ]);
        }

        return response()->json(['status' => true, 'message' => trans('api.data_has_been_retrieved_successfully'),'data' => $days], 200);
    }

    /**
     * StartDate
     *
     * @return \Carbon\Carbon
     */
    private function startDate()
    {
        return Carbon::now();
    }

    /**
     * EndDate
     *
     * @return \Carbon\Carbon
     */
    private function endDate()
    {
        return Carbon::now()->addDays(7);
    }

    /**
     * Days
     *
     * @return array<\Carbon\CarbonInterface>
     */
    private function days()
    {
        return CarbonPeriod::since($this->startDate())->days(1)->until($this->endDate())->toArray();
    }

    /**
     * DayAppointments
     *
     * @param mixed $day
     * @return array
     */
    private function dayAppointments($day)
    {
        $appointments = [];

        if (in_array(strtolower($day), $this->workDays())) {
            $appointments = $this->workHours();
        }

        return $appointments;
    }

    /**
     * Return workDays
     *
     * @return array<string>|bool
     */
    private function workDays()
    {
        $days = [];
        $center = Application::first();

        if (isset($center->working_days) && $center->working_days != null) {
            $days = explode(', ', $center->working_days);
        }

        return $days;
    }

    /**
     * Return workHours
     *
     * @return array
     */
    private function workHours()
    {
        $hours = [];
        $center = Application::first();

        if ((isset($center->from) && $center->from != null) && (isset($center->to) && $center->to != null)) {
            $tStart = strtotime(substr($center->from, 0, strpos($center->from, " ")));
            $tEnd = strtotime(substr($center->to, 0, strpos($center->to, " ")));
            $tNow = $tStart;

            while ($tNow <= $tEnd) {
                $time = date('H:i A', $tNow) .' - '.date('H:i A', strtotime('+239 minutes', $tNow));

                array_push($hours, $time);

                $tNow = strtotime('+240 minutes', $tNow);
            }
        }

        return $hours;
    }
}

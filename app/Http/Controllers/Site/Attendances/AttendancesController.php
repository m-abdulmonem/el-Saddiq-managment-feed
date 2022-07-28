<?php

namespace App\Http\Controllers\Site\Attendances;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class AttendancesController extends Controller
{

    protected string $folder = "site.dashboard";
    protected string $trans = "users/attendances";
    protected string $perm = "attendance";
    /**
     * @var Attendance
     */
    private Attendance $attendance;


    public function __construct(Attendance $attendance)
    {

        $this->attendance = $attendance;
    }

    /**
     * Display a listing of the events.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $title = trans("$this->trans.title");

        return view("$this->folder.attendances", compact("title"));
    }

    /**
     * get all attend and absence and holidays record
     *
     * @return JsonResponse
     */
    public function events()
    {
        $data = [];

        //attend record
        foreach ($this->attendance->where("user_id", "!=", 1)->where("is_exist", true)->get() as $attendance) {
            $date = $attendance->date->format("Y-m-d");
            $end = ($timeOut = $attendance->time_out) ? $timeOut : now()->format("H:i:s");
            $dateTime = "$date" . "T" . $end;

            $data[] = [
//                'id' => $attendance->id,
                'title' => $attendance->user->name,
                'start' => "$date",
                'end' => "$date",
                'rendering'=> 'background',
//                'url' => route("users.show", $attendance->user_id),
//                'startTime' => $attendance->time_in,
//                'endTime' => $end,
//                'allDay' => $attendance->time_out === "18:00:00",
//                'color' => '#28a745',
//                'textColor' => '#fff',
            ];
        }

        //absence record
        foreach ($this->attendance->where("user_id", "!=", 1)->where("is_exist", false)->where("is_holiday", false)->get() as $absence) {

//            if (!$absence->is_exist)
            $data[] = [
                'id' => $absence->id,
                'title' => trans("attendances.absence", ['name' => $absence->user->name]),
                'start' => $absence->date,
                'color' => '#dc3545',
                'textColor' => '#fff',
                'allDay' => true
            ];
        }
        //holidays record
        foreach ($this->attendance->where("user_id", "!=", 1)->where("is_exist", false)->where("is_holiday", true)->get() as $holiday) {
//            if ($holiday->user_id == 1)
            $data[] = [
                'id' => $holiday->id,
                'title' => trans("attendances.holiday", ['name' => $holiday->user->name]),
                'start' => $holiday->date,
                'color' => '#ffc107',
                'textColor' => '#fff',
                'allDay' => true,
            ];
        }

        return json($data);
    }

}

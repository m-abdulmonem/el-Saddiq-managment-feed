<?php

namespace App\Http\Controllers\Site\Attendances;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\Attendance;

class AttendancesController extends Controller
{

    protected $folder = "site.dashboard";
    protected $trans = "users/attendances";
    protected $perm = "attendance";
    /**
     * @var Attendance
     */
    private $attendance;


    public function __construct(Attendance $attendance)
    {

        $this->attendance = $attendance;
    }

    /**
     * Display a listing of the events.
     *
     * @return Response
     */
    public function index()
    {
        $title = trans("$this->trans.title");

        return view("$this->folder.attendances",compact("title"));
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
        foreach ($this->attendance->where("user_id","!=",1)->where("is_exist",true)->get() as $attendance){

            $data[] = [
                'id'    => $attendance->id,
                'title' => $attendance->user->name,
                'start' => "$attendance->date $attendance->time_in",
                'end'   => "$attendance->date $attendance->time_out",
                'url'   => route("users.show",$attendance->user_id),
                'startTime' => $attendance->time_in,
                'endTime' => $attendance->time_out,
                'allDay' => $attendance->time_out === "18:00:00" ? true : false,
                'color' => '#28a745',
                'textColor' => '#fff'
            ];
        }

        //absence record
        foreach ($this->attendance->where("user_id","!=",1)->where("is_exist",false)->where("is_holiday",false)->get() as $absence){

//            if (!$absence->is_exist)
                $data[] = [
                    'id'    => $absence->id,
                    'title' => trans("attendances.absence",['name' => $absence->user->name]),
                    'start' => $absence->date,
                    'color' => '#dc3545',
                    'textColor' => '#fff',
                    'allDay' => true
                ];
        }
        //holidays record
        foreach ($this->attendance->where("user_id","!=",1)->where("is_exist",false)->where("is_holiday",true)->get() as $holiday){
//            if ($holiday->user_id == 1)
                $data[] = [
                    'id'    => $holiday->id,
                    'title' => trans("attendances.holiday",['name'=>$holiday->user->name]),
                    'start' => $holiday->date,
                    'color' => '#ffc107',
                    'textColor' => '#fff',
                    'allDay' => true,
                ];
        }

        return json($data);
    }

}

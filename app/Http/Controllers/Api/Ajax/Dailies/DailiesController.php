<?php

namespace App\Http\Controllers\Api\Ajax\Dailies;

use Illuminate\Http\Request;
use App\Models\Dailies\Daily;
use App\Http\Controllers\Controller;

class DailiesController extends Controller
{
    protected $perm = "daily";
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return datatables()->of(Daily::latest()->get())
            ->addIndexColumn()
            ->addColumn("user", function ($data) {
            return $this->user($data);
        })
            ->addColumn("date", function ($data) {
            return $data->created_at->format("Y-m-d");
        })
            ->addColumn("time_in", function ($data) {
            return hour_in_ar($data->time_in->format("h:i:s a"));
        })
            ->addColumn("time_out", function ($data) {
            return $data->time_out ? hour_in_ar($data->time_out->format("h:i:s a")) : "-";
        })
            ->addColumn("inc_dec", function ($data) {
            return currency($data->inc_dec);
        })
            ->addColumn("net", function ($data) {
            return currency($data->net_sales);
        })
            ->addColumn('action', function ($data) {
//                        $btn = $this->btnPaidSalary($data);
//                $btn = btn_view($this->perm,"users",$data);
//                $btn .= btn_update($this->perm,"users",$data);
//                $btn .= btn_delete($this->perm,"users",$data);
//                        return $btn;
        })
            ->rawColumns(['action', 'user'])
            ->make(true);

    }
    private function user($data)
    {
        $href = route("users.show", $data->user->id);

        return "<a class='btn btn-link info-color' href='$href'>{$data->user->name()}</a>";
    }
}

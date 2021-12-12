<?php

namespace App\Http\Controllers\Ajax\Jobs;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    protected $trans = "users/jobs";
    protected $perm = "job";

    /**
     * @var Job
     */
    private $job;

    /**
     * JobsController constructor.
     *
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * get all records in database
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax())
            return datatables()->of($this->job->get())
                ->addIndexColumn()
                ->addColumn("related",function ($data){
                    $url =  user_can("read user")
                        ? "href=" . route("users.index",['j'=>$data->id])
                        : "disabled" ;
                    return "<a $url class='btn btn-success $url'>".trans("$this->trans.show_related")."</a>";
                })
                ->addColumn('action', function($data){
                    $btn = $this->btnUpdate($data);
                    $btn .=  btn_delete($this->perm,"jobs",$data);
                    return $btn;
                })
                ->rawColumns(['action','related'])
                ->make(true);
    }

    /**
     * create html update button
     *
     * @param $data
     * @return string
     */
    private function btnUpdate($data)
    {
        $update = user_can("update $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $update'
                        data-name='$data->name'
                        data-id='$data->id'><i class='fa fa-edit'></i></button>";
    }
}

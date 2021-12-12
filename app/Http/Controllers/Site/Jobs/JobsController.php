<?php

namespace App\Http\Controllers\Site\Jobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Jobs\CreateRequest;
use App\Http\Requests\Jobs\UpdateRequest;
use App\Models\Category;
use App\Models\Job;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobsController extends Controller
{

    protected $folder = "site.jobs";
    protected $trans = "users/jobs";
    protected $perm = "job";

    /**
     * @var Job
     */
    private $job;

    public function __construct(Job $job)
    {
        $this->job = $job;

        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws Exception
     */
    public function index()
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans
        ];
        return view("$this->folder.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @param Job $job
     * @return JsonResponse
     */
    public function store(CreateRequest $request,Job $job)
    {
        return $job->createRecord($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Job $job
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Job $job)
    {
        return $job->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Job $job)
    {
        return $job->removeRecorder();
    }
}

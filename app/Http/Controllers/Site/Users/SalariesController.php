<?php

namespace App\Http\Controllers\Site\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Salary\CreateRequest;
use App\Http\Requests\User\Salary\UpdateRequest;
use App\Models\User\Salary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalariesController extends Controller
{

    protected $folder = 'site.users.salaries';
    protected $trans = 'users/users';
    protected $perm = 'salary';

    public function __construct()
    {
//        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @param Salary $salary
     * @return JsonResponse
     */
    public function store(CreateRequest $request,Salary $salary)
    {
        return $salary->createRecord($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Salary $salary
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Salary $salary)
    {
        return $salary->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

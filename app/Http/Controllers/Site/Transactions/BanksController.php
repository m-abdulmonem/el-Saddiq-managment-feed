<?php

namespace App\Http\Controllers\Site\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Banks\CreateRequest;
use App\Http\Requests\Transactions\Banks\UpdateRequest;
use App\Models\Transactions\Bank;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BanksController extends Controller
{

    protected $folder = "site.transactions.banks";
    protected $trans = "transactions/banks";
    protected $perm = "banks";

    /**
     * BanksController constructor.
     */
    public function __construct()
    {
        $this->perm();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'title' => trans("$this->trans.title"),
            'trans' => $this->trans,
            'perm' => $this->perm
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @param Bank $bank
     * @return JsonResponse|void
     */
    public function store(CreateRequest $request,Bank $bank)
    {
        return $bank->createRecord($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param Bank $bank
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Bank $bank)
    {
        return $bank->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bank $bank
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Bank $bank)
    {
        return $bank->removeRecorder();
    }
}

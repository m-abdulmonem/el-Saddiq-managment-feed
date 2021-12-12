<?php

namespace App\Http\Controllers\Site\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Expenses\CreateRequest;
use App\Http\Requests\Transactions\Expenses\UpdateRequest;
use App\Models\Transactions\Expenses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExpensesController extends Controller
{

    protected $folder = "site.transactions.expenses";
    protected $trans = "transactions/expenses";
    protected $perm = "expenses";

    /**
     * ExpensesController constructor.
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
     * @param Expenses $expenses
     * @return void
     */
    public function store(CreateRequest $request,Expenses $expenses)
    {
        return $expenses->createWith($request->all());
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
     * @param Expenses $expense
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Expenses $expense)
    {
        return $expense->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Expenses $expense
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Expenses $expense)
    {
        return $expense->removeRecorder();
    }
}

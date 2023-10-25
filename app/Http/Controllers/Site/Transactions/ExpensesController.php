<?php

namespace App\Http\Controllers\Site\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Expenses\CreateRequest;
use App\Http\Requests\Transactions\Expenses\UpdateRequest;
use App\Models\Transactions\Expenses;

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
     * @return View
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

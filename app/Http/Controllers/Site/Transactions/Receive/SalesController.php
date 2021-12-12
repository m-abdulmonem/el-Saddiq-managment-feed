<?php

namespace App\Http\Controllers\Site\Transactions\Receive;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Receipts\CreateRequest;
use App\Models\Transactions\CatchPurchase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesController extends Controller
{
    protected $folder = "site.transactions.receipts";
    protected $trans = "transactions/receipts";
    protected $perm = "receipts";

    /**
     * SalesController constructor.
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
            'title' => trans("$this->trans.sales.title"),
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
     * @param CatchPurchase $sale
     * @return Response
     */
    public function store(CreateRequest $request,CatchPurchase $sale)
    {
        $columns = ['code' => $sale->code(), 'balance_id' => $sale->createClientBalance($request)->id];

        $data = $sale->create(array_merge($request->all(),$columns));

        return jsonSuccess(trans("home.alert_success_create",['name' => null]),$data);

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
     * @param CreateRequest $request
     * @param CatchPurchase $sale
     * @return JsonResponse
     */
    public function update(CreateRequest $request, CatchPurchase $sale)
    {
        if($request->paid > removeMines($request->remaining)){
            $sale->createClientBalance($request);
            return $sale->updateRecord($request->all());
        } else
            return jsonError(trans("transactions/payments.alert_paid_is_bigger"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Site\Transactions\Receive;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Receipts\CreateRequest;
use App\Models\Supplier\SupplierBillReturn;
use App\Models\Transactions\CatchPurchase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReturnedController extends Controller
{
    protected $folder = "site.transactions.receipts";
    protected $trans = "transactions/receipts";
    protected $perm = "receipts";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => trans("$this->trans.returned.title"),
            'trans' => $this->trans,
            'perm' => $this->perm
        ];
        return view("$this->folder.returned_index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
        $columns = ['code' => $sale->code(), 'balance_id' => $sale->createBalance($request)->id];

        $data = $sale->create(array_merge($request->all(),$columns));

        return jsonSuccess(trans("home.alert_success_create",['name' => null]),$data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

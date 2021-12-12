<?php

namespace App\Http\Controllers\Site\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Payments\CreateRequest;
use App\Http\Requests\Transactions\Payments\UpdateRequest;
use App\Models\Transactions\CatchPurchase;
use App\Models\Transactions\Payments;
use Illuminate\Http\Request;

class ReturnedController extends Controller
{
    protected $folder = "site.transactions.payments";
    protected $trans = "transactions/payments";
    protected $perm = "payments";
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
     * @param Payments $payment
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request,Payments $payment)
    {
        $columns = ['payment_type' => 'expenses','code' => $payment->code(), 'balance_id' => $payment->createClientBalance($request)->id];

        $data = $payment->create(array_merge($request->all(),$columns));

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
     * @param UpdateRequest $request
     * @param Payments $purchase
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Payments $purchase)
    {
        if($request->paid < removeMines($request->remaining)){
            $purchase->createClientBalance($request);
            return $purchase->updateRecord($request->all());
        } else
            return jsonError(trans("$this->trans.alert_paid_is_bigger"));
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

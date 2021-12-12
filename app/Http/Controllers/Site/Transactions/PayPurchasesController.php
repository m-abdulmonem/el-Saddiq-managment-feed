<?php

namespace App\Http\Controllers\Site\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Payments\CreateRequest;
use App\Http\Requests\Transactions\Payments\UpdateRequest;
use App\Models\Transactions\Payments;
use App\Services\Supplier\Bills\BillServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PayPurchasesController extends Controller
{
    protected $folder = "site.transactions.payments";
    protected $trans = "transactions/payments";
    protected $perm = "payments";
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'title' => trans("$this->trans.purchases.title"),
            'trans' => $this->trans,
            'perm' => $this->perm
        ];
        return view("$this->folder.purchases_index",$data);
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
     * @param Payments $payment
     * @return void
     */
    public function store(CreateRequest $request,Payments $payment)
    {
        $columns = ['payment_type' => 'pay_for_supplier', 'balance_id' => $payment->createBalance($request)->id,'code' => $payment->code()];

        $data = $payment->create(array_merge($request->all(),$columns));

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
     * @param UpdateRequest $request
     * @param Payments $purchase
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Payments $purchase)
    {
        $purchase->createBalance($request);
        return ($request->paid > removeMines($request->remaining))
            ? jsonError(trans("$this->trans.alert_paid_is_bigger"))
            : $purchase->updateRecord($request->all());
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

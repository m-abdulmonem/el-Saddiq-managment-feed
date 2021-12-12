<?php

namespace App\Http\Controllers\Site\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\Payments\CreateRequest;
use App\Http\Requests\Transactions\Payments\UpdateRequest;
use App\Models\Transactions\Payments;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentsController extends Controller
{
    protected $folder = "site.transactions.payments";
    protected $trans = "transactions/payments";
    protected $perm = "payments";

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
     * @param Payments $payment
     * @return void
     */
    public function store(CreateRequest $request,Payments $payment)
    {
        return $payment->createWith($request->all());
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
     * @param Payments $payment
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Payments $payment)
    {
        return $payment->updateRecord($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Payments $payment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Payments $payment)
    {
        return $payment->removeRecorder();
    }
}

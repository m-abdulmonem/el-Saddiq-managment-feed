<?php

namespace App\Http\Controllers\Site\Suppliers;

use App\Http\Requests\Supplier\Bills\CreateRequest;
use App\Http\Requests\Supplier\Bills\UpdateRequest;
use App\Services\Supplier\Bills\BillServices;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use Exception;
use Illuminate\Http\JsonResponse;


class BillsController extends Controller
{

    /**
     * the view folder name
     *
     * @var string
     */
    protected $folder = "site.suppliers.bills";

    /**
     * @var string
     */
    protected $perm = "supplier_bill";

    /**
     * @var string
     */
    protected $trans = "suppliers/bills";
    /**
     * @var BillServices
     */
    private $bill;


    public function __construct(BillServices $bill)
    {
        $this->bill = $bill;

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
        $data = [
            'title' => trans("$this->trans.create"),
            'trans' => $this->trans
        ];

        return view("$this->folder.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return void
     * @throws ValidationException
     */
    public function store(CreateRequest $request)
    {
        $text = trans("home.alert_success_create",[ 'name' => trans("$this->trans.bill") ]);

        $this->bill->createWithCode($request->excepted());

        return back()->with("success",$text);
    }

    /**
     * Display the specified resource.
     *
     * @param BillServices $bill
     * @return Response
     */
    public function show(BillServices $bill)
    {
        $data = [
            'title' => trans("$this->trans.view",[ 'code' => num_to_ar($bill->code) ]),
            'trans' => $this->trans,
            'bill' => $bill,
        ];

        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BillServices $bill
     * @return Response
     */
    public function edit(BillServices $bill)
    {
        $data = [
            'title' => trans("$this->trans.edit",['code' => $bill->code_number]),
            'stocks' => Stock::pluck("name","id"),
            'trans' => $this->trans,
            'perm' => $this->perm,
            'bill' => $bill,
        ];

        return view("$this->folder.update",$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param BillServices $bill
     * @return Response
     * @throws Exception
     */
    public function update(UpdateRequest $request, BillServices $bill)
    {

        $request->is_returned ? $bill->syncReturnShipping($request) : $bill->update($request->excepted());

        return back()->with("success", trans("home.alert_success_update"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BillServices $bill
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(BillServices $bill)
    {
        return ( (($bill->price - $bill->discount) - $bill->balances()->sum("paid")) === 0)
            ? $bill->removeRecorder()
            : jsonError(trans("$this->trans.alert_could_not_deleted"));
    }
}

<?php

namespace App\Http\Controllers\Site\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\Invoices\CreateRequest;
use App\Http\Requests\Clients\Invoices\UpdateRequest;
use App\Models\Client\ClientBill;
use App\Models\Client\ClientBillReturn;
use App\Services\Clients\bills\InvoicesServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class InvoicesController extends Controller
{


    /**
     * view folder
     *
     * @var string
     */
    protected $folder = "site.clients.bills";

    /**
     * translation folder name
     *
     * @var string
     */
    protected $trans = "clients/bills";
    /**
     * permission
     *
     * @var string
     */
    protected $perm = "client_bill";

    protected $request_keys = ['discount','total_price','notes','debt','total_price','client_id'];
    /**
     * @var InvoicesServices
     */
    private $invoices;

    /**
     * InvoicesController constructor.
     * @param InvoicesServices $invoices
     */
    public function __construct(InvoicesServices $invoices)
    {
        $this->invoices = $invoices;
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
        //view page
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
        return view("$this->folder.vue.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return Response
     */
    public function store(CreateRequest $request)
    {
        $invoice = $this->invoices->createWithCode($request->excepted());

        return ($request->daily)
            ? jsonSuccess(trans("home.alert_success_create"),$invoice)
            : redirect()->route("ajax.client.print.invoice",$invoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param InvoicesServices $invoice
     * @return Response
     */
    public function show(InvoicesServices $invoice)
    {
        $data =[
            'title' => trans("$this->trans.view",[$invoice->code]),
            'trans' => $this->trans,
            'bill' => $invoice,
        ];
        return view("$this->folder.view",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InvoicesServices $invoice
     * @return Response
     */
    public function edit(InvoicesServices $invoice)
    {
        $data = [
            'title' => trans("$this->trans.edit",['code' => $invoice->code]),
            'trans' => $this->trans,
            'bill' => $invoice
        ];
        return view("$this->folder.update",$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param InvoicesServices $invoice
     * @return Response
     */
    public function update(UpdateRequest $request,InvoicesServices $invoice)
    {
        $request->type == "discarded_sale"
            ? $invoice->invoices()->createWithCode(array_merge($request->excepted(), ['bill_id' => $invoice->id]))
            : $invoice->update($request->excepted());

        return $request->ajax()
            ? jsonSuccess(trans("home.alert_success_update"),$invoice)
            : back()->with("success", trans("home.alert_success_update"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InvoicesServices $invoices
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(InvoicesServices $invoices)
    {
        return $invoices->removeRecorder();
    }
}

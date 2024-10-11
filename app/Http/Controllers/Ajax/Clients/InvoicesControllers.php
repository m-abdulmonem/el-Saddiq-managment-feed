<?php

namespace App\Http\Controllers\Ajax\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientBill;
use App\Models\Client\ClientBillReturn;
use App\Models\Client\ClientProductReturn;
use App\Models\Stock;
use App\Services\Balances\BalancesServices;
use App\Services\Clients\bills\InvoicesServices;
use Barryvdh\DomPDF\PDF;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class InvoicesControllers extends Controller
{

    /**
     * view folder
     *
     * @var string
     */
    protected $folder = "site.clients";

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
    /**
     * @var InvoicesServices
     */
    private $invoices;
    /**
     * @var BalancesServices
     */
    private $balances;

    public function __construct(InvoicesServices $invoices,BalancesServices $balances)
    {

        $this->invoices = $invoices;
        $this->balances = $balances;
    }

    public function index(Request $request)
    {
//        dd( $this->invoices->sort($request));
        if ($request->ajax()) {
            return datatables()->of( $this->invoices->sort($request))
                ->addIndexColumn()
                ->addColumn("code",function ($data){
                    return to_arabic_int($data->code);
                })
                ->addColumn("name",function ($data){
                    return $data->client->name();
                })
                ->addColumn("type",function ($data){
                    return $data->type();
                })
                ->addColumn("discount",function ($data){
                    return currency($data->discount);
                })
                ->addColumn("price",function ($data){
                    return currency($data->price);
                })
                ->addColumn("status",function ($data){
                    return ($data instanceof InvoicesServices) ? $data->statusTag() : "-";
                })
                ->addColumn("balances",function ($data){
                    return "-";
                })
                ->addColumn("creditor",function ($data){
                    return 0;
                })
                ->addColumn("debtor",function ($data){
                    return 0;
                })
                ->addColumn("date",function ($data){
                    return $data->created_at->format("Y-m-d");
                })
                ->addColumn('action', function($data){
                    $btn = $data->btnPrint();
                    $btn .= btn_view($this->perm,"invoices",$data);
//                    $btn .= btn_update($this->perm,"invoices",$data);
                    return $btn .= btn_delete($this->perm,"invoices",$data,"code_number") ;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }

    }

    public function products(InvoicesServices $invoice, Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of($invoice->byType($request->type))
                ->addIndexColumn()
                ->addColumn("name",function ($data){
                    return $this->productLink($data);
                })
                ->addColumn("type",function ($data){
                    return ($data instanceof ClientProductReturn) ? trans("$this->trans.discarded_product") : trans("$this->trans.sold_product");
                })
                ->addColumn("quantity",function ($data){
                    return  num_to_ar($data->pivot->quantity );
                })
                ->addColumn("stock",function ($data) use ($invoice){
                    return $this->stockLink($data);
                })
                ->addColumn("piece_price",function ($data){
                    return currency($data->pivot->piece_price);
                })
                ->addColumn("price",function ($data){
                    return currency($data->pivot->price);
                })
                ->addColumn("weight",function ($data){
                    return num_to_ar($data->weight);
                })
                ->addColumn("total_weight",function ($data){
                    return num_to_ar($data->pivot->quantity * $data->weight);
                })
                ->rawColumns(["name","stock","expired_at"])
                ->make(true);
        }//end if cond
    }

    public function returnedInvoices(InvoicesServices $invoice,Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of($invoice->invoices)
                ->addIndexColumn()
                ->addColumn("code",function ($data){
                    return num_to_ar($data->code);
                })
                ->addColumn("quantity",function ($data){
                    return  num_to_ar($data->quantity) ;
                })
                ->addColumn("price",function ($data){
                    return currency($data->price);
                })

                ->addColumn("balances",function ($data){
                    return currency($data->price);
                })
                ->addColumn("creditor",function ($data){
                    return currency($data->price);
                })
                ->addColumn("debtor",function ($data){
                    return currency($data->price);
                })
                ->addColumn("date",function ($data){
                    $data->created_at->format("Y-m-d");
                })

                ->rawColumns(["product","stock","expired_at"])
                ->make(true);
        }//end if cond
    }

    public function balances(InvoicesServices $invoice,Request $request)
    {
        if ($request->ajax()) {
            if ($request->startDate || $request->end)
                $data = $invoice->balances()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
            elseif ($type = $request->type)
                $data = $invoice->balances()->where("type",$type)->latest()->get();
            else
                $data = $invoice->balances()->latest();

            return $this->balances->client($data);
        }
    }
    public function codes()
    {
        $data = [];
        foreach (InvoicesServices::all() as $invoice)
            if ($invoice->remaining() > 0)
                $data[] = [
                    'id' => $invoice->id,
                    'text' => $invoice->code,
                    'client' => $invoice->client->name(),
                    'remaining' => currency($invoice->remaining()),
                    'price' => currency($invoice->price)
                ];
        return json($data);
    }

    public function names()
    {
        $data = [];
        foreach (ClientBillReturn::all() as $invoice){
            if (($remaining = $invoice->clientBill()->first()->balances()->where("type","payment")->sum("paid") - $invoice->price) < 0)
            $data[] = [
                'id' => $invoice->id,
                'text' => $invoice->code,
                'supplier' => $invoice->client->name(),
                'remainingBalance' => currency(removeMines($remaining)),
                'price' => currency($invoice->price)
            ];
        }
        return json($data);
    }


    public function printInvoice(InvoicesServices $invoice,PDF $pdf)
    {
        $data = [
            'trans' => $this->trans,
            'invoice' => $invoice,
        ];

//        return json($invoice->client->name());
//        $pdf->loadView("$this->folder.print.invoice",$data)
//            ->save("pdf/invoices/invoice_$invoice->code"."_".now()->format("Y-m-d_H-i-s").".pdf");

        return view("$this->folder.print.invoice",$data);
    }

    public function search(Request $request,InvoicesServices $invoice)
    {
        $data = [];
        foreach ($invoice->where("code","like","%$request->keywords%")->orWhereHas("client",function (Builder $q) use($request){
            return $q->where("name","like","%$request->keywords%")->orWhere("code","like","%$request->keywords%");
        })->get() as $invoice)
            foreach ($invoice->products as $product)
                $data[] = [
                    'id' => $invoice->id,
                    'number' => $invoice->code,
                    'client_id' => $invoice->client_id,
                    'client' => $invoice->client->name(),
                    'price' => $invoice->price,
                    'discount' => $invoice->discount,
                    'status' => $invoice->status,
                    'quantity' => $invoice->quantity,
                    'stock' => $product->stocks()->pluck("stocks.name","stocks.id"),
                    'product' => [
                        [
                            'id' => $product->id,
                            'code' => $product->code,
                            'name' => $product->name(),
                            'stock_id' => $product->pivot->stock_id,
                            'quantity' => $product->pivot->quantity,
                            'weight' => $product->weight,
                            'profit' => $product->profit,
                            'admin' => auth()->id(),
                            'remaining' => "-",
                            'price' => $product->pivot->piece_price,
                            'discount' => $product->pivot->discount,
                            'total' => $product->pivot->price,
                            'net' => $product->pivot->price - $product->pivot->discount
                        ]
                    ]
                ];
        return json($data);
    }

    public function printLastInvoice()
    {
        $route = route("ajax.clients.print.invoice",InvoicesServices::latest()->first()->id);
        return jsonSuccess("",$route);
    }

    /**
     * get stock view page link
     *
     * @param $data
     * @return string
     */
    public function stockLink($data)
    {
        return "<a class='info-color' href='".route("stocks.show",$data->pivot->stock->id)."'>{$data->pivot->stock->name()}</a>";
    }

    /**
     * get product view page link
     *
     * @param $data
     * @return string
     */
    public function productLink($data)
    {
        return "<a class='info-color' href='".route("products.show",$data->id)."'>{$data->name()}</a>";
    }
}

<?php

namespace App\Http\Controllers\Ajax\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierBill;
use App\Models\Supplier\SupplierBillReturn;
use App\Services\Balances\BalancesServices;
use App\Services\Clients\bills\InvoicesServices;
use App\Services\Supplier\Bills\BillServices;
use App\Services\User\Balances\SupplierBalanceServices;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    protected $trans = "suppliers/bills";
    protected $perm = "supplier_bill";

    /**
     * @var BillServices
     */
    private $bill;

    /**
     * @var BalancesServices
     */
    private $balances;

    /**
     * @var SupplierBalanceServices
     */
    private $supplierBalance;

    /**
     * BillsController constructor.
     * @param BillServices $bill
     * @param BalancesServices $balances
     */
    public function __construct(BillServices $bill,BalancesServices $balances)
    {
        $this->supplierBalance = new SupplierBalanceServices();
        $this->balances = $balances;
        $this->bill = $bill;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of( $this->bill->sort($request) )
                ->addIndexColumn()
                ->addColumn("name",function ($data){
                    return $data->supplier->name();
                })
                ->addColumn("type",function ($data){
                    return($data instanceof  SupplierBillReturn)
                        ? trans("$this->trans.return_shipping")
                        : trans("$this->trans.purchase");
                })
                ->addColumn("quantity",function ($data){
                    return  "$data->quantity";
                })
                ->addColumn("balances",function ($data){
                    return currency($data->remaining());
                })
                ->addColumn("discount",function ($data){
                    return currency($data->discount);
                })
                ->addColumn("price",function ($data){
                    return currency($data->price);
                })
                ->addColumn("creditor",function ($data){
                    return currency($data->creditor());
                })
                ->addColumn("debtor",function ($data){
                    return currency($data->debtor());
                })
                ->addColumn('action', function($data){

                    //view bill button
                    $btn = btn_view($this->perm,"bills",$data);
                    //update button
                    $btn .= btn_update($this->perm,"bills",$data);
                    //delete button
                    $btn .= btn_delete($this->perm,"bills",$data,"code_number") ;

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }//end if cond
    }


    public function products(BillServices $bill,Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of($bill->products)
                ->addIndexColumn()
                ->addColumn("product",function ($data){
                    return $this->productLink($data);
                })
                ->addColumn("stock",function ($data) use ($bill){
                    return $this->stockLink($data,$bill);
                })
                ->addColumn("quantity",function ($data){
                    return  $data->pivot->quantity ;
                })
                ->addColumn("piece_price",function ($data){
                    return currency($data->pivot->price);
                })
                ->addColumn("purchase_price",function ($data){
                    return currency($data->pivot->piece_price);
                })
                ->addColumn("after_discount",function ($data){
                    if ($discount = $data->discount);
                        return currency($data->pivot->piece_price - ($discount/ $data->count()));
                })
                ->addColumn("sale_price",function ($data) use ($bill){
                    $stock = ($stock = $bill->stock($data->id)) ? $stock->sale_price : 0;

                    return currency($stock);
                })
                ->addColumn("price",function ($data){
                    return currency($data->pivot->price * $data->pivot->quantity);
                })
                ->addColumn("expired_at",function ($data) use ($bill){
                    if ($stock = $bill->stock($data->id)) {
                        $expiredClass = $stock->expired_at->diffInDays() <= 30 ? "danger-color" : null;
                        return "<span class='$expiredClass'>{$stock->expired_at->diffForHumans() }</span>";
                    }
                    return "-";
                })
                ->rawColumns(["product","stock","expired_at"])
                ->make(true);
        }//end if cond
    }

    public function returnedProducts(BillServices $bill,Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of($bill->returnedBills)
                ->addIndexColumn()
                ->addColumn("code",function ($data){
                    return num_to_ar($data->code);
                })
                ->addColumn("quantity",function ($data){
                    return  num_to_ar($data->quantity);
                })
                ->addColumn("price",function ($data){
                    return currency($data->price);
                })
                ->addColumn("balances",function ($data){
                    return currency($data->price);
                })
                ->addColumn("creditor",function ($data){
                    return currency(0);
                })
                ->addColumn("debtor",function ($data) use ($bill){
                    return currency(0);
                })
                ->addColumn("date",function ($data){
                    return $data->created_at->diffForHumans();
                })
                ->rawColumns([])
                ->make(true);
        }//end if cond

    }

    public function names()
    {

        $data = [];
        foreach (BillServices::all() as $bill){
            if ($bill->remainingBalance() < 0)
                $data[] = ['id' => $bill->id, 'text' => "$bill->code"];
        }
        return json($data);
    }

    public function codes()
    {
        $data = [];
        foreach (SupplierBillReturn::all() as $bill)
            if (($remaining = $bill->supplierBalance()->where("type","catch")->sum("paid") - $bill->price) < 0)
                $data[] = [
                    'id' => $bill->id,
                    'text' => $bill->code,
                    'supplier' => $bill->supplier->name(),
                    'remainingBalance' => currency(removeMines($remaining)),
                    'price' => currency($bill->price)
                ];

        return json($data);
    }

    public function printTransaction(BillServices $bill)
    {

    }
    
    /**
     * @param BillServices $bill
     * @param Request $request
     * @return mixed
     */
    public function balances(BillServices $bill,Request $request)
    {
        if ($request->ajax()) return $this->balances->supplier($bill->balances);
    }

    /**
     * get stock view page link
     *
     * @param $data
     * @param $bill
     * @return string
     */
    public function stockLink($data,$bill)
    {
        if($stock = $bill->stock($data->id))

            return "<a class='info-color' href='".route("stocks.show",$stock->stock->id)."'>{$stock->stock->name()}</a>";
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

<?php

namespace App\Http\Controllers\Ajax\Stocks;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Product\ProductStock;
use App\Models\Stock;
use App\Services\Stock\StockServices;
use Illuminate\Http\Request;

class StocksController extends Controller
{

    protected $trans = "stocks";
    protected $perm = "stock";

    public function index()
    {
        $i = 0;

        if (request()->ajax()){
                    return datatables()->eloquent( Stock::latest())
                // ->addIndexColumn()
                  ->editColumn("DT_RowIndex",function ($data) use($i){
                    $i++;
                    return $i;
                })
                ->addColumn("name",function ($data){
                    return $data->name;
                })
                ->addColumn("address",function ($data){
                    return str_limit($data->address,100);
                })
                ->addColumn("related",function ($data){
                    $perm = user_can("read $this->perm") ? "btn-info" : "disabled";

                    return "<a class='btn $perm' href='".route("products.index",['s'=>$data->id])."'>".trans("$this->trans.show_related")."</a>";
                })
                ->addColumn('action', function($data){

                    $btn = $this->btnStocktaking($data);
                    $btn .= btn_view($this->perm,"stocks",$data);
                    $btn .= $this->btnUpdate($data);
                    $btn .= btn_delete($this->perm,"stocks",$data);
                    return $btn;
                })
                ->rawColumns(['action','related','name'])
                ->make(true);
        }
        return response()->json([]);
    }

    /**
     * @param Request $request
     * @param ProductStock $pivot
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function move(Request $request,ProductStock $pivot)
    {
        $data = $pivot->replicate()->fill(['quantity' => $request->quantity,'stock_id'=>$request->stock_id])->save();

        ($request->quantity != $pivot->quantity) ? $pivot->decrement("quantity",$request->quantity) : $pivot->delete() ;

        return jsonSuccess(trans("$this->trans.alert_success_move",['name'=>$request->name]),$data);
    }

    public function list()
    {
        $data = [];
        foreach (Stock::all() as $stock)
            $data[] = ['id' => $stock->id,'name' => $stock->name()];
        return $data;
    }

    public function names()
    {
        $data = [];
        foreach (Stock::all() as $stock)
            $data[] = ['id' => $stock->id,'text' => $stock->name()];
        return json($data);
    }

    public function consumptionGraph(Request $request,StockServices $stock)
    {
        return json($stock->consumptionGraph($request->start,$request->end));
    }

    public function productsGraph(Request $request,StockServices $stock)
    {
        return json($stock->productsGraph($request->start,$request->end));
    }
    public function locationsGraph(Request $request,StockServices $stock)
    {
        return json($stock->locationsGraph($request->start,$request->end));
    }

    public function stocktaking(StockServices $stock)
    {
        $trans = $this->trans;
        $stock->load('products');
        return view("site.stocks.print.stocktaking",compact("trans","stock"));
    }


    private function btnStocktaking($data)
    {
        $url = route("ajax.stocks.print.stocktaking",$data->id);

        $text = trans("stocks.stocktaking");

        return "<a class='btn btn-primary ' title='$text' href='$url'><i class='fa fa-layer-group'></i></a>";
    }


    private function btnUpdate($data)
    {
        $perm = user_can("read $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $perm'
                        data-id='$data->id'
                        data-name='$data->name'
                        data-address='$data->address'
                        ><i class='fa fa-edit'></i></button>";
    }
}

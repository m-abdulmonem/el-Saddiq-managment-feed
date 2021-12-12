<?php

namespace App\Http\Controllers\Site\Products;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        //check if user has permission
        check_perm("read product_history");
        // check if request is ajax to return data to table
        if ($request->ajax()) {
            return datatables()->of( ProductStock::with(['bill','user','product'])->latest()->get() )
                ->addIndexColumn()
                ->addColumn("name",function ($data){
                    if ($data->product)
                        return $data->product->code. " - " .  $data->product->name;
                    return null;
                })
                ->addColumn("supplier",function ($data){
                    if ($data->product)
                        return Supplier::find($data->product->supplier_id)->name ;
                    return null;
                })
                ->addColumn("ton_price",function ($data){
//                    return num_to_arabic($data->ton_price);
                    return trans("products.sale",['sale' => number_format($data->ton_price)]) ;
                })
                ->addColumn("price",function ($data){
                    return trans("products.sale",['sale' => number_format($data->sale_price)]);
                })
                ->addColumn("quantity",function ($data){
                    $supplier_product = SupplierProduct::where("product_id",$data->product_id)->latest("product_id")->first();
                    if ($supplier_product)
                        return trans("products.ton",['ton' => convertTon($data->piece_weight,$supplier_product->quantity) - (convertTon($data->piece_weight,$supplier_product->quantity) - $data->quantity) ]);
                })
                ->addColumn("quantity_consumed",function ($data){
                    $supplier_product = SupplierProduct::where("product_id",$data->product_id)->latest("product_id")->first();
                    if ($supplier_product)
                        return trans("products.ton",['ton' =>  convertTon($data->piece_weight,$supplier_product->quantity) - $data->quantity]);
                })
                ->addColumn("consumption",function ($data){
                    $supplier_product = SupplierProduct::where("product_id",$data->product_id)->latest("product_id")->first();
                    if ($supplier_product)
                        return trans("products_history.consumption_day_count",['day' => $supplier_product->created_at->diffInDays($data->updated_at) ]);
                })
                ->addColumn("created_at",function ($data){
                    $created_at = carbon($data->created_at)->locale("ar_ArR");
                    return $data->created_at->diffForHumans() .
                        " <small class='badge badge-info h5'>" . $created_at->day . " " . $created_at->monthName ." , " . $created_at->year  . "</small>";
                })
                ->rawColumns(['created_at'])
                ->make(true);

        }//end if cond
        //view page
        return view("site.products.history.history",[
            'title' => trans("products_history.title")
        ]);
    }

    public function price(Request $request)
    {
        //check if user has permission
        check_perm("read product_price_history");
        // check if request is ajax to return data to table
        if ($request->ajax()) {
            return datatables()->of( Price::with(['product','user'])->latest()->get() )
                ->addIndexColumn()
                ->addColumn("name",function ($data){
                    if ($data->product)
                        return $data->product->code. " - " .  $data->product->name;
                    return null;
                })
                ->addColumn("supplier",function ($data){
                    if ($data->product)
                        return Supplier::find($data->product->supplier_id)->name ;
                    return null;
                })
                ->addColumn("ton_price",function ($data){
                    return trans("products.sale",['sale' => number_format($data->ton_price)]) ;
                })
                ->addColumn("price",function ($data){
                    return trans("products.sale",['sale' => number_format($data->sale_price)]);
                })
                ->addColumn("quantity",function ($data){
                    $product = ProductStock::where("product_id",$data->product_id)->first();
                    if ($product)
                        return trans("products.ton",['ton' =>  ( $data->quantity/( $product->piece_weight == 25 ? 40 : 20 ) ) ]);
                    return null;
                })

                ->addColumn("status",function ($data){
                    return trans("products_price_history." . $data->status);
                })
                ->addColumn("difference_value",function ($data){
                    return trans("products.sale",['sale' => number_format($data->difference_value)]);
                })
                ->addColumn("created_at",function ($data){
                    $created_at = carbon($data->created_at)->locale("ar_ArR");
                    return $data->created_at->diffForHumans() . " <small class='badge badge-info h6'>" . $created_at->day . " " . $created_at->monthName ." , " . $created_at->year  . "</small>";
                })
                ->rawColumns(['created_at'])
                ->make(true);

        }//end if cond
        //view page
        return view("site.products.history.prices",[
            'title' => trans("products_price_history.title")
        ]);
    }
}

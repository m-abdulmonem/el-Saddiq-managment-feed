<?php

namespace App\Http\Controllers\Ajax\Products;

use App\Http\Controllers\Controller;
use App\Models\Dailies\Daily;
use App\Models\Product\Medicine;
use Illuminate\Http\Request;

class MedicinesController extends Controller
{
    /**
     * @var string
     */
    protected $trans = "products/medicines";

    /**
     * @var string
     */
    protected $perm = "medicine";

    public function index(Request $request,Medicine $medicine)
    {
        if ($request->ajax()) {
            return datatables()->of($medicine->latest()->get())
                ->addIndexColumn()
                ->addColumn("code", function ($data) {
                    return $data->code;
                })
                ->addColumn("name", function ($data) {
                    return $data->name;
                })
                ->addColumn("quantity", function ($data) {
                    return num_to_ar($data->quantity);
                })
                ->addColumn("sale_price", function ($data) {
                    return currency($data->sale_price);
                })
                ->addColumn("purchase_price", function ($data){
                    return currency($data->purchase_price);
                })
                ->addColumn("profit", function ($data) {
                    return currency($data->profit);
                })

//                ->addColumn("gain",function ($data){
//                    return currency($data->debt()->sum("gain"));
//                })
//                ->addColumn("loss",function ($data){
//                    return currency($data->debt()->sum("loss"));
//                })
                ->addColumn('action', function ($data) use ($request) {
                    $btn = $this->btnUpdate($data);
                    $btn .= btn_delete($this->perm, "products", $data);
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function purchases(Request $request, Medicine $medicine)
    {
        foreach ($request->medicines as $k => $id) {
            $medicine->where("id",$id)->first()->update([
                'quantity' => $medicine->increment("quantity",$request->quantity[$k]),
                'sale_price' => $request->sale_price[$k],
                'purchase_price' => $request->purchase_price[$k],
//                'stock_in' => $request->stock_in[$k]
            ]);
        }
        return jsonSuccess(trans("$this->trans.alert_success_purchase"));
    }

    public function sell(Request $request,Medicine $medicine,Daily $daily)
    {
//        return $request->all();
        foreach ($request->medicines as $k => $ids) {
            foreach ($ids as $price => $id){
                $data = $medicine->find($id);
                $data->sales()->createWith($request,$daily,$price,$k,$id);
                $data->decrement("quantity", $request->quantity[$k]);
            }
        }
        return jsonSuccess(trans("$this->trans.alert_success_sell"));
    }

    public function search(Request $request)
    {
        $data = [];
        $medicines = Medicine::where("name","like","%$request->keywords%")
            ->orWhere("code","like","%$request->keywords%")
            ->orWhere("for","like","%$request->keywords%")
            ->get();
        foreach ($medicines as $medicine)
            if ($medicine->quantity >= 1)
                $data[] = [
                    'id' => $medicine->id,
                    'code' => $medicine->code,
                    'name' => $medicine->name,
                    'quantity' => $medicine->quantity,
                    'sale_price' => $medicine->sale_price,
                    'purchase_price' => $medicine->purchase_price,
                    'profit' => $medicine->sale_price,
                    'stock_in' => $medicine->stock_in,
                    'for' => $medicine->for,
                ];
        return json($data);
    }

//    private function btnPurchase($data)
//    {
//        $perm =  user_can("update $this->perm") ? "btn-purchase" : "disabled";
//        return "<button class='btn btn-info $perm'
//                        data-id='$data->id'
//                        data-name='$data->name'
//                        data-sale-price='$data->sale_price'
//                        data-purchase-price='{$data->purchase_price}'
//                        data-stock-in='$data->stock_in'
//                        data-for='{$data->for}'
//                        ><i class='fas fa-prescription-bottle-alt'></i></button>";
//    }

    private function btnUpdate($data)
    {
        $perm =  user_can("update $this->perm") ? "btn-update" : "disabled";
        return "<button class='btn btn-primary $perm'
                        data-id='$data->id' 
                        data-name='$data->name'
                        data-quantity='$data->quantity'
                        data-profit='$data->profit'
                        data-sale-price='$data->sale_price'
                        data-purchase-price='{$data->purchase_price}'
                        data-stock-in='$data->stock_in'
                        data-for='{$data->for}'
                        ><i class='fa fa-edit'></i></button>";
    }
}

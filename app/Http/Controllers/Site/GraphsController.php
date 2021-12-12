<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Client\Client;
use Illuminate\Http\Request;


class GraphsController extends Controller
{


    public function clients()
    {
        return view("admin.clients.graph.index",[
            'title' => "",
            'client' => Client::find(1)
        ]);
    }


    public function client_bills(Request $request,$id){

        return $request->ajax()
            ? jsonSuccess("client bill graph",function () use ($request,$id){
                return Client::find($id)->getInvoicesStatistics($request->start,$request->end);
            })
            : $this->getErrornotFoundJson();
    }

    public function client_quantity(Request $request,$id){

        return $request->ajax()
            ? jsonSuccess("client bills quantity graph",function () use ($request,$id){
                return Client::find($id)->getInvoicesQuantity($request->start,$request->end);
            })
            : $this->getErrornotFoundJson();
    }


    public function used_product(Request $request,$id)
    {
        return $request->ajax()
            ? jsonSuccess("the most used products graph",function () use ($request,$id){
                return Client::find($id)->getMostProductsNames($request->start,$request->end);
            })
            : $this->getErrornotFoundJson();
    }
    
}

<?php

namespace App\Http\Controllers\Ajax\Stocks;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientProduct;
use App\Models\Stock;
use App\Services\Stock\StockServices;
use Illuminate\Http\Request;

class GraphController extends Controller
{


    /**
     * @var StockServices
     */
    private $services;

    public function __construct(StockServices $services)
    {
        $this->services = $services;
    }


    public function topProducts(Request $request,StockServices $stock)
    {
        return json(['text' => 'stock top products' , 'data' => $stock->topProducts($request) ]);
    }

    public function consumption(Request $request,StockServices $stock)
    {
        return json(['text' => 'stock consumption' , 'data' => $stock->consumption($request) ]);
    }
    
}

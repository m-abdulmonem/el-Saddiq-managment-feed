<?php

namespace App\Http\Controllers\Api\Ajax\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Products\ProductServices;

class Select2ProductsController extends Controller
{
    public function __construct(private Request $request, private ProductServices $product)
    {

    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $callback = function ($product) {

            $quantity = $product->stocks()->where("products_stocks.quantity", ">=", 1)->sum("quantity");
            
            if ($quantity >= 1) {
                return [
                // 'num' => ($i+1),
                'id' => $product->id,
                'admin' => auth("sanctum")->id(),
                'code' => $product->code,
                'name' => $product->name(),
                'profit' => $product->profit(),
                'weight' => $product->weight,
                'discount' => $product->discounts,
                'quantity' => $quantity,
                'stocks' => $product->stocks()->pluck("stocks.name", "stocks.id"),
                'price' => ($product->stocks()->latest()->first()->pivot->sale_price ?? 0),
                ];
            }

        };

        return response()->json(array_filter($this->query()->get()->map($callback)->toArray()));
    }

    private function query()
    {
        if ($keywords = $this->request->keywords) {
            return ProductServices::search($keywords);
        // return json(->map($callback)->toArray());
        }

        return $this->product->with("stocks")->take($this->request->pagination ?: 10);
    }
}

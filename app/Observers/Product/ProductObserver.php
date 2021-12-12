<?php

namespace App\Observers\Product;

use App\Models\Supplier\SupplierBill;
use App\Services\Products\ProductServices;

class ProductObserver
{
    public function created(ProductServices $product)
    {
        $request = request();
        $sale = $request->weight ? ($request->purchase_price / $request->weight) : ($request->purchase_price / $request->quantity);

        $product->productsStocks()->create([
            'bill_id' => $product->createOpeningBill($request),
            'ton_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'stock_id' => $request->stock_id,
            'quantity' => $request->quantity,
            'piece_price' => $sale,
        ]);

        $product->productsSupplier()->create([
            'quantity' => $request->weight ? $request->quantity * $request->weight : $request->quantity,
            'bill_id' => $product->createOpeningBill($request),
            'sale_price' => $request->sale_price,
            'price' => $request->purchase_price,
            'piece_price' => $sale,
        ]);
    }
}

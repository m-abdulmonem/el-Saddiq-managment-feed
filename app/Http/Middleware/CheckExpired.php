<?php

namespace App\Http\Middleware;

use App\Models\Product\NotifyExpired;
use App\Models\Product\ProductStock;
use Closure;
use Illuminate\Http\Request;

class CheckExpired
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        foreach (ProductStock::all() as $product){
            $remaining = $product->expired_at->diffInDays(now());
            if ($remaining <= 50 || $remaining <= 30 ||$remaining <= 20 || $remaining <= 10 ) {
                if (!NotifyExpired::where("product_stock_id",$product->id)->first())
                    NotifyExpired::create([
                        'text' => trans("products/products.alert_expire_notify", ['name' => $product->product->name(), 'quantity' => $product->quantity]),
                        'remaining_days' => $remaining,
                        'quantity' => $product->quantity,
                        'user_id' => auth()->id(),
                        'product_stock_id' => $product->id
                    ]);
            }
            elseif ($remaining == 0) {
                if (!NotifyExpired::where("product_stock_id",$product->id)->first())
                    NotifyExpired::create([
                        'text' => trans("products/products.alert_expired_notify", ['name' => $product->product->name(), 'quantity' => $product->quantity]),
                        'remaining_days' => $remaining,
                        'quantity' => $product->quantity,
                        'user_id' => auth()->id(),
                        'product_stock_id' => $product->id
                    ]);
            }
        }
        return $next($request);
    }
}

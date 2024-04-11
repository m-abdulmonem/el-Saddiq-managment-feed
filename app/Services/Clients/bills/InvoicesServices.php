<?php


namespace App\Services\Clients\bills;


use App\Models\Client\ClientBalance;
use App\Models\Client\ClientBill;
use App\Models\Product\ProductStock;

class InvoicesServices extends ClientBill
{

    public function sort($request)
    {
        if ($request->client)
            return $this->byClientType($request->type, $request->client);
        else
            return $this->latest()->get();
    }

    public function byClientType($type, $id)
    {
        if ($type == "invoices")
            return $this->where("client_id", $id)->latest()->get();
        elseif ($type == "returned_sale_invoice")
            return $this->byReturnedInvoices($id);
        else
            return collect($this->where("client_id", $id)->latest()->get())->merge($this->byReturnedInvoices($id));
    }

    public function byReturnedInvoices($id)
    {
        $invoices = mapArray($this->where("client_id", $id)->get(), function ($c, $v) {
            return $c->push($v->invoices()->latest()->get());
        });

        return mapArray($invoices, function ($c, $invoices) {
            foreach ($invoices as $invoice)
                $c->push($invoice);
            return $c;
        });
    }

    public function byType($type)
    {
        if ($type == "sold_product")
            return $this->products()->latest()->get();
        elseif ($type == "discarded_sale")
            return $this->returnedProducts();
        else
            return collect($this->products()->latest()->get())->merge($this->returnedProducts());
    }

    public function returnedProducts($id = null)
    {
        $callback = function ($c, $invoice) use ($id) {
            if ($id)
                return $c->push($invoice->products()->where("client_id", $id)->latest()->get());
            return $c->push($invoice->products()->latest()->get());
        };
        return mapArray($callback, $this->invoices);
    }

    public function debt()
    {
        $callback = function ($c, $product) {
            $purchasePrice = $product->stocks()->where("stock_id", $product->pivot->stock_id)->latest()->first()->pivot->piece_price;

            return $c->push(($product->pivot->quantity * $product->pivot->piece_price) - ($product->pivot->quantity * $purchasePrice));
        };
        return mapArray($this->products, $callback)->sum();
    }

    public function gain()
    {
        return $this->remaining() <= 0 ? $this->debt() : 0;
    }

    public function loss()
    {
        return $this->remaining() > 0 ? $this->remaining() : 0;
    }

    public function returnedQuantity()
    {
        return $this->returnedProducts()->sum("quantity");
    }
    public function totalPaid($type = "catch")
    {
        return $this->balances()->where("type", $type)->sum("paid");
    }

    public function discount()
    {
        return $this->price - $this->discount;
    }

    public function remaining()
    {
        return $this->discount() - $this->totalPaid();
    }
    public function remainingBalance()
    {
        return $this->totalPaid("payment") - $this->invoices()->latest()->first()->price;
    }

    public function currentBalance()
    {
        return $this->discount() + $this->client->prevBalance() - $this->totalPaid();
    }

    public function daily()
    {
        $totalPaid = 0;
        foreach ($this->get() as $invoice)
            $totalPaid += $invoice->balances()->where("type", "catch")
                ->whereDay("created_at", now()->format("d"))
                ->whereMonth("created_at", now()->format("m"))
                ->whereYear("created_at", now()->format("Y"))->sum("paid");

        return $totalPaid;
    }


    public function createWithCode($data)
    {
        $new = [
            'code' => $this->code(),
            'quantity' => $data['total_quantity'],
            'price' => $data['total_price'],
            'user_id' => auth()->id(),
        ];

        return $this->create(array_merge($data, $new));
    }


    public function updateStock($request, $k, $id, $update = false)
    {
        if ($update) {
            (($diff = ($this->products()->find($id)->pivot->quantity ?? 0) - $request->quantity[$k]) < 0)
                ?ProductStock::decrease($id, $request->stock_id[$k], removeMines($diff))
                : ProductStock::increase($id, $request->stock_id[$k], $diff);
        }
        else
            ProductStock::decrease($id, $request->stock_id[$k], $request->quantity[$k]);
    }

    public function createProduct($request, $update = false)
    {
        $callback = function ($c, $k, $id) use ($request, $update) {
            if ($productStock = ProductStock::purchasedProduct($id, $request->stock_id[$k])->latest()->first())
{
                $this->updateStock($request, $k, $id, $update);
                return $c->put($id, [
                'quantity' => $request->quantity[$k],
                'price' => $request->price[$k],
                'piece_price' => $request->unitPrice[$k],
                'purchase_price' => $productStock->piece_price,
                'client_id' => $request->client_id,
                'stock_id' => $request->stock_id[$k],
                ]);
            }
        };

        return $this->products()->sync(eachData($request->products, $callback)->toArray());
    }



    public function createBalance($request, $type = "catch")
    {

        $data = [
            'remaining_amount' => (!$request->debt) ? (double)(intval($request->total_price) - intval($request->postpaid)) : 0,
            'paid' => (double)($request->debt == "postpaid" ?  $request->postpaid : $request->total_price),
            'type' => $type,
            'code' => ClientBalance::code(),
            'client_id' => $request->client_id,
            'user_id' => auth('sanctum')->id()
        ];

        return $this->balances()->create($data);
    }

    public function createDiscount($request)
    {
        if ($request->product_discount) {
            $callback = function ($c, $k, $id) use ($request) {
                return $c->put($id, [
                'discount' => $request->product_discount[$k] / $request->quantity[$k],
                'client_id' => $request->client_id,
                'user_id' => auth()->id()
                ]);
            };
            return $this->discounts()->sync(eachData($request->products, $callback)->toArray());
        }
    }

    public function btnPrint()
    {
        $url = route("ajax.clients.print.invoice", $this->id);

        return "<a href='$url' class='btn btn-secondary' target='_blank'><i class='fa fa-print'></i> </a>";
    }

    public function statusTag()
    {
        return "<span class='" . $this->getStatusTag() . "'>" . trans("clients/bills.option_$this->status") . "</span>";
    }


    public function getStatusTag()
    {
        return [
            'draft' => 'draft-status',
            'loaded' => 'loaded-status',
            'onWay' => 'onWay-status',
            'delivered' => 'shipped-status',
            'canceled' => "canceled-status"
        ][$this->status];
    }
}

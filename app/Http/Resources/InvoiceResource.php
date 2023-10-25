<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => \num_to_ar($this->id),
            "code" => num_to_ar($this->code),
            "discount" => \currency($this->discount),
            "price" => \currency($this->price),
            "quantity" => \num_to_ar($this->quantity),
            'net' => currency($this->net()),
            'spell_out' => spell_out($this->net()) . ' ' . 'جنية لاغير',
            'is_paid' => $this->balances()->where("type", "catch")->sum("paid") < $this->price,
            'created_at' => \num_to_ar($this->created_at->format("Y-m-d")),
            'now' =>  \num_to_ar(now()->format("Y-m-d H:i:s")),
            "client" => $this->clientParsed(),
            'products' => $this->productsParsed()
        ];
    }

    private function net() :int
    {
       return $this->price - $this->discount;
    }

    private function clientParsed(): array
    {
        return [
            'name' => $this->client->name(),
            'address' => $this->client->address,
            'phone' => num_to_ar($this->client->phone),
            'prev_balance' => currency($this->client->prevBalance()),
            'current_blance' => currency($this->currentBalance())
        ];
    }

    private function productsParsed(): array
    {
        $callback = function ($product) {
            return [
                'id' => $product->id,
                'name' => \num_to_ar($product->nameSupplier()),
                'piece_price' => currency($product->pivot->piece_price),
                'quantity' => num_to_ar($product->pivot->quantity),
                'totalWeight' => num_to_ar($product->pivot->quantity * $product->weight) ?? "-",
                'price' => currency($product->pivot->price)
            ];
        };
        return $this->products()->get()->map($callback)->toArray();
    }
}

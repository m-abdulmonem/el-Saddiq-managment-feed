<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyResource extends JsonResource
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
            'user' =>  $this->user->name() ?? "-",
            'number' => $this->number,
            'time_in' => hour_in_ar(date("h:i a",strtotime($this->time_in))),
            'time_out' => hour_in_ar(date("h:i a",strtotime($this->time_out))),
            'net_sales' => currency($this->net_sales),
            'balance' => currency($this->balance),
            'clients_count' => num_to_ar(1),
            'date' => num_to_ar( $this->created_at->format("Y-m-d")),
            'discarded_sale' => currency( 0 ),
            'inc_dec' =>  currency($this->inc_dec),
            'sold_products_count' => \num_to_ar(1)
        ];
    }
}

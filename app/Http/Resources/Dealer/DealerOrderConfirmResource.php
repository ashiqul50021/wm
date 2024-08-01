<?php

namespace App\Http\Resources\Dealer;

use Illuminate\Http\Resources\Json\JsonResource;

class DealerOrderConfirmResource extends JsonResource
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
            "id" => $this->id,
            'invoice_no' => $this->invoice_no ?? '0',
            'user_name' => $this->user->name,
            'user_address' => $this->user->name,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            "note" => $this->note,
            "total_amount" => $this->total_amount,
            "confirm_amount" => $this->confirm_amount,
            "pending_amount" => $this->pending_amount,
            "delivery_status" => $this->delivery_status,
            "created_at" => $this->created_at->format('d M y'),
            'requestConfirmProduct' => RequestConfirmProductResource::collection($this->requestConfirmProduct),
        ];
    }
}

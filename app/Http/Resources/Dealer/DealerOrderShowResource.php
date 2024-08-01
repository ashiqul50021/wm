<?php

namespace App\Http\Resources\Dealer;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DealerOrderShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            // 'user_id' => $this->user,
            'user_name' => $this->user->name,
            'user_address' => $this->user->user_address,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            "note" => $this->note,
            "total_amount" => $this->total_amount,
            "delivery_status" => $this->delivery_status,
            "created_at" => $this->created_at->format('d M y'),
            'requestConfirmProduct' => RequestConfirmProductResource::collection($this->requestConfirmProduct),
        ];

    }
}
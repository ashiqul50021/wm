<?php

namespace App\Http\Resources\Dealer;

use App\Models\ProductStock;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Dealer\DealerRequestProductResource;
use App\Http\Resources\UserResource;

class DealerOrderResource extends JsonResource
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
            'user_name' => $this->user->name,
            'user_address' => $this->user->name,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            "note" => $this->note,
            "total_amount" => $this->total_amount,
            "created_at" => $this->created_at,
            'dealer_request_products_id' => DealerRequestProductResource::collection($this->dealer_request_products),
        ];
    }

    // public function toArray($request)
    // {
    //     return [
    //         "id" => $this->id,
    //         'user_name' => $this->user->name,
    //         'user_address' => $this->user->name,
    //         'phone' => $this->user->phone,
    //         'email' => $this->user->email,
    //         "total_amount" => $this->total_amount,
    //         'dealer_request_products_id' => $this->dealer_request_products->map(function($item) {
    //             return [
    //                 "note" => $this->note,
    //                 "id" => $item->id,
    //                 "dealer_request_id" => $item->dealer_request_id,
    //                 "products" => new DealerRequestProductResource($item),
    //                 "is_varient" => $item->is_varient,
    //                 "product_stock_id" => $item->product_stock_id,
    //                 "variation" => $item->variation,
    //                 "qty" => $item->qty,
    //                 "price" => $item->price,
    //                 "delivery_status" => $item->delivery_status,
    //                 "request_status" => $item->request_status
    //             ];
    //         })
    //     ];
    // }
}

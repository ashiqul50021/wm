<?php

namespace App\Http\Resources\Dealer;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DealerRequestProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            // "dealer_request_id" => $this->dealer_request_products->note,
            "dealer_request_id" => $this->dealer_request_id,
            'products'     => [
                'id' => $this->product->id,
                'title' => $this->product->name_en,
                'product_thumbnail' => $this->product->product_thumbnail,
                'model' => $this->product->model_number,
                'brand' => $this->product->brand->name_en,
                'after_dis_wholesell_price' => $this->product->wholesell_price - $this->product->whole_sell_dis,
            ],
            "is_varient" => $this->is_varient,
            "product_stock_id" => $this->product_stock_id,
            "variation" => $this->variation,
            "qty" => $this->qty,
            "price" => $this->price,
            "delivery_status" => $this->delivery_status,
            "request_status" => $this->request_status,
        ];
    }
}

<?php

namespace App\Http\Resources\Dealer;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestConfirmProductResource extends JsonResource
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
            "request_confirm_id" => $this->request_confirm_id,
            'products'     => [
                'id' => $this->product->id,
                'title' => $this->product->name_en,
                'product_thumbnail' => $this->product->product_thumbnail,
                'model' => $this->product->model_number,
               'brand' => $this->product->brand->name_en ?? "N/A",
                // 'wholesell_price' => $this->product->wholesell_price,
                // 'whole_sell_dis' => $this->product->whole_sell_dis,
                'after_dis_wholesell_price' => $this->product->wholesell_price - $this->product->whole_sell_dis,
            ],
            "request_qty" => $this->request_qty,
            "confirm_qty" => $this->confirm_qty,
            "due_qty" => $this->due_qty,
            "unit_price" => $this->unit_price,
            "total_price" => $this->total_price,
            "created_at" => $this->created_at,
        ];
    }
}
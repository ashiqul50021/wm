<?php

namespace App\Http\Resources\Dealer;

use Illuminate\Http\Resources\Json\JsonResource;

class PosResource extends JsonResource
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
            'id'          => $this->id,
            'brand_id'    => $this->brand->name_en . '_' . $this->brand->id,
            'category_id' => $this->category->name_en . '_' . $this->category->id,
            "tags" => $this->tags,
            "name_en" => $this->name_en,
            "name_bn" => $this-> name_bn,
            "slug" => $this-> slug,
            "product_code" => $this->product_code,
            "model_number" => $this->model_number,
            "unit_weight" => $this->unit_weight,
            "purchase_price" => $this->purchase_price,
            "wholesell_price" => $this->wholesell_price,
            "wholesell_minimum_qty" => $this->wholesell_minimum_qty,
            "regular_price" => $this->regular_price,
            "body_rate" => $this->body_rate,
            "finishing_rate" => $this->finishing_rate,
            "discount_price" => $this->discount_price,
            "discount_type" => $this->discount_type,
            "minimum_buy_qty" => $this->minimum_buy_qty,
            "stock_qty" => $this->stock_qty,
            "product_thumbnail" => $this->product_thumbnail,
            "menu_facture_image" => $this->menu_facture_image,
            'multi_images'     => $this->multi_imgs->pluck('photo_name')->map(function ($imageName) {
                return $imageName;
            }),
            "description_en" => strip_tags($this->description_en) ?? "",
            "description_bn" => strip_tags($this->description_bn) ?? "",
            "whole_sell_dis_type" => $this->whole_sell_dis_type,
            "whole_sell_dis" => $this->whole_sell_dis,
            "avarage_rating" => $this->avarage_rating,
	        "rating_count" => $this->rating_count,
        ];
    }
}

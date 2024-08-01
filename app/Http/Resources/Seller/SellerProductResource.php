<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerProductResource extends JsonResource
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
            'Product' => [
                'id' => $this->id,
                "brand"=>[
                 'id' =>  $this->brand->id,
                  'name_en' => $this->brand->name_en,
                  'name_bn' => $this->brand->name_bn,
                  'image' => $this->brand->brand_image,
                ],
                "category"=>[
                    'id' =>  $this->category->id,
                     'name_en' => $this->category->name_en,
                     'name_bn' => $this->category->name_bn,
                     'image' => $this->category->image,
                   ],
                "sub_category_id" => $this->sub_category_id,
                "sub_sub_category_id"=> $this->sub_sub_category_id,
                "tags"=> $this->tags,
                "url"=> $this->url,
                "vendor_id"=> $this->vendor_id,
                "seller_id"=> $this->seller_id,
                "supplier_id"=> $this->supplier_id,
                "unit_id"=> $this->unit_id,
                "campaing_id"=> $this->campaing_id,
                'name_en' => $this->name_en,
                "name_bn"=> $this->name_bn,
                "slug"=> $this->slug,
                "product_code"=> $this->product_code,
                "model_number"=> $this->model_number,
                "unit_weight"=> $this->unit_weight,
                "purchase_price"=> $this->purchase_price,
                "purchase_code"=> $this->purchase_code,
                "is_wholesell"=> $this->is_wholesell,
                "wholesell_price"=> $this->wholesell_price,
                "wholesell_minimum_qty"=> $this->wholesell_minimum_qty,
                "regular_price"=> $this->regular_price,
                "body_rate"=> $this->body_rate,
                "finishing_rate"=> $this->finishing_rate,
                "discount_price"=> $this->discount_price,
                "discount_type"=> $this->discount_type,
                "minimum_buy_qty"=> $this->minimum_buy_qty,
                "stock_qty"=> $this->stock_qty,
                "quantity_update_info"=> $this->quantity_update_info,
                "product_thumbnail"=> $this->product_thumbnail,
                'multiImages' => $this->multi_imgs,
                "menu_facture_image"=> $this->menu_facture_image,
                "description_en"=> strip_tags($this->description_en),
                "description_bn"=> strip_tags($this->description_bn),
                "is_featured"=> $this->is_featured,
                "is_deals"=> $this->is_deals,
                "is_dealer"=> $this->is_dealer,
                "status"=> $this->status,
                "is_approved"=> $this->is_approved,
                "is_digital"=> $this->is_digital,
                "approved"=> $this->approved,
                "created_by"=> $this->created_by,
                "whole_sell_dis_type"=> $this->whole_sell_dis_type,
                "whole_sell_dis"=> $this->whole_sell_dis,
            ]
        ];
    }


}

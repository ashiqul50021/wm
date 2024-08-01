<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'role' => $this->role ?? 0,
            'vendor_id' => $this->vendor_id,
            'name' => $this->name ?? "",
            'username' => $this->username ?? "",
            'phone' => $this->phone ?? "",
            'email' => $this->email ?? "",
            'address' => $this->address ?? "",
            'profile_image' => $this->profile_image ?? "",
            'email_verified_at' => $this->email_verified_at ?? "",
            'status' => $this->status ?? 0,
            'is_approved' => $this->is_approved ?? 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

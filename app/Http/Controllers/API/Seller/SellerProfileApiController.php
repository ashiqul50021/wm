<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProfileApiController extends Controller
{
    public function profileUpdate(Request $request,$id){
        $id = Auth::user()->id;
        $data = Seller::where('user_id', $id)->with('user')->first();

        $data->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        $data->shop_name = $request->name;
        $data->address = $request->address;

        if ($request->hasFile('profile_image')) {
            try {
                if (file_exists($data->shop_profile)) {
                    unlink($data->shop_profile);
                }
            } catch (Exception $e) {
            }
            $shop_profile = $request->profile_image;
            $shop_pro = time() . $shop_profile->getClientOriginalName();
            $shop_profile->move('upload/seller_images/', $shop_pro);

            $data->shop_profile = 'upload/seller_images/' . $shop_pro;
            $data->user->profile_image = 'upload/seller_images/' . $shop_pro;
        } else {
            $shop_pro = '';
        }
        $data->save();

        return response()->json([
            'message' => 'Seller Profile Updated Successfully',
            'seller' => $data,

        ],200);

    }
}

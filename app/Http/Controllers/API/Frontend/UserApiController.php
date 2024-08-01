<?php

namespace App\Http\Controllers\API\Frontend;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\District;
use App\Models\Division;
use App\Models\Shipping;
use App\Models\Upazilla;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        //$orders = Order::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
        $orders = Order::where('user_id', Auth::id())->count();

        $all = Order::where('user_id', Auth::user()->id)
            ->where('delivery_status', 'pending')
            ->count();

        $pending = Order::where('user_id', Auth::user()->id)
            ->where('delivery_status', 'pending')
            ->count();

        $processing = Order::where('user_id', Auth::user()->id)
            ->where('delivery_status', 'processing')
            ->count();

        $shipping = Order::where('user_id', Auth::user()->id)
            ->where('delivery_status', 'shipped')
            ->count();

        $picked = Order::where('user_id', Auth::user()->id)
            ->where('delivery_status', 'picked_up')
            ->count();;

        $completed = Order::where('user_id', Auth::user()->id)
            ->where('delivery_status', 'delivered')
            ->count();

        $cancelled = Order::where('user_id', Auth::user()->id)
            ->where('delivery_status', 'cancel')
            ->count();

        return response()->json([
            'orders_count' => $orders,
            'all_count' => $all,
            'pending_count' => $pending,
            'processing_count' => $processing,
            'shipping_count' => $shipping,
            'picked_count' => $picked,
            'completed_count' => $completed,
            'cancelled_count' => $cancelled,
        ], 200);
    }

    public function orderList()
    {
        $orderList = Order::where('user_id', Auth::id())->latest()->get();
        return response()->json([
            'order_list' => $orderList,
        ], 200);
    }

    public function orderView($invoice_no)
    {
        $order = Order::with(['order_details.product:id,name_en,product_thumbnail'])->where('invoice_no', $invoice_no)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json([
            'order' => $order,
        ], 200);
    }

    public function orderTrack(Request $request)
    {
        $this->validate($request, [
            'invoice_no' => 'required',
            'phone' => 'required',
        ]);
        $orderTrack = Order::where('invoice_no', $request->invoice_no)->where('phone', $request->phone)->first();
        if (!$orderTrack) {
            return response()->json([
                "message" => "Invalid Invoice or Phone No!"
            ], 404);
        }

        return response()->json([
            'order_track' => $orderTrack,
        ], 200);
    }

    public function userProfile()
    {
        $profile = Auth::user();
        return response()->json([
            'profile' => new UserResource($profile),
        ]);
    }

    public function userProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'phone' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($id)],
        ]);

        $user = User::find($id);

        $profile_image = $user->profile_image;
        // user Photo Update
        if ($request->hasfile('profile_image')) {
            // if($profile_image !== ''){
            //     unlink($profile_image);
            // }
            $profile_img = $request->profile_image;
            $profile_save = time() . $profile_img->getClientOriginalName();
            $profile_img->move('upload/user/', $profile_save);
            $user->profile_image = 'upload/user/' . $profile_save;
        } else {
            $profile_save = '';
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;

        $user->save();

        return response()->json([
            "user" => $user
        ], 200);
    }

    public function UserPasswordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:4',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => "Your Current Password is incorrect!",
            ], 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password Updated Successfully.',
        ], 200);
    }

    public function userLogout(Request $request)
    {
        $user = Auth::user();

        PersonalAccessToken::where('tokenable_id', $user->id)
            ->where('tokenable_type', get_class($user))
            ->delete();


        Auth::guard('web')->logout();

        return response()->json([
            'message' => 'User Logout Successfully.',
        ]);
    }

    public function getDivision()
    {
        $division = Division::get();

        return response()->json([
            'division' => $division,
        ]);
    }

    public function getDistrict()
    {
        $district = District::get();

        return response()->json([
            'district' => $district,
        ]);
    }

    public function getUpazilla()
    {
        $upazilla = Upazilla::get();

        return response()->json([
            'upazilla' => $upazilla,
        ]);
    }

    public function divisionWiseDistrict($division_id)
    {
        $division = Division::find($division_id);

        $district = District::where('division_id', $division->id)->get();

        return response()->json([
            'district' => $district,
        ]);
    }

    public function districtWiseUpazilla($district_id)
    {
        $district = District::find($district_id);

        $upazilla = Upazilla::where('district_id', $district->id)->get();

        return response()->json([
            'upazilla' => $upazilla,
        ]);
    }

    public function userAddressStore(Request $request)
    {
        $this->validate($request, [
            'division_id' => 'required',
            'district_id' => 'required',
            'upazilla_id' => 'required',
            'address' => 'required'
        ]);
        $address = new Address();
        $address->division_id = $request->division_id;
        $address->district_id = $request->district_id;
        $address->upazilla_id = $request->upazilla_id;
        $address->user_id = Auth::user()->id;
        $address->address = $request->address;
        if ($request->is_default == Null) {
            $request->is_default = 0;
        }
        $address->is_default = $request->is_default;

        if ($request->status == Null) {
            $request->status = 0;
        }
        $address->status = $request->status;
        $address->created_at = Carbon::now();

        $address->save();

        return response()->json([
            'user_address' => $address,
        ]);
    }

    public function userAddressShow(Request $request, $address_id)
    {
        $address = Address::find($address_id);
        $address_details = [
            'division_name_en' => $address->division->division_name_en ?? 'NULL',
            'division_id' => $address->division->id ?? 1,
            'district_name_en' => $address->district->district_name_en ?? 'NULL',
            'district_id' => $address->district->id ?? 1,
            'upazilla_name_en' => $address->upazilla->name_en ?? 'NULL',
            'upazilla_id' => $address->upazilla->id ?? 1,
            'address' => $address->address,
        ];

        // return json_encode($address_details);
        return response()->json([
            "address_details" => $address_details,
        ]);
    }

    public function shippingCost()
    {
        $shipping_cost = Shipping::all();
        return response()->json([
            'shipping_cost' => $shipping_cost,
        ]);
    }

    public function placeAnOrder(Request $request)
    {
        $order = (object)$request->order;
        $orderDetails = $request->input('order_details');
        $productIdss = [];
        $productQty = [];
        foreach ($orderDetails as $single) {
            $productIdss[] = $single['product_id'];
            $productQty[] = $single['qty'];
        }
        // dd($productIdss,  $productQty);

        if ($request->payment_option == 'cod') {
            $payment_status = 0;
            $invoice_no = date('YmdHis') . rand(10, 99);
        }
        // else {
        //     $payment_status = 1;
        //     $invoice_no = Session::get('invoice_no');
        // }

        $order = Order::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'sub_total' => $request->sub_total,
            'grand_total' => $request->grand_total,
            'shipping_charge' => $request->shipping_charge,
            'shipping_name' => $request->shipping_name,
            'shipping_type' => $request->shipping_type,
            'payment_method' => $request->payment_option,
            'payment_status' => $request->payment_status,
            'delivery_status' => 'pending',
            'phone' => $request->phone,
            'email' => $request->email,
            'invoice_no' => $invoice_no,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'upazilla_id' => $request->upazilla_id,
            'address' => $request->address,
            'comment' => $request->comment,
            'type' => $request->type,
            //'created_by' => Auth::guard('admin')->user()->id,
        ]);

        $orderDetailsArray = [];

        $productIds = $productIdss;
        $quantities = $productQty;

        foreach ($productIds as $key => $productId) {
            $product = Product::find($productId);
            if (!$product) {
                return response()->json([
                    'message' => "product not found!",
                ]);
                continue;
            }
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $product->id;
            $orderDetail->product_name = $product->name_en;
            $orderDetail->qty = $quantities[$key];
            $orderDetail->save();

            $orderDetailsArray[] = $orderDetail;
        }

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
            'order_details' => $orderDetailsArray,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\API\Dealer;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\DealerRequest;
use App\Http\Controllers\Controller;
use App\Models\DealerRequestConfirm;
use App\Models\DealerRequestProduct;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Dealer\DealerOrderResource;
use App\Http\Resources\Dealer\DealerOrderShowResource;
use App\Http\Resources\Dealer\DealerOrderConfirmResource;
use App\Http\Resources\Dealer\DealerSalesInvoiceResource;
use App\Http\Resources\Dealer\CategoryWiseProductResource;
use App\Http\Resources\Dealer\DealerRequestProductResource;

class DealerOrderApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ORDER STORE - UPDATE
    |--------------------------------------------------------------------------
    |
    */

    public function orderStore(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string',
            'user_phn' => 'required|string',
            'user_mail' => 'required|email',
            'total_amount' => 'required|numeric',
            'note' => 'nullable|string',
            'product_list' => 'required|array|min:1',
            'product_list.*.product_id' => 'required|integer',
            'product_list.*.qty' => 'required|integer|min:1',
            'product_list.*.price' => 'required|numeric|min:0',
            'product_list.*.total_price' => 'required|numeric|min:0',
        ]);

        $dealerRequest = new DealerRequest();
        $dealerRequest->user_id = Auth::user()->id;
        $dealerRequest->total_amount = $request->total_amount;
        $dealerRequest->note = $request->note;
        $dealerRequest->save();

        $orderProducts = [];
        foreach ($request->product_list as $productData) {
            $orderProduct = new DealerRequestProduct();
            $orderProduct->dealer_request_id = $dealerRequest->id;
            $orderProduct->product_id = $productData['product_id'];
            $orderProduct->qty = $productData['qty'];
            $orderProduct->price = $productData['price'];
            $orderProduct->save();

            $orderProducts[] = new DealerRequestProductResource($orderProduct);
        }

        return response()->json([
            'message' => "Order created successfully!",
            'dealer_request' => $dealerRequest,
            'dealer_request_product' => $orderProducts,
        ], 201);
    }

    public function orderUpdate(Request $request, $id)
    {
        $dealerRequest = DealerRequest::findOrFail($id);
        $dealerRequest->user_id = Auth::user()->id;
        $dealerRequest->total_amount = $request->total_amount;
        $dealerRequest->save();

        // delete previous dealer request product
        DealerRequestProduct::where('dealer_request_id', $dealerRequest->id)->delete();

        // Update products qty
        foreach ($request->product_list as $productData) {
            // Create a new DealerRequestProduct for each product in the request
            $orderProduct = new DealerRequestProduct();
            $orderProduct->dealer_request_id = $dealerRequest->id;
            $orderProduct->product_id = $productData['product_id'];
            $orderProduct->qty = $productData['qty'];
            $orderProduct->price = $productData['price'];
            $orderProduct->save();
        }

        return response()->json([
            'message' => "Order updated successfully!",
            'dealer_request' => $dealerRequest->id,
        ], 200);
    }


    public function allRequest()
    {
        $user = Auth::id();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated!!!!!!!'], 401);
        }

        $all_requests = DealerRequest::where('user_id', $user)->latest()->get();

        if ($all_requests->isEmpty()) {
            return response()->json([
                'message' => 'No data Found in this table',
            ], 200);
        }

        return DealerOrderResource::collection($all_requests);
    }

    public function allRequestShow($id)
    {
        $dealer = DealerRequest::find($id);
        if (!$dealer) {
            return response()->json(['error' => 'Dealer request not found.'], 404);
        }

        return new DealerOrderResource($dealer);
    }

    public function dealerOrderConfirm()
    {
        $user = Auth::id();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated!!!!!!!'], 401);
        }

        $orders = DealerRequestConfirm::where('user_id', $user)->get();

        return DealerOrderConfirmResource::collection($orders);
    }

    public function dealerOrderShow($id)
    {
        $order = DealerRequestConfirm::find($id);
        // dd($order);
        if (!$order) {
            return response()->json([
                'message' => 'No Order Show',
            ], 404);
        }
        return new DealerOrderShowResource($order);
    }

    public function allRequestDestroy($id)
    {
        try {
            $dealer_request = DealerRequest::find($id);
            if (!$dealer_request) {
                return response()->json(["message" => "Id Not Found"], 404);
            }
            $dealer_request_product = DealerRequestProduct::where('request_status', 1)->first();

            if (!$dealer_request_product) {
                $dealer_request->delete();

                return response()->json([
                    'message' => 'Order Request Deleted Successfully.',
                    'status' => 'success'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Your Order Request approved Cant be Deleted.',
                    'status' => 'warning'
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting the order request.',
                'status' => 'error'
            ], 500);
        }
    } //end method

    public function dealerSalesInvoice($id)
    {
        $dealerConfirm = DealerRequestConfirm::find($id);

        if (!$dealerConfirm) {
            return response()->json(['error' => 'Dealer not found'], 404);
        }

        return new DealerSalesInvoiceResource($dealerConfirm);
    }
    public function categoryWiseProduct($catId)
    {
        $products = Product::where('category_id', $catId)->latest()->get();
        if (!$products) {
            response()->json([
                'message' => 'No Product Found',
            ], 200);
        }
        return new CategoryWiseProductResource($products);
    }
}

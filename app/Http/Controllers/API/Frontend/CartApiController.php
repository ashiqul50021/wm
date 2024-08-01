<?php

namespace App\Http\Controllers\API\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cartIndex()
    {
        $carts = Cart::content();
        //dd($carts);

        return response()->json([
            'cart' => $carts,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request, $id)
    {
        //dd($request->all());
        $product = Product::find($id);
        if (!$product) {
            return response()->json(["Product Not Found!"],404);
        }

        $carts = Cart::content();

        if (!$product->is_varient) {
            $prev_cart_qty = 0;
            foreach ($carts as $cart) {
                if ($cart->id == $id) {
                    $prev_cart_qty += $cart->qty;
                }
            }

            $qty = $prev_cart_qty + $request->quantity;

            if ($qty > $product->stock_qty) {
                return response()->json(['error' => 'Not enough stock']);
            }
        } else {
            $prev_cart_qty = 0;
        }

        if ($request->product_price) {
            $price = $request->product_price;
        } else {
            if ($product->discount_price > 0) {
                if ($product->discount_type == 1) {
                    $price = $product->regular_price - $product->discount_price;
                } else {
                    $price = $product->regular_price - ($product->discount_price * $product->regular_price / 100);
                }
            } else {
                $price = $product->regular_price;
            }
        }

        Cart::add([
            'id' => $id,
            'name' => $product->name_en,
            'qty' => $request->quantity,
            'price' => $price,
            'weight' => 1,
            'options' => [
                'image' => $product->product_thumbnail,
                'slug' => $product->slug,
                'is_varient' => 0,
            ],
        ]);

        return response()->json(['success' => 'Successfully Added on Your Cart'],200);
    }

    public function getCartProduct()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal,
        ));
    }

    public function AddMiniCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => round($cartTotal),
        ));
    }
}

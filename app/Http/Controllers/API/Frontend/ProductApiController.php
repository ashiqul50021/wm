<?php

namespace App\Http\Controllers\API\Frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\MultiImg;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductDefaultResource;

class ProductApiController extends Controller
{
    public function productShop()
    {
        $products = Product::orderBy('name_en', 'ASC')->where('status', 1)->where('approved', 1)->latest()->get();

        return response()->json([
            'product_shop' => ProductDefaultResource::collection($products),
        ]);
    }

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            if ($product->id) {
                $multiImg = MultiImg::where('product_id', $product->id)->get();
            }

            // Related Products
            $cat_id = $product->category_id;
            $relatedProduct = Product::where('category_id', $cat_id)->where('id', '!=', $product->id)->where('approved', 1)->orderBy('id', 'DESC')->limit(5)->get();

            $categories = Category::orderBy('name_en', 'ASC')->where('status', '=', 1)->limit(5)->get();
            $new_products = Product::orderBy('name_en')->where('status', '=', 1)->where('approved', 1)->limit(3)->latest()->get();

            return response()->json([
                'product' => $product,
                'multiImg' => $multiImg,
                'categories' => $categories,
                'new_products' => $new_products,
                'relatedProduct' => $relatedProduct,
            ], 200);
        }

        return response()->json([
            "Product Not Found!"
        ], 404);
    }

    public function productReviewStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'user_name' => 'required',
            'comment' => 'required',
            'start_rating' => 'required',
        ]);

        $productReview = ProductReview::create([
            'product_id' => $request->product_id,
            'user_name' => $request->user_name,
            'comment' => $request->comment,
            'start_rating' => $request->start_rating,
            'status' => 0
        ]);

        return response()->json([
            'message' => 'Review Submitted Successfully!',
            'data' => $productReview,
        ]);
    }

    public function productFeatured()
    {
        $products_featured = Product::where('status', '1')->where('is_featured', '1')->latest()->get();
        if ($products_featured->isEmpty()) {
            return response()->json(['message' => 'No Product Featured found!'], 200);
        }

        return response()->json([
            'product_featured' => ProductDefaultResource::collection($products_featured),
        ]);
    }

    public function productFeaturedLimit()
    {
        $products_featured_limit = Product::where('status', '1')->where('is_featured', '1')->latest()->limit(10)->get();
        if ($products_featured_limit->isEmpty()) {
            return response()->json(['message' => 'No Product Featured found!'], 200);
        }

        return response()->json([
            'product_featured_limit' => ProductDefaultResource::collection($products_featured_limit),
        ]);
    }

    public function topSelling()
    {
        $products_top_selling = Product::where('status', 1)->where('approved', 1)->orderBy('id', 'ASC')->latest()->limit(100)->get();

        if ($products_top_selling->isEmpty()) {
            return response()->json([
                'message' => 'No Top selling product found',
            ]);
        }

        return response()->json([
            'top_selling_products' => ProductDefaultResource::collection($products_top_selling),
        ]);
    }

    public function topSellingLimit()
    {
        $products_top_selling_limit = Product::where('status', 1)->where('approved', 1)->orderBy('id', 'ASC')->latest()->limit(5)->get();

        if ($products_top_selling_limit->isEmpty()) {
            return response()->json([
                'message' => 'No Top selling product found',
            ]);
        }

        return response()->json([
            'top_selling_products_limit' => ProductDefaultResource::collection($products_top_selling_limit),
        ]);
    }

    public function trendingProduct()
    {
        $products_trending = Product::where('status', 1)->where('approved', 1)->orderBy('id', 'ASC')->latest()->limit(100)->get();
        if ($products_trending->isEmpty()) {
            return response()->json([
                'message' => 'No Trending Product Found',
            ], 404);
        }

        return response()->json([
            'trending_products' => ProductDefaultResource::collection($products_trending),
        ]);
    }

    public function trendingProductLimit()
    {
        $products_trending_limit = Product::where('status', 1)->where('approved', 1)->orderBy('id', 'ASC')->latest()->limit(5)->get();
        if ($products_trending_limit->isEmpty()) {
            return response()->json([
                'message' => 'No Trending Product Found',
            ], 404);
        }

        return response()->json([
            'trending_products_limit' => ProductDefaultResource::collection($products_trending_limit),
        ]);
    }
}

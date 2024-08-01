<?php

namespace App\Http\Controllers\API\Frontend;

use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CategoryWiseProduct($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return response()->json(["Invalid Slug in CateWiseProduct!"], 404);
        }

        $catWiseProducts = Product::where('category_id', $category->id)->get();

        // return CategoryResource::collection($categories);
        return response()->json([
            'Category_Wise_Product' => $catWiseProducts,
        ], 200);
    }

    public function VendorWiseProduct(Request $request, $slug)
    {
    }

    public function TagWiseProduct(Request $request, $slug)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
